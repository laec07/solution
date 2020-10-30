<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Guia_movimiento;
use App\Ruta;

class Detalle_envio extends Model
{


    protected $guarded = [];

    public function movimientos()
    {
    	return $this->belongsTo(Guia_movimiento::class,'no_guia','no_guia','estado','id_movimiento');
    }

    public function rutas()
    {
    	return $this->belongsTo(Ruta::class,'id','id_ruta');
    }

    public function scopePorcliente($query, $cliente){
        if ($cliente!='TODOS') {
            return $query->where('envios.id_cliente',$cliente);
        }
    }

    public function scopePormensajeroE($query, $mensajeroE){
        if ($mensajeroE!='TODOS') {
            return $query->where('detalle_envios.user_id',$mensajeroE);
        }
    }

    public function scopePormensjeroR($query, $mensajeroR){
        if ($mensajeroR!='TODOS') {
            return $query->where('envios.user_id',$mensajeroR);
        }
    }

    public function scopeRutaLiq($query, $id_rutaL){
        if ($id_rutaL!='TODOS') {
            return $query->where('detalle_envios.id_ruta',$id_rutaL);
        }
    }

}
