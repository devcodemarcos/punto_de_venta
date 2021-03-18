<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

class Users extends Component
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

        $users = User::whereNull('deleted_at')
        ->where(function($query) use($search) {
            $query->where('name', 'LIKE', "%{$search}%");
            $query->orWhere('username', 'LIKE', "%{$search}%");
        })
        ->orderBy('name', 'asc')
        ->paginate(10);

        return view('livewire.users', compact('users'));
    }
}
