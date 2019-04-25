<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{--<link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">--}}
    {{--<link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">--}}
  <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <nav style="height: 30px;" class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="navbar">
              {{ config('app.name', 'Laravel') }}
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent" >
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item"><a class="nav-link" href="/new-task">Nowe</a></li>
                  <li class="nav-item"><a class="nav-link" href="/all-tasks">Wszystkie</a></li>
                  @auth
                      <li class="nav-item"><a class="nav-link" href="/settings">Ustawienia</a></li>
                  @endauth
                  @guest
                      <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                  @else
                      <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                      </li>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                  @endguest
              </ul>
          </div>
      </div>
  </nav>
  <div id="app">
    <v-app>
        <v-container grid-list-md  >
              @yield('content')
        </v-container>
    </v-app>
  </div>
</body>
</html>
