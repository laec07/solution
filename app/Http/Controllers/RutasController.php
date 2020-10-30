<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ruta;

class RutasController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');

    }
    
    public function index()
    {
        return view('rutas.index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $id_agencia =auth()->user()->id_agencia;

        $nombre = Request('nombre');
        $descripcion = Request('descripcion');
        $estado = Request('estado');

        $rutas = new Ruta();
        $rutas->id_agencia = $id_agencia;
        $rutas->nombre = $nombre;
        $rutas->descripcion = $descripcion;
        $rutas->estado = $estado;
        $rutas->save();
    }


    public function show($id)
    {
        $id_agencia =auth()->user()->id_agencia;

        $rutas = Ruta::where('id_agencia',$id_agencia)
                        ->whereIn('estado',['A','I'])
                        ->get();

        return view('rutas.detalle')
                ->with('rutas',$rutas);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $id = Request('id');
        $nombre = Request('nombre');
        $descripcion = Request('descripcion');
        $estado = Request('estado');

        $rutas = Ruta::findOrFail($id);
        $rutas->nombre = $nombre;
        $rutas->descripcion = $descripcion;
        $rutas->estado = $estado;
        $rutas->update();
    }


    public function destroy($id)
    {
        $id = Request('id');
        $rutas = Ruta::findOrFail($id);
        $rutas->estado = 'D';
        $rutas->update();

    }
}
