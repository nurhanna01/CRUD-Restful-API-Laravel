<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // method untuk melihat semua user yang terdaftar
    public function users()
    {
        $users=User::all();
        return fractal()
        ->collection($users)
        ->transformWith(new UserTransformer)
        ->toArray();
    }

    // melihat detail data dari pengguna yang sedang login
    // sehingga diperlukan menambahkan Authorization milik pengguna yg login pada header
    public function profile()
    {
        $user = User::find(Auth::user()->id);

        return fractal()
        ->item($user)
        ->transformWith(new UserTransformer)
        ->includePosts()
        ->toArray(); 
    }
}
