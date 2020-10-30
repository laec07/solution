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
use App\Ruta;

class LiquidacionclientesController extends Controller
{

    public function index()
    {
        $id_agencia =auth()->user()->id_agencia;

        $rutas = Ruta::where([
                                 ['id_agencia',$id_agencia],
                                 ['estado','A']   
                                ])
                                ->get();

        $clientes = Cliente::where([
                                 ['id_agencia',$id_agencia],
                                 ['estado','A']   
                                ])
                                ->get();
        return view('liquidacionclientes.index')
                        ->with('clientes',$clientes)
                        ->with('rutas',$rutas);


    }


    public function create()
    {
        //
    }



    public function store(Request $request)
    {   // guarda liquidación

        //trae variables agencia y usuario
        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id();        
        $id_cliente = Request('id_cliente');
        $total_mg = Request('total_mg');
        $total_ms = Request('total_ms');
        $total_mL = Request('total_mL');
        $id_rutaL =  request('id_ruta');

        //busca guia para validarlas que no exista liquidaciones NULL
        $detalle_envioV = Detalle_envio::select('detalle_envios.no_guia as no_guia',
                                               'detalle_envios.total_paquete',
                                               'detalle_envios.total_msj',
                                               'detalle_envios.total_liquidar'
                                                )
                                        ->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
                                        ->where('e.id_cliente',$id_cliente)
                                        ->where('detalle_envios.estado','13')
                                        ->rutaLiq($id_rutaL)
                                        ->get();

        $h=0;
        //ciclo para buscar guias sin calculo de liquidacion
        foreach ($detalle_envioV as  $val) {
            $item = $val->total_liquidar;
            //si encuentra suma unidad a $h
            if ($item== NULL) {
                $h=+1;
            }
        }
        //Validacion de $h (guias con liquidaciones null)
        if ($h>0) {
                alert()->error('Error','Existen guías sin liquidar, por favor verifique!!!');
                return route('liquidacionclientes.index');
        }else{  //Prepara para guardar liquidación
                $liquidacion = new Liquidacion();
                //Valida campos y datos
                $liquidacion->id_agencia = $id_agencia;
                $liquidacion->user_id = $user_id;
                $liquidacion->id_cliente = $id_cliente;
                $liquidacion->total_paquete = $total_mg;
                $liquidacion->total_mensajeria = $total_ms;
                $liquidacion->total_liquidar = $total_mL;
                $liquidacion->estado ='A' ;
                //inserta registro
                $liquidacion->save();
                //trae id liquidacion para insertar en guias
                $id_liquidacion = $liquidacion->id;

                //busca guias que cumplan criterio para crear ciclo
                $detalle_envioL = Detalle_envio::select('detalle_envios.no_guia as no_guia',
                                                       'detalle_envios.total_paquete',
                                                       'detalle_envios.total_msj',
                                                       'detalle_envios.total_liquidar'
                                                        )
                                                ->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
                                                ->where('e.id_cliente',$id_cliente)
                                                ->where('detalle_envios.estado','13')
                                                ->rutaLiq($id_rutaL)
                                                ->get();

                //ciclo de resultado obtenidos
                foreach ($detalle_envioL as $value) {        

                    //actualiza estado e id liquidación en guias encontradas
                     $update = Detalle_envio::where('no_guia',$value->no_guia)
                                ->update(
                                        ['id_liquidacion' => $id_liquidacion,
                                         'estado' => '10'
                                        ]
                                        );
                    //Inserta movimiento liquidación
                    $guia_movimiento = new Guia_movimiento();
                    $guia_movimiento->id_movimiento = '10';
                    $guia_movimiento->no_guia = $value->no_guia;
                    $guia_movimiento->user_id = $user_id;
                    $guia_movimiento->estado = 'A';
                    $guia_movimiento->id_agencia = $id_agencia;

                    //guarda datos
                    $guia_movimiento->save(); 

                }
            alert()->success('Ok','Se ingresa liquidación correctamente!!');
            return route('liquidacionclientes.index');            
        }

    }


    public function show($id)
    {
        $id = request('id');


        $id_rutaL =  request('id_ruta');

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
                                    'guia_movimientos.observaciones as obs_entrega',
                                    'guia_movimientos.id_movimiento as id_mov',
                                    'detalle_envios.no_envio',
                                    'detalle_envios.id_pago',
                                    'users.name as mensajero' 
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
                                    ->where('envios.id_cliente',$id)
                                    ->whereIn('detalle_envios.estado',['13'])
                                    ->rutaLiq($id_rutaL)
                                    //->where('envios.estado','4')
                ->get();

        $tipo_pagos = Tipo_pago::where('id','>','4')
                        ->get();
        $bancos = Banco::all();


                return view('liquidacionclientes.detalle')
                        ->with('detalle_envio',$detalle_envio)
                        ->with('tipo_pagos',$tipo_pagos)
                        ->with('bancos',$bancos);
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


    public function update(Request $request, $id)
    {   //obtiene id usuario
        $user_id = Request('user_id');
        $id_rutaL =  request('id_ruta');
        //busca guias que cumplan criterio para crear ciclo
        $detalle_envio = Detalle_envio::select('detalle_envios.no_guia as no_guia',
                                               'detalle_envios.total_paquete',
                                               'detalle_envios.total_msj',
                                               'detalle_envios.total_liquidar'
                                                )
                                        ->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
                                        ->where('e.id_cliente',$user_id)
                                        ->where('detalle_envios.estado','13')
                                        ->rutaLiq($id_rutaL)
                                        ->get();
        //ciclo de resultado obtenidos
        foreach ($detalle_envio as $value) {
            
        $total = $value->total_paquete - $value->total_msj;
        //actualiza total liquidar en guias encontradas
         $update = Detalle_envio::where('no_guia',$value->no_guia)
                    ->update(
                            ['total_liquidar' => $total]
                            );           
        }
            

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
