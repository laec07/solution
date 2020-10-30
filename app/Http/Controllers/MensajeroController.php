<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;

class MensajeroController extends Controller
{
        public function index()
    {//trae datos de dashboard
        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id(); 
        //Envios recibidos
        $envios = Envio::where('user_id',$user_id)
                        ->whereIn('estado',['1'])
                        ->get();
    	$count_envio = $envios->count();
        //Guias asignadas
    	$detalle_envio = Detalle_envio::where('user_id',$user_id)
    								->whereIn('estado',['4','5','6','7','8','12'])
    								->get();
        //Total recaudar
    	$sum_recaudar = $detalle_envio->sum('total_paquete');
        //Pendientes de entrega
        $guias_pendientes = Detalle_envio::where('user_id',$user_id)
                                    ->whereIn('estado',['4'])
                                    ->get();
        $count_entregas = $guias_pendientes->count();

        //Total recaudado
    	$detalle_envioR = Detalle_envio::where('user_id',$user_id)
    								->whereIn('estado',['5'])
    								->get();
    	$sum_recaudo = $detalle_envioR->sum('total_paquete');

        return view('mensajero.index',compact('count_envio','count_entregas','sum_recaudar','sum_recaudo'));
    }
}
