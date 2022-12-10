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

        $(".btnUbahFoto").click(function(e){
            e.preventDefault()
            const oid = $(this).data("oid")
            const link = "/santri/ubah/" + oid
            $("#mdlUbahFoto form").attr("action",link)
            $("#mdlUbahFoto").modal("show")
        })

    })
</script>
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-dark">
        <h3 class="card-title">List Santri</h3>
    </div>
    <div class="card-body">
        <div class="mb-4 text-right">
            <a href="/santri/tambah" class="btn btn-sm btn-primary ml-2"><i class="fas fa-plus"></i> Tambah Santri</a>
            <a href="/santri/ekspor" class="btn btn-sm btn-secondary ml-2"><i class="fas fa-file-excel"></i> Unduh Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th width="50">#</th>
                        <th width="10"></th>
                        <th>Nama</th>
                        <th width="10">Aktif</th>
                        <th>NIK</th>
                        <th>NIS</th>
                        <th>Tanggal Masuk</th>
                        <th>Jenis Kelamin</th>
                        <th>Nomor HP</th>
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
                                    <a class="dropdown-item" href="/santri/detail/{{ $list->Oid }}">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <a class="dropdown-item" href="/santri/ubah/{{ $list->Oid }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="return confirmAlert('/santri/hapus/{{ $list->Oid }}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </td>
                            <td>{{ $list->Nama }}</td>
                            @if ($list->Aktif)
                                <td align="center"><i class="text-success fas fa-check"></i></td>
                            @else
                                <td align="center"><i class="text-danger fas fa-times"></i></td>
                            @endif
                            <td>{{ $list->NIK }}</td>
                            <td>{{ $list->NIS }}</td>
                            <td>{{ $list->TglMasuk }}</td>
                            <td>{{ $list->JenisKelamin }}</td>
                            <td>{{ $list->NoHp }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlUbahFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Foto Santri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Foto Baru</label>
                        <input type="file" class="form-control-file" required name="Foto">
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