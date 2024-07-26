<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:pos_order,order_id',
            'book_id' => 'required|exists:pos_book,book_id',
            'detail_price' => 'required|numeric',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        // Consultar disponibilidad de stock
        $book = Book::find($request->book_id);

        if ($book->stock < $request->quantity) {
            return response()->json([
                'message' => 'Stock insuficiente para el libro solicitado.',
                'status' => 400,
            ], 400);
        }

        // reduccion del stock
        $book->stock -= $request->quantity;
        $book->save();

        // Crear orden detalle
        $orderDetail = OrderDetail::create([
            'order_id' => $request->order_id,
            'book_id' => $request->book_id,
            'detail_price' => $request->detail_price,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'message' => 'Detalle de la orden creado exitosamente',
            'order_detail' => $orderDetail,
            'status' => 201,
        ], 201);
    }


    public function show($id)
    {
        $orderDetail = OrderDetail::with('order')->find($id);

        if (!$orderDetail) {
            return response()->json([
                'message' => 'Detalle de la orden no encontrada',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'order_detail' => $orderDetail,
            'status' => 200,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $orderDetail = OrderDetail::find($id);

        if (!$orderDetail) {
            return response()->json([
                'message' => 'Detalle de la orden no encontrada',
                'status' => 404,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        //Consultar disponibilidad de stock
        $book = Book::find($orderDetail->book_id);

        if ($book->stock + $orderDetail->quantity < $request->quantity) {
            return response()->json([
                'message' => 'Stock insuficiente para el libro solicitado.',
                'status' => 400,
            ], 400);
        }

        // actualizar stock
        $book->stock += $orderDetail->quantity - $request->quantity;
        $book->save();

        // actualizar orden-detalle
        $orderDetail->quantity = $request->quantity;
        $orderDetail->save();

        return response()->json([
            'message' => 'Detalle de la orden actualizada exitosamente',
            'order_detail' => $orderDetail,
            'status' => 200,
        ], 200);
    }

    public function destroy($id)
    {
        $orderDetail = OrderDetail::find($id);

        if (!$orderDetail) {
            return response()->json([
                'message' => 'Detalle de la orden no encontrada',
                'status' => 404,
            ], 404);
        }

        // restaurar stock
        $book = Book::find($orderDetail->book_id);
        $book->stock += $orderDetail->quantity;
        $book->save();

        $orderDetail->delete();

        return response()->json([
            'message' => 'Detalle de la orden eliminado exitosamente',
            'status' => 200,
        ], 200);
    }
}
