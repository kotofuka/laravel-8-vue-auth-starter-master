<!doctype html>
<html @lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600">
    <link rel="stylesheet" href=""{{ asset('css/app.css') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


</head>
<body>
    <div id='test-app'>

        <h1>Страница для перевода звука в текст</h1>
        <div id = "text1" style="display: inline-block">
            <p>Данная страница служит для перевода звука в текст. Чтобы записать звук нажмите на кнопку <strong><i>Начать запись</i></strong>. 
                Для остановки нажмите на кнопку <strong><i>Остановить запись</i></strong>. 
                После остановки записи вы можете конвертировать звук в текст, нажав на кнопку <strong><i>Преобразовать звук в текст</i></strong></p>
        </div>

        <main class="py-4">
            @yield('content')
        </main>

    </div>
    {{-- <script src="{{ asset('js/test.js') }}"></script> --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>