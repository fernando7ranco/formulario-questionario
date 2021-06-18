<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use App\Models\Questionario;
use App\Models\PerguntasQuestionario;
use App\Models\RespostasPergunta;

class QuestionarioController extends Controller
{
    private $rquest;
    
    public function __construct(Request $rquest)
    {
        $this->middleware('auth');
        $this->request = $rquest;
    }

    public function list()
    {
        $dados = (new Questionario)->orderBy('id', 'DESC')->get();

        return view('home', ['questionarios' => $dados]);
    }

    public function formCadastro()
    {
        return view('questionario.cadastro.form');
    }

    public function formEditar($id)
    {
        $questionario = new Questionario();
        $dados = $questionario->where(['id' => $id, 'user_id' => $this->request->user()->id])->first();

        return view('questionario.alteracao.form', ['questionario' => $dados]);
    }

    public function visualizarRespostas($id)
    {
        $questionario = new Questionario();
        $dados = $questionario->where(['id' => $id, 'user_id' => $this->request->user()->id])->first();

        return view('questionario.respostas.visualizacao', ['questionario' => $dados]);
    }

    public function formResponder($id)
    {
        $questionario = new Questionario();
        $dados = $questionario->where(['id' => $id])->first();

        return view('questionario.responder.form', ['questionario' => $dados]);
    }

