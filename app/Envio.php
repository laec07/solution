<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use App\User;

class Envio extends Model
{
    protected $guarded = [];

    protected $table = 'envios';

    protected $primaryKey = 'no_envio';

    public function clientes()
    {
    	return $this->belongsTo(Cliente::class,'id_cliente');
    }

        public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function envios_detalle()
    {
    	return $this->hasMany(Cliente::class);
    }


}
