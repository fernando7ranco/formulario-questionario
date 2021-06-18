@extends('layouts.app')

@php
function camposDeResposta($id, $tipo, $obrigatorio){

    $campo = null;

    /*
    1=> 'Texto livre',
    2=> 'Numérico',
    3=> 'Data',
    4=> 'LAT e LONG'
    */

    $required = $obrigatorio ? 'required' : '';
    $name = "perguntas[{$id}]";

    switch($tipo){
        case 1:
            $value = Request::old('perguntas') ? Request::old('perguntas')[$id]['texto'] : '';
            $campo = "<textarea name='{$name}[texto]' rows='6' class='form-control' placeholder='Digite sua resposta' {$required}>{$value}</textarea>";
        break;
        case 2:
            $value = Request::old('perguntas') ? Request::old('perguntas')[$id]['numerico'] : '';
            $campo ='<div class="input-group mb-3">
                        <div class="input-group-prepend" >
                            <span class="input-group-text">123..</span>
                        </div>
                        <input type="text" value="'.$value.'" '. $required .' name="'.$name.'[numerico]" onkeyup="soNumeros(this)" class="form-control" >
                    </div>';
        break;
        case 3:
            $value = Request::old('perguntas') ? Request::old('perguntas')[$id]['data'] : '';
            $campo ='<div class="input-group mb-3">
                        <div class="input-group-prepend" >
                            <span class="input-group-text">dd/mm/aaaa</span>
                        </div>
                        <input type="text" value="'.$value.'" '. $required .' name="'.$name.'[data]" onkeyup="mdata(this)" class="form-control" >
                    </div>';
        break;
        case 4:
            $value = Request::old('perguntas') ? Request::old('perguntas')[$id]['latitude'] : '';
            $campo ='<div class="input-group mb-3">
                        <div class="input-group-prepend" >
                            <span class="input-group-text" style="width:90px">Latitude</span>
                        </div>
                        <input type="text" value="'.$value.'" '. $required .' name="'.$name.'[latitude]"  class="form-control" >
                    </div>';
            $value = Request::old('perguntas') ? Request::old('perguntas')[$id]['longitude'] : '';
            $campo.='<div class="input-group mb-3">
                        <div class="input-group-prepend" >
                            <span class="input-group-text" style="width:90px" >Longitude</span>
                        </div>
                        <input type="text" value="'.$value.'" '. $required .' name="'.$name.'[longitude]"  class="form-control" >
                    </div>';
        break;
    }
    
    return $campo;
}
@endphp

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
                    <br><br>
                    <div class="col-md-10 offset-md-1" >
                        <h3>{{ $questionario->titulo }}</h3>
                        <p class="text-justify">{{ $questionario->instrucoes }}</p>
                        <br><br>
                        <form  class="col-md-10 offset-md-1" method="POST" action="{{ route('responder-questionario') }}">
                            @csrf
                            
                            <input type="hidden" value="{{ $questionario->id }}" name="questionario_id">
                            
                            @if($errors->has('error'))
                                <div class="alert alert-danger" role="alert">
                                    @foreach($errors->get('error') as $erro)
                                        <strong>{{$erro}}</strong><br>
                                    @endforeach
                                </div>
                            @endif
                            <p>Perguntas <strong>*</strong> possuem respostas obrigatorias</p>
                            @foreach($questionario->perguntas as $pergunta)
                                <br><br>
                                <p>{{ $pergunta->pergunta }} {!! $pergunta->pergunta_obrigatoria ? '<b>*<b>' : '' !!}</p>
                                {!! camposDeResposta($pergunta->id, $pergunta->tipo_resposta, $pergunta->pergunta_obrigatoria) !!}
                            @endforeach
                            <br><br>
                            <button type="submit" class="btn btn-primary">
                                ENVIAR RESPOSTAS
                            </button>

                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    function mdata(input){
        let v = input.value;
        
        v=v.replace(/\D/g,"");
        v=v.replace(/(\d{2})(\d)/,"$1/$2");
        v=v.replace(/(\d{2})(\d)/,"$1/$2");
        v=v.replace(/(\d{2})(\d{2})$/,"$1$2");

        input.value = v;
    }

    function soNumeros(input){
        input.value = input.value.replace(/\D/g,"")
    }

</script>
@endsection
