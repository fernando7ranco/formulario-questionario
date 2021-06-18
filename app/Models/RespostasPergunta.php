<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;

class RespostasPergunta extends Model
{
    protected $fillable = ['pergunta_id', 'user_id', 'texto', 'data', 'numerico', 'latitude', 'longitute'];

    public function usuario()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

}
