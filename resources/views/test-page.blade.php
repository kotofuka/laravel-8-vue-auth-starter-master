<!doctype html>
<html @lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/test.js') }}"></script>

</head>
<body>
    <h1>Страница для перевода звука в текст</h1>
    <div id = "text1" style="display: inline-block">
        <p>Данная страница служит для перевода звука в текст. Чтобы записать звук нажмите на кнопку <strong><i>Начать запись</i></strong>. 
            Для остановки нажмите на кнопку <strong><i>Остановить запись</i></strong>. 
            После остановки записи вы можете конвертировать звук в текст, нажав на кнопку <strong><i>Преобразовать звук в текст</i></strong></p>
    </div>
    <input type="button" id="start_button" value="начать запись" onclick="StartRecord()">
    <input type="button" id="pause_button" value="остановить запись" onclick="PauseRecord()">
    <input type="button" id="stop_button" value="закончить запись" onclick="StopRecord()">
</body>
</html>