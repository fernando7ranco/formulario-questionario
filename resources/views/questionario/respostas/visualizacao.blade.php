@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Questionário</div>

                <div class="card-body">
                    @if(!$questionario)
                        <div class="alert alert-danger" role="alert">
                            <strong>Questionário invalido</strong>
                        </div>
                    @else
                    <div class="col-md-10 offset-md-1" >
                        <h3>{{ $questionario->titulo }}</h3>
                        <p class="text-justify">{{ $questionario->instrucoes }}</p>
                        <br><br>

                        @foreach($questionario->perguntas as $pergunta)
                            <br><br>
                            <h3>{{ $pergunta->pergunta }}</h3>
                            
                            @foreach($pergunta->respostas as $resposta)
                                <p>
                                {{ $resposta->usuario->name }} <small class="text-muted float-right">Respondido em {{ date('d/m/Y H:i', strtotime($resposta->created_at)) }} </small><br>
                                @switch($pergunta->tipo_resposta)
                                    @case(1)
                                            {{ $resposta->texto }}
                                        @break
                                    @case(2)
                                            {{ $resposta->numerico }}
                                        @break
                                    @case(3)
                                            {{ $resposta->data }}
                                        @break
                                    @case(4)
                                            <strong>Latitude:</strong> {{ $resposta->latitude }}
                                            <strong>Longitude:</strong> {{ $resposta->longitude }}
                                        @break
                                @endswitch
                                </p>
                            @endforeach

                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection