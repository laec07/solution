@extends('../layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-6">

			<h3>Editar usuario: {{$user->name}} </h3>
			@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
			<form action=" {{ route('usuarios.update', $user->id) }} " method="POST" enctype="multipart/form-data">
				@method('PATCH')
				@csrf

				  <div class="row">
				  	<div class="form-group col-md-6">
					    <label >Nombre</label>
					    <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="Nombre">
					</div>
				  	<div class="form-group col-md-6">
					    <label >Usuario</label>
					    <input type="text" class="form-control" name="username" value="{{$user->username}}" placeholder="Nombre" readonly="">
					</div>
				  </div>

			    <div class="row">
				  <div class="form-group col-md-6">
				    <label for="email">Rol</label>
				    <select name="rol" class="form-control">
				    	<option selected disabled>Elige rol de usuario..</option>
				    	@foreach($roles as $role)
				    		@if($role->name == str_replace(array('["', '"]'), '', $user->tieneRol()))
				    		<option value="{{$role->id}} " selected> {{$role->name}} </option>
				    		@else
				    		<option value="{{$role->id}} "> {{$role->name}} </option>
				    		@endif
				    	@endforeach
				    </select>
				  </div>
				    <div class="form-group col-md-6">
					    <label >Email</label>
					    <input type="email" class="form-control" name="email" value="{{$user->email}}" placeholder="email">
				    </div>
			    </div>

			    <div class="row">
			    	<div class="form-group col-md-6">
			    		<label>Contraseña <span class="small">Opcional</span> </label>
			    		<input type="password" class="form-control" name="password" placeholder="Contraseña" >
			    	</div>
			    	<div class="form-group col-md-6">
			    		<label>Confirme Contraseña <span class="small">Opcional</span></label>
			    		<input type="password" class="form-control" name="password_confirmation" placeholder="Confirme Contraseña" >
			    	</div>
			    </div>

			    <div class="row">
				  <div class="form-group col-md-6"> 
				  	<label>Imagen</label>
				  	<input type="file" name="imagen" class="form-control">

				  </div>
				  <div class="form-group col-md-6">
				  	@if($user->imagen !="")
				  		<img src="{{asset('imagenes/'.$user->imagen)}}" alt="{{ $user->imagen}} " height="50px" width="50px" class="img-circle elevation-2" >
				  	@endif				  	
				  </div>
			    </div>

			    <div class="row">
			    	<div class="col-md-6">
					  <button type="submit" class="btn btn-primary">Actualizar</button>
					  <a href=" {{asset('/usuarios')}} "> <button type="button" class="btn btn-danger">Cancelar</button></a>			    		
			    	</div>
			    	
			    </div>



			</form>
		</div>
	</div>
</div>

@endsection