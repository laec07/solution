<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Liquidacion;

class AdminController extends Controller
{
    public function index()
    {//trae datos de dashboard

    	$id_agencia =auth()->user()->id_agencia;
    	//cuenta envios
    	$envios = Detalle_envio::select('detalle_envios.no_guia')
                        ->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
                        ->where('e.id_agencia',$id_agencia)
                        ->where('e.estado',['1'])
                        ->where('detalle_envios.estado','1')
                        ->get();
    	$count_envio = $envios->count();
    	//guias pendientes de asignar
    	$pendientes_asignar = Detalle_envio::select('detalle_envios.no_guia')
    					->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
    					->where('e.id_agencia',$id_agencia)
    					->whereIN('detalle_envios.estado',['2','15'])
    					->get();
    	$count_pendientesasg = $pendientes_asignar->count();

    	//liquidaciones pendientes de dépositos
    	$liquidaciones = Liquidacion::where([
    										['id_agencia',$id_agencia],
    										['estado','A']
    										])
    								->get();
    	$count_liq = $liquidaciones->count();
        //Pendientes de entrega
        $guias_pendientes = Detalle_envio::select('detalle_envios.no_guia')
    					->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
    					->where('e.id_agencia',$id_agencia)
    					->whereIn('detalle_envios.estado',['4','3'])
    					->get();
        $count_pendientesent = $guias_pendientes->count();

        return view('administrador.index',compact('count_envio','count_pendientesasg','count_liq','count_pendientesent'));
    }

public function show($id)
    {//muestra guias asignada a mensajero con sus diferentes movimientos
        $id_agencia =auth()->user()->id_agencia;

        $detalle_envio = Detalle_envio::select(
                                    'detalle_envios.no_guia',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.destinatario',
                                    'detalle_envios.telefono',
                                    'detalle_envios.total_paquete',
                                    'detalle_envios.fecha_entregar',
                                    'detalle_envios.observaciones',
                                    'detalle_envios.devolucion',
                                    'detalle_envios.recibe',
                                    'detalle_envios.estado',
                                    'detalle_envios.direccion',
                                    'detalle_envios.id_pago',
                                    'movimientos.descripcion',
                                    'u.name as mensajero',
                                    'tipo_pagos.descripcion as pago',
                                    'guia_movimientos.observaciones as obs_entrega' )
                            ->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
                            ->leftjoin('guia_movimientos', function($join)
                                        {
                                            $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                            $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                        })
                            ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                            ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                            ->leftjoin('users as u','u.id','=','detalle_envios.user_id')
                            ->where('e.id_agencia',$id_agencia)
                            ->whereIn('detalle_envios.estado',['4','3'])
                            ->groupBy('detalle_envios.no_guia','detalle_envios.destinatario',
                                    'detalle_envios.telefono',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.total_paquete',
                                    'detalle_envios.fecha_entregar',
                                    'detalle_envios.observaciones',
                                    'detalle_envios.devolucion',
                                    'detalle_envios.recibe',
                                    'detalle_envios.estado',
                                    'detalle_envios.direccion',
                                    'detalle_envios.id_pago',
                                    'movimientos.descripcion',
                                    'u.name',
                                    'tipo_pagos.descripcion',
                                    'guia_movimientos.observaciones')
        ->get();

        return view('administrador.PendientesEntrega',['detalle_envio' => $detalle_envio]); 
    }

}


