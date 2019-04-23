<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>piotr kalkulator</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        {{--kontrola błędów - flash message--}}
        <?= $errors ?>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @error ('client_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div id="app">
            <example-component>hello</example-component>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
