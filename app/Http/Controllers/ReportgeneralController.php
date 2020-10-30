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
use App\Liquidacion;

class ReportgeneralController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    } 

    public function index()
    {
        $id_agencia =auth()->user()->id_agencia;

        $user = User::where([
                            ['id_agencia',$id_agencia],
                            ['status','A']
                            ])
                            ->get();


        $clientes = Cliente::where([
                                 ['id_agencia',$id_agencia],
                                 ['estado','A']   
                                ])
                                ->get();

        return view('reportgeneral.index')
                ->with('user', $user)
                ->with('clientes', $clientes);
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
    public function show(Request $request, $id)
    {
        $f1 = Request('f1');
        $f2 = Request('f2');
        $cliente = Request('cliente');
        $mensajeroE = Request('mensajeroE');
        $mensajeroR = Request('mensajeroR');

        $user =auth()->id();
        $user_genera = User::findOrFail($user);
        $id_agencia =auth()->user()->id_agencia;


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
                                    'detalle_envios.no_envio',
                                    'envios.estado as estado_envio',
                                    'movimientos.descripcion',
                                    'tipo_pagos.descripcion as pago',
                                    'guia_movimientos.observaciones as obs_entrega',
                                    'guia_movimientos.no_guia as no_guia_mov',
                                    'guia_movimientos.id_movimiento as id_mov',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.id_pago',
                                    'm.name as mensajeroR',
                                    'e.name as mensajeroE',
                                    'envios.created_at as fecha_envio',
                                    'clientes.nombre as cliente',
                                    'g2.created_at as fecha_entrega'  
                                            )
                                    ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                    ->leftjoin('guia_movimientos', function($join)
                                                {
                                                    $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                                    $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                                })
                                    ->leftjoin('guia_movimientos as g2', function($join)
                                                {
                                                    $join->on('g2.no_guia', '=', 'detalle_envios.no_guia');
                                                    $join->where('g2.id_movimiento','=','5');

                                    })
                                    ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                                    ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                                    ->leftjoin('users as e','e.id','=','detalle_envios.user_id')
                                    ->leftjoin('users as m','m.id','=','envios.user_id')
                                    ->leftjoin('clientes','clientes.id','=','envios.id_cliente')
                                    ->whereBetween('envios.created_at',[$f1, $f2])
                                    //->whereIn('detalle_envios.estado',['13'])
                                    ->where('envios.estado','>','0')
                                    ->where('envios.id_agencia',$id_agencia)
                                    ->porcliente($cliente)
                                    ->pormensjeroR($mensajeroR)
                                    ->pormensajeroE($mensajeroE)
                                   
                ->get();

                $guia_movimientos = Guia_movimiento::all();


                return view('reportgeneral.rep_Excel')
                        ->with('detalle_envio',$detalle_envio)
                        ->with('guia_movimientos', $guia_movimientos)
                        ->with('f1',$f1)
                        ->with('f2',$f2)
                        ->with('cliente',$cliente)
                        ->with('user_genera',$user_genera);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $f1 = Request('f1').' 00:00:00';
        $f2 = Request('f2').' 23:59:59';

        //dd($f1);
        $cliente = Request('cliente');
        $mensajeroE = Request('mensajeroE');
        $mensajeroR = Request('mensajeroR');
        $id_agencia =auth()->user()->id_agencia;


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
                                    'detalle_envios.no_envio',
                                    'envios.estado as estado_envio',
                                    'movimientos.descripcion',
                                    'tipo_pagos.descripcion as pago',
                                    'guia_movimientos.observaciones as obs_entrega',
                                    'guia_movimientos.no_guia as no_guia_mov',
                                    'guia_movimientos.id_movimiento as id_mov',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.id_pago',
                                    'm.name as mensajeroR',
                                    'e.name as mensajeroE',
                                    'envios.created_at as fecha_envio',
                                    'clientes.nombre as cliente',
                                    'g2.created_at as fecha_entrega'  
                                            )
                                    ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                    ->leftjoin('guia_movimientos', function($join)
                                                {
                                                    $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                                    $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                                })
                                    ->leftjoin('guia_movimientos as g2', function($join)
                                                {
                                                    $join->on('g2.no_guia', '=', 'detalle_envios.no_guia');
                                                    $join->where('g2.id_movimiento','=','5');

                                    })
                                    ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                                    ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                                    ->leftjoin('users as e','e.id','=','detalle_envios.user_id')
                                    ->leftjoin('users as m','m.id','=','envios.user_id')
                                    ->leftjoin('clientes','clientes.id','=','envios.id_cliente')
                                    ->whereBetween('envios.created_at',[$f1, $f2])
                                    //->whereIn('detalle_envios.estado',['13'])
                                    ->where('envios.estado','>','0')
                                    ->where('envios.id_agencia',$id_agencia)
                                    ->porcliente($cliente)
                                    ->pormensjeroR($mensajeroR)
                                    ->pormensajeroE($mensajeroE)
                                   
                ->get();

                $guia_movimientos = Guia_movimiento::all();


                return view('reportgeneral.detalle')
                        ->with('detalle_envio',$detalle_envio)
                        ->with('guia_movimientos', $guia_movimientos)
                        ->with('f1',$f1)
                        ->with('f2',$f2)
                        ->with('cliente',$cliente)
                        ->with('mensajeroE',$mensajeroE)
                        ->with('mensajeroR',$mensajeroR);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        
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
