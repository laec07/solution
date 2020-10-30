@extends('../layouts.app')

@section('content')
<div class="container">

			<form action="/usuarios" method="POST" enctype="multipart/form-data">
				@csrf

				<h2>Creación de usuario</h2>

			  <div class="row">
			  	<div class="form-group col-md-6">
				    <label >Nombre</label>
				    <input type="text" class="form-control" name="name"  placeholder="Nombre">
				</div>
			  	<div class="form-group col-md-6">
				    <label >Usuario</label>
				    <input type="text" class="form-control" name="username"  placeholder="Usuario">
				</div>
			    </div>

			    <div class="row">
			    	
				  <div class="form-group col-md-6">
				    <label for="email">Rol</label>
				    <select name="rol" class="form-control">
				    	<option selected disabled>Elige rol de usuario..</option>
				    	@foreach($roles as $role)
				    	<option value="{{$role->id}} "> {{$role->name}} </option>
				    	@endforeach
				    </select>
				  </div>

			    <div class="form-group col-md-6">
				    <label >Email</label>
				    <input type="email" class="form-control" name="email"  placeholder="email">
			    </div>

			    </div>

			    <div class="row">
			    	<div class="form-group col-md-6">
			    		<label>Contraseña</label>
			    		<input type="password" class="form-control" name="password" placeholder="Contraseña">
			    	</div>
			    	<div class="form-group col-md-6">
			    		<label>Confirme Contraseña</label>
			    		<input type="password" class="form-control" name="password_confirmation" placeholder="Confirme Contraseña">
			    	</div>
			    </div>

			    <div class="row">

				  <div class="form-group col-md-6"> 
				  	<label>Imagen</label>
				  	<input type="file" name="imagen" class="form-control">
				  </div>			    	
			    </div>

			  <button type="submit" class="btn btn-primary">Registrar</button>
			  <a href=" {{asset('/usuarios')}} "> <button type="button" class="btn btn-danger">Cancelar</button></a>
			</form>

</div>

@endsection