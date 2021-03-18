<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Provider;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.products');
    }

    public function create()
    {
        $providers = Provider::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        return view('products.create', compact('providers'));
    }

    public function store(Request $request)
    {
        try {
            $product = new Product;
            $product->barcode = $request->post('barcode');
            $product->name = $request->post('name');
            $product->description = $request->post('description');
            $product->purchase_price = $request->post('purchase_price');
            $product->sale_price = $request->post('sale_price');
            $product->stock = $request->post('stock');
            $product->minimum_stock = $request->post('minimum_stock');
            $product->user_id = auth()->id();

            if($request->post('provider_id')) {
                $product->provider_id = $request->post('provider_id');
            }

            if ($request->file('photo')) {
                $imageName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('/produtcs', $imageName, 'public');
                $product->photo = $path;
            }
        
            $product->save();

            return response()->json([
                'message' => 'Producto registrado correctamente'
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

    public function delete(Product $product)
    {
        $product->deleted_at = Carbon::now();
        $product->save();

        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ]);
    }

    public function edit(Product $product)
    {
        $providers = Provider::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        return view('products.edit', compact('product', 'providers'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $product->name = $request->post('name');
            $product->description = $request->post('description');
            $product->purchase_price = $request->post('purchase_price');
            $product->sale_price = $request->post('sale_price');
            $product->stock = $request->post('stock');
            $product->minimum_stock = $request->post('minimum_stock');
            $product->provider_id = $request->post('provider_id');

            if ($request->file('photo')) {
                if($product->photo !== 'produtcs/no-image-available.jpg') {
                    Storage::delete('public/' . $product->photo);
                }

                $imageName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('/produtcs', $imageName, 'public');
                $product->photo = $path;
            }

            $product->save();

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
                'message' => $message
            ], 500);
        }
    }
}
