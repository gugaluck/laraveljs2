@extends("layout")

@section('titulo')
    Detalhe do Atleta: {{$atleta->nome}}
@stop

@section('conteudo')
    Detalhe do Atleta: <b>{{$atleta->nome}}</b>
    <hr>
    <b>Código:</b> {{$atleta->id}} <br>
    <b>Nome:</b> {{$atleta->nome}} <br>
    <b>Time:</b> {{$atleta->time_nome}} <br>
@stop