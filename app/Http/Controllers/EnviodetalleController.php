<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalle_envio;
use App\Agencia;
use App\Envio;
use App\Guia_movimiento;
use App\Cliente;
use Illuminate\Support\Facades\Validator;



class EnviodetalleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        $id = request('id');
        $detalle_envio = Detalle_envio::where([
            ['no_envio',$id]
        ])
        ->get();
        return view('enviosdetalles.index',['detalle_envio'=> $detalle_envio]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {   //trae variables agencia y usuario
        $id_agencia =auth()->user()->id_agencia;
        $user_id =Request('user_id');
        //busca agencia para utilizar abrev en no. guia
        $agencia = Agencia::where('id',$id_agencia)
                    ->get();       
        foreach ($agencia as  $value) {
             $abrev=$value->abrev;
        }
        
        //trae ultimo correlativo ingresado
        $data = Detalle_envio::all() ->sortByDesc('correlativo')->first();
        //suma unidad a correlativo para obtener el nuevo no. guia
        $correlativo=$data->correlativo;
        $correlativo=$correlativo+1;

        //prepara tabla para insertar datos
        $detalle_envios = new Detalle_envio();
        //inserta datos, primera linea con correlativo
        $detalle_envios->no_guia =$abrev.$user_id.'0'.$correlativo;
        $detalle_envios->no_envio =request('id');
        $detalle_envios->id_tipo_vehi ='1';
        $detalle_envios->id_tarifa ='1';
        $detalle_envios->destinatario =request('destinatario');
        $detalle_envios->telefono =request('telefono');
        $detalle_envios->direccion =request('direccion');
        $detalle_envios->piezas ='0';
        $detalle_envios->total_paquete =request('total_paquete');
        $detalle_envios->estado ='1'; 
        $detalle_envios->fecha_entregar =request('fecha_entrega'); 
        $detalle_envios->observaciones =request('observaciones');
        //guarda datos
        $detalle_envios->save();
        //obtiene no envio
        $id_envio=request('id');
        //busca envio para sumar valor y unidades
        $envio=Envio::where('no_envio',$id_envio)
                        ->get();
            foreach ($envio as $en) {
                $total=$en->total_envio;
                $items=$en->items;
            }
        //suma valores y unidades
        $total=$total+request('total_paquete');
        $en->total_envio=$total;
        $en->items=$items+1;
        $en->update();

        //ingresa movimiento guia
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '1';
        $guia_movimiento->no_guia = $abrev.$user_id.'0'.$correlativo;
        $guia_movimiento->user_id = $user_id;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();
    }


    public function show(Request $id)
    {
        //muestra detalles del envio
        $id = request('id');
        $detalle_envio = Detalle_envio::where([
            ['no_envio',$id]
        ])
        ->get();
        return view('enviosdetalles.show',['detalle_envio'=> $detalle_envio]);
    }


    public function edit($id)
    {//para impresión

        //dd($id);
        //$id = Request($id);
        $id_agencia =auth()->user()->id_agencia;


        $result_envio=Envio::where('no_envio',$id)
                        ->get();
        //dd($result_envio);
        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();

        $detalle_envio = Detalle_envio::where([
            ['no_envio',$id]
        ])
        ->get();

        return view('envios.print')
                ->with('result_envio',$result_envio)
                ->with('detalle_envio', $detalle_envio)
                ->with('clientes',$clientes); 
        
    }


    public function update(Request $request, $id)
    {
        $no_envio = Request('no_envio');
        $no_guia = Request('no_guia');
        $destinatario = Request('destinatario');
        $telefono = Request('telefono');
        $direccion = Request('direccion');
        $total = Request('total');
        $fecha = Request('fecha');
        $observaciones = Request('observaciones');
        $total_b = Request('total_b');

        $envio = Envio::findOrFail($no_envio);
        $envio->total_envio= $envio->total_envio-$total_b;
        $envio->total_envio= $envio->total_envio+$total;
        $envio->update();

        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                            ->update([
                                    'destinatario' => $destinatario,
                                    'telefono' => $telefono,
                                    'direccion' => $direccion,
                                    'total_paquete' => $total,
                                    'fecha_entregar' => $fecha,
                                    'observaciones' => $observaciones
                                    ]);        
    }


    public function destroy(Request $id)
    {

        $no_guia=request('id');

        $detalle_envio=Guia_movimiento::where('no_guia',$no_guia)
            ->delete();

        $detalle_envio=Detalle_envio::where('no_guia',$no_guia)
            ->delete();



        $id_envio=request('id_envio');

        $envio=Envio::where('no_envio',$id_envio)
                        ->get();
            foreach ($envio as $en) {
                $total=$en->total_envio;
                $items=$en->items;
            }
        $total=$total-request('total_paquete');
        $en->total_envio=$total;
        $en->items=$items-1;
        $en->update();
            
    }
}
