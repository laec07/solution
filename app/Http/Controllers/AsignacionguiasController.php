<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Cliente;
use App\User;
use App\Ruta;
use App\Guia_movimiento;
use App\Tarifario;

class AsignacionguiasController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');

    }
    public function index()
    {
        //MUESTRA PARAMETROS PARA LA ASIGNACION EN ENCABEZADO
        $id_agencia =auth()->user()->id_agencia;
        $id = request('id');
        
        $user = User::where([
                            ['id_agencia',$id_agencia],
                            ['role_id','2'],
                            ['status','A']
                            ])
                            ->get();
        $rutas = Ruta::where([
                            ['id_agencia',$id_agencia],
                            ['estado','A']
                            ])
                            ->get();

        $tarifarios = Tarifario::where([
                            ['id_agencia',$id_agencia],
                            ['estado','A']
                            ])
                            ->get();

        return view('asignacionguias.index')
                    ->with('user',$user)
                    ->with('rutas',$rutas)
                    ->with('tarifarios',$tarifarios);
    }


    public function create(Request $request)
    {
        //
        //muestra guias disponibles para asignar en select
        $id_agencia =auth()->user()->id_agencia;
        $detalle_envios = Detalle_envio::select(
                                                'detalle_envios.no_guia',
                                                'detalle_envios.no_envio',
                                                'detalle_envios.destinatario',
                                                'detalle_envios.telefono',
                                                'detalle_envios.direccion',
                                                'detalle_envios.total_paquete',
                                                'detalle_envios.fecha_entregar',
                                                'detalle_envios.estado',
                                                'envios.id_agencia',
                                                'clientes.nombre'
                                                )
                                        ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                        ->join('clientes','clientes.id','=','envios.id_cliente')
                                        ->whereIN('detalle_envios.estado',['2','15'])
                                        ->where('envios.id_agencia',$id_agencia)
                                        ->get();


        return view('asignacionguias.select',['detalle_envios' => $detalle_envios]);


    }


    public function store(Request $request)
    {
        //muestra guias disponibles para asignar en columna
        $id_agencia =auth()->user()->id_agencia;
        $detalle_envios = Detalle_envio::select(
                                                'detalle_envios.no_guia',
                                                'detalle_envios.no_envio',
                                                'detalle_envios.destinatario',
                                                'detalle_envios.telefono',
                                                'detalle_envios.direccion',
                                                'detalle_envios.total_paquete',
                                                'detalle_envios.fecha_entregar',
                                                'detalle_envios.estado',
                                                'detalle_envios.total_paquete',
                                                'envios.id_agencia',
                                                'clientes.nombre'
                                                )
                                        ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                        ->join('clientes','clientes.id','=','envios.id_cliente')
                                        ->whereIn('detalle_envios.estado',['2','15'])
                                        ->where('envios.id_agencia',$id_agencia)
                                        ->get();


        return view('asignacionguias.disponibles',['detalle_envios' => $detalle_envios]);
    }


    public function show(Request $request)
    {
        //muestra guias asignadas
        $id_agencia =auth()->user()->id_agencia; 
        $id_mensajero = Request('id_mensajero');
        $detalle_envios = Detalle_envio::select(
                                                'detalle_envios.no_guia',
                                                'detalle_envios.no_envio',
                                                'detalle_envios.destinatario',
                                                'detalle_envios.telefono',
                                                'detalle_envios.direccion',
                                                'detalle_envios.total_paquete',
                                                'detalle_envios.total_msj',
                                                'detalle_envios.fecha_entregar',
                                                'detalle_envios.estado',
                                                'detalle_envios.id_ruta',
                                                'rutas.descripcion as ruta',
                                                'detalle_envios.id_tarifa',
                                                'tarifarios.descripcion as tarifa',
                                                'envios.id_agencia',
                                                'clientes.nombre'
                                                )
                                        ->join('envios','envios.no_envio','=','detalle_envios.no_envio')
                                        ->join('clientes','clientes.id','=','envios.id_cliente')
                                        ->join('rutas','rutas.id','=','detalle_envios.id_ruta')
                                        ->join('tarifarios','tarifarios.id','=','detalle_envios.id_tarifa')
                                        ->whereIn('detalle_envios.estado',['3','11','6','7','8'])
                                        ->where('detalle_envios.user_id',$id_mensajero)
                                        ->get();
        $user = User::where([
                            ['id_agencia',$id_agencia],
                            ['role_id','2'],
                            ['status','A']
                            ])
                            ->get();
        $rutas = Ruta::where([
                            ['id_agencia',$id_agencia],
                            ['estado','A']
                            ])
                            ->get();

        $tarifarios = Tarifario::where([
                            ['id_agencia',$id_agencia],
                            ['estado','A']
                            ])
                            ->get();


        return view('asignacionguias.asignadas')
                ->with('detalle_envios',$detalle_envios)
                ->with('user',$user)
                ->with('rutas',$rutas)
                ->with('tarifarios',$tarifarios);


    }


    public function edit($id)
    {//MUESTRA TARIFA UPDATE

        $id=Request('id');
        $tarifas = Tarifario::findOrFail($id);

        return view('enviosasignacion.price_edit',['tarifas' => $tarifas]);


    }


    public function update(Request $request, $id)
    {//asigna guia a piloto
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;

        $no_guia = Request('no_guia'); 
        $piloto = Request('user_id');
        $id_ruta = Request('id_ruta');
        $id_tarifa = Request('id_tarifa');
        $total_msj = Request('total_msj');

        //Actualiza guia a piloto
        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(
                                ['estado' => '3',
                                'user_id' => $piloto,
                                'id_ruta' => $id_ruta,
                                'total_msj' => $total_msj,
                                'id_tarifa' => $id_tarifa,
                                ]
                                );
        //Inserta movimiento asignacion a ruta
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '3';
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $user_id;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();
        //Inserta movimiento asignado a piloto
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '14';
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $piloto;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos
        $guia_movimiento->save();         
    }


    public function destroy($id)
    {//Regresa a bodega
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;

        $no_guia = Request('no_guia'); 

        //Actualiza guia a piloto
        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(
                                ['estado' => '2',
                                'user_id' => NULL,
                                'id_ruta' => NULL,
                                'total_msj' => '0',
                                'devolucion' => NULL
                                ]
                                );
        //Inserta movimiento asignacion a ruta
        $guia_movimiento = new Guia_movimiento();
        $guia_movimiento->id_movimiento = '2';
        $guia_movimiento->no_guia = $no_guia;
        $guia_movimiento->user_id = $user_id;
        $guia_movimiento->estado = 'A';
        $guia_movimiento->id_agencia = $id_agencia;
        //guarda datos       //
        $guia_movimiento->save();
    }
}
