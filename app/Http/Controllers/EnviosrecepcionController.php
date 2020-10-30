<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Cliente;
use App\User;
use App\Guia_movimiento;

class EnviosrecepcionController extends Controller
{
    
        public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {   


        return view('enviosrecepcion.index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Request $id)
    {//muestra guias pendientes de recibir
       // $id = request('id');
        $id_agencia =auth()->user()->id_agencia;




        $detalle_envio = Detalle_envio::select(
                                'detalle_envios.no_guia',
                                'detalle_envios.destinatario',
                                'detalle_envios.telefono',
                                'detalle_envios.direccion',
                                'detalle_envios.total_paquete',
                                'detalle_envios.fecha_entregar',
                                'detalle_envios.observaciones',
                                'detalle_envios.estado',
                                'u.name',
                                'c.nombre as cliente',
                                'e.no_envio'

                            )
                        ->join('envios as e','e.no_envio','=','detalle_envios.no_envio')
                        ->join('users as u','u.id','=','e.user_id')
                        ->join('clientes as c','c.id','=','e.id_cliente')
                        ->where('detalle_envios.estado','1')
                        ->where('e.estado','>=','1')
                        ->where('e.id_agencia',$id_agencia)

                        ->get();
        return view('enviosrecepcion.detalle',['detalle_envio'=> $detalle_envio]);
    }


    public function edit($id)
    {//ya no se usa
        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id();

        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();             

        $result_envio=Envio::where('no_envio',$id)
                        ->get();

        return view('enviosrecepcion.edit',['result_envio'=>$result_envio],['clientes' => $clientes]); 
    }


    public function update(Request $id)
    {

        $no_guia = Request('id');
        $estado = Request('estado');
        $no_envio = Request('no_envio');
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;


        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(['estado' => $estado]);

        if ($estado=='2') {
        //ingresa movimiento guia
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '2';
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $user_id;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();

        $envio = Envio::where('no_envio',$no_envio)
        ->update(['estado'=>'3']);

        }else{
        $detalle_envio=Guia_movimiento::where([
                                            ['no_guia',$no_guia],
                                            ['id_movimiento','2']
                                        ])
            ->delete();
        }
                
    }

    public function update_estado(Request $request, $id)
    {

        $envio = Envio::findOrFail($id);
        $envio->estado='3';
        $envio->update();

        alert()->success('Ok','Recepción de envío satisfactorio!!!');
        return redirect('/enviosrecepcion');
                
    }

    public function destroy($id)
    {
        //
    }
}
