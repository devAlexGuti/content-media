<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('details')->get();
        return response()->json($orders, 200);
        //return Order::with('details')->get();
       /*  return "hola"; */
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:pos_client,client_id',
            'total' => 'required|numeric',
            'doc_type' => 'required|in:1,2,3',
            'doc_number' => 'required|max:255',
            'last_name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $order = Order::create($request->all());

        return response()->json([
            'message' => 'Orden creada exitosamente',
            'order' => $order,
            'status' => 201,
        ], 201);
    }

    public function show($id)
    {
        $order = Order::with('details')->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Orden no encontrada'
            ], 404);
        }

        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:pos_client,client_id',
            'total' => 'required|numeric',
            'doc_type' => 'required|in:1,2,3',
            'doc_number' => 'required|max:255',
            'last_name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $order->update($request->all());

        return response()->json([
            'message' => 'Order actualizada exitosamente',
            'order' => $order,
            'status' => 200,
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        //$order->details()->delete();

        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $order->delete();

        return response()->json([
            'message' => 'Orden eliminada correctamente',
            'status' => 200,
        ], 200);
    }

    //Agregar un libro al carrito de compras - orden
    public function addBookToOrder(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $book = Book::find($request->book_id);

        if ($book->stock < $request->quantity) {
            return response()->json([
                'message' => 'Stock insuficiente para el libro solicitado.',
                'status' => 400,
            ], 400);
        }

        $book->stock -= $request->quantity;
        $book->save();

        $orderDetail = OrderDetail::create([
            'order_id' => $order->order_id,
            'book_id' => $request->book_id,
            'detail_price' => $request->detail_price,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'message' => 'Libro añadido a la orden exitosamente',
            'order_detail' => $orderDetail,
            'status' => 201,
        ], 201);
    }

    //Cambiar la cantidad de un libro en el carrito de compras
    public function updateBookQuantity(Request $request, $orderId, $bookId)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $orderDetail = OrderDetail::where('order_id', $orderId)
                    ->where('book_id', $bookId)
                    ->first();

        if (!$orderDetail) {
            return response()->json(['message' => 'Detalles del pedido no encontrados'], 404);
        }

        $book = Book::find($bookId);

        if ($book->stock + $orderDetail->quantity < $request->quantity) {
            return response()->json([
                'message' => 'Stock insuficiente para el libro solicitado.',
                'status' => 400,
            ], 400);
        }

        $book->stock += $orderDetail->quantity - $request->quantity;
        $book->save();

        $orderDetail->quantity = $request->quantity;
        $orderDetail->save();

        return response()->json([
            'message' => 'Cantidad de libros actualizada correctamente',
            'order_detail' => $orderDetail,
            'status' => 200,
        ], 200);
    }

    //Eliminar libro del carrito de compras
    public function removeBookFromOrder($orderId, $bookId)
    {
        $orderDetail = OrderDetail::where('order_id', $orderId)
                                  ->where('book_id', $bookId)
                                  ->first();

        if (!$orderDetail) {
            return response()->json(['message' => 'Detalle la orden no encontrado'], 404);
        }

        $book = Book::find($bookId);
        $book->stock += $orderDetail->quantity;
        $book->save();

        $orderDetail->delete();

        return response()->json([
            'message' => 'Libro eliminado de la orden correctamente',
            'status' => 200,
        ], 200);
    }

    //finalizar la compra en el carrito de compras
    public function checkout(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:pos_client,client_id',
            'total' => 'required|numeric',
            'doc_type' => 'required|in:1,2,3',
            'doc_number' => 'required|max:255',
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $order = Order::findOrFail($id);

        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        if ($order->details->isEmpty()) {
            return response()->json([
                'message' => 'La orden no tiene detalles. No se puede procesar el checkout.',
                'status' => 400,
            ], 400);
        }

        $order->update([
            'client_id' => $request->client_id,
            'total' => $order->details->sum(function($detail) {
                return $detail->detail_price * $detail->quantity;
            }),
            'doc_type' => $request->doc_type,
            'doc_number' => $request->doc_number,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'payment_status' => 'paid',  // Asumimos que el pago en efectivo se realiza exitosamente
        ]);
        // Lógica adicional para el checkout

        return response()->json([
            'message' => 'Compra finalizada',
            'order' => $order,
            'status' => 200,
        ], 200);
    }


}
