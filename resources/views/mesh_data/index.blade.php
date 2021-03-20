<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script   src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h2 class="section-title">{{ config('app.name') }}</h2>
                <div class="center">
                    <form action="" method="get" name="form">
                        <input type="text" name="time" value="{{ $time }}" onchange="form.submit();" class="datepicker">
                    </form>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var elems = document.querySelectorAll('.datepicker');
                        var instances = M.Datepicker.init(elems, options);
                    });
                    $(document).ready(function(){
                        $('.datepicker').datepicker({
                            i18n:{
                                months:["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
                            },
                            format: "yyyy-mm-dd"
                        });
                    });
                    </script>
                </div>
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
