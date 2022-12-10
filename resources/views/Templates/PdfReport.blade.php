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
    <h2 class="text-center" style="font-family: Arial, Helvetica, sans-serif">{!! $title !!}</h2>
    <table>
        @foreach ($information as $key => $value)
            <tr>
                <td>{{ $key }}</td>
                <th>: {{ $value }}</th>
            </tr>
        @endforeach
    </table>
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
                        <td style="font-size: 12pt !important">{{ $row->{$header->Field} }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>