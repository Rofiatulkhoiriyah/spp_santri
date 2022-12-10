@extends('Templates.Master')
@section('pageTitle','Santri')

@section('extraCss')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('extraJs')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endsection

@section('customJs')
<script>
  $(function(){
    $("#dataTable").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
    })
  })
</script>
@endsection

@section('content')
<div class="card">
  <div class="card-header bg-dark">
    <h3 class="card-title">List Pengguna</h3>
  </div>
  <div class="card-body">
    <div class="mb-4 text-right">
      <a href="#" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#mdlTambah"><i class="fas fa-plus"></i> Tambah Admin</a>
      {{-- <a href="/pengguna/wali" class="btn btn-sm btn-secondary ml-2"><i class="fas fa-user-plus"></i> Tambah Wali</a> --}}
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="dataTable">
        <thead class="thead-dark">
          <tr>
            <th width="50">#</th>
            <th width="10"></th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td align="center">
              <button class="btn btn-primary btn-sm" id="dropdownMenuButton{{ $loop->iteration }}" data-toggle="dropdown">
              <i class="fas fa-chevron-down"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $loop->iteration }}">
                <a class="dropdown-item" href="/pengguna/ubah/{{ $list->Oid }}">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a class="dropdown-item" href="#" onclick="return confirmAlert('/pengguna/hapus/{{ $list->Oid }}')">
                  <i class="fas fa-trash"></i> Hapus
                </a>
              </div>
            </td>
            <td>{{ $list->Nama }}</td>
            <td>{{ $list->Username }}</td>
            <td>{{ ucwords($list->Role) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="mdlTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/pengguna/admin" method="post">
          @csrf
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" required autocomplete="off" name="Nama">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" required autocomplete="off" name="Username">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" required autocomplete="off" name="Password">
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