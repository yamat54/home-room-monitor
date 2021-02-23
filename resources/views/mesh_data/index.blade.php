<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
                <div class="center">
                    <ul class="pagination">
                        <li class="@if($page == 1){{ 'disabled' }}@else{{ 'waves-effect' }}@endif"><a href="@if($page > 1){{ '/?page=' . ($page - 1) }}@else{{ '#!' }}@endif"><i class="material-icons">chevron_left</i></a></li>
                        @for ($i = 1; $i <= $max_page; $i++)
                        <li class="@if($page == $i){{ 'active' }}@else{{ 'waves-effect' }}@endif"><a href="/@if($i > 1){{ '?page=' . $i }}@endif">{{ $i }}</a></li>
                        @endfor
                        <li class="@if($page >= $max_page){{ 'disabled' }}@else{{ 'waves-effect' }}@endif"><a href="@if($page < $max_page){{ '/?page=' . ($page + 1) }}@else{{ '#!' }}@endif"><i class="material-icons">chevron_right</i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
