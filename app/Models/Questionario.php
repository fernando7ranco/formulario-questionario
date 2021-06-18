<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use  App\Models\PerguntasQuestionario;
use  App\User;

class Questionario extends Model
{
    protected $fillable = ['titulo', 'instrucoes', 'user_id'];

    public function usuario()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function perguntas()
    {
        return $this->hasMany(PerguntasQuestionario::class, 'questionario_id','id');
    }
}
