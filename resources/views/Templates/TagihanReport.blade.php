<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    {{-- Header --}}
    <table style="width: 100%">
        <tr>
            <td><img src="{{ asset(getSettings('Logo')) }}" width="120"></td>
            <td style="text-align: center">
                <b style="font-size: 15pt">{{ getSettings('Nama') }}</b><br>
                {{ getSettings('Alamat') }}, {{ getSettings('Kecamatan') }}, {{ getSettings('Kota') }}, {{ getSettings('Provinsi') }} {{ getSettings('KodePos') }} <br>
                Telp: {{ getSettings('Telepon') }}, E-mail: {{ getSettings('Email') }} 
            </td>
        </tr>
    </table>
    <hr>
    <br>

    <div style="text-align: center">
        <b style="font-size: 15pt;">SYAHRIYAH SANTRI</b>
    </div>
    
    <br>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>#</th>
                @foreach ($tableHeader as $header)
                    <th style="font-size: 12pt !important">{{ $header->Label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @foreach ($tableHeader as $header)
                        <td style="font-size: 12pt !important">{{ is_numeric($row->{$header->Field}) ? 'Rp ' . number_format($row->{$header->Field}) : $row->{$header->Field} }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    Keterangan: laporan ini diambil pada tanggal {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    <br><br><br><br>
    <table style="width:100%">
        <tr>
            <td style="text-align: center">
                <br>
                Bendahara
                <br><br><br><br>
                (................................)
            </td>
            <td style="text-align: center">
                Semarang, ................... <br>
                Pimpinan
                <br><br><br><br>
                (................................)
            </td>
        </tr>
    </table>
</body>
</html>