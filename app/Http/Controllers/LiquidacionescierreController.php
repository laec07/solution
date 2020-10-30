<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use App\Envio;
use App\User;
use App\Deposito;
use App\Liquidacion;

class LiquidacionescierreController extends Controller
{

        public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Request $request, $id)
    {
        $no_liquidacion= Request('no_liquidacion');

        $pagos = Deposito::Select(
                                'depositos.id',
                                'depositos.id_liquidacion',
                                'depositos.no_documento',
                                'depositos.fecha_documento',
                                'depositos.id_cuenta',
                                'depositos.id_pago',
                                'depositos.observaciones',
                                'depositos.user_id',
                                'depositos.created_at',
                                'depositos.total',
                                'depositos.created_at',
                                'cc.no_cuenta',
                                'b.descripcion as banco',
                                'u.username'
                                        )
                    ->join('cuenta_clientes as cc','cc.id','=','depositos.id_cuenta')
                    ->join('bancos as b','b.id','=','cc.id_banco')
                    ->join('users as u','u.id','=','depositos.user_id')
                    ->where('depositos.id_liquidacion',$no_liquidacion)
                    ->get();

       return view('liquidacionescierre.detallepagos')
                ->with('pagos',$pagos); 
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $user_id =auth()->id();
        $id_liquidacion = Request('id_liquidacion');

       

        $liquidacion = Liquidacion::findOrFail($id_liquidacion);
        $liquidacion->estado= "C";
        $liquidacion->user_idCierre= $user_id;
        $liquidacion->update();
    }


    public function destroy(Request $id)
    {
        $id = Request('id');
        $no_liq_h = Request('no_liq_h');
        $total_p = Request('total');
        
        $liquidacion = Liquidacion::findOrFail($no_liq_h);
        $liquidacion->total_depositos= $liquidacion->total_depositos-$total_p;
        $liquidacion->update();

        $deposito=Deposito::where('id',$id)
            ->delete();

 
    }
}
