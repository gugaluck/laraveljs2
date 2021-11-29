@extends("layout")

@section('titulo')
    Detalhe do Campeonato: {{$campeonato->nome}}
@stop

@section('conteudo')
    Detalhe do Campeonato: <b>{{$campeonato->nome}}</b>
    <hr>
    <b>Código:</b> {{$campeonato->id}} <br>
    <b>Nome:</b> {{$campeonato->nome}} <br>
@stop