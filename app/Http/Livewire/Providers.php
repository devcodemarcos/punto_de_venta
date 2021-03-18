<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Provider;

class Providers extends Component
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

        $providers = Provider::whereNull('deleted_at')
        ->where(function($q) use($search) {
            $q->orWhere('name', 'LIKE', "%{$search}%");
            $q->orWhere('phone', 'LIKE', "%{$search}%");
            $q->orWhere('email', 'LIKE', "%{$search}%");
            $q->orWhere('comments', 'LIKE', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        
        return view('livewire.providers', compact('providers'));
    }
}
