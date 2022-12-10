@extends('Templates.Master')
@section('pageTitle','Tagihan ' . $santri->Nama)

@section('content')
<div class="card">
    <div class="card-header bg-dark">
        <h3 class="card-title">Tagihan</h3>
    </div>
    <div class="card-body">
        <a href="/santri/tagihan/{{ $santri->Oid }}" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Kembali</a>
        <form action="" method="post" class="mt-2">
            @csrf
            <div class="form-group">
                <label>Periode</label>
                <input type="text" class="form-control dtpicker" required readonly autocomplete="off" name="Periode" value="{{ $data->Periode }}">
            </div>
            <div class="form-group">
                <label>Jenis</label>
                <select id="cmbJenis" class="form-control">
                    @foreach ($jenis as $row)
                        <option value="{{ $row->Jenis }}" {{ $data->Jenis == $row->Jenis ? 'selected' : '' }}>{{ $row->Jenis }}</option>                                    
                    @endforeach
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input type="text" class="form-control mt-2" required name="Jenis" autocomplete="off" id="txtJenis" placeholder="Masukkan jenis pembayaran" value="{{ $data->Jenis }}" style="display: none">
            </div>
            <div class="form-group">
                <label>Jumlah Tagihan</label>
                <input type="number" class="form-control" required name="Jumlah" placeholder="Masukkan jumlah yang harus dibayar" value="{{ $data->Jumlah }}">
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('customJs')
<script>
    $(function(){

        $("#cmbJenis").on("change",function(){
            let val = $(this).val()
            
            if(val != 0 && val != 'Lainnya') $("#txtJenis").val(val)
            else if(val == 0 || val == 'Lainnya') $("#txtJenis").val("")

            if(val == 'Lainnya') $("#txtJenis").css("display","")
            else $("#txtJenis").css("display","none")
        })

    })
</script>
@endsection