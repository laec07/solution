<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Envio;

class Cliente extends Model
{
    protected $guarded = [];


        public function envios()
    {
    	return $this->hasMany(Envio::class);


    }
}
