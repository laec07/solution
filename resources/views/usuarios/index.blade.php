@extends('layouts.app')

@section('content')
 <div class="container">
   <h2>Lista de usuarios <a href="usuarios/create"><button type="button" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Agregar</button> </a> </h2>
 </div>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nombre</th>
      <th scope="col">Usuario</th>
      <th scope="col">email</th>
      <th scope="col">Rol</th>
      <th scope="col">imagen</th>
      <th scope="col"><i class="fa fa-wrench" aria-hidden="true"></i></th>
    </tr>
  </thead>
  <tbody>

    	@foreach($users as $user)
    	<tr>
	      <th scope="row">{{$user->id}}  </th>
	      <td> {{$user->name}} </td>
	      <td>{{$user->username}} </td>
	      <td>{{$user->email }} </td>
          <td>
          	@foreach($user->roles as $role)
            	{{$role->name}}
          	@endforeach
          </td>
	      <td>
          @if($user->imagen !="")
          <img src="{{asset('imagenes/'.$user->imagen)  }}" width="50px" height="50px" class="img-circle elevation-2">
          @else
          <img src="{{asset('dist/img/usuario.png')  }}" width="50px" height="50px" class="img-circle elevation-2">
          @endif 
        </td>
	      <td>
	      	<a  class="btn btn-warning" href="{{route('usuarios.edit',$user->id)}} "><i class="fa fa-edit" aria-hidden="true"></i></a>
	      	<a  class="btn btn-danger" href=" {{ url('/usuarios/'.$user->id.'/estado') }} " onclick="return confirm('¿Desea continuar eliminando registro?') " ><i class="fa fa-trash" aria-hidden="true"></i></a>



	      </td>
	    </tr>

    	@endforeach


  </tbody>
</table>
@endsection
