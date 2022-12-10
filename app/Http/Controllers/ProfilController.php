<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Pengguna;
use App\Models\Santri;

class ProfilController extends Controller
{
    public function index()
    {
        $data = Pengguna::where('Oid',Auth::user()->Oid)->first();

        return view('Profile.Show')->with('data',$data);
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        $pengguna = Pengguna::where('Oid',$user->Oid)->first();
        $santri = Santri::where('Pengguna',$pengguna->Oid)->first();

        if($request->has('Nama')) {
            $check = str_replace(' ','',$request->Nama);
            if($check == '') return redirect('/profile')->with('warning','Kolom <b>Nama</b> harus diisi');
            $pengguna->Nama = $request->Nama;
        }

        if($request->has('Username')) {
            $check = str_replace(' ','',$request->Username);
            if($check == '') return redirect('/profile')->with('warning','Kolom <b>Username</b> harus diisi');
            if($pengguna->Username != $request->Username) {
                $check = Pengguna::where('Username',$request->Username)->first();
                if($check) return redirect('/profile')->with('error','Username sudah terpakai');

                $pengguna->Username = $request->Username;
            } else return redirect('/profile');
        }

        if($request->has('Password')) {
            if($request->Password == $request->NewPassword) {
                if(password_verify($request->OldPassword, $pengguna->Password)) $pengguna->Password = bcrypt($request->Password);
                else return redirect('/profile')->with('error','Password lama salah');
            } else return redirect('/profile')->with('error','Password baru tidak sama');
        }

        $pengguna->save();

        if($santri && $request->has('Nama')) {
            $santri->Nama = $request->Nama;
            $santri->save();
        }

        return redirect('/profile')->with('success','Data berhasil disimpan');
    }
}
