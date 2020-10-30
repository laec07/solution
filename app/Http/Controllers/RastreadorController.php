<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalle_envio;
use App\Guia_movimiento;
use App\Cliente;

class RastreadorController extends Controller
{

    public function index()
    {
        return view('rastreador.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $id)
    {//muestra guias asignada a mensajero con sus diferentes movimientos
        $id_agencia =auth()->user()->id_agencia;
        $no_guia = Request('no_guia');

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
                                    'c.nombre as cliente',
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
                            ->join('clientes as c','c.id','=','e.id_cliente')
                            ->where('e.id_agencia',$id_agencia)
                            ->where('detalle_envios.no_guia',$no_guia)
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
                                    'c.nombre',
                                    'guia_movimientos.observaciones')
        ->get();

        $guia_movimientos = Guia_movimiento::select(
                                                'guia_movimientos.id',
                                                'guia_movimientos.id_movimiento',
                                                'm.descripcion',
                                                'guia_movimientos.user_id',
                                                'u.username',
                                                'guia_movimientos.observaciones',
                                                'guia_movimientos.created_at'
                                                    )
                                            ->join('movimientos as m','m.id','=','guia_movimientos.id_movimiento')
                                            ->join('users as u','u.id', '=','guia_movimientos.user_id')
                                            ->where('guia_movimientos.no_guia', '=', $no_guia)
                                            ->Orderby('guia_movimientos.id')
                                            ->get();

        return view('rastreador.detalle')
                    ->with('detalle_envio',$detalle_envio)
                    ->with('guia_movimientos',$guia_movimientos);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
