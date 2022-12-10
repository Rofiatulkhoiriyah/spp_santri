@extends('Templates.Master')
@section('pageTitle','List Galeri')
    
@section('content')
  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title">Galeri</h3>
    </div>
    <div class="card-body">
      <div class="text-right">
        <button type="button" class="btn btn-primary btn-sm btnTambah mb-2"><i class="fas fa-plus"></i> Tambah Gambar</button>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th width="50">#</th>
              <th width="80"></th>
              <th width="100">Gambar</th>
              <th>Judul</th>
              <th>Isi</th>
              <th width="100">Tampil</th>
            </tr>
          </thead>
          <tbody>
            @if (count($lists) < 1)
              <tr>
                <td colspan="6" class="text-center">Belum ada Gambar</td>
              </tr>
            @else
              @foreach ($lists as $list)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-center">
                      <button class="btn btn-primary btn-sm" id="dropdownMenuButton{{ $loop->iteration }}" data-toggle="dropdown">
                        <i class="fas fa-chevron-down"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $loop->iteration }}">
                        <button class="dropdown-item btnEdit" data-oid="{{ $list->Oid }}">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="dropdown-item btnUbahGambar" data-oid="{{ $list->Oid }}">
                          <i class="fas fa-camera"></i> Ubah Gambar
                        </button>
                        <a class="dropdown-item" href="#" onclick="return confirmAlert('/setting/galeri/hapus/{{ $list->Oid }}')">
                          <i class="fas fa-trash"></i> Hapus
                        </a>
                      </div>
                    </td>
                    <td><img src="{{ asset($list->Direktori) }}" width="100"></td>
                    <td>{{ $list->Judul }}</td>
                    <td>{{ implode(' ', array_slice(explode(' ', $list->Deskripsi), 0, 10)) }}..</td>
                    @if ($list->Tampilkan)
                      <td class="text-center"><i class="text-success fas fa-check"></i></td>
                    @else
                      <td class="text-center"><i class="text-danger fas fa-times"></i></td>
                    @endif
                  </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="mdlForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-8" id="groupJudul">
                <label>Judul</label>
                <input type="text" class="form-control" id="txtJudul" required autocomplete="off" name="Judul">
              </div>
              <div class="form-group col-md-4" id="groupTampilkan">
                <label>Tampilkan</label>
                <div class="container ml-3">
                  <input class="form-check-input" name="Tampilkan" type="checkbox" id="cbxTampilkan">
                  <label class="form-check-label" for="cbxTampilkan">
                      Tampilkan
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group" id="groupGambar">
              <label>Gambar</label>
              <input type="file" class="form-control-file" required id="fileGambar" name="Gambar">
            </div>
            <div class="form-group" id="groupDeskripsi">
              <label>Deskripsi</label>
              <textarea name="Deskripsi" id="txtDeskripsi" class="form-control" rows="10"></textarea>
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

      function setState(state) {
        if(state == "edit") {
          $("#groupGambar").css("display","none")
          $("#fileGambar").removeAttr("required")
          $("#fileGambar").removeAttr("name")
        } else {
          $("#groupGambar").css("display","")
          $("#fileGambar").attr("required","required")
          $("#fileGambar").attr("name","Gambar")
        }

        if(state == "change") {
          $("#groupJudul").css("display","none")
          $("#txtJudul").removeAttr("required")
          $("#txtJudul").removeAttr("name")
          
          $("#groupTampilkan").css("display","none")
          $("#cbxTampilkan").removeAttr("name")

          $("#groupDeskripsi").css("display","none")
          $("#txtDeskripsi").removeAttr("name")
        } else {
          $("#groupJudul").css("display","")
          $("#txtJudul").attr("required","required")
          $("#txtJudul").attr("name","Judul")
          
          $("#groupTampilkan").css("display","")
          $("#cbxTampilkan").attr("name","Tampilkan")

          $("#groupDeskripsi").css("display","")
          $("#txtDeskripsi").attr("name","Deskripsi")
        }
      }

      function setForm(judul = "", tampilkan = false, deskripsi = "", action = null) {
        $("#txtJudul").val(judul)
        $("#cbxTampilkan").prop("checked",tampilkan)
        $("#txtDeskripsi").val(deskripsi)
        $("#fileGambar").val("")
        if(action !== null) $("#mdlForm form").attr("action",action)
        else $("#mdlForm form").attr("action","")
      }

      $(".btnTambah").click(function(){
        setForm()
        setState("add")
        $("#mdlForm h5").html("Tambah Gambar")
        $("#mdlForm").modal("show")
      })

      $(".btnEdit").click(function(){
        setState("edit")
        const Oid = $(this).data("oid")
        const Url = "/galeri/" + Oid 
        $("#loading-state").css("display","")
        $.ajax({
          url: Url,
          dataType: "json",
          success: function(res) {
            setForm(res.Judul, res.Tampilkan, res.Deskripsi, "/setting" + Url)
            $("#mdlForm h5").html("Edit Gambar")
            $("#mdlForm").modal("show")
            $("#loading-state").css("display","none")
          }
        })
      })

      $(".btnUbahGambar").click(function(){
        const Oid = $(this).data("oid")
        setForm()
        setState("change")
        setForm("",false,"","/setting/galeri/" + Oid)
        $("#mdlForm h5").html("Ubah Gambar")
        $("#mdlForm").modal("show")
      })

    })
  </script>
@endsection