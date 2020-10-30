<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarifario;

class TarifasController extends Controller
{
    
        public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        return view('tarifas.index');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $id_agencia =auth()->user()->id_agencia;

        $total = Request('total');
        $descripcion = Request('descripcion');
        $estado = Request('estado');

        $tarifas = new Tarifario();
        $tarifas->id_agencia = $id_agencia;
        $tarifas->total = $total;
        $tarifas->descripcion = $descripcion;
        $tarifas->estado = $estado;
        $tarifas->save();        
    }


    public function show($id)
    {
        $id_agencia =auth()->user()->id_agencia;

        $tarifas = Tarifario::where('id_agencia',$id_agencia)
                        ->whereIn('estado',['A','I'])
                        ->get();

        return view('tarifas.detalle')
                ->with('tarifas',$tarifas);
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
        $total = Request('total');
        $descripcion = Request('descripcion');
        $estado = Request('estado');

        $tarifas = Tarifario::findOrFail($id);
        $tarifas->total = $total;
        $tarifas->descripcion = $descripcion;
        $tarifas->estado = $estado;
        $tarifas->update();
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
        $tarifas = Tarifario::findOrFail($id);
        $tarifas->estado = 'D';
        $tarifas->update();
    }
}
