<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClientesController extends Controller
{

        public function __construct()
    {
        $this->middleware('auth');

    }
    public function index()
    {


        return view('clientes.index');
    }


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
        $id_agencia =auth()->user()->id_agencia;

        $nombre = Request('nombre'); 
        $direccion = Request('direccion');
        $telefono = Request('telefono');
        $email = Request('email');
        $estado = Request('estado');


        $clientes = new Cliente();
        $clientes->nombre = $nombre;
        $clientes->direccion = $direccion;
        $clientes->telefono = $telefono;
        $clientes->email = $email;
        $clientes->estado = $estado;
        $clientes->id_agencia = $id_agencia;
        $clientes->save();
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

        $Clientes = Cliente::where('id_agencia',$id_agencia)
                            ->whereIn('estado',['A','I'])
                            ->get();

        return view('clientes.detalle')
                ->with('clientes',$Clientes);
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
        $nombre = Request('nombre'); 
        $direccion = Request('direccion');
        $telefono = Request('telefono');
        $email = Request('email');
        $estado = Request('estado');



        $cliente = Cliente::findOrFail($id);
        $cliente->nombre = $nombre;
        $cliente->direccion = $direccion;
        $cliente->telefono = $telefono;
        $cliente->email = $email;
        $cliente->estado = $estado;
        $cliente->update();



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

        $cliente = Cliente::findOrFail($id);
        $cliente->estado = 'D';
        $cliente->update();
    }
}
