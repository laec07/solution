<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Cuenta_cliente;
use App\Banco;

class CuentaclientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_agencia =auth()->user()->id_agencia;
        $bancos = Banco::all();

        $clientes = Cliente::where('id_agencia',$id_agencia)
                            ->whereIn('estado',['A','I'])
                            ->get();

        return view('cuentaclientes.index')
                ->with('bancos',$bancos)
                ->with('clientes',$clientes);
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

        $id_cliente = Request('id_cliente'); 
        $no_cuenta = Request('no_cuenta');
        $id_banco = Request('id_banco');
        $tipo = Request('tipo');
        $estado = Request('estado');

        $cuenta_clientes = new Cuenta_cliente();
        $cuenta_clientes->id_cliente = $id_cliente;
        $cuenta_clientes->no_cuenta = $no_cuenta;
        $cuenta_clientes->id_banco = $id_banco;
        $cuenta_clientes->tipo = $tipo;
        $cuenta_clientes->estado = $estado;
        $cuenta_clientes->save();       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_agencia =auth()->user()->id_agencia;

        $cuentas = Cuenta_cliente::Select(
                                          'cuenta_clientes.id',
                                          'cuenta_clientes.id_cliente',
                                          'cuenta_clientes.no_cuenta',
                                          'cuenta_clientes.id_banco',
                                          'cuenta_clientes.estado',
                                          'cuenta_clientes.tipo',
                                          'b.descripcion as banco',
                                          'c.nombre as cliente'
                                            )
                                    ->join('bancos as b','b.id','=','cuenta_clientes.id_banco')
                                    ->join('clientes as c','c.id','=','cuenta_clientes.id_cliente')
                                    ->whereIn('cuenta_clientes.estado',['A','I'])
                                    ->where('c.id_agencia',$id_agencia)
                                    ->get();

        return view('cuentaclientes.detalle')
                ->with('cuentas',$cuentas);
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
        $id = Request('id');
        $id_cliente = Request('id_cliente'); 
        $no_cuenta = Request('no_cuenta');
        $id_banco = Request('id_banco');
        $tipo = Request('tipo');
        $estado = Request('estado');

        $cuenta_clientes = Cuenta_cliente::findOrFail($id);
        $cuenta_clientes->id_cliente = $id_cliente;
        $cuenta_clientes->no_cuenta = $no_cuenta;
        $cuenta_clientes->id_banco = $id_banco;
        $cuenta_clientes->tipo = $tipo;
        $cuenta_clientes->estado = $estado;
        $cuenta_clientes->update();  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Request('id');
        $cuenta_clientes = Cuenta_cliente::findOrFail($id);
        $cuenta_clientes->estado = 'D';
        $cuenta_clientes->update();  
    }
}
