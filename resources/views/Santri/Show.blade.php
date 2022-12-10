@extends('Templates.Master')
@section('pageTitle','Profil Santri')

@section('content')
@foreach ($data as $row)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">Profil Santri</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if (\Auth::user()->Role == 'admin')
                            <div class="col-12 d-flex justify-content-between mb-3">
                                <a href="/santri" class="btn btn-sm btn-secondary"><i class="fas fa-chevron-left"></i> Kembali</a>
                                <a href="/santri/ubah/{{ $row->Oid }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        @endif
                        <div class="col-md-2">
                            <img src="{{ asset($row->Foto) }}" class="img-fluid">
                        </div>
                        <div class="col-md-10 row">
                            <div class="col-md-4 mb-3 col-12">
                                <b>Nama</b> <br>
                                {{ $row->Nama }}
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <b>NIK</b> <br>
                                {{ $row->NIK }}
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <b>NIS</b> <br>
                                {{ $row->NIS }}
                            </div>
    
                            <div class="col-md-4 mb-3 col-12">
                                <b>Tanggal Lahir</b> <br>
                                {{ $row->TglLahir }}
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <b>Tanggal Masuk</b> <br>
                                {{ $row->TglMasuk }}
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <b>Aktif</b> <br>
                                {!! ($row->Aktif) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}
                            </div>
    
                            <div class="col-md-4 mb-3 col-12">
                                <b>Jenis Kelamin</b> <br>
                                {{ $row->JenisKelamin }}
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <b>Agama</b> <br>
                                {{ $row->Agama }}
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <b>Nomor Handphone</b> <br>
                                {{ $row->NoHp }}
                            </div>
    
                            <div class="col-md-6 mb-3 col-12">
                                <b>Hobi</b> <br>
                                {{ $row->Hobi }}
                            </div>
                            <div class="col-md-6 mb-3 col-12">
                                <b>Cita Cita</b> <br>
                                {{ $row->CitaCita }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection