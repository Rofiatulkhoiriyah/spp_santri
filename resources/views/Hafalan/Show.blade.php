@extends('Templates.Master')
@section('pageTitle','Hafalan Santri')

@section('content')
@foreach ($data as $row)
  @php
      $santri = $row->santri;
      $lists = $row->lists;
  @endphp
  <div class="card mb-1">
    <div class="card-header bg-dark">
      <h3 class="card-title">Hafalan {{ $santri->Nama }}</h3>
    </div>
    <div class="card-body">
      @if (\Auth::user()->Role == 'admin')
        <div class="text-right mb-3">
          <button class="btn btn-primary" data-toggle="modal" data-target="#mdlTambah">
          <i class="fas fa-plus"></i> Tambah Hafalan
          </button>
        </div>
      @endif
      <h4 class="text-center">DIBAWAH INI MERUPAKAN HASIL HAFALAN SANTRI SELAMA DI {{ getSettings('Nama') }}</h4>
      <table>
        <tr>
          <td>
            <h5><b>Nama</b></h5>
          </td>
          <td>
            <h5>: {{ $santri->Nama }}</h5>
          </td>
        </tr>
        <tr>
          <td>
            <h5><b>NIS</b></h5>
          </td>
          <td>
            <h5>: {{ $santri->NIS }}</h5>
          </td>
        </tr>
      </table>
      <table class="table table-bordered table-striped mt-3">
        <thead>
          <tr class="text-center">
            <th>#</th>
            <th>Tanggal</th>
            <th>Surah</th>
            <th>Keterangan</th>
            @if (\Auth::user()->Role == 'admin')
              <th width="120">Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @if (count($lists) < 1)
            <tr>
              <td colspan="5" class="text-center">Belum melakukan Hafalan</td>
            </tr>
          @else
            @foreach ($lists as $list)
              @php
                setlocale(LC_ALL, 'IND');
                $tgl = strftime('%d %B %Y', strtotime($list->Tanggal));
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tgl }}</td>
                <td>{{ $list->Surah }}</td>
                <td>{{ $list->Keterangan }}</td>
                @if (\Auth::user()->Role == 'admin')
                  <td class="text-center">
                    <a href="#"
                      onclick="return confirmAlert('/santri/hafalan/{{ $santri->Oid . '/' . $list->Oid }}/delete')"
                      class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i>
                    </a>
                  </td>
                @endif
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endforeach


@if (\Auth::user()->Role == 'admin')
  <div class="modal fade" id="mdlTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Hafalan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            @csrf
            <div class="form-group">
              <label>Tanggal</label>
              <input type="text" class="form-control dtpicker" name="Tanggal" required readonly autocomplete="off" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
            <div class="form-group">
              <label>Surah</label>
              <input type="text" class="form-control" name="Surah" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <textarea name="Keterangan" rows="5" class="form-control" required></textarea>
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