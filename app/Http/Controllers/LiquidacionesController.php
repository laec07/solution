<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Cliente;
use App\User;
use App\Guia_movimiento;
use App\Tipo_pago;
use App\Banco;
use App\Cuenta_cliente;
use App\Deposito;
use App\Liquidacion;


class LiquidacionesController extends Controller
{

        public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {

        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id();

        $tipo_pagos = Tipo_pago::where('estado','A')
                        ->get();

        $envios = Envio::select('envios.no_envio',
                                'envios.id_cliente',
                                'envios.created_at',
                                'envios.total_envio',
                                'envios.total_general',
                                't1.total_paquete',
                                't1.total_msj',
                                't1.total_liquidar',
                                't1.item',
                                't2.item_liquidado',
                                'c.nombre as cliente'
                                )
                        ->join(Detalle_envio::raw('(
                            SELECT
                                no_envio,
                                sum( total_paquete ) AS total_paquete,
                                sum( total_msj ) AS total_msj,
                                sum( total_liquidar ) AS total_liquidar,
                                count( no_guia ) AS item 
                            FROM
                                detalle_envios 
                            GROUP BY
                                no_envio
                                ) t1'),function($join){
                                $join->on('t1.no_envio', '=', 'envios.no_envio');
                            })
                        ->leftjoin(Detalle_envio::raw('(
                            SELECT 
                                no_envio, 
                                count( no_guia ) AS item_liquidado 
                            FROM 
                                detalle_envios 
                            WHERE estado IN ( 10, 11 ) 
                            GROUP BY 
                                no_envio
                                ) t2'), function($join){
                                $join->on('t2.no_envio', '=', 'envios.no_envio');
                            })
                        ->join('clientes as c','c.id','=','envios.id_cliente')
                        ->where('envios.id_agencia',$id_agencia)
                        ->whereIn('envios.estado',['4'])
                        ->orderBy('envios.no_envio')
                        ->get();

        return view('liquidaciones.index')
                ->with('envios', $envios)
                ->with('tipo_pagos', $tipo_pagos);
    }


    public function create()
    {
        $id=Request('id');
        $cuentas = Cuenta_cliente::Select('cuenta_clientes.id',
                                          'cuenta_clientes.no_cuenta',
                                          'cuenta_clientes.id_banco',
                                          'cuenta_clientes.id_cliente',
                                          'bancos.descripcion'
                                        )
                                ->join('bancos','bancos.id','=','cuenta_clientes.id_banco')
                                ->where('cuenta_clientes.id_cliente',$id)
                                ->get();

        return view('liquidaciones.cuentas',['cuentas' => $cuentas]);
    }


    public function store(Request $request)
    {
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;

        $no_guia = Request('id');
        $total_msj = Request('total_msj');
        $total_liquidar = Request('total_liquidar');
        $tp_msj = Request('tp_msj');

        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                            ->update(
                                    ['total_msj' => $total_msj,
                                     'total_liquidar' => $total_liquidar,
                                     'tp_msj' => $tp_msj,
                                     'estado' => '13'

                                    ]
                                    );

        //ingresa movimiento guia
        $guia_movimiento = Guia_movimiento::updateOrCreate(
                            ['id_movimiento' => '13',
                             'no_guia' => $no_guia,
                             'user_id' => $user_id,
                             'estado' => 'A',
                             'id_agencia' => $id_agencia
                            ]
        );


    }


    public function show($id)
    {
        $id = request('id');
        $detalle_envio = Detalle_envio::select(
                                    'detalle_envios.no_guia as no_guia',
                                    'detalle_envios.destinatario',
                                    'detalle_envios.telefono',
                                    'detalle_envios.total_paquete',
                                    'detalle_envios.total_liquidar',
                                    'detalle_envios.fecha_entregar',
                                    'detalle_envios.observaciones',
                                    'detalle_envios.recibe',
                                    'detalle_envios.estado',
                                    'detalle_envios.direccion',
                                    'detalle_envios.total_msj',
                                    'detalle_envios.tp_msj',
                                    'movimientos.descripcion',
                                    'tipo_pagos.descripcion as pago',
                                    'guia_movimientos.observaciones as obs_entrega',
                                    'guia_movimientos.id_movimiento as id_mov',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.id_pago',
                                    'users.name as mensajero' 
                                            )
                                    ->leftjoin('guia_movimientos', function($join)
                                                {
                                                    $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                                    $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                                })
                                    ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                                    ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                                    ->leftjoin('users','users.id','=','detalle_envios.user_id')
                                    ->where('detalle_envios.no_envio',$id)
                                    ->whereIn('detalle_envios.estado',['RP','5','6','7','8','AS','13','11','12'])
                ->get();

        $tipo_pagos = Tipo_pago::where('id','>','4')
                        ->get();
        $bancos = Banco::all();


                return view('liquidaciones.detalle')
                        ->with('detalle_envio',$detalle_envio)
                        ->with('tipo_pagos',$tipo_pagos)
                        ->with('bancos',$bancos);
    }


    public function edit($id)
    {
  
        $result_envio=Envio::where('no_envio',$id)
                        ->get();

        return view('liquidaciones.edit',['result_envio'=>$result_envio]);

        
    }


    public function update(Request $request, $id)
    {
        $no_guia = Request('id');
        $total = Request('total');
        $total_b = Request('total_b');
        $no_envio = Request('no_envio');

        $envio = Envio::findOrFail($no_envio);
        $envio->total_envio= $envio->total_envio-$total_b;
        $envio->total_envio= $envio->total_envio+$total;
        $envio->update();

        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                            ->update(['total_paquete' => $total]);

    }


    public function destroy(Request $request)
    {
        $user_id =auth()->id();

        $no_liq_p = request('no_liq_p');

        $total_liquidar_p = request('total_liquidar_p');
        $total_pago = request('total_pago');
        $tipo_pago = request('tipo_pago');
        $cuenta_cliente = request('cuenta_cliente');
        $no_documento = request('no_documento');
        $fecha_documento = request('fecha_documento');
        $observaciones = request('observaciones');

        $liquidacion = Liquidacion::findOrFail($no_liq_p);
        $liquidacion->total_depositos= $liquidacion->total_depositos+$total_pago;
        $liquidacion->update();

        $depositos = new Deposito();

        $depositos->id_liquidacion = $no_liq_p;
        $depositos->no_documento = $no_documento;
        $depositos->fecha_documento = $fecha_documento;
        $depositos->id_cuenta = $cuenta_cliente;
        $depositos->id_pago = $tipo_pago;
        $depositos->observaciones = $observaciones;
        $depositos->user_id = $user_id;
        $depositos->total = $total_pago;

        $depositos->save();

    }
}
