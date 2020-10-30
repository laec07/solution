<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Cliente;
use Illuminate\Support\Facades\Validator;

class EnviosController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        //MUESTRA VISTA PRINCIPAL

        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id();        
        //TRAE INFORMACION DE CLIENTE Y ENVIOS
        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();

        $envios = Envio::where('user_id',$user_id)
                        ->whereIn('estado',['1'])
                        ->get();
  
    
        return view('envios.index',['clientes' => $clientes],['envios' => $envios]);
    }


    public function create(Request $id)
    {//para impresion
        $id = Request($id);
        $id_agencia =auth()->user()->id_agencia;

        $result_envio=Envio::where('no_envio',$id)
                        ->get();

        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();

        $detalle_envio = Detalle_envio::where([
            ['no_envio',$id]
        ])
        ->get();

        return view('print.detalle')
                ->with('result_envio',$result_envio)
                ->with('detalle_envio', $detalle_envio)
                ->with('clientes',$clientes);         
    }


    public function store(Request $request)
    {

        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id();

        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();

        $validator = Validator::make($request->all(), [
                'id_cliente' => 'required',
        ]);

        if ($validator->fails()) {
                return back()->with('errors', $validator->messages()->all()[0])->withInput();
            }
        $envio = new Envio();    

        $envio->user_id = $user_id;
        $envio->id_agencia = $id_agencia;
        $envio->id_cliente = request('id_cliente');
        $envio->total_envio = '0';
        $envio->total_mensajeria = '0';
        $envio->total_general = '0';
        $envio->estado = '0';
        $envio->items = '0';

        $envio->save();

        $no_envio = $envio->no_envio;
        $result_envio=Envio::where('no_envio',$no_envio)
                        ->get();

        return view('envios.detalle',['result_envio'=>$result_envio],['clientes' => $clientes]);        

    }


    public function show($id)
    {
              $result_envio=Envio::where('no_envio',$no_envio)
                        ->get();

        return view('envios.detalle',['result_envio'=>$result_envio],['clientes' => $clientes]);  
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

        return view('envios.detalle',['result_envio'=>$result_envio],['clientes' => $clientes]);  
    }


    public function update(Request $request, $id)
    {
        $envio = Envio::findOrFail($id);
        $envio->estado='1';
        $envio->update();

        alert()->success('Ok','Envio ingresado correctamente');
        return redirect('/envios');        

    }

    public function update_estado( $id)
        {
        $envio = Envio::findOrFail($id);
        $envio->estado='0';
        $envio->update();

        alert()->success('Ok','Envio eliminado correctamente');
        return redirect('/envios'); 
        }

    public function destroy($id)
    {
        //
    }
}
