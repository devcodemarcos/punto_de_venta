<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;

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

    public function findByText(Request $request)
    {
        $products = Product::where('stock', '>', '0')
        ->where('name', 'LIKE', "%{$request->text}%")
        ->orWhere('description', 'LIKE', "%{$request->text}%")
        ->get();

        if($products->count() > 0) {
            return response()->json($products);
        }
        
        return response()->json([
            'message' => "No hay coincidencias con {$request->text}"
        ], 404);
    }

    public function payment(Request $request)
    {
        return DB::transaction(function() use ($request) {
            $sale = new Sale;
            $sale->total = $request->input('sale.total');
            $sale->payment = $request->input('sale.pago');
            $sale->give_change = $request->input('sale.cambio');
            $sale->user_id = auth()->id();
            $sale->save();

            $products = $request->input('products');
            
            $data = array();
            foreach ($products as $barcode => $product) {
                $data[] = [
                    'quantity' => $product['quantity'],
                    'total' => $product['subtotal'],
                    'sale_price' => $product['sale_price'],
                    'product_id' => $product['id'],
                    'sale_id' => $sale->id
                ];
            }
            SaleDetail::insert($data);

            return response()->json([
                'message' => 'Venta realizada correctamente'
            ]);
        });
    }
}
