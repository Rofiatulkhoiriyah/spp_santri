@extends('Templates.Master')
@section('pageTitle','Profil Lembaga')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-dark">
        <h3 class="card-title">Informasi Lembaga</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <h3 class="text-center">PROFIL LEMBAGA</h3>
          </div>
          <div class="col-md-4">
            <h3 class="text-center">DATA PENDIRIAN</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2 col-12">
            <img src="{{ $data->Logo }}" class="img-fluid">
          </div>
          <div class="col-md-6 col-12">
            <div class="row">
              <div class="col-md-6 col-12 mb-4">
                <b>Jenjang</b> <br>
                {{ $data->Jenjang }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>No Statistik</b> <br>
                {{ $data->NoStatistik }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Nama Lembaga</b> <br>
                {{ $data->Nama }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Alamat</b> <br>
                {{ $data->Alamat }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>RT</b> <br>
                {{ $data->RT }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>RW</b> <br>
                {{ $data->RW }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Provinsi</b> <br>
                {{ $data->Provinsi }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Kabupaten/Kota</b> <br>
                {{ $data->Kota }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Kecamatan</b> <br>
                {{ $data->Kecamatan }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Kode Pos</b> <br>
                {{ $data->KodePos }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Lintang</b> <br>
                {{ $data->Lintang }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Bujur</b> <br>
                {{ $data->Bujur }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Telepon</b> <br>
                {{ $data->Telepon }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Fax</b> <br>
                {{ $data->Fax }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Email</b> <br>
                {{ $data->Email }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Website</b> <br>
                {{ $data->Website }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Topografi</b> <br>
                {{ $data->Topografi }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Geografi</b> <br>
                {{ $data->Geografi }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Potensi Ekonomi</b> <br>
                {{ $data->PotensiEkonomi }}
              </div>
            </div>
          </div>
          <div class="col-md-4 col-12">
            <div class="row">
              <div class="col-md-6 col-12 mb-4">
                <b>Tahun Berdiri Hijriah</b> <br>
                {{ $data->ThnBerdiriHijriah }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Tahun Berdiri Masehi</b> <br>
                {{ $data->ThnBerdiriMasehi }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>No SK IJOP</b> <br>
                {{ $data->NoSK }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Tanggal SK IJOP</b> <br>
                {{ $data->TglSK }}
              </div>
              <div class="col-md-6 col-12 mb-4">
                <b>Instansi/Penerbit IJOP</b> <br>
                {{ $data->PenerbitSK }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection