@extends('Templates.Master')
@section('pageTitle','Pengaturan Akun')

@section('content')
<div class="row">
  <div class="col-md-9 col-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <tr>
            <th width="200">Nama</th>
            <td>{{ $data->Nama }}</td>
          </tr>
          <tr>
            <th>Username</th>
            <td>{{ $data->Username }}</td>
          </tr>
          <tr>
            <th>Password</th>
            <td>*****</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-12">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#mdlUbahNama">Ubah Nama</button>
        @if (\Auth::user()->Role == 'admin')
          <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#mdlUbahUsername">Ubah Username</button>
        @endif
        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#mdlUbahPassword">Ubah Password</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mdlUbahNama" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Nama</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          @csrf
          <div class="form-group">
            <label>Nama <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Nama" required autocomplete="off" value="{{ $data->Nama }}">
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mdlUbahUsername" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Username</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          @csrf
          <div class="form-group">
            <label>Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Username" required autocomplete="off" value="{{ $data->Username }}">
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mdlUbahPassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          @csrf
          <div class="form-group">
            <label>Password Lama <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="OldPassword" required>
          </div>
          <div class="form-group">
            <label>Password Baru <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="Password" required>
          </div>
          <div class="form-group">
            <label>Ulangi Password Baru <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="NewPassword" required>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection