<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            i18n:{
                months:["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
            },
            format: "yyyy-mm-dd"
        });
    });
    function search(page) {
        $('[name=page]').val(page);
        $('form').submit();
    }
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h2 class="section-title">{{ config('app.name') }}</h2>
                <div class="center">
                    <form action="" method="get" name="form">
                        <input type="hidden" name="page">
                        <div class="row">
                            <div class="col s3">
                                <input type="text" name="time_start" value="{{ $time_start }}" class="datepicker">
                            </div>
                            <div class="col s3">
                                <p>〜</p>
                            </div>
                            <div class="col s3">
                                <input type="text" name="time_end" value="{{ $time_end }}" class="datepicker">
                            </div>
                            <div class="col s3">
                                <button class="btn waves-effect waves-light" type="button" onclick="search()">検索</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="center">
                    <ul class="pagination">
                        <li class="@if($page == 1){{ 'disabled' }}@else{{ 'waves-effect' }}@endif"><a href="javascript:void(0);@if($page_prev){{ 'search('.$page_prev.')' }}@endif"><i class="material-icons">chevron_left</i></a></li>
                        @for ($i = 1; $i <= $page_max; $i++)
                        <li class="@if($page == $i){{ 'active' }}@else{{ 'waves-effect' }}@endif"><a href="javascript:void(0);{{ 'search('.$i.')' }}">{{ $i }}</a></li>
                        @endfor
                        <li class="@if($page >= $page_max){{ 'disabled' }}@else{{ 'waves-effect' }}@endif"><a href="javascript:void(0);@if($page_next){{ 'search('.$page_next.')' }}@endif"><i class="material-icons">chevron_right</i></a></li>
                    </ul>
                </div>
                <div class="card">
                    <table>
                        <tr>
                            <th>日時▼</th>
                            <th>温度</th>
                            <th>湿度</th>
                        </tr>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->temp }}℃</td>
                            <td>{{ $item->humid }}%</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="center">
                    <ul class="pagination">
                        <li class="@if($page == 1){{ 'disabled' }}@else{{ 'waves-effect' }}@endif"><a href="javascript:void(0);@if($page_prev){{ 'search('.$page_prev.')' }}@endif"><i class="material-icons">chevron_left</i></a></li>
                        @for ($i = 1; $i <= $page_max; $i++)
                        <li class="@if($page == $i){{ 'active' }}@else{{ 'waves-effect' }}@endif"><a href="javascript:void(0);{{ 'search('.$i.')' }}">{{ $i }}</a></li>
                        @endfor
                        <li class="@if($page >= $page_max){{ 'disabled' }}@else{{ 'waves-effect' }}@endif"><a href="javascript:void(0);@if($page_next){{ 'search('.$page_next.')' }}@endif"><i class="material-icons">chevron_right</i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