    public function create()
    {

        $input = $this->request->all();

        $validator = Validator::make($input, [
            'titulo' => 'required|min:3',
            'instrucoes' => 'required|min:3',
            'dados.*.pergunta' => 'required|min:3',
            'dados.*.tipo_resposta' => 'required|integer'
        ],
        [
            'required' => 'O campo :attribute é obrigatário',
        ], [
            'titulo'      => 'Titulo',
            'instrucoes'     => 'Instruções',
            'dados.*.pergunta'  => 'Pergunta',
            'dados.*.tipo_resposta' => 'Tipo de Resposta'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $questionario = new Questionario();
        $questionario->user_id = $this->request->user()->id;
        $questionario->titulo = $input['titulo'];
        $questionario->instrucoes = $input['instrucoes'];

        try{
            if(!$questionario->save())
                return redirect()->back()->withErrors(['error' => 'validate your request'])->withInput();
        }catch(\Illuminate\Database\QueryException $ex){ 
            return redirect()->back()->withErrors(['error' => 'validate your request'])->withInput();
        }
        
        foreach($input['dados'] as $valores){
            $PerguntasQuestionario = new PerguntasQuestionario();
            $PerguntasQuestionario->questionario_id = $questionario->id;
            $PerguntasQuestionario->pergunta = $valores['pergunta'];
            $PerguntasQuestionario->tipo_resposta = $valores['tipo_resposta'];
            $PerguntasQuestionario->pergunta_obrigatoria = isset($valores['pergunta_obrigatoria']) ? 1 : 0;
            $PerguntasQuestionario->save();
        }
        $this->request->session()->flash('status', 'Questionário criado com sucesso!');
        return redirect()->route('listar-questionario');
    }

    public function update()
    {

        $input = $this->request->all();
        
        $validator = Validator::make($input, [
            'questionario_id' => 'required|integer',
            'titulo' => 'required|min:3',
            'instrucoes' => 'required|min:3',
            'dados.*.pergunta' => 'required|min:3',
            'dados.*.tipo_resposta' => 'required|integer'
        ],
        [
            'required' => 'O campo :attribute é obrigatório',
        ], [
            'titulo'      => 'Titulo',
            'instrucoes'     => 'Instruções',
            'dados.*.pergunta'  => 'Pergunta',
            'dados.*.tipo_resposta' => 'Tipo de Resposta'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $questionario = new Questionario();

        $questionario = $questionario->where(['id' => $input['questionario_id'], 'user_id' => $this->request->user()->id])->first();

        if(!$questionario)
            return redirect()->back()->withErrors(['error' => 'esse questionario não pertence ao seu usuario'])->withInput();

        $questionario->titulo = $input['titulo'];
        $questionario->instrucoes = $input['instrucoes'];

        try{
            if(!$questionario->save())
                return redirect()->back()->withErrors(['error' => 'validate your request'])->withInput();
        }catch(\Illuminate\Database\QueryException $ex){ 
            return redirect()->back()->withErrors(['error' => 'validate your request'])->withInput();
        }
        
        foreach($input['dados'] as $valores){

            $PerguntasQuestionario = new PerguntasQuestionario();

            if(isset($valores['pergunta_id'])){
               $PerguntasQuestionario = $PerguntasQuestionario->where(['questionario_id' => $questionario->id, 'id' => $valores['pergunta_id']])->first();

                if(!$PerguntasQuestionario)
                    return redirect()->back()->withErrors(['error' => 'alteração de pergunta invalida tente atualizar a pagina para continuar'])->withInput();

                if(isset($valores['excluir_pergunta']) && $valores['excluir_pergunta'] == 1){
                    $PerguntasQuestionario->delete();
                    continue;
                }

            }else
                $PerguntasQuestionario->questionario_id = $questionario->id;

            $PerguntasQuestionario->pergunta = $valores['pergunta'];
            $PerguntasQuestionario->tipo_resposta = $valores['tipo_resposta'];
            $PerguntasQuestionario->pergunta_obrigatoria = isset($valores['pergunta_obrigatoria']) ? 1 : 0;

            $PerguntasQuestionario->save();
        }
        
        $this->request->session()->flash('status', 'Questionario alterado com sucesso!');

        return redirect()->route('listar-questionario');
    }

    public function responderQuestionario()
    {
        $input = $this->request->all();
        
        $erros = [];
        
        foreach($input['perguntas'] as $id => &$pergunta){

            $PerguntasQuestionario = new PerguntasQuestionario();

            $PerguntasQuestionario = $PerguntasQuestionario->where(['questionario_id' => $input['questionario_id'], 'id' => $id])->first();

            if(!$PerguntasQuestionario){
                $erros[] = 'Pergunta não existente';
            }

            if($PerguntasQuestionario->tipo_resposta == 1){
                if(isset($pergunta['texto'])){
                    if($PerguntasQuestionario->pergunta_obrigatoria && empty($pergunta['texto'])){
                        $erros[] = 'Responda todas as perguntas obrigatoias';
                    }
                }else{
                    $erros[] = 'Tipo de resposta não aceita para pergunta de texto';
                }
            }
            if($PerguntasQuestionario->tipo_resposta == 2){
                if(isset($pergunta['numerico'])){
                    if($PerguntasQuestionario->pergunta_obrigatoria && empty($pergunta['numerico'])){
                        $erros[] = 'Responda todas as perguntas obrigatoias';
                    }
                    if($pergunta['numerico'] && !is_numeric($pergunta['numerico']))
                        $erros[] = 'Por favor responda uma pergunta numérica com numéros';
                }else{
                    $erros[] = 'Tipo de resposta não aceita para pergunta numérica';
                }
            }
            if($PerguntasQuestionario->tipo_resposta == 3){
                if(isset($pergunta['data'])){
                    $pergunta['data'] = isset($pergunta['data']) ? implode('-', array_reverse(explode('/',$pergunta['data']))) : null;
                    if($PerguntasQuestionario->pergunta_obrigatoria && empty($pergunta['data'])){
                        $erros[] = 'Responda todas as perguntas obrigatoias';
                    }
                    if($pergunta['data'] && !strtotime($pergunta['data']))
                        $erros[] = 'Por favor responda uma pergunta de data com uma data valida';
                }else{
                    $erros[] = 'Tipo de resposta não aceita para pergunta numérica';
                }
            } 
            if($PerguntasQuestionario->tipo_resposta == 4){
                if(isset($pergunta['latitude']) and isset($pergunta['longitude'])){
                    if($PerguntasQuestionario->pergunta_obrigatoria && ( empty($pergunta['latitude']) or empty($pergunta['longitude']) )){
                        $erros[] = 'Responda todas as perguntas obrigatoias';
                    }
                }else{
                    $erros[] = 'Tipo de resposta não aceita para pergunta de logintude e latitude';
                }    
            } 
        }

        if(count($erros))
            return redirect()->back()->withErrors(['error' => $erros])->withInput();

        foreach($input['perguntas'] as $id => $p){

            $RespostasPergunta = new RespostasPergunta();
            $RespostasPergunta->pergunta_id = $id;
            $RespostasPergunta->user_id = $this->request->user()->id;

            if(isset($p['texto']))
                $RespostasPergunta->texto = $p['texto'];
            elseif(isset($p['numerico']))
                $RespostasPergunta->numerico = $p['numerico'];
            elseif(isset($p['data']))
                $RespostasPergunta->data = $p['data'];
            elseif(isset($p['latitude']) and isset($p['longitude'])){
                $RespostasPergunta->latitude = $p['latitude'];
                $RespostasPergunta->longitude = $p['longitude'];
            }
            $RespostasPergunta->save();
        }
        
        $this->request->session()->flash('status', 'Respostas enviadas com sucesso!');

        return redirect()->route('listar-questionario');
    }
}
