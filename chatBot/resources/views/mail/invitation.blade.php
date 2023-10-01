@extends('layouts.mailLayouts')

@section('title','Convite Loved Husband')


@section('content')
        <div class="row ">
            <div class="col m12 s12 l12 ">
                <div class="container card-panel myCard">
                    <div class="card-content center">
                    <p>Olá! Você acabou de receber um convite para fazer parte do seleto grupo de homens
                        que decidiram tornar-se maridos ainda melhores </p>
                        <ul>
                            <li>passo 1:Acesse: {{url($url)}}</li>
                            <li>passo 2: Clique em "aceitar convite" </li>
                            <li>passo 3: Copie e cole o código </li>
                            <li>passo 4: Complete seu cadastro </li>
                            <li>passo 5: Defina uma senha </li>
                        </ul>
                        <br>
                        <p class="code">{{substr($token,0,3).substr($token,-3)}}</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
