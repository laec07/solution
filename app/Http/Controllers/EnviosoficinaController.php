<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Detalle_envio;
use App\Cliente;
use App\User;
use Illuminate\Support\Facades\Validator;

class EnviosoficinaController extends Controller
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

        $envios = Envio::whereIn('estado',['1'])
                        ->where('id_agencia',$id_agencia)
                        ->get();

        $mensajeros = User::where('status','A')
                        ->where('id_agencia',$id_agencia)
                        ->get();

        return view('enviosoficina.index')
                    ->with('clientes',$clientes)
                    ->with('envios', $envios)
                    ->with('mensajeros', $mensajeros);

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
        $id_agencia =auth()->user()->id_agencia;
        $user_id =request('id_mensajero');

        $mensajeros = User::where('status','A')
                        ->where('id_agencia',$id_agencia)
                        ->get();

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

        return view('enviosoficina.detalle')
                    ->with('result_envio',$result_envio)
                    ->with('clientes',$clientes)
                    ->with('mensajeros',$mensajeros); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_agencia =auth()->user()->id_agencia;
        $user_id =auth()->id();

        $mensajeros = User::where('status','A')
                        ->where('id_agencia',$id_agencia)
                        ->get();


        $clientes = Cliente::where([ 
                            ['estado','A'],
                            ['id_agencia',$id_agencia] 
                            ])
                            ->get();             

        $result_envio=Envio::where('no_envio',$id)
                        ->get();

        return view('enviosoficina.detalle')
                    ->with('result_envio',$result_envio)
                    ->with('clientes',$clientes)
                    ->with('mensajeros',$mensajeros);  
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
        $envio = Envio::findOrFail($id);
        $envio->estado='1';
        $envio->update();

        alert()->success('Ok','Envio ingresado correctamente');
        return redirect('/enviosoficina'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
