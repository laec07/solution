<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalle_envio;
use App\Agencia;
use App\Envio;
use App\Guia_movimiento;
use App\User;

class RevisionController extends Controller
{

    public function index()
    {

       return view('revision.index');
    }


    public function create()
    {
        //
    }

    //traslado
    public function store(Request $request)
    {
        $id_mensajero = Request('id_mensajero');
        $no_guia = Request('no_guia');

        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;

        $user_trasl = User::findOrFail($user_id);

        $user_dest = User::findOrFail($id_mensajero);
        

        //Actualiza guia a piloto
        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(
                                ['estado' => '3',
                                'user_id' => $id_mensajero
                                ]
                                );

        //Inserta movimiento asignado a piloto
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '14';
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $id_mensajero;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        $guia_movimiento->observaciones = 'Traslado por usuario '.$user_trasl->username .' a '.$user_dest->username;
        //guarda datos
        $guia_movimiento->save();
        //Inserta movimiento asignacion a ruta
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '3';
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $id_mensajero;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        $guia_movimiento->observaciones = 'Traslado por usuario '.$user_trasl->username .' a '.$user_dest->username;
        //guarda datos
        $guia_movimiento->save();                        



    }
    //muestra guias asignadas y otros datos
    public function show($id)
    {
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;

        $detalle_envio = Detalle_envio::where([['user_id',$user_id]])
                                    ->whereIn('estado',['3','4'])
                                    ->get();

        $mensajero = User::where([
                            ['id_agencia',$id_agencia],
                            ['role_id','2'],
                            ['status','A'],
                            ['id','!=',$user_id]
                            ])
                            ->get(); 

        return view('revision.detalle')
            ->with('detalle_envio',$detalle_envio)
            ->with('mensajero', $mensajero); 
    }


    public function edit($id)
    {
        //
    }

    public function update(Request  $id)
    {
        $no_guia = Request('id');
        $estado = Request('estado');
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;


        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(['estado' => $estado]);

        if ($estado=='4') {
        //ingresa movimiento guia
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '4';
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $user_id;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();
        }else{
        $guia_movimiento=Guia_movimiento::where([
                                            ['no_guia',$no_guia],
                                            ['id_movimiento','4']
                                        ])
            ->delete();
        }
    }


    public function destroy($id)
    {
        //
    }
}
