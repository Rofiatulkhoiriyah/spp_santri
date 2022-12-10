<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Tagihan;
use App\Models\Santri;
use App\Models\Wali;
use App\Models\JenisTagihan;
use App\Service\ExcelService;
use App\Service\PdfService;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->Role == 'admin') return $this->list($request);
        else return $this->show($user->Oid);
    }

    private function list($request, $return = 'view')
    {
        $jmlSPP = JenisTagihan::where('Jenis','Syahriah')->first();
        if($return == 'view') {
            $redirectParam = [];
            foreach($request->all() as $key => $value) $redirectParam[] = $key .'='. $value;
            
            if(!$request->has('Status') || ($request->Status != 'Belum Lunas' && $request->Status != 'Semua')) $redirectParam[] = 'Status=Belum Lunas';
            if(!$request->has('Jenis') || $request->Jenis == '') $redirectParam[] = 'Jenis=Semua';
            
            if(!$request->has('Status') || !$request->has('Jenis')) {
                $path = implode('&',$redirectParam);
                return redirect('/santri/tagihan?'.$path);
            }

            $createSpp = new Request([
                'Jumlah' => $jmlSPP->Jumlah,
                'Periode' => Carbon::now()->format('Y-m-d')
            ]);
            $this->createSpp($createSpp);
        }

        $data = [];

        if($return == 'data') $getSantri = Santri::where('Aktif',true)->orderBy('TglMasuk','DESC')->get();
        else $getSantri = Santri::orderBy('Aktif','DESC')->orderBy('TglMasuk','DESC')->get();
        foreach($getSantri as $santri) {
            $getTagihan = Tagihan::where('Santri',$santri->Oid);
            if($request->has('Jenis') && $request->Jenis != 'Semua') $getTagihan = $getTagihan->where('Jenis',$request->Jenis);
            if($request->has('Periode') && $request->Periode != '') {
                $filter = explode(' - ',$request->Periode);
                $dari = explode('/',$filter[0]);
                $dari = array_reverse($dari);
                $dari = implode('-',$dari);

                $sampai = explode('/',$filter[1]);
                $sampai = array_reverse($sampai);
                $sampai = implode('-',$sampai);

                $getTagihan = $getTagihan->whereBetween('Periode',[$dari, $sampai]);
            }
            $getTagihan = $getTagihan->get();

            $jml = 0;
            $jenis = [];
            $status = 'Lunas';
            foreach($getTagihan as $tagihan) {
                if($tagihan->Status == 'Belum Lunas') {
                    if(!in_array($tagihan->Jenis, $jenis)) $jenis[] = $tagihan->Jenis;
                    $jml += $tagihan->Jumlah;
                    $status = 'Belum Lunas';
                }
            }
            $jenis = implode(', ', $jenis);

            $tmp = (object) [
                'Oid' => $santri->Oid,
                'Santri' => $santri->Nama,
                'Jumlah' => $jml,
                'Jenis' => $jenis,
                'Status' => $status
            ];

            if($request->Status == 'Semua') $data[] = $tmp;
            elseif($request->Status == 'Belum Lunas' && $jml > 0) $data[] = $tmp;
        }

        $jenis = Tagihan::selectRaw('DISTINCT(Jenis) as Jenis')->get();
        if($return == 'view') return view('Tagihan.List')->with('lists',$data)->with('jenis',$jenis)->with('jmlSpp',$jmlSPP);
        elseif($return == 'data') return $data;
    }

    public function show($Oid)
    {
        $data = [];
        $santri = Santri::where('Oid',$Oid)->first();
        if(!$santri) $santri = Santri::where('Pengguna',$Oid)->first();

        if($santri) {
            $spp = Tagihan::where('Santri',$santri->Oid)->where('Jenis','Syahriah')->orderBy('Periode','DESC')->get();
            $tagihan = Tagihan::where('Santri',$santri->Oid)->where('Jenis','!=','Syahriah')->orderBy('Periode','DESC')->get();
            $data[] = (object) [
                'santri' => $santri,
                'spp' => $spp,
                'tagihan' => $tagihan
            ];
        } else {
            $wali = Wali::where('Pengguna',$Oid)->with('santriObj')->get();
            foreach($wali as $row) {
                $spp = Tagihan::where('Santri',$row->Santri)->where('Jenis','Syahriah')->orderBy('Periode','DESC')->get();
                $tagihan = Tagihan::where('Santri',$row->Santri)->where('Jenis','!=','Syahriah')->orderBy('Periode','DESC')->get();
                $data[] = (object) [
                    'santri' => $row->santriObj,
                    'spp' => $spp,
                    'tagihan' => $tagihan
                ]; 
            }
        }
        
        if(Auth::user()->Role != 'admin' && $data[0]->santri->Pengguna != Auth::user()->Oid) return redirect('/santri/tagihan');
        
        $jenis = Tagihan::selectRaw('DISTINCT(Jenis) as Jenis')->where('Jenis','!=','Syahriah')->get();
        return view('Tagihan.Show')->with('data',$data)->with('jenis',$jenis);
    }

    public function update($Santri, $Oid)
    {
        $user = Auth::user();
        $santri = Santri::where('Oid',$Santri)->first();
        if($user->Role != 'admin') return redirect('/santri/tagihan');

        $tagihan = Tagihan::where('Oid',$Oid)->first();
        $jenis = Tagihan::selectRaw('DISTINCT(Jenis) as Jenis')->where('Jenis','!=','Syahriah')->get();

        return view('Tagihan.Edit')->with('data',$tagihan)->with('santri',$santri)->with('jenis',$jenis);
    }

    public function save(Request $request, $Santri, $Oid = null)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return redirect('/santri/tagihan');

        if(!$request->has('Periode') || $request->Periode == '') return back()->with('warning','Kolom Periode harus diisi');
        if(!$request->has('Jenis') || $request->Jenis == '') return back()->with('warning','Kolom Jenis harus diisi');
        if(!$request->has('Jumlah') || $request->Jumlah == '') return back()->with('warning','Kolom Jumlah harus diisi');

        if(!$Oid) {
            $tagihan = new Tagihan;
            $tagihan->Oid = Uuid::uuid4();
            $tagihan->Status = 'Belum Lunas';
        } else $tagihan = Tagihan::where('Oid',$Oid)->first();

        $tagihan->Santri = $Santri;
        $tagihan->Periode = $request->Periode;
        $tagihan->Jenis = $request->Jenis;
        $tagihan->Jumlah = $request->Jumlah;
        $tagihan->save();

        return redirect('/santri/tagihan/'.$Santri)->with('success','Berhasil menyimpan tagihan');
    }

    public function delete($Santri, $Oid)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return redirect('/santri/tagihan');

        $tagihan = Tagihan::where('Oid',$Oid)->first();
        $tagihan->delete();

        return redirect('/santri/tagihan/'.$Santri)->with('success','Berhasil menghapus tagihan');
    }

    public function pay($Santri, $Oid)
    {
        $user = Auth::user();
        if($user->Role != 'admin') return redirect('/santri/tagihan');

        $tagihan = Tagihan::where('Oid',$Oid)->first();
        $tagihan->Status = 'Lunas';
        $tagihan->TglBayar = Carbon::now()->format('Y-m-d');
        $tagihan->save();

        return redirect('/santri/tagihan/'.$Santri)->with('success','Tagihan lunas');
    }

    public function createMass(Request $request)
    {
        if(!$request->has('DariTanggal') || $request->DariTanggal == '') return back()->with('warning','Kolom Tanggal Masuk (Dari) harus diisi');
        if(!$request->has('SampaiTanggal') || $request->SampaiTanggal == '') return back()->with('warning','Kolom Tanggal Masuk (Sampai) harus diisi');
        if(!$request->has('Periode') || $request->Periode == '') return back()->with('warning','Kolom Periode harus diisi');
        if(!$request->has('Jenis') || $request->Jenis == '') return back()->with('warning','Kolom Jenis harus diisi');
        if(!$request->has('Jumlah') || $request->Jumlah == '') return back()->with('warning','Kolom Jumlah harus diisi');

        $getSantri = Santri::where('Aktif',true)->whereBetween('TglMasuk',[$request->DariTanggal, $request->SampaiTanggal])->get();
        foreach($getSantri as $santri) {
            $tagihan = new Request([
                'Periode' => $request->Periode,
                'Jenis' => $request->Jenis,
                'Jumlah' => $request->Jumlah,
            ]);
            $this->save($tagihan, $santri->Oid);
        }

        return redirect('/santri/tagihan')->with('success','Berhasil membuat tagihan');
    }

    public function updateSpp(Request $request)
    {
        $jmlSPP = JenisTagihan::where('Jenis','Syahriah')->first();
        if(!$jmlSPP) {
            $jmlSPP = new JenisTagihan;
            $jmlSPP->Oid = Uuid::uuid4();
            $jmlSPP->Jenis = 'Syahriah';
        } 

        $jmlSPP->Jumlah = $request->Jumlah;
        $jmlSPP->save();

        return back()->with('success','Berhasil menyimpan jumlah tagihan Syahriah baru');
    }

    public function createSpp(Request $request)
    {
        if(!$request->has('Periode') || $request->Periode == '') return back()->with('warning','Kolom Periode harus diisi');
        if(!$request->has('Jumlah') || $request->Jumlah == '') return back()->with('warning','Kolom Jumlah harus diisi');

        $getSantri = Santri::where('Aktif',true)->get();
        foreach($getSantri as $santri) {
            $periode = Carbon::parse($request->Periode)->startOfMonth()->format('Y-m-d');
            $check = Tagihan::where('Santri',$santri->Oid)->where('Periode',$periode)->where('Jenis','Syahriah')->first();
            if($check) continue;

            $tagihan = new Request([
                'Periode' => $periode,
                'Jenis' => 'Syahriah',
                'Jumlah' => $request->Jumlah,
            ]);
            $this->save($tagihan, $santri->Oid);
        }

        \Session::forget('success');
        return true;
    }

    private function reportTableHeader()
    {
        $tableHeader = [
            (object) ['Label' => 'Santri', 'Field' => 'Santri'],
            (object) ['Label' => 'Jumlah Tagihan', 'Field' => 'Jumlah'],
            (object) ['Label' => 'Jenis-jenis Tagihan', 'Field' => 'Jenis'],
            (object) ['Label' => 'Status', 'Field' => 'Status'],
        ];

        return $tableHeader;
    }

    public function exportExcel(Request $request)
    {
        if(Auth::user()->Role != 'admin') return redirect('/santri/tagihan');

        $data = $this->list($request, 'data');
        $i = 1;
        foreach($data as $row) $row->Numbering = $i++;

        $tableHeader = $this->reportTableHeader();
        array_unshift($tableHeader, (object) ['Label' => '#', 'Field' => 'Numbering']);

        $service = new ExcelService;
        $filename = 'Total Tagihan Santri Per Tanggal ' . Carbon::now()->format('d F Y');
        return $service->setTitle($filename)
                        ->setHeader($tableHeader)
                        ->setData($data)
                        ->filename($filename)
                        ->download();
    }

    public function exportExcelBySantri($santri, $type)
    {
        $santri = Santri::where('Oid',$santri)->first();
        if(Auth::user()->Role != 'admin' && Auth::user()->Oid != $santri->Pengguna) return redirect('/santri/tagihan');

        if($type == 'spp') {
            $data = Tagihan::where('Santri',$santri->Oid)->where('Jenis','Syahriah')->orderBy('Periode','DESC')->get();
            $tableHeader = [
                (object) ['Label' => '#', 'Field' => 'Numbering'],
                (object) ['Label' => 'Periode', 'Field' => 'Periode'],
                (object) ['Label' => 'Tanggal Bayar', 'Field' => 'TglBayar'],
                (object) ['Label' => 'Jumlah', 'Field' => 'Jumlah'],
                (object) ['Label' => 'Status', 'Field' => 'Status'],
            ];
        } elseif($type == 'lainnya') {
            $data = Tagihan::where('Santri',$santri->Oid)->where('Jenis','!=','Syahriah')->orderBy('Periode','DESC')->get();
            $tableHeader = [
                (object) ['Label' => '#', 'Field' => 'Numbering'],
                (object) ['Label' => 'Periode', 'Field' => 'Periode'],
                (object) ['Label' => 'Jenis', 'Field' => 'Jenis'],
                (object) ['Label' => 'Tanggal Bayar', 'Field' => 'TglBayar'],
                (object) ['Label' => 'Jumlah', 'Field' => 'Jumlah'],
                (object) ['Label' => 'Status', 'Field' => 'Status'],
            ];
        }
        $i = 1;
        foreach($data as $row) {
            $row->Numbering = $i++;
            $row->Periode = Carbon::parse($row->Periode)->format('d F Y');
            $row->TglBayar = Carbon::parse($row->TglBayar)->format('d F Y');
        }

        $information = ['Nama' => $santri->Nama, 'NIS' => $santri->NIS];

        $service = new ExcelService;
        $filename = 'Total Tagihan Santri';
        $subtitle = getSettings('Nama');
        return $service->setTitle($filename)
                        ->setSubtitle($subtitle)
                        ->setInformation($information)
                        ->setHeader($tableHeader)
                        ->setData($data)
                        ->filename($filename)
                        ->download();
    }

    public function exportPdf(Request $request)
    {
        if(Auth::user()->Role != 'admin') return redirect('/santri/tagihan');
        
        $data = $this->list($request, 'data');

        $service = new PdfService;
        $filename = 'Total Tagihan Santri Per Tanggal ' . Carbon::now()->format('d F Y');

        return $service->setTitle($filename)
                ->setHeader($this->reportTableHeader())
                ->setData($data)
                ->filename($filename)
                ->download('Templates.TagihanReport');
    }

    public function exportPdfBySantri($santri, $type)
    {
        $santri = Santri::where('Oid',$santri)->first();
        if(Auth::user()->Role != 'admin' && Auth::user()->Oid != $santri->Pengguna) return redirect('/santri/tagihan');

        if($type == 'spp') {
            $data = Tagihan::where('Santri',$santri->Oid)->where('Jenis','Syahriah')->orderBy('Periode','DESC')->get();
            $tableHeader = [
                (object) ['Label' => 'Periode', 'Field' => 'Periode'],
                (object) ['Label' => 'Tanggal Bayar', 'Field' => 'TglBayar'],
                (object) ['Label' => 'Jumlah', 'Field' => 'Jumlah'],
                (object) ['Label' => 'Status', 'Field' => 'Status'],
            ];
        } elseif($type == 'lainnya') {
            $data = Tagihan::where('Santri',$santri->Oid)->where('Jenis','!=','Syahriah')->orderBy('Periode','DESC')->get();
            $tableHeader = [
                (object) ['Label' => 'Periode', 'Field' => 'Periode'],
                (object) ['Label' => 'Jenis', 'Field' => 'Jenis'],
                (object) ['Label' => 'Tanggal Bayar', 'Field' => 'TglBayar'],
                (object) ['Label' => 'Jumlah', 'Field' => 'Jumlah'],
                (object) ['Label' => 'Status', 'Field' => 'Status'],
            ];
        }
        foreach($data as $row) {
            $row->Periode = Carbon::parse($row->Periode)->format('d F Y');
            $row->TglBayar = Carbon::parse($row->TglBayar)->format('d F Y');
        }

        $service = new PdfService;
        $filename = 'Total Tagihan Santri';
        $subtitle = getSettings('Nama');

        $information = ['Nama' => $santri->Nama, 'NIS' => $santri->NIS];

        return $service->setTitle(nl2br($filename . PHP_EOL . $subtitle))
                ->setInformation($information)
                ->setHeader($tableHeader)
                ->setData($data)
                ->filename($filename)
                ->download();
    }
}
