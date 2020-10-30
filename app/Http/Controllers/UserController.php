<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserEditFormRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   $id_agencia =auth()->user()->id_agencia;
        $users = User::where('status','A' )
                ->where('id_agencia',$id_agencia)
                ->where('id','>','1')
        		->get();
        return view('usuarios.index', ['users' => $users]);

    }

    public function create()
    {
    	$roles = Role::all();
    	return view('usuarios.create', ['roles'=>$roles]);
    }

    public function store(UserEditFormRequest $request)
    {

        $id_agencia =auth()->user()->id_agencia;
        $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'max:255',
                'username' => 'required|max:20|Unique:users',
                'rol' => 'required',
                'password' => 'required|min:6|confirmed',
                'imagen' => 'mimes:jped,bmp,png'
        ]);

        if ($validator->fails()) {
                return back()->with('errors', $validator->messages()->all()[0])->withInput();
            }



    	$usuario = new User();

    	$usuario->name = request('name');
    	$usuario->email = request('email');
    	$usuario->password = bcrypt(request('password'));
    	$usuario->role_id = request('rol');
    	$usuario->username =request('username');
    	$usuario->status ='A';
        $usuario->id_agencia = $id_agencia;
    	if ($request->hasFile('image')) {
    		$file = $request->imagen;
    		$file->move(public_path().'/imagenes',$file->getClientOriginalName());
    	}



    	$usuario->save();

    	$usuario->asignarRol($request->get('rol'));

    	alert()->success('Ok','Datos insertados correctamente');
    	return redirect('/usuarios');

    }

    public function edit($id)
    {
    	$roles = Role::all();
    	return view('usuarios.edit',['user' => User::findOrFail($id)],
    		['roles' => $roles]);
    }

    public function update(UserEditFormRequest $request, $id)
    {

    	$usuario = User::findOrFail($id);

    	$usuario->name = $request->get('name');
    	$usuario->email = $request->get('email');
    	$usuario->role_id= $request->get('rol');

    	if ($request->hasFile('imagen')) {
    		$file = $request->imagen;
    		$file->move(public_path().'/imagenes',$file->getClientOriginalName());
    		$usuario->imagen = $file->getClientOriginalName();
    	}

    	$pass = $request->get('password');
    	if ($pass !=null) {
    		$usuario->password = bcrypt(request('password'));
    	}else{
    		unset($usuario->password);
    	}

    	$role = $usuario->roles;
    	if (count($role)>0) {
    		$role_id = $role[0]->id;
    	}

    	User::find($id)->roles()->updateExistingPivot($role_id, ['role_id' => $request->get('rol')]);

    	$usuario->update();
        //toast('Datos actualizados correctamente','success');

    	alert()->success('Ok','Datos actualizados correctamente');
    	return redirect('/usuarios');

    }

    public function update_estado( $id)
        {
            $usuario = User::findOrFail($id);

            $usuario->status = 'I';
            $usuario->update();

        alert()->success('Ok','Registro eliminado correctamente');
        return redirect('/usuarios');
        }


}
