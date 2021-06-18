@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lista de Questionários</div>

                <div class="card-body">
                    @if(Session::has('status'))
						<div class="flash-message">
							<div class="alert alert-success">
								<strong>{{Session::get('status')}}</strong>
							</div>
						</div> 
					@endif
                    <ul class="list-group list-group-flush">
                        @foreach($questionarios as $questionario)

                        <li class="list-group-item">
                        
                            <h5 class="mb-1">{{$questionario->titulo}}</h5>
                            <small class="text-muted">Autor: {{$questionario->usuario->name}}</small>
                          
                            @if(Auth::user()->id == $questionario->user_id)
                                <div class="col-md-5 float-right">
                                    <a class="btn btn-link" href="{{route('editar-questionario', ['id'=>$questionario->id])}}" >Editar</a>
                                    <a class="btn btn-link" href="{{route('respostas-questionario', ['id'=>$questionario->id])}}" >Visualizar Respostas</a>
                                </div>
                            @else
                                <div class="col-md-3 float-right">
                                    <a href="{{route('form-responder-questionario', ['id'=>$questionario->id])}}"  class="btn btn-link">Responder</a>
                                </div>
                            @endif

                        </li>

                        @endforeach
                    </ul>
                                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
