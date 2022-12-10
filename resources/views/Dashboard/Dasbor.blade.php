@extends('Templates.Master')
@section('pageTitle','Dashboard')

@section('content')
  <div class="row">
    <div class="col-md-5 mb-2">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title">Pengumuman</h3>
        </div>
        <div class="card-body">
          @if (count($pengumuman) > 0)
            <ul class="list-group">
              @foreach ($pengumuman as $row)
                <li class="list-group-item d-flex justify-content-between align-middle">
                  <div>
                    {{ $row->Judul }}
                  </div>
                  <button class="btn btn-primary btn-sm btnPengumumanDetail" data-oid="{{ $row->Oid }}">Detail</button>
                </li>
              @endforeach
            </ul>
          @else
            <p class="text-center">Belum ada Pengumuman</p>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-7 mb-2">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title">Galeri</h3>
        </div>
        <div class="card-body text-center">
          @if (count($galeri) > 0)
            <div class="row">
              @foreach ($galeri as $row)
                <div class="col-md-4 col-sm-2 col-12 mb-2">
                  <div class="gallery-container">
                    <img src="{{ asset($row->Direktori) }}" class="gallery-image img-fluid">
                    <div class="gallery-overlay">
                      <div class="gallery-text mb-1">{{ $row->Judul }}</div>
                      <button class="btn btn-primary btn-sm btnGaleriDetail" data-oid="{{ $row->Oid }}">Buka</button>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            Belum ada Gambar
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="mdlPengumuman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="mdlGaleri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <a href="#" class="badge badge-primary ml-3 mt-2">Download</a>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center my-2">
            <img src="" class="img-fluid">
          </div>
          <p></p>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extraCss')
  <style>
    .gallery-container {
      background: black;
      position: relative;
      text-align: center;
      color: #fff;
    }

    .gallery-container .gallery-image {
      opacity: 1;
    }
    .gallery-container .gallery-overlay {
      opacity: 1;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: none;
    }

    .gallery-container:hover .gallery-image {
      transition: 500ms;
      opacity: .5;
    }

    .gallery-container:hover .gallery-overlay {
      transition: 500ms;
      display: block;
    }
  </style>
@endsection

@section('customJs')
  <script>
    $(function(){
    
      $(".btnPengumumanDetail").click(function(){
        $("#loading-state").css("display","")
        const Oid = $(this).data("oid")
        $.ajax({
          url: "/pengumuman/" + Oid + "/show",
          dataType: "json",
          success: function(res) {
            $("#mdlPengumuman .modal-title").html(res.Judul)
            $("#mdlPengumuman .modal-body").html(res.Deskripsi)
            $("#mdlPengumuman").modal("show")
            $("#loading-state").css("display","none")
          }
        })
      })
    
      $(".btnGaleriDetail").click(function(){
        $("#loading-state").css("display","")
        const Oid = $(this).data("oid")
        const baseUrl = "{{ url('/') }}"
        $.ajax({
          url: "/galeri/" + Oid + "/show",
          dataType: "json",
          success: function(res) {
            $("#mdlGaleri .modal-title").html(res.Judul)
            $("#mdlGaleri .modal-header a").attr("href","/"+res.Direktori)
            $("#mdlGaleri .modal-header a").attr("download","/"+res.Direktori)
            $("#mdlGaleri .modal-body p").html(res.Deskripsi)
            $("#mdlGaleri .modal-body img").attr("src","/"+res.Direktori)
            $("#mdlGaleri").modal("show")
            $("#loading-state").css("display","none")
          }
        })
      })

    })
  </script>  
@endsection