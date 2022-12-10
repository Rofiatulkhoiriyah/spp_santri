<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Ramsey\Uuid\Uuid;

use App\Models\Pengaturan;
use App\Models\DasborPengumuman;
use App\Models\DasborGambar;

class PengaturanController extends Controller
{
    private function upload($request, $inputName, $folderDestination)
    {
        $file = $request->file($inputName);
        $filename = date('YmdHis').'_'.$file->getClientOriginalName();
        $file->move($folderDestination,$filename);

        return $folderDestination . '/' . $filename;
    }

    // LEMBAGA PROFILE SECTION
    public function index()
    {
        $user = Auth::user();
        if($user->Role == 'admin') return $this->form();
        else return $this->show();
    }

    private function get()
    {
        $pengaturan = Pengaturan::all();
        $data = (object) [];
        foreach($pengaturan as $row) $data->{$row->Kode} = $row->Isi;

        return $data;
    }

    private function form()
    {
        $data = $this->get();
        return view('Pengaturan.Form')->with('data',$data);
    }

    private function show()
    {
        $data = $this->get();
        return view('Pengaturan.Show')->with('data',$data);
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return redirect('/setting')->with('warning','Kamu tidak memiliki akses untuk mengubah informasi');
        if($request->has('Logo')) return $this->changeLogo($request);
        else {
            foreach($request->all() as $key => $value) if($key != '_token') {
                $pengaturan = Pengaturan::where('Kode',$key)->first();
                $pengaturan->Isi = $value;
                $pengaturan->save();
            }

            return redirect('/setting')->with('success','Berhasil mengubah informasi');
        }
    }

    private function changeLogo($request)
    {
        $validator = Validator::make($request->all(),
        [
            'Logo' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);
        if($validator->fails()) return redirect('/setting')->with('error','File harus berekstensi jpg, jpeg, png, atau bmp');

        $pengaturan = Pengaturan::where('Kode','Logo')->first();

        if($pengaturan->Isi != 'assets/images/logo.png') unlink(public_path($pengaturan->Isi));

        $dir = $this->upload($request, 'Logo', 'upload');

        $pengaturan->Isi = $dir;
        $pengaturan->save();
        
        return redirect('/setting')->with('success','Berhasil mengubah logo');
    }

    // PENGUMUMAN SECTION
    public function listPengumuman()
    {
        if(Auth::user()->Role != 'admin') return redirect('/');
        $pengumuman = DasborPengumuman::orderBy('CreatedAt','DESC')->get();
        return view('Pengaturan.Pengumuman.List')->with('lists',$pengumuman);
    }

    public function savePengumuman(Request $request, $Oid = null)
    {
        if(Auth::user()->Role != 'admin') return redirect('/');
        if(!$Oid) {
            $pengumuman = new DasborPengumuman;
            $pengumuman->Oid = Uuid::uuid4();
        } else $pengumuman = DasborPengumuman::where('Oid',$Oid)->first();

        $pengumuman->Judul = $request->Judul;
        $pengumuman->Deskripsi = $request->Deskripsi;
        $pengumuman->Tampilkan = ($request->has('Tampilkan') && $request->Tampilkan == 'on') ? true : false;
        $pengumuman->save();

        return back()->with('success','Berhasil menyimpan pengumuman');
    }

    public function deletePengumuman($Oid)
    {
        if(Auth::user()->Role != 'admin') return redirect('/');
        $pengumuman = DasborPengumuman::where('Oid',$Oid)->first();
        $pengumuman->delete();

        return back()->with('success','Berhasil menghapus pengumuman');
    }

    public function getPengumuman($Oid, $type = 'edit')
    {
        $pengumuman = DasborPengumuman::where('Oid',$Oid)->select('Oid','Judul','Deskripsi','Tampilkan')->first();
        if($type == 'show') $pengumuman->Deskripsi = nl2br($pengumuman->Deskripsi);

        return response()->json($pengumuman, 200);
    }

    // GALERI SECTION
    public function listGaleri()
    {
        if(Auth::user()->Role != 'admin') return redirect('/');
        $galeri = DasborGambar::orderBy('CreatedAt','DESC')->get();
        return view('Pengaturan.Galeri.List')->with('lists',$galeri);
    }

    public function saveGaleri(Request $request, $Oid = null)
    {
        if(Auth::user()->Role != 'admin') return redirect('/');
        if(!$Oid) {
            $dir = $this->upload($request, 'Gambar', 'upload');
            $galeri = new DasborGambar;
            $galeri->Oid = Uuid::uuid4();
            $galeri->Direktori = $dir;
        } else $galeri = DasborGambar::where('Oid',$Oid)->first();
        
        if($request->has('Gambar') && $Oid) {
            $dir = $this->upload($request, 'Gambar', 'upload');
            unlink(public_path($galeri->Direktori));
            $galeri->Direktori = $dir;
        } else {
            $galeri->Judul = $request->Judul;
            $galeri->Deskripsi = $request->Deskripsi;
            $galeri->Tampilkan = ($request->has('Tampilkan') && $request->Tampilkan == 'on') ? true : false;
        }

        $galeri->save();

        return back()->with('success','Berhasil menyimpan gambar');
    }

    public function deleteGaleri($Oid)
    {
        if(Auth::user()->Role != 'admin') return redirect('/');
        $galeri = DasborGambar::where('Oid',$Oid)->first();
        $galeri->delete();

        return back()->with('success','Berhasil menghapus gambar');
    }

    public function getGaleri($Oid, $type = 'edit')
    {
        $galeri = DasborGambar::where('Oid',$Oid)->select('Oid','Direktori','Judul','Deskripsi','Tampilkan')->first();
        if($type == 'show') $galeri->Deskripsi = nl2br($galeri->Deskripsi);

        return response()->json($galeri, 200);
    }
}
