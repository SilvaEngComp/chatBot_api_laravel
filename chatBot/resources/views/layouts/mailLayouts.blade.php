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
      .center{
        display: grid;
    align-items: center;
      }
      .myCard{
         margin-left: 10%;
      }
      img{
          margin-left:25%;
          width:20%;
          height: 20%;
      }
      p{
          font-size: 1.5vw;
          font-family: Qanelas;
      }

      .code{
          font-size: 40pt;
            margin-left:15%;
          letter-spacing: 5px;
      }
      .main-div{
          width: 400px;
      }


@font-face {
  font-family: raustila;
  src: url(store/fonts/raustila-Regular.ttf) format('truetype');
  font-weight: bold;
}
@font-face {
  font-family: Qanelas;
  src: url(store/fonts/Qanelas/Qanelas-Regular.otf) format("opentype"),
  url(/src/assets/fonts/Qanelas/Qanelas-Bold.otf) format("opentype")

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
