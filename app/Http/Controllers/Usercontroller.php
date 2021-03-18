<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;

class Usercontroller extends Controller
{
    public function index()
    {
        return view('users.users');
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);
        return view('users.profile', compact('user'));
    }

    public function delete(User $user)
    {
        $user->deleted_at = Carbon::now();
        $user->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}
