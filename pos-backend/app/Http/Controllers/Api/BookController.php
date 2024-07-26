<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        $data = [
            'books' => $books,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'isbn'=> 'required|digits:13|unique:pos_book,isbn',
            'name'=> 'required|max:255',
            'stock'=> 'required|integer',
            'current_price'=> 'required|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'image_book' => 'sometimes|file|image|max:2048'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'error',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data,400);
        }

        $book = Book::create([
            'isbn'=> $request->isbn,
            'name'=> $request->name,
            'stock'=> $request->stock,
            'current_price'=> $request->current_price,
        ]);

        if ($request->hasFile('image_book')) {
            $file = $request->file('image_book');
            $destinationPath = 'images/books/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $book->image_book = $destinationPath . $filename;
        }

        $book->save();

        if(!$book){
            $data = [
                'message' => 'error al crear libro',
                'status' => 500,
            ];
            return response()->json($data,500);
        }

        $data = [
            'book' => $book,
            'status' => 201,
        ];
        return response()->json($data,201);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if(!$book){

        $data = [
            'message' => 'Libro no encontrado',
            'status' => 404,
        ];
        return response()->json($data,404);
        }

        $data = [
            'book' => $book,
            'status' => 200,
        ];

        return response()->json($data,200);
    }

    public function destroy ($id)
    {
        $book = Book::find($id);

        if(!$book){

            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404,
            ];
            return response()->json($data,404);
        }

        $book->delete();

            $data = [
                'message' => 'Libro eliminado',
                'status' => 200,
            ];

        return response()->json($data,200);
    }

    public function update (Request $request, $id)
    {
        $book = Book::find($id);

        if(!$book){
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 500,
            ];
            return response()->json($data,500);
        }

        //dd($request->all());
        //dd($request->file('image_book'));

        $validator=Validator::make($request->all(), [
            'isbn'=> 'required|digits:13',
            'name'=> 'required|max:255',
            'stock'=> 'required|integer',
            'current_price'=> 'required|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'image_book' => 'nullable|file|image|max:2048'
        ]);


        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data,400);
        }

        $book->isbn= $request->isbn;
        $book->name= $request->name;
        $book->stock= $request->stock;
        $book->current_price= $request->current_price;

        // Manejar la carga del archivo si está presente
        //if ($request->hasFile('image_book')) {
            // Eliminar la imagen anterior si existe
        /*     if ($book->image_book && file_exists(public_path($book->image_book))) {
                unlink(public_path($book->image_book));
            }

            $file = $request->file('image_book');
            $destinationPath = 'images/books/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $book->image_book = $destinationPath . $filename;
        } */

        $book->save();

        $data = [
            'message' => 'Libro actualizado',
            'book' => $book,
            'status' => 200,
        ];
        return response()->json($data,200);
    }

    public function updatePartial (Request $request, $id)
    {
        $book = Book::find($id);

        if(!$book){
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404,
            ];
            return response()->json($data,404);
        }

        $validator=Validator::make($request->all(), [
            'isbn'=> 'required|digits:13',
            'name'=> 'required|max:255',
            'stock'=> 'required|integer',
            'current_price'=> 'required|regex:/^\d{1,8}(\.\d{1,2})?$/',
        ]);


        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data,400);
        }
        if($request->has('isbn')){
            $book->isbn = $request->isbn;
        }
        if($request->has('name')){
            $book->name = $request->name;
        }
        if($request->has('stock')){
            $book->stock = $request->stock;
        }
        if($request->has('current_price')){
            $book->current_price = $request->current_price;
        }

        $book->save();

        $data = [
            'message' => 'Libro actualizado',
            'book' => $book,
            'status' => 200,
        ];
        return response()->json($data,200);
    }
}
