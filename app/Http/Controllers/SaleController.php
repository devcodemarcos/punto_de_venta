<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class SaleController extends Controller
{
    public function sale()
    {
        return view('sales.sales');
    }

    public function findByBarcode(Request $request)
    {
        $barcode = $request->post('barcode');
        $product = Product::where('barcode', $barcode)->whereNull('deleted_at')->first();
        if ($product) {
            if($product->stock > 0) {
                return response()->json($product);
            }

            return response()->json([
                'message' => 'El producto que buscas ya no cuenta con stock en el sistema'
            ], 406);
        }

        return response()->json([
            'message' => 'El producto que buscas no existe'
        ], 404);
    }

    public function findByText()
    {
        
    }
}
