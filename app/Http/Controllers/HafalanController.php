<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Hafalan;
use App\Models\Wali;
use Carbon\Carbon;
use Auth;
use Ramsey\Uuid\Uuid;

class HafalanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->Role == 'admin') return $this->list($request);
        else return $this->show($request, $user->Oid);
    }

    private function list(Request $request)
    {
        $getSantri = Santri::orderBy('Aktif','DESC')->orderBy('TglMasuk','DESC')->get();
        $data = [];
        foreach($getSantri as $santri) {
            $hafalan = Hafalan::where('Santri',$santri->Oid)->count();
            $data[] = (object) [
                'Oid' => $santri->Oid,
                'Santri' => $santri,
                'Jumlah' => $hafalan
            ];
        }

        return view('Hafalan.List')->with('lists',$data);
    }

    public function show(Request $request, $Oid)
    {
        $data = [];
        $santri = Santri::where('Oid',$Oid)->first();
        if(!$santri) $santri = Santri::where('Pengguna',$Oid)->first();

        if($santri) {
            $hafalan = Hafalan::where('Santri',$santri->Oid)->get();
            $data[] = (object) [
                'santri' => $santri,
                'lists' => $hafalan
            ];
        } else {
            $wali = Wali::where('Pengguna',$Oid)->with('santriObj')->get();
            foreach($wali as $row) {
                $hafalan = Hafalan::where('Santri',$row->Santri)->get();
                $data[] = (object) [
                    'santri' => $row->santriObj,
                    'lists' => $hafalan
                ]; 
            }
        }

        if(Auth::user()->Role != 'admin' && $data[0]->santri->Pengguna != Auth::user()->Oid) return redirect('/santri/hafalan');

        return view('Hafalan.Show')->with('data',$data);
    }

    public function save(Request $request, $Santri, $Oid = null)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return redirect('/santri/hafalan');

        if(!$request->has('Tanggal') || $request->Tanggal == '') return back()->with('warning','Kolom Tanggal harus diisi');
        if(!$request->has('Surah') || $request->Surah == '') return back()->with('warning','Kolom Surah harus diisi');
        if(!$request->has('Keterangan') || $request->Keterangan == '') return back()->with('warning','Kolom Keterangan harus diisi');

        if(!$Oid) {
            $hafalan = new Hafalan;
            $hafalan->Oid = Uuid::uuid4();
        } else $hafalan = Hafalan::where('Oid',$Oid)->first();

        $hafalan->Santri = $Santri;
        $hafalan->Tanggal = $request->Tanggal;
        $hafalan->Surah = $request->Surah;
        $hafalan->Keterangan = $request->Keterangan;
        $hafalan->save();

        return back()->with('success','Berhasil menyimpan hafalan');
    }

    public function delete(Request $request, $Santri, $Oid)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return redirect('/santri/hafalan');

        $hafalan = Hafalan::where('Oid',$Oid)->first();
        $hafalan->delete();

        return back()->with('success','Berhasil menghapus hafalan');
    }
}