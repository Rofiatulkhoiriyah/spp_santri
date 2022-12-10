@extends('Templates.Master')
@section('pageTitle','Tagihan Santri')

@section('content')
@foreach ($data as $row)
  @php
      $santri = $row->santri;
      $tagihan = $row->tagihan;
      $spp = $row->spp;
  @endphp
  <div class="row mb-1">
    <div class="col-md-5 col-12">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title">Tagihan Syahriah {{ $santri->Nama }}</h3>
        </div>
        <div class="card-body">
          <div class="text-right mb-3">
            <a href="/santri/tagihan/excel/{{ $santri->Oid }}/spp" class="btn btn-secondary btn-sm mb-1">
              <i class="fas fa-file-excel"></i> Unduh Excel
            </a>
            <a href="/santri/tagihan/pdf/{{ $santri->Oid }}/spp" class="btn btn-secondary btn-sm mb-1">
                <i class="fas fa-file-pdf"></i> Unduh PDF
            </a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="text-center">
                <tr>
                  <th width="50">#</th>
                  <th>Periode</th>
                  <th>Tanggal Bayar</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                  @if (\Auth::user()->Role == 'admin')
                    <th>Aksi</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @php
                  $sisa = 0;
                @endphp
                @if (count($spp) > 0)
                  @foreach ($spp as $list)
                    @php
                      setlocale(LC_ALL, 'IND');
                      $periode = strftime('%d %B %Y', strtotime($list->Periode));
                      $bayar = ($list->TglBayar) ? strftime('%d %B %Y', strtotime($list->TglBayar)) : '';
                      if($list->Status == 'Belum Lunas') $sisa += $list->Jumlah
                    @endphp
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $periode }}</td>
                      <td>{{ $bayar }}</td>
                      <td>{{ number_format($list->Jumlah) }}</td>
                      <td>
                        @if ($list->Status == 'Belum Lunas')
                          <span class="badge badge-danger">Belum Lunas</span>
                        @else
                          <span class="badge badge-success">Lunas</span>
                        @endif
                      </td>
                      @if (\Auth::user()->Role == 'admin')
                      <td class="text-center">
                        @if ($list->Status == 'Belum Lunas')
                          <a href="#" class="btn btn-success btn-sm" onclick="return confirmAlert('/santri/tagihan/{{ $santri->Oid }}/{{ $list->Oid }}/pay')">
                            <i class="fas fa-check"></i>
                          </a>
                        @endif
                      </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="7" class="text-center">Belum ada tagihan</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Sisa Tagihan</th>
                  <th colspan="3">
                    <span class="{{ ($sisa > 0) ? 'text-danger' : 'text-success' }}">{{ number_format($sisa) }}</span>
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-12">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title">Tagihan Lainnya {{ $santri->Nama }}</h3>
        </div>
        <div class="card-body">
          <div class="actions text-right mb-3">
            @if (\Auth::user()->Role == 'admin')
              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mdlTambah">
                <i class="fas fa-plus"></i> Tambah Tagihan
              </button>
            @endif
            <a href="/santri/tagihan/excel/{{ $santri->Oid }}/lainnya" class="btn btn-secondary btn-sm mb-1">
              <i class="fas fa-file-excel"></i> Unduh Excel
            </a>
            <a href="/santri/tagihan/pdf/{{ $santri->Oid }}/lainnya" class="btn btn-secondary btn-sm mb-1">
              <i class="fas fa-file-pdf"></i> Unduh PDF
            </a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="text-center">
                <tr>
                  <th width="50">#</th>
                  <th>Periode</th>
                  <th>Jenis</th>
                  <th>Tanggal Bayar</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                  @if (\Auth::user()->Role == 'admin')
                    <th>Aksi</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @php
                  $sisa = 0;
                @endphp
                @if (count($tagihan) > 0)
                  @foreach ($tagihan as $list)
                    @php
                      setlocale(LC_ALL, 'IND');
                      $periode = strftime('%d %B %Y', strtotime($list->Periode));
                      $bayar = ($list->TglBayar) ? strftime('%d %B %Y', strtotime($list->TglBayar)) : '';
                      if($list->Status == 'Belum Lunas') $sisa += $list->Jumlah
                    @endphp
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $periode }}</td>
                      <td>{{ $list->Jenis }}</td>
                      <td>{{ $bayar }}</td>
                      <td>{{ number_format($list->Jumlah) }}</td>
                      <td>
                        <span class="badge {{ (ucwords($list->Status) == 'Lunas') ? 'badge-success' : 'badge-danger' }}">
                          {{ ucwords($list->Status) }}
                        </span>
                      </td>
                      @if (\Auth::user()->Role == 'admin')
                        <td class="text-center">
                          <a href="/santri/tagihan/{{ $santri->Oid }}/{{ $list->Oid }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-pen"></i>
                          </a>
                          <a href="#" class="btn btn-danger btn-sm" onclick="return confirmAlert('/santri/tagihan/{{ $santri->Oid }}/{{ $list->Oid }}/delete')">
                            <i class="fas fa-trash"></i>
                          </a>
                          @if ($list->Status == 'Belum Lunas')
                            <a href="#" class="btn btn-success btn-sm" onclick="return confirmAlert('/santri/tagihan/{{ $santri->Oid }}/{{ $list->Oid }}/pay')">
                              <i class="fas fa-check"></i>
                            </a>
                          @endif
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="7" class="text-center">Belum ada tagihan</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Sisa Tagihan</th>
                  <th colspan="3">
                    <span class="{{ ($sisa > 0) ? 'text-danger' : 'text-success' }}">{{ number_format($sisa) }}</span>
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach

@if (\Auth::user()->Role == 'admin')
  <div class="modal fade" id="mdlTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Tagihan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            @csrf
            <div class="form-group">
              <label>Periode</label>
              <input type="text" class="form-control dtpicker" readonly required autocomplete="off" name="Periode" placeholder="Klik untuk memilih periode">
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
@endif
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