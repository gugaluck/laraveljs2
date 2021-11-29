@extends("layout")

@section('titulo')
    Detalhe do Time: {{$time->nome}}
@stop

@section('conteudo')
    Detalhe do Time: <b>{{$time->nome}}</b>
    <hr>
    <b>Código:</b> {{$time->id}} <br>
    <b>Nome:</b> {{$time->nome}} <br>
@stop