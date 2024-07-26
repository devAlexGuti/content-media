<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        $data = [
            'clients' => $clients,
            'status' => 200
        ];
        return response()->json($data,200);
       /*  return "hola"; */
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'doc_type'=> 'required|in:1,2,3',
            'doc_number'=> 'required|max:255|unique:pos_client,doc_number',
            'first_name'=> 'required|max:255',
            'last_name'=> 'required|max:255',
            'phone'=> 'required|digits:9|unique:pos_client,phone',
            'email'=> 'required|email|unique:pos_client,email'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->doc_type == 1 && !preg_match('/^\d{8}$/', $request->doc_number)) {
                $validator->errors()->add('doc_number', 'El número de DNI debe tener 8 dígitos.');
            } elseif ($request->doc_type == 2 && !preg_match('/^\d{11}$/', $request->doc_number)) {
                $validator->errors()->add('doc_number', 'El número de RUC debe tener 11 dígitos.');
            } elseif ($request->doc_type == 3 && !preg_match('/^\d{9}$/', $request->doc_number))  {
                $validator->errors()->add('doc_number', 'El carné de extranjería debe tener 9 dígitos.');
            }
        });
        if ($validator->fails()) {
            $data = [
                'message' => 'error',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data,400);
        }

        $client = Client::create([
            'doc_type'=> $request->doc_type,
            'doc_number'=> $request->doc_number,
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'phone'=> $request->phone,
            'email'=> $request->email
        ]);

        if(!$client){
            $data = [
                'message' => 'error al crear cliente',
                'status' => 500,
            ];
            return response()->json($data,500);
        }

        $data = [
            'client' => $client,
            'status' => 201,
        ];
        return response()->json($data,201);
    }

    public function show($id)
    {
        $client = Client::find($id);

        if(!$client){

        $data = [
            'message' => 'Cliente no encontrado',
            'status' => 404,
        ];
        return response()->json($data,404);
        }

        $data = [
            'client' => $client,
            'status' => 200,
        ];

        return response()->json($data,200);
    }

    public function destroy ($id)
    {
        $client = Client::find($id);

        if(!$client){

            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404,
            ];
            return response()->json($data,404);
        }

        $client->delete();

            $data = [
                'message' => 'Cliente eliminado',
                'status' => 200,
            ];

        return response()->json($data,200);
    }

    public function update (Request $request, $id)
    {
        $client = Client::find($id);

        if(!$client){
            $data = [
                'message' => 'Contacto no encontrado',
                'status' => 500,
            ];
            return response()->json($data,500);
        }

        $validator=Validator::make($request->all(), [
            'doc_type'=> 'required|in:1,2,3',
            'doc_number'=> 'required|max:255',
            'first_name'=> 'required|max:255',
            'last_name'=> 'required|max:255',
            'phone'=> 'required|digits:9',
            'email'=> 'required|max:255'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->doc_type == 1 && !preg_match('/^\d{8}$/', $request->doc_number)) {
                $validator->errors()->add('doc_number', 'El número de DNI debe tener 8 dígitos.');
            } elseif ($request->doc_type == 2 && !preg_match('/^\d{11}$/', $request->doc_number)) {
                $validator->errors()->add('doc_number', 'El número de RUC debe tener 11 dígitos.');
            } elseif ($request->doc_type == 3 && !preg_match('/^\d{9}$/', $request->doc_number))  {
                $validator->errors()->add('doc_number', 'El carné de extranjería debe tener 9 dígitos.');
            }
        });

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data,400);
        }

        $client->doc_type= $request->doc_type;
        $client->doc_number= $request->doc_number;
        $client->first_name= $request->first_name;
        $client->last_name= $request->last_name;
        $client->phone= $request->phone;
        $client->email= $request->email;

        $client->save();

        $data = [
            'message' => 'Cliente actualizado',
            'client' => $client,
            'status' => 200,
        ];
        return response()->json($data,200);
    }

    public function updatePartial (Request $request, $id)
    {
        $client = Client::find($id);

        if(!$client){
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404,
            ];
            return response()->json($data,404);
        }

        $validator=Validator::make($request->all(), [
            'doc_type'=> 'max:255',
            'doc_number'=> 'max:255',
            'first_name'=> 'max:255',
            'last_name'=> 'max:255',
            'phone'=> 'digits:9',
            'email'=> 'email|unique:post_client'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->doc_type == 1 && !preg_match('/^\d{8}$/', $request->doc_number)) {
                $validator->errors()->add('doc_number', 'El número de DNI debe tener 8 dígitos.');
            } elseif ($request->doc_type == 2 && !preg_match('/^\d{11}$/', $request->doc_number)) {
                $validator->errors()->add('doc_number', 'El número de RUC debe tener 11 dígitos.');
            } elseif ($request->doc_type == 3 && !preg_match('/^\d{9}$/', $request->doc_number))  {
                $validator->errors()->add('doc_number', 'El carné de extranjería debe tener 9 dígitos.');
            }
        });

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data,400);
        }
        if($request->has('doc_type')){
            $client->doc_type = $request->doc_type;
        }
        if($request->has('doc_number')){
            $client->doc_number = $request->doc_number;
        }
        if($request->has('first_name')){
            $client->first_name = $request->first_name;
        }
        if($request->has('last_name')){
            $client->last_name = $request->last_name;
        }
        if($request->has('phone')){
            $client->phone = $request->phone;
        }
        if($request->has('email')){
            $client->email = $request->email;
        }

        $client->save();

        $data = [
            'message' => 'Cliente actualizado',
            'client' => $client,
            'status' => 200,
        ];
        return response()->json($data,200);
    }
}
