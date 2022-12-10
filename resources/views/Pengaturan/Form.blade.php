@extends('Templates.Master')
@section('pageTitle','Profil Lembaga')

@section('content')
<div class="row">
  <div class="col-md-3">
    <div class="card">
      <div class="card-header bg-dark">
        <h3 class="card-title">Logo Lembaga</h3>
      </div>
      <div class="card-body">
        <div class="text-center">
          <img src="{{ asset($data->Logo) }}" height="100" width="auto">
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label>Ubah Logo</label>
            <input type="file" class="form-control-file" name="Logo" required>
          </div>
          <div class="text-right">
            <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Perbarui Logo</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <form action="" method="post" class="col-md-9 row">
    @csrf
    <div class="col-md-7">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title">Profil Lembaga</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Jenjang</label>
            <input type="text" class="form-control" name="Jenjang" autocomplete="off" value="{{ $data->Jenjang }}">
          </div>
          <div class="form-group">
            <label>No. Statistik</label>
            <input type="text" class="form-control" name="NoStatistik" autocomplete="off" value="{{ $data->NoStatistik }}">
          </div>
          <div class="form-group">
            <label>Nama Lembaga</label>
            <input type="text" class="form-control" name="Nama" required autocomplete="off" value="{{ $data->Nama }}">
          </div>
          <div class="form-group">
            <label>Alamat Jalan</label>
            <textarea name="Alamat" class="form-control">{{ $data->Alamat }}</textarea>
          </div>
          <div class="row">
            <div class="form-group col-6">
              <label>RT</label>
              <input type="text" class="form-control" name="RT" autocomplete="off" value="{{ $data->RT }}">
            </div>
            <div class="form-group col-6">
              <label>RW</label>
              <input type="text" class="form-control" name="RW" autocomplete="off" value="{{ $data->RW }}">
            </div>
          </div>
          <div class="form-group">
            <label>Provinsi</label>
            <input type="text" class="form-control" name="Provinsi" autocomplete="off" value="{{ $data->Provinsi }}">
          </div>
          <div class="form-group">
            <label>Kabupaten/Kota</label>
            <input type="text" class="form-control" name="Kota" autocomplete="off" value="{{ $data->Kota }}">
          </div>
          <div class="form-group">
            <label>Kecamatan</label>
            <input type="text" class="form-control" name="Kecamatan" autocomplete="off" value="{{ $data->Kecamatan }}">
          </div>
          <div class="form-group">
            <label>Kode Pos</label>
            <input type="text" class="form-control" name="KodePos" autocomplete="off" value="{{ $data->KodePos }}">
          </div>
          <div class="row">
            <div class="form-group col-6">
              <label>Lintang</label>
              <input type="text" class="form-control" name="Lintang" autocomplete="off" value="{{ $data->Lintang }}">
            </div>
            <div class="form-group col-6">
              <label>Bujur</label>
              <input type="text" class="form-control" name="Bujur" autocomplete="off" value="{{ $data->Bujur }}">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-6">
              <label>Telepon</label>
              <input type="text" class="form-control" name="Telepon" autocomplete="off" value="{{ $data->Telepon }}">
            </div>
            <div class="form-group col-6">
              <label>Fax</label>
              <input type="text" class="form-control" name="Fax" autocomplete="off" value="{{ $data->Fax }}">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-6">
              <label>Website</label>
              <input type="text" class="form-control" name="Website" autocomplete="off" value="{{ $data->Website }}">
            </div>
            <div class="form-group col-6">
              <label>Email</label>
              <input type="text" class="form-control" name="Email" autocomplete="off" value="{{ $data->Email }}">
            </div>
          </div>
          <div class="form-group">
            <label>Topografi</label>
            <input type="text" class="form-control" name="Topografi" autocomplete="off" value="{{ $data->Topografi }}">
          </div>
          <div class="form-group">
            <label>Geografi</label>
            <input type="text" class="form-control" name="Geografi" autocomplete="off" value="{{ $data->Geografi }}">
          </div>
          <div class="form-group">
            <label>Potensi Ekonomi</label>
            <input type="text" class="form-control" name="PotensiEkonomi" autocomplete="off" value="{{ $data->PotensiEkonomi }}">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title">Data Pendirian</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Tahun Berdiri (Hijriah)</label>
            <input type="number" class="form-control" name="ThnBerdiriHijriah" autocomplete="off" value="{{ $data->ThnBerdiriHijriah }}">
          </div>
          <div class="form-group">
            <label>Tahun Berdiri (Masehi)</label>
            <input type="text" class="form-control" name="ThnBerdiriMasehi" autocomplete="off" value="{{ $data->ThnBerdiriMasehi }}">
          </div>
          <div class="form-group">
            <label>No SK IJOP</label>
            <input type="text" class="form-control" name="NoSK" autocomplete="off" value="{{ $data->NoSK }}">
          </div>
          <div class="form-group">
            <label>Tanggal SK IJOP</label>
            <input type="date" class="form-control" name="TglSK" autocomplete="off" value="{{ $data->TglSK }}">
          </div>
          <div class="form-group">
            <label>Instansi/Penerbit IJOP</label>
            <input type="text" class="form-control" name="PenerbitSK" autocomplete="off" value="{{ $data->PenerbitSK }}">
          </div>
          <div class="col-12 text-right">
            <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection