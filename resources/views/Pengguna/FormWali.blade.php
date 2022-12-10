@extends('Templates.Master')
@section('pageTitle','Form Wali')

@section('content')
  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title">Form Wali</h3>
    </div>
    <div class="card-body">
      <form action="/pengguna/wali{{ (isset($data)) ? '/' . $data->Oid : '' }}" method="post">
        @csrf
        <div class="form-group">
          <label>Nama</label>
          <input type="text" class="form-control" required autocomplete="off" name="Nama" value="{{ isset($data->Nama) ? $data->Nama : '' }}">
        </div>
        <div class="row">
          @if (!isset($data))
            <div class="form-group col-md-6 col-12">
              <label>Username</label>
              <input type="text" class="form-control" required autocomplete="off" name="Username">
            </div>
          @endif
          <div class="form-group {{ !isset($data) ? 'col-md-6' : '' }} col-12">
            <label>Password</label>
            <input type="password" class="form-control" required autocomplete="off" name="Password">
          </div>
        </div>
        <div class="form-group">
          <label>Santri</label>
          <div class="container-fluid">
            <div class="row">
              @foreach ($santri as $row)
                <div class="form-check col-md-2 col-12">
                  <input class="form-check-input" type="checkbox" id="cbx{{ $row->Oid }}" name="{{ $row->Oid }}" {{ (isset($selected) && in_array($row->Oid, $selected)) ? 'checked' : '' }}>
                  <label class="form-check-label" for="cbx{{ $row->Oid }}">
                    {{ $row->Nama }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="text-right">
          <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
@endsection