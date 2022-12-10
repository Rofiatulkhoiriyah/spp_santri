<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Santri;
use Ramsey\Uuid\Uuid;
use App\Models\Pengguna;
use App\Models\Wali;
use App\Service\ExcelService;
use Carbon\Carbon;

class SantriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->Role == 'admin') return $this->list();
        else return $this->show($user->Oid);
    }

    private function list()
    {
        $data = Santri::orderBy('Aktif','DESC')->orderBy('TglMasuk','DESC')->get();
        return view('Santri.List')->with('lists',$data);
    }

    public function show($Oid)
    {
        $data = Santri::where('Oid',$Oid)->get();
        if(count($data) < 1) {
            $wali = Wali::where('Pengguna',$Oid)->with('santriObj')->get();
            if(count($wali) > 0) {
                $data = [];
                foreach($wali as $row) $data[] = $row->santriObj;
            } else $data = Santri::where('Pengguna',$Oid)->get();
        }

        if(Auth::user()->Role != 'admin' && $data[0]->Pengguna != Auth::user()->Oid) return redirect('/');

        return view('Santri.Show')->with('data',$data);
    }

    private function checkPermission($Oid)
    {
        $user = Auth::user();
        if(!$Oid && $user->Role != 'admin') return false;
        elseif($Oid && $user->Role == 'user') {
            $self = Santri::where('Pengguna',$user->Oid)->first();
            if($self->Oid != $Oid) return false;
        }

        return true;
    }

    public function form($Oid = null)
    {
        if(!$this->checkPermission($Oid)) return redirect('/santri');

        if($Oid) {
            $data = Santri::where('Oid',$Oid)->with('penggunaObj')->first();
            $data->Username = $data->penggunaObj->Username;
        }

        if($old = \Session::get('old')) {
            $data = (object) $old;
            $data->isOld = true;
        }
        
        if($old = \Session::get('editOld')) {
            $data = (object) $old;
            $data->isEditOld = true;
        }

        $view = view('Santri.Form');
        if(isset($data)) $view = $view->with('data',$data);
        return $view;
    }

    public function save(Request $request, $Oid = null)
    {
        if(!$this->checkPermission($Oid)) return redirect('/santri');

        $required = ['Nama','TglMasuk','TglLahir','JenisKelamin','Username'];
        foreach($required as $field) if($request->has($field)) {
            $value = str_replace(' ','',$request->{$field});
            if($value == '' || $value == '0') return back()->with('warning','Kolom <b>'. $field .'</b> harus diisi')->with('old',$request->all());
        }

        if($Oid) $santri = Santri::where('Oid',$Oid)->first();
        else {
            $santri = new Santri;
            $santri->Oid = Uuid::uuid4();
        }

        if(!$Oid) {
            $penggunaOid = Uuid::uuid4();
            $check = Pengguna::where('Username', $request->Username)->first();
            if($check) return back()->with('error','Username sudah terdaftar, silahkan masukkan username yang berbeda')->with('old',$request->all());
            Pengguna::insert([
                'Oid' => $penggunaOid,
                'Nama' => $request->Nama,
                'Username' => $request->Username,
                'Password' => bcrypt($request->Password),
                'Role' => 'user'
            ]);
        } else {
            $pengguna = Pengguna::where('Oid', $santri->Pengguna)->first();
            $penggunaOid = $santri->Pengguna;
            if($request->Username && $request->Username != $pengguna->Username) {
                $check = Pengguna::where('Username', $request->Username)->first();
                if($check) return back()->with('error','Username sudah terdaftar, silahkan masukkan username yang berbeda')->with('editOld', $request->all());

                $pengguna->Username = $request->Username;
                if($request->Password) $pengguna->Password = bcrypt($request->Password);
                $pengguna->save();
            }
        }

        if($request->has('Foto')) {
            $validator = Validator::make($request->all(),
            [
                'Foto' => 'required|mimes:jpg,jpeg,png,bmp'
            ]);
            if($validator->fails()) return back()->with('error','Foto harus berekstensi jpg, jpeg, png, atau bmp');

            $dir = $this->upload($request, 'Foto', 'upload');
            $santri->Foto = $dir;
        }

        if(!$request->has('Aktif') && !$request->has('Foto') && $Oid) $request->request->add(['Aktif' => 0]);

        $except = ['_token','Username','Password','Pengguna','Foto'];
        foreach($request->all() as $key => $value) if(!in_array($key, $except)) {
            $value = ($value === 'on') ? 1 : $value;
            $santri->{$key} = $value;
        }

        if(!$Oid) $santri->Pengguna = $penggunaOid;
        $santri->save();

        $pengguna = Pengguna::where('Oid',$santri->Pengguna)->first();
        $pengguna->Nama = $santri->Nama;
        $pengguna->save();


        return redirect('/santri/detail/'.$santri->Oid)->with('success','Data berhasil disimpan');
    }

    public function delete($Oid)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return redirect('/santri');

        $santri = Santri::where('Oid',$Oid)->first();
        $pengguna = Pengguna::where('Oid',$santri->Pengguna)->delete();
        $santri->delete();

        return redirect('/santri')->with('success','Data berhasil dihapus');
    }

    public function export()
    {
        if(Auth::user()->Role != 'admin') return redirect('/');

        $tableHeader = [
            ['Label' => 'Nama', 'Field' => 'Nama'],
            ['Label' => 'NIK', 'Field' => 'NIK'],
            ['Label' => 'NIS', 'Field' => 'NIS'],
            ['Label' => 'Tanggal Lahir', 'Field' => 'TglLahir'],
            ['Label' => 'Jenis Kelamin', 'Field' => 'JenisKelamin'],
            ['Label' => 'Agama', 'Field' => 'Agama'],
            ['Label' => 'Hobi', 'Field' => 'Hobi'],
            ['Label' => 'Cita-Cita', 'Field' => 'CitaCita'],
            ['Label' => 'Nomor Handphone', 'Field' => 'NoHp'],
            ['Label' => 'Tanggal Masuk', 'Field' => 'TglMasuk'],
        ];

        $data = Santri::where('Aktif',true)->get();

        $service = new ExcelService;
        $filename = 'Data Santri ' . Carbon::now()->format('d F Y');
        return $service->setTitle('Data Santri')->setHeader($tableHeader)->setData($data)->filename($filename)->download();
    }

    private function upload($request, $inputName, $folderDestination)
    {
        $file = $request->file($inputName);
        $filename = date('YmdHis').'_'.$file->getClientOriginalName();
        $file->move($folderDestination,$filename);

        return $folderDestination . '/' . $filename;
    }
}
