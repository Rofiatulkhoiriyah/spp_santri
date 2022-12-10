@extends('Templates.Master')
@section('pageTitle','Hafalan Santri')

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

@section('content')
    <div class="card">
        <div class="card-header bg-dark">
            <h3 class="card-title">List Hafalan</h3>
        </div>
        <div class="card-body">
            <div class="text-right">
                
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th width="10"></th>
                            <th>NIS</th>
                            <th>Santri</th>
                            <th>Jenis Kelamin</th>
                            <th>Jumlah Hafalan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" id="dropdownMenuButton{{ $loop->iteration }}" data-toggle="dropdown">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $loop->iteration }}">
                                        <a class="dropdown-item" href="/santri/hafalan/{{ $list->Oid }}">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $list->Santri->NIS }}</td>
                                <td>{{ $list->Santri->Nama }}</td>
                                <td>{{ $list->Santri->JenisKelamin }}</td>
                                <td>{{ $list->Jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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