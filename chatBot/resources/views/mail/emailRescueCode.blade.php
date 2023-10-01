@extends('layouts.mailLayouts')

@section('title','C��digo de Ativa�0�4�0�0o')


@section('content')
        <div class="row">
            <div class="col m12 s12 l12 ">
                <div class="container card-panel myCard">


                    <div class="card-content center">
                    <h1></strong>Presado usuário {{ $userName }} !</strong></h1>
                        <p> Utilize o Código de verificação que aparece abaixo para trocar sua senha.
                        <br>
                        <p class="code">{{substr($token,0,3).substr($token,-3)}}</p>
                    </div>

            </div>
        </div>
        </div>
@endsection
