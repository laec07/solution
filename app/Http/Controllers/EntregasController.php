<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Movimiento;
use App\User;
use App\Guia_movimiento;
use App\Tipo_pago;

class EntregasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    } 

    public function index()
    {   //trae movimientos a página principal
        $movimientos = Movimiento::whereIN('id',['5','6','7','8','12'])
                        ->get();
        return view('entregas.index',['movimientos' => $movimientos]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;
        $recibe =Request('recibe');
        $tipo_pago = Request('tipo_pago');
        $no_guia = Request('id');
        $estado = Request('estado');
        //ingresa movimiento guia
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = $estado;
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $user_id;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->observaciones = Request('observaciones');
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();

        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(
                                ['estado' => $estado,
                                'recibe' => $recibe,
                                'id_pago' => $tipo_pago]);


    }


    public function show($id)
    {//muestra guias asignada a mensajero con sus diferentes movimientos
        $user_id =auth()->id();

        $detalle_envio = Detalle_envio::select(
                                    'detalle_envios.no_guia as no_guia',
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
                                    'tipo_pagos.descripcion as pago',
                                    'guia_movimientos.observaciones as obs_entrega' )
                            ->leftjoin('guia_movimientos', function($join)
                                        {
                                            $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                            $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                        })
                            ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                            ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                            ->where('detalle_envios.user_id',$user_id)
                            ->whereIn('detalle_envios.estado',['4','5','6','7','8','12'])
                            ->groupBy('detalle_envios.no_guia','detalle_envios.destinatario',
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
                                    'tipo_pagos.descripcion',
                                    'guia_movimientos.observaciones')
        ->get();

        return view('entregas.detalle',['detalle_envio' => $detalle_envio]); 
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //Elimina movimiento de entrega y deuelve a estado pendiente de entrega
        $no_guia = Request('id');
        $estado = Request('estado');
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;
        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(['estado' => '4','id_pago' => NULL,'recibe' => '']);

        $detalle_envio=Guia_movimiento::where([
                                            ['no_guia',$no_guia],
                                            ['id_movimiento','5']
                                        ])
            ->delete();
    }


    public function destroy($id)
    {
        //
    }
}
