<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerguntasQuestionario extends Model
{
    protected $fillable = ['questionario_id', 'pergunta', 'tipo_resposta', 'pergunta_obrigatoria'];

    public function respostas()
    {
        return $this->hasMany(RespostasPergunta::class, 'pergunta_id','id');
    }
}
