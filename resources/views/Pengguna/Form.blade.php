@extends('Templates.Master')
@section('pageTitle','Form Pengguna')

@section('content')
  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title">Form Pengguna</h3>
    </div>
    <div class="card-body">
      <form action="/pengguna/admin/{{ $data->Oid }}" method="post">
        @csrf
        <div class="form-group">
          <label>Nama</label>
          <input type="text" class="form-control" required autocomplete="off" name="Nama" value="{{ $data->Nama }}">
        </div>
        <div class="form-group">
          <label>Password Baru</label>
          <input type="password" class="form-control" autocomplete="off" name="Password">
        </div>
        <div class="text-right">
          <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
@endsection