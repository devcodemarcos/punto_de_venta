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
        $product = Product::where('barcode', $barcode)
        ->whereNull('deleted_at')
        ->firstOrFail();
        return response()->json($product);
    }

    public function findByText()
    {
        
    }
}
