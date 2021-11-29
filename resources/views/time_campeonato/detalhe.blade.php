@extends("layout")

@section('titulo')
    Detalhe do Time x Campeonato
@stop

@section('conteudo')
    Detalhe:
    <hr>
    <b>Código:</b> {{$time_campeonato->id}} <br>
    <b>Time:</b> {{$time_campeonato->time_nome}} <br>
    <b>Campeonato:</b> {{$time_campeonato->campeonato_nome}} <br>
@stop