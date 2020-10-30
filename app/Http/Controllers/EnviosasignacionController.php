<?php

namespace App\Http\Controllers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Cliente;
use App\User;
use App\Ruta;
use App\Guia_movimiento;
use App\Tarifario;

class EnviosasignacionController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id(); 
        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();

        $envios = Envio::where('id_agencia',$id_agencia)
                        ->whereIn('estado',['3'])
                        ->get();

        $user = User::where([
                            ['id_agencia',$id_agencia],
                            ['role_id','2'],
                            ['status','A']
                            ])
                            ->get();
        
        return view('enviosasignacion.index',['envios' => $envios]);                
    }


    public function create(Request $request)
    {   //MUESTRA TARIFA INSERT
        $id=Request('id');
        $tarifas = Tarifario::findOrFail($id);

        return view('enviosasignacion.price',['tarifas' => $tarifas]);
    }


    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $id_agencia =auth()->user()->id_agencia;
        $id = request('id');


        $detalle_envio = Detalle_envio::select(
                                'detalle_envios.no_guia as no_guia',
                                'detalle_envios.destinatario',
                                'detalle_envios.telefono',
                                'detalle_envios.total_paquete',
                                'detalle_envios.fecha_entregar',
                                'detalle_envios.observaciones',
                                'detalle_envios.estado',
                                'detalle_envios.direccion',
                                'detalle_envios.total_msj',
                                'detalle_envios.id_tarifa',
                                'rutas.descripcion as ruta',
                                'rutas.id as id_ruta',
                                'users.name',
                                'users.id as user_id'
                                )
        ->leftjoin('rutas','rutas.id','=','detalle_envios.id_ruta')
        ->leftjoin('users','users.id','=','detalle_envios.user_id')
        ->where('detalle_envios.no_envio',$id)
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

        return view('enviosasignacion.detalle')
                    ->with('detalle_envio', $detalle_envio)
                    ->with('user',$user)
                    ->with('rutas',$rutas)
                    ->with('tarifarios',$tarifarios);
    }


    public function edit($id)
    {
        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id();

        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();             

        $result_envio=Envio::where('no_envio',$id)
                        ->get();

        return view('enviosasignacion.edit',['result_envio'=>$result_envio],['clientes' => $clientes]); 
    }


    public function update(Request $request, $id)
    {
        $no_guia = Request('id');
        $user_id =auth()->id();
        $id_agencia =auth()->user()->id_agencia;

        $ruta = Request('ruta');
        $tarifa = Request('tarifa');
        $total_msj = Request('total_msj');
        $ckeck = Request('check');
        $fecha_entregar = Request('fecha_entregar');

        if ($ckeck=='true') {
            $dev='S';
            $mov='11';
        }else{
            $dev='N';
            $mov='AS';
        }

        $detalle_envio = Detalle_envio::where('no_guia',$no_guia)
                        ->update(
                                ['estado' => $mov,
                                'id_ruta' => $ruta,
                                'total_msj' => $total_msj,
                                'id_tarifa' => $tarifa,
                                'devolucion' => $dev,
                                'fecha_entregar' => $fecha_entregar
                                ]
                                );


        }
    

    public function update_estado(Request $request, $id)
    {

        $envio = Envio::findOrFail($id);
        $envio->estado='4';
        $envio->update();

        alert()->success('Ok','Asignación de envío satisfactorio!!!');
        return redirect('/enviosasignacion');
                
    }
    public function destroy($id)
    {
        //
    }
}
