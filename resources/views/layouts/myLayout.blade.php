<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  <style>
      html{
          background-color: #c5cae9 ;
 
      }
      .fundo{
            background-image: url("assets/images/tela-inicial.webp");
    background-repeat: no-repeat;
    background-size: 100% 100%;
      }
      .center{
        display: grid;
    align-items: center;
    text-align: center;
      }
      .myCard{
         margin-left: 10%;
      }


      p{
          font-size: 1.0vw;
      }
  </style>
<script src="{{ asset('js/main.js')  }}" type="text/javascript"></script>
      </head>
    <body>
       <div class="container">
            @yield('content')
       </div>

    </body>
</html>
