<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Provider;
use Carbon\Carbon;

class ProviderController extends Controller
{
    public function index()
    {
        return view('providers.providers');
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        try {
            $provider = new Provider;
            $provider->name = $request->post('name');
            $provider->phone = $request->post('phone');
            $provider->email = $request->post('email');
            $provider->comments = $request->post('comments');
            $provider->save();

            return response()->json([
                'message' => 'Proveedor registrado correctamente'
            ]);
        }
        catch (QueryException $e) {
            $message = 'Ocurrio un error desconocido, contactar al administrador del sistema';
            if($e->errorInfo[1] === 1062){
                $message = 'El <b>' . Helper::translate_error_db($e->errorInfo[2]) . '</b> ingresado ya esta registrado, intente con otro por favor';
            }

            return response()->json([
                'message' => $message,
            ], 500);
        }
    }

    public function delete(Provider $provider)
    {
        $provider->deleted_at = Carbon::now();
        $provider->save();

        return response()->json([
            'message' => 'Proveedor eliminado correctamente'
        ]);
    }

    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        try {
            $provider->name = $request->post('name');
            $provider->phone = $request->post('phone');
            $provider->email = $request->post('email');
            $provider->comments = $request->post('comments');
            $provider->save();

            return response()->json([
                'message' => 'Datos del proveedor editados correctamente'
            ]);
        }
        catch (QueryException $e) {
            $message = 'Ocurrio un error desconocido, contactar al administrador del sistema';
            if($e->errorInfo[1] === 1062){
                $message = 'El <b>' . Helper::translate_error_db($e->errorInfo[2]) . '</b> ingresado ya esta registrado, intente con otro por favor';
            }

            return response()->json([
                'message' => $message,
            ], 500);
        }
    }
}
