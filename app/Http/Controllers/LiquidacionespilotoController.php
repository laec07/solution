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
use App\Pago;

use PDF;
use Illuminate\Support\Facades\Validator;

class LiquidacionespilotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $id_agencia =auth()->user()->id_agencia;
        $users = User::where([
                            ['id_agencia',$id_agencia],
                            ['role_id','2'],
                            ['status','A']
                            ])
                            ->get();
        return view('liquidacionespiloto.index',['users' => $users]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
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
                                    'envios.estado as estado_envio',
                                    'movimientos.descripcion',
                                    'tipo_pagos.descripcion as pago',
                                    'detalle_envios.id_pago',
                                    'guia_movimientos.observaciones as obs_entrega',
                                    'guia_movimientos.id_movimiento as id_mov',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.id_pago',
                                    'users.name as mensajero',
                                    'clientes.nombre as cliente' 
                                            )
                                    ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                    ->leftjoin('guia_movimientos', function($join)
                                                {
                                                    $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                                    $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                                })
                                    ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                                    ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                                    ->leftjoin('users','users.id','=','detalle_envios.user_id')
                                    ->leftjoin('clientes','clientes.id','=','envios.id_cliente')
                                    ->where('detalle_envios.user_id',$id)
                                    ->whereIn('detalle_envios.estado',['4','5','6','7','8','3','11','12'])
                                    //->where('envios.estado','4')
                ->get();

        $tipo_pagos = Tipo_pago::where('id','>','4')
                        ->get();
        $bancos = Banco::all();


                return view('liquidacionespiloto.detalle')
                        ->with('detalle_envio',$detalle_envio)
                        ->with('tipo_pagos',$tipo_pagos)
                        ->with('bancos',$bancos)
                        ->with('user_id',$id);
    }

    // Generate Vista previa para imprimir
    public function createPDF($id) {
      // retreive all records from db

        $user =auth()->id();
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
                                    'envios.estado as estado_envio',
                                    'movimientos.descripcion',
                                    'tipo_pagos.descripcion as pago',
                                    'detalle_envios.id_pago',
                                    'guia_movimientos.observaciones as obs_entrega',
                                    'guia_movimientos.id_movimiento as id_mov',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.id_pago',
                                    'users.name as mensajero',
                                    'clientes.nombre as cliente' 
                                            )
                                    ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                    ->leftjoin('guia_movimientos', function($join)
                                                {
                                                    $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                                    $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                                })
                                    ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                                    ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                                    ->leftjoin('users','users.id','=','detalle_envios.user_id')
                                    ->leftjoin('clientes','clientes.id','=','envios.id_cliente')
                                    ->where('detalle_envios.user_id',$id)
                                    ->whereIn('detalle_envios.estado',['4','5','6','7','8','3','11','12'])
                                    //->where('envios.estado','4')
                ->get();

        $mensajero = User::findOrFail($id);
        $user_genera = User::findOrFail($user);


      // comparte data a la vista
      //view()->share('detalle_envio',$detalle_envio);
      //$pdf = PDF::loadView('liquidacionespiloto.pdf_LiqPiloto', $detalle_envio);

      // download PDF file with download method
      //return $pdf->stream();

                return view('liquidacionespiloto.pdf_LiqPiloto')
                        ->with('detalle_envio',$detalle_envio)
                        ->with('mensajero',$mensajero)
                        ->with('user_genera',$user_genera);

    }
    //Genera excel descargable
    public function edit($id)
    {
        $user =auth()->id();
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
                                    'envios.estado as estado_envio',
                                    'movimientos.descripcion',
                                    'tipo_pagos.descripcion as pago',
                                    'detalle_envios.id_pago',
                                    'guia_movimientos.observaciones as obs_entrega',
                                    'guia_movimientos.id_movimiento as id_mov',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.id_pago',
                                    'users.name as mensajero',
                                    'clientes.nombre as cliente' 
                                            )
                                    ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                    ->leftjoin('guia_movimientos', function($join)
                                                {
                                                    $join->on('detalle_envios.estado','=','guia_movimientos.id_movimiento');
                                                    $join->on('detalle_envios.no_guia','=','guia_movimientos.no_guia');
                                                })
                                    ->leftjoin('movimientos','movimientos.id','=','guia_movimientos.id_movimiento')
                                    ->leftjoin('tipo_pagos','tipo_pagos.id','=','detalle_envios.id_pago')
                                    ->leftjoin('users','users.id','=','detalle_envios.user_id')
                                    ->leftjoin('clientes','clientes.id','=','envios.id_cliente')
                                    ->where('detalle_envios.user_id',$id)
                                    ->whereIn('detalle_envios.estado',['4','5','6','7','8','3','11','12'])
                                    //->where('envios.estado','4')
                ->get();

        $mensajero = User::findOrFail($id);
        $user_genera = User::findOrFail($user);


      // comparte data a la vista
      //view()->share('detalle_envio',$detalle_envio);
      //$pdf = PDF::loadView('liquidacionespiloto.pdf_LiqPiloto', $detalle_envio);

      // download PDF file with download method
      //return $pdf->stream();

                return view('liquidacionespiloto.excel_LiqPiloto')
                        ->with('detalle_envio',$detalle_envio)
                        ->with('mensajero',$mensajero)
                        ->with('user_genera',$user_genera);
    }


    //Guarda estado pendiente de liquidar
    public function update(Request $request, $id)
    {
        $user_id = Request('user_id');
        $user_ins =auth()->id();
        $id_agencia =auth()->user()->id_agencia;


        //Busca guias para devolverlas a bodega
        $busca_guia = Detalle_envio::where('user_id',$user_id)
                        ->whereIn('estado',['6','7','8'])
                        ->get();
        
        foreach ($busca_guia as $value) {

        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '15';
        $guia_movimiento->no_guia = $value->no_guia;
        $guia_movimiento->user_id = $user_ins;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();

        }

        $detalle_envio = Detalle_envio::where('user_id',$user_id)
                    ->whereIn('estado',['6','7','8'])
                    ->update(
                            ['estado' => '15']
                            );

        //Busca guias entregadas o devueltas a clientes para pasarlas a siguiente estado
        $busca_guia = Detalle_envio::where('user_id',$user_id)
                        ->whereIn('estado',['5','12'])
                        ->get();
        
        foreach ($busca_guia as $value) {

        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '13';
        $guia_movimiento->no_guia = $value->no_guia;
        $guia_movimiento->user_id = $user_ins;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();

        }

        $detalle_envio = Detalle_envio::where('user_id',$user_id)
                    ->whereIn('estado',['5','12'])
                    ->update(
                            ['estado' => '13']
                            );

        
        alert()->success('Ok','Datos ingresados correctamente');        
        return route('liquidacionespiloto.index');
        
    }


    public function destroy($id)
    {
        //
    }
}
