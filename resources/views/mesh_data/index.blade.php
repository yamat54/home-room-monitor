<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h2 class="section-title">{{ config('app.name') }}</h2>
                <div class="card">
                    <table>
                        <tr>
                            <th>日時</th>
                            <th>温度</th>
                            <th>湿度</th>
                        </tr>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->time }}</td>
                            <td>{{ $item->temp }}℃</td>
                            <td>{{ $item->humid }}%</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
