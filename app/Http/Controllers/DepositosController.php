<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Deposito;
use App\Liquidacion;
use App\Tipo_pago;
use App\Cuenta_cliente;
use App\Banco;



class DepositosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    } 
    
    public function index()
    {
        $tipo_pagos = Tipo_pago::where('estado','A')
                        ->get();

        return view('depositos.index',['tipo_pagos' => $tipo_pagos]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Deposito $depositos)
    {
        //
    }


    public function edit(Deposito $depositos)
    {
        $liquidacion = Liquidacion::Select(
                                            'liquidaciones.id',
                                            'liquidaciones.id_agencia',
                                            'liquidaciones.user_id',
                                            'liquidaciones.id_cliente',
                                            'liquidaciones.total_paquete',
                                            'liquidaciones.total_liquidar',
                                            'liquidaciones.total_mensajeria',
                                            'liquidaciones.total_depositos',
                                            'liquidaciones.estado',
                                            'liquidaciones.created_at',
                                            'c.nombre'
                                            )
                                    ->join('clientes as c','c.id','=','liquidaciones.id_cliente')
                                    ->where('liquidaciones.estado','A')
                                    ->get();

        $cuentas = Cuenta_cliente::Select(
                                          'cuenta_clientes.id',
                                          'cuenta_clientes.id_cliente',
                                          'cuenta_clientes.no_cuenta',
                                          'cuenta_clientes.id_banco',
                                          'cuenta_clientes.estado',
                                          'b.descripcion'
                                            )
                                    ->join('bancos as b','b.id','=','cuenta_clientes.id_banco')
                                    ->where('cuenta_clientes.estado','A')
                                    ->get();
                                    
        return view('depositos.detalle',['liquidacion' => $liquidacion ],['cuentas' => $cuentas ]);
    }


    public function update(Request $request, Depositos $depositos)
    {
        //
    }


    public function destroy(Deposito $depositos)
    {
        //
    }
}
