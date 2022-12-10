<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DasborGambar;
use App\Models\DasborPengumuman;

class DasborController extends Controller
{
    public function index()
    {
        $pengumuman = DasborPengumuman::where('Tampilkan',true)->orderBy('CreatedAt','DESC')->get();
        $galeri = DasborGambar::where('Tampilkan',true)->orderBy('CreatedAt','ASC')->get();
        return view('Dashboard.Dasbor')->with('pengumuman', $pengumuman)->with('galeri',$galeri);
    }
}
