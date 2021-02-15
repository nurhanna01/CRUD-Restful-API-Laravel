<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // pengguna melakukan register
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => bcrypt($request->email)
        ]);
        
        $respon = fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' => $user->api_token
            ])
            ->toArray();
        
        return response()->json($respon,201);
    }

    // proses pemeriksaan data login pengguna
    public function login(Request $request){
        if(!Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return response()->json(['error'=>'email atau password anda salah']);
        }

        $user=User::find(Auth::User()->id);
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' => $user->api_token
            ])
            ->toArray();
    }
}
