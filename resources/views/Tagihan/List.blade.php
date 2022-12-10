@extends('Templates.Master')
@section('pageTitle','Tagihan Santri')

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
            <h3 class="card-title">List Tagihan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <form action="" method="get" class="col-md-7 row" id="frmPresearch">                
                    <div class="form-group col-md-3 col-12">
                        <label>Status Tagihan</label>
                        <select name="Status" class="form-control">
                            <option value="Belum Lunas" {{ ($_GET['Status'] == 'Belum Lunas') ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Semua" {{ ($_GET['Status'] == 'Semua') ? 'selected' : '' }}>Semua Santri</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label>Jenis</label>
                        <select name="Jenis" class="form-control">
                            <option value="Semua" {{ ($_GET['Jenis'] == 'Semua') ? 'selected' : '' }}>Semua</option>
                            @foreach ($jenis as $row)
                                <option value="{{ $row->Jenis }}" {{ ($_GET['Jenis'] == $row->Jenis) ? 'selected' : '' }}>{{ $row->Jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label>Periode</label>
                        <input type="text" class="form-control" id="dtPeriode" autocomplete="off" readonly name="Periode" value="{{ isset($_GET['Periode']) ? $_GET['Periode'] : '' }}">
                    </div>
                </form>
                <div class="col-md-5 text-right">
                    <button class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#mdlTagihanMasal">
                        <i class="fas fa-plus"></i> Buat Tagihan Masal
                    </button>
                    <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#mdlTagihanSPP">
                        <i class="fas fa-cog"></i> Atur Tagihan Syahriah
                    </button>
                    <a href="/santri/tagihan/excel?{{ $_SERVER['QUERY_STRING'] }}" class="btn btn-secondary btn-sm mb-1">
                        <i class="fas fa-file-excel"></i> Unduh Excel
                    </a>
                    <a href="/santri/tagihan/pdf?{{ $_SERVER['QUERY_STRING'] }}" class="btn btn-secondary btn-sm mb-1">
                        <i class="fas fa-file-pdf"></i> Unduh PDF
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th width="10"></th>
                            <th>Santri</th>
                            <th>Jumlah Tagihan</th>
                            <th>Jenis-jenis Tagihan</th>
                            <th>Status</th>
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
                                        <a class="dropdown-item" href="/santri/tagihan/{{ $list->Oid }}">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $list->Santri }}</td>
                                <td>{{ number_format($list->Jumlah) }}</td>
                                <td>{{ $list->Jenis }}</td>
                                <td>{{ $list->Status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdlTagihanMasal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Tagihan Masal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/santri/tagihan/mass" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col">
                                <label>Dari (Tanggal Masuk Santri)</label>
                                <input type="text" class="form-control dtpicker" required readonly name="DariTanggal" placeholder="Klik untuk memilih tanggal">
                            </div>
                            <div class="form-group col">
                                <label>Sampai (Tanggal Masuk Santri)</label>
                                <input type="text" class="form-control dtpicker" required readonly name="SampaiTanggal" placeholder="Klik untuk memilih tanggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <input type="text" class="form-control dtpicker" required readonly name="Periode" placeholder="Klik untuk memilih periode">
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select id="cmbJenis" class="form-control">
                                <option value="0">--- Pilih Jenis ---</option>
                                @foreach ($jenis as $row)
                                    <option value="{{ $row->Jenis }}">{{ $row->Jenis }}</option>                                    
                                @endforeach
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" class="form-control mt-2" required name="Jenis" autocomplete="off" id="txtJenis" placeholder="Masukkan jenis pembayaran" style="display: none">
                        </div>
                        <div class="form-group">
                            <label>Jumlah Tagihan</label>
                            <input type="number" class="form-control" required name="Jumlah" placeholder="Masukkan jumlah yang harus dibayar">
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

    <div class="modal fade" id="mdlTagihanSPP" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tagihan Syahriah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/santri/tagihan/spp" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Jumlah Tagihan</label>
                            <input type="number" class="form-control" required name="Jumlah" placeholder="Masukkan jumlah yang harus dibayar" value="{{ ($jmlSpp) ? $jmlSpp->Jumlah : 0 }}">
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

@section('customJs')
<script>
    $(function(){
        $("#dataTable").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
        })

        $("#cmbJenis").on("change",function(){
            let val = $(this).val()
            
            if(val != 0 && val != 'Lainnya') $("#txtJenis").val(val)
            else if(val == 0 || val == 'Lainnya') $("#txtJenis").val("")

            if(val == 'Lainnya') $("#txtJenis").css("display","")
            else $("#txtJenis").css("display","none")
        })

        $("#frmPresearch").change(function(){
            $("#frmPresearch").submit()
        })

        $("#dtPeriode").daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD/M/YYYY'
            }
        })

        $("#dtPeriode").on("apply.daterangepicker", function(ev, picker) {
            $(this).val(picker.startDate.format("DD/M/YYYY") + " - " + picker.endDate.format("DD/M/YYYY"));
            $("#frmPresearch").submit()
        });

        $("#dtPeriode").on("cancel.daterangepicker", function(ev, picker) {
            $(this).val("");
        });
    })
</script>
@endsection