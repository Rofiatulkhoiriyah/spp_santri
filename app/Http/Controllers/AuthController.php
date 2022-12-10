<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Pengguna;
use App\Models\Santri;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Pengguna::where('Username',$request->Username)->first();
        if($user) {
            if($user->Role != 'admin') {
                $santri = Santri::where('Pengguna',$user->Oid)->first();
                if($santri && !$santri->Aktif) return redirect('/auth/login')->with('error','Akun kamu tidak aktif');
            }

            if(password_verify($request->Password, $user->Password)) {
                $login = Auth::login($user);

                return redirect('/');
            } else return redirect('/auth/login')->with('error','Password Salah');
        } else return redirect('/auth/login')->with('error','Username tidak ditemukan');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/auth/login');
    }
}
