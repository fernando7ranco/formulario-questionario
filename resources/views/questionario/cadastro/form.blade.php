@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Novo Questionario</div>

                <div class="card-body">
                    <form  class="col-md-8 offset-md-2" method="POST" action="{{ route('cadastrar-questionario') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-12">

                                <label for="titulo" class="col-md-12 col-form-label">Titulo</label>
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ old('titulo') }}" required >

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">

                                <label for="instrucoes" class="col-md-12 col-form-label">Instruções</label>
                                <textarea id="instrucoes" rows="6" class="form-control @error('instrucoes') is-invalid @enderror" name="instrucoes" required>{{ old('instrucoes') }}</textarea>

                                @error('instrucoes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <br><br><br>

                        <div class="row">
                            <h3 class="col-md-12">Perguntas</h3>
                        </div>

            
                        <pre>
                        @php
                            $defaultDados = [['pergunta' => null, 'tipo_resposta' => null, 'pergunta_obrigatoria' => null]];

                            $dados = Request::old('dados') ? Request::old('dados') : $defaultDados;

                            function optionsTipoResposta($value = null){
                                $valores = [
                                    1=> 'Texto livre',
                                    2=> 'Numérico',
                                    3=> 'Data',
                                    4=> 'LAT e LONG'
                                ];
                                $op = '<option value="">(Selecione)</option>';
                                
                                foreach($valores as $k => $v){
                                    $s = $value == $k ? 'selected' : '';
                                    $op.= "<option {$s} value='{$k}'>{$v}</option>";
                                }

                                return $op;       
                            }
                        @endphp
                        </pre>
                        <div id="local_perguntas">

                        @foreach($dados as $key => $dado)

                            <div class="form-group row pergunta">

                                <div class="form-group col-md-12">

                                    <label for="pergunta1" class="col-md-12 col-form-label">Pergunta</label>
                                    <input id="pergunta1" type="text" class="form-control  @if($errors->has('dados.'.$key.'.pergunta')) {{'is-invalid'}} @endif" name="dados[{{$key}}][pergunta]" value="{{ @$dado['pergunta'] }}" required>

                                    @if($errors->has('dados.'.$key.'.pergunta'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ implode(', ', $errors->get('dados.'.$key.'.pergunta')) }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-12">

                                    <label for="tipo_resposta{{$key}}" class="col-md-12 col-form-label">Tipo de resposta para pergunta</label>

                                    <select id="tipo_resposta{{$key}}" class="form-control @if($errors->has('dados.'.$key.'.tipo_resposta')) {{'is-invalid'}} @endif" name="dados[{{$key}}][tipo_resposta]" required>
                                    {!! optionsTipoResposta(@$dado['tipo_resposta']) !!}
                                    </select>
                                    

                                    @if($errors->has('dados.'.$key.'.tipo_resposta'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ implode(', ', $errors->get('dados.'.$key.'.tipo_resposta')) }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-12">

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="pergunta_obrigatoria{{$key}}" value='1' @if(@$dado['pergunta_obrigatoria'] == 1) {{'checked'}} @endif name="dados[{{$key}}][pergunta_obrigatoria]">
                                        <label  for="pergunta_obrigatoria{{$key}}" class="form-check-label">Resposta obrigatoria</label>
                                    </div>

                                    <button type="button" class="btn btn-light float-right" title="remover a pergunta" onclick="excluirPergunta(this)">remover</button>
                                    <div class="form-group d-none bts-para-exclusao">
                                        <button type="button" class="btn btn-primary" onclick="confirmaExclusao(this)" >Confirmar exclusão</button>
                                        <button type="button" class="btn btn-secondary" onclick="cancelaExclusao(this)" >cancelar</button>
                                    </div>

                                </div>
                                
                            </div>
                        @endforeach
                        
                        </div>
                            
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-9">
                                <button type="button" id="add-pergunta" onclick="addPerguntas()" class="btn btn-outline-primary">
                                   + PERGUNTAS
                                </button>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                   CADASTRAR QUESTIONÁRIO
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

    let contadorPerguntas = {{ count($dados) }};

    function addPerguntas(){

        let indexP = ++contadorPerguntas;

        let html = `<br><br>
                    <div class="form-group row pergunta">
                        <div class="form-group col-md-12">
                            <label for="pergunta${indexP}" class="col-md-12 col-form-label">Pergunta</label>
                            <input id="pergunta${indexP}" type="text" class="form-control" name="dados[${indexP}][pergunta]"required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="tipo_resposta${indexP}" class="col-md-12 col-form-label">Tipo de resposta para pergunta</label>
                            <select id="tipo_resposta${indexP}" class="form-control" name="dados[${indexP}][tipo_resposta]" required>
                                <option value="">(Selecione)</option>
                                <option value="1">Texto livre</option>
                                <option value="2">Numérico</option>
                                <option value="3">Data</option>
                                <option value="4">LAT e LONG</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-12">

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="pergunta_obrigatoria${indexP}" value="1" name="dados[${indexP}][pergunta_obrigatoria]">
                                <label  for="pergunta_obrigatoria${indexP}" class="form-check-label">Resposta obrigatoria</label>
                            </div>

                            <button type="button" class="btn btn-light float-right" title="remover a pergunta" onclick="excluirPergunta(this)">remover</button>
                            <div class="form-group d-none bts-para-exclusao">
                                <button type="button" class="btn btn-primary" onclick="confirmaExclusao(this)" >Confirmar exclusão</button>
                                <button type="button" class="btn btn-secondary" onclick="cancelaExclusao(this)" >cancelar</button>
                            </div>

                        </div>
                    </div>`;

        let div = document.createElement("div");
        div.innerHTML = html;

        document.querySelector('#local_perguntas').append(div);
    }

    function excluirPergunta(button){
        if(document.querySelectorAll('.pergunta').length>1)
            button.nextElementSibling.classList.remove('d-none');
    }

    function cancelaExclusao(button){
       button.parentElement.classList.add('d-none')
    }

    function confirmaExclusao(button){
        
        if(document.querySelectorAll('.pergunta').length>1)
            button.closest('.pergunta').remove();
    }
</script>
@endsection
