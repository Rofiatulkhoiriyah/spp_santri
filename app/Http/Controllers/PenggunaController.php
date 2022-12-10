<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Pengguna;
use App\Models\Santri;
use App\Models\Wali;
use Ramsey\Uuid\Uuid;

class PenggunaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->Role == 'admin') return $this->list();
        else return redirect('/profile');
    }

    public function list()
    {
        $lists = Pengguna::where('Role','admin')->orderBy('CreatedAt','DESC')->get();
        foreach($lists as $list) {
            if($list->Role == 'user') {
                $santri = Santri::where('Pengguna',$list->Oid)->first();
                if($santri) $list->Role = 'Santri';

                $wali = Wali::where('Pengguna',$list->Oid)->first();
                if($wali) $list->Role = 'Wali';
            }
        }
        
        return view('Pengguna.List')->with('lists',$lists);
    }

    public function edit(Request $request, $Oid)
    {
        if(Auth::user()->Role != 'admin') return redirect('/profile');

        $pengguna = Pengguna::where('Oid',$Oid)->first();
        $wali = Wali::where('Pengguna',$Oid)->first();

        if($wali) return $this->wali($request, $Oid);
        else return view('Pengguna.Form')->with('data',$pengguna);
    }

    public function adminSave(Request $request, $Oid = null)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return back();

        if(!$Oid) {
            $check = Pengguna::where('Username',$request->Username)->first();
            if($check) return back()->with('error','Username sudah terdaftar, silahkan masukkan username yang berbeda');
    
            $pengguna = new Pengguna;
            $pengguna->Oid = Uuid::uuid4();
            $pengguna->Username = $request->Username;
            $pengguna->Role = 'admin';
        } else $pengguna = Pengguna::where('Oid',$Oid)->first();
    
        if($request->has('Password')) $pengguna->Password = bcrypt($request->Password);
        $pengguna->Nama = $request->Nama;
        $pengguna->save();

        return redirect('/pengguna')->with('success','Berhasil menyimpan pengguna');
    }

    public function wali(Request $request, $Oid = null)
    {
        $santri = Santri::where('Aktif',true)->get();

        $view = view('Pengguna.FormWali')->with('santri',$santri);
        if($Oid) {
            $data = Pengguna::where('Oid',$Oid)->first();
            $get = Wali::where('Pengguna',$Oid)->get();
            $selected = [];
            foreach($get as $row) $selected[] = $row->Santri; 
            $view = $view->with('data',$data)->with('selected',$selected);
        }

        return $view;
    }

    public function waliSave(Request $request, $Oid = null)
    {
        if(!$Oid) {
            $check = Pengguna::where('Username',$request->Username)->first();
            if($check) return back()->with('error','Username sudah terdaftar, silahkan masukkan username yang berbeda');

            $pengguna = new Pengguna;
            $pengguna->Oid = Uuid::uuid4();
            $pengguna->Username = $request->Username;
        } else $pengguna = Pengguna::where('Oid',$Oid)->first();
        
        if($request->has('Password')) $pengguna->Password = bcrypt($request->Password);
        $pengguna->Role = 'user';
        $pengguna->Nama = $request->Nama;
        $pengguna->save();

        if($Oid) Wali::where('Pengguna',$Oid)->forceDelete();

        foreach($request->all() as $key => $value) {
            if(Uuid::isValid($key)) {
                Wali::insert([
                    'Oid' => Uuid::uuid4(),
                    'Pengguna' => $pengguna->Oid,
                    'Santri' => $key
                ]);
            }
        }

        return redirect('/pengguna')->with('success','Berhasil menyimpan Wali');
    }

    public function delete($Oid)
    {
        if(Auth::user()->Role != 'admin') return redirect('/profile');
        $pengguna = Pengguna::where('Oid',$Oid)->first();
        $pengguna->delete();

        return back()->with('success','Berhasil menghapus pengguna');
    }
}
