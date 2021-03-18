<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;

class Products extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => [
            'except' => ''
        ]
    ];

    public $search;

    public function render()
    {
        $search = $this->search;

        $products = Product::whereNull('deleted_at')
        ->where(function($q) use($search) {
            $q->orWhere('barcode', 'LIKE', "%{$search}%");
            $q->orWhere('name', 'LIKE', "%{$search}%");
            $q->orWhere('description', 'LIKE', "%{$search}%");
        })
        ->orderBy('name', 'asc')
        ->paginate(10);

        return view('livewire.products', compact('products'));
    }

    public function increment(Product $product)
    {
        $product->stock = $product->stock + 1;
        $product->save();
    }
    
    public function decrement(Product $product)
    {
        if($product->stock > 0) {
            $product->stock = $product->stock - 1;
            $product->save();
        }
    }
}
