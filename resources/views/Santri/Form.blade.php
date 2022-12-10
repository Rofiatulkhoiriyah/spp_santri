@extends('Templates.Master')
@section('pageTitle','Santri')

@section('content')
<div class="card">
    <div class="card-header bg-dark">
        <h3 class="card-title">Ubah Santri</h3>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <a href="/santri" class="btn btn-sm btn-secondary ml-2"><i class="fas fa-chevron-left"></i> Kembali</a>
        </div>
        <form action="" method="post" class="row" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-3">
                <label>Foto Santri</label>
                @if (isset($data) && !isset($data->isOld) && isset($data->Foto) && $data->Foto)
                    <div class="mb-1">
                        <img src="{{ asset($data->Foto) }}" width="80">
                    </div>
                @endif
                <input type="file" class="form-control-file" name="Foto" {{ (!isset($data) || isset($data->isOld)) ? 'required' : '' }}>
            </div>
            <div class="form-group col-md-3">
                <label>NIK</label>
                <input type="text" class="form-control" name="NIK" autocomplete="off" value="{{ isset($data) ? $data->NIK : '' }}">
            </div>
            <div class="form-group col-md-3">
                <label>NIS</label>
                <input type="text" class="form-control" name="NIS" autocomplete="off" value="{{ isset($data) ? $data->NIS : '' }}">
            </div>
            <div class="form-group col-md-3">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="Nama" required autocomplete="off" value="{{ isset($data) ? $data->Nama : '' }}">
            </div>
            
            <div class="form-group col-md-4">
                <label>Status</label>
                <div class="container ml-3">
                    <input class="form-check-input" name="Aktif" type="checkbox" {{ (isset($data) && isset($data->Aktif) && $data->Aktif) ? 'checked' : '' }} id="cbxAktif">
                    <label class="form-check-label" for="cbxAktif">
                        Aktif
                    </label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label>Nomor Handphone</label>
                <input type="number" class="form-control" name="NoHp" autocomplete="off" value="{{ isset($data) ? $data->NoHp : '' }}">
            </div>
            <div class="form-group col-md-4">
                <label>Tanggal Masuk <span class="text-danger">*</span></label>
                <input type="text" readonly class="form-control dtpicker" name="TglMasuk" required autocomplete="off" value="{{ isset($data) ? $data->TglMasuk : date('Y-m-d') }}" placeholder="Klik untuk memilih tanggal">
            </div>
            
            <div class="form-group col-md-4">
                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="text" readonly class="form-control dtpicker" name="TglLahir" required autocomplete="off" value="{{ isset($data) ? $data->TglLahir : '' }}" placeholder="Klik untuk memilih tanggal">
            </div>
            <div class="form-group col-md-4">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="JenisKelamin" class="form-control">
                    <option value="0">--- Pilih Jenis Kelamin ---</option>
                    <option value="Laki-Laki" {{ (isset($data) && $data->JenisKelamin == 'Laki-Laki') ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="Perempuan" {{ (isset($data) && $data->JenisKelamin == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Agama <span class="text-danger">*</span></label>
                <select name="Agama" class="form-control">
                    <option value="Islam" {{ (isset($data) && $data->Agama == 'Islam') ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ (isset($data) && $data->Agama == 'Kristen') ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ (isset($data) && $data->Agama == 'Katolik') ? 'selected' : '' }}>Katolik</option>
                    <option value="Buddha" {{ (isset($data) && $data->Agama == 'Buddha') ? 'selected' : '' }}>Buddha</option>
                    <option value="Hindu" {{ (isset($data) && $data->Agama == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                    <option value="Konghucu" {{ (isset($data) && $data->Agama == 'Konghucu') ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>
            
            <div class="form-group col-md-6">
                <label>Hobi</label>
                <input type="text" class="form-control" name="Hobi" autocomplete="off" value="{{ isset($data) ? $data->Hobi : '' }}">
            </div>
            <div class="form-group col-md-6">
                <label>CitaCita</label>
                <input type="text" class="form-control" name="CitaCita" autocomplete="off" value="{{ isset($data) ? $data->CitaCita : '' }}">
            </div>

            <div class="col-12 mt-2">
                <h5><b>Akun</b></h5>
            </div>
            <div class="form-group col-md-6">
                <label>Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="Username" autocomplete="off" required value="{{ isset($data) ? $data->Username : '' }}" {{ (isset($data) || isset($data->isEditOld)) ? 'disabled' : '' }}>
            </div>
            <div class="form-group col-md-6">
                <label>
                    Password 
                    @if ((!isset($data) || isset($data->isOld)) && !isset($data->isEditOld))
                        <span class="text-danger">*</span>
                    @endif
                </label>
                <input type="password" class="form-control" name="Password" {{ ((!isset($data) || isset($data->isOld)) && !isset($data->isEditOld)) ? 'required' : '' }} autocomplete="off" value="{{ isset($data) ? $data->Password : '' }}">
            </div>

            <div class="col-12 text-right">
                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection