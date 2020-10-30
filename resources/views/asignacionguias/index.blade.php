@extends('../layouts.app')

@section('content')


<div class="card card-primary">
	<div class="card-header">
		Asignación de Guías
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-4">
				<label>Mensajero</label>
				<select class="form-control " id="user_id" onchange="show_asign()" >
					<option value="0" >Seleccione mensajero</option>
					@forelse($user as $mensajero)
					<option value="{{$mensajero->id}}">{{$mensajero->name}}</option>
					@empty
					No tiene mensajeros asociados agencia
					@endforelse
				</select>
			</div>
			<div class="col-md-4">
				<label>Ruta:</label>
				<select class="form-control" id="id_ruta">
					<option value="0" >Seleccione ruta</option>
					@forelse($rutas as $ruta)
					<option value="{{$ruta->id}}">{{$ruta->descripcion}}</option>
					@empty
					<option value="0" >No tiene rutas asignadas</option>
					@endforelse
				</select>
			</div>
			<div class="col-md-2">
				<label>Tarifa:</label>
				<select class="form-control" id="id_tarifa">
					<option value="0" >Seleccione tarifa</option>
					@forelse($tarifarios as $tarifario)
					<option value="{{$tarifario->id}}">{{$tarifario->descripcion}} - {{$tarifario->total}} </option>
					@empty
					<option value="0" >No tiene tarifas asignadas</option>
					@endforelse
				</select>				
			</div>
			<div class="col-md-2" id="total_f">
	            <label>Total:</label>
	            <div class="input-group">
	              <div class="input-group-prepend">
	                <span class="input-group-text">
	                  Q
	                </span>
	              </div>
	              <input type="number" class="form-control" name="total_msj" id="total_msj" step="0.01" value="">
	            </div>
				
			</div>
		</div>
	</div>
</div>

<div id="show_select"></div>
<br>
<div class="row">
	<div class="col-md-5">
		<div class="card card-info ">
			<div class="card-header">
				Guías sin asignar
			</div>
			<div class="card-body">
				<div id="guias_disponibles"></div>
			</div>			
		</div>
	</div>

	<div class="col-md-7">
		<div class="card card-info">
			<div class="card-header">
				Guías asignadas
			</div>
			<div class="card-body">
				<div id="guias_asignadas"></div>
			</div>			
		</div>		
	</div>
</div>


@endsection

@section('scripts')

  <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}" defer ></script>
<script>


//Muestra select con guias disponibles para asignar
function show_select() {
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('asignacionguias.create','id') }}",
		data:{},
		success:function(data){
			$("#show_select").html(data);
		}
	})
}
show_select()
//Musetra guias disponibles para asignar
function show_disp() {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'POST',
		url:"{{ route('asignacionguias.store','id') }}",
		data:{},
		success:function(data){
			$("#guias_disponibles").html(data);
		}
	})
}
show_disp()
//muestra guias asignadas a mensajero
function show_asign() {

id_mensajero = document.getElementById('user_id').value;

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('asignacionguias.show','id') }}",
		data:{id_mensajero:id_mensajero},
		success:function(data){
			$("#guias_asignadas").html(data);
		}
	})
}
show_disp()

//
//trae datos para ingreso de asignación
$(document).on("click", "#btn_asign", function(){

var no_guia =	document.getElementById('select_guia').value
var user_id =	document.getElementById('user_id').value
var id_ruta =	document.getElementById('id_ruta').value
var id_tarifa =	document.getElementById('id_tarifa').value
var total_msj =	document.getElementById('total_msj').value
	if (user_id == 0) {
		Swal.fire({
	  icon: 'error',
	  title: 'Oops...',
	  text: 'Seleccione mensajero!',
		})
	}else{
		if (id_ruta == 0) {
			Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'Seleccione ruta!',
			})
		}
		else{
			if (id_tarifa == 0) {
					Swal.fire({
				  icon: 'error',
				  title: 'Oops...',
				  text: 'Seleccione tarifa!',
					})
			}else{
				insert_asig(no_guia,user_id,id_ruta,id_tarifa,total_msj);
			}
		}
	}


})
//Asigna por boton individual
function asig_mod2(no_guia) {
var user_id =	document.getElementById('user_id').value
var id_ruta =	document.getElementById('id_ruta').value
var id_tarifa =	document.getElementById('id_tarifa').value
var total_msj =	document.getElementById('total_msj').value
	if (user_id == 0) {
		Swal.fire({
	  icon: 'error',
	  title: 'Oops...',
	  text: 'Seleccione mensajero!',
		})
	}else{
		if (id_ruta == 0) {
			Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'Seleccione ruta!',
			})
		}
		else{
			if (id_tarifa == 0) {
					Swal.fire({
				  icon: 'error',
				  title: 'Oops...',
				  text: 'Seleccione tarifa!',
					})
			}else{
				insert_asig(no_guia,user_id,id_ruta,id_tarifa,total_msj);
			}
		}
	}
}


//Ingresar asignacion
function insert_asig(no_guia,user_id,id_ruta,id_tarifa,total_msj) {


			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'PUT',
				url:"{{ route('asignacionguias.update','id') }}",
				data:{no_guia:no_guia,user_id:user_id,id_ruta:id_ruta,id_tarifa:id_tarifa,total_msj:total_msj},
				success:function(data){
					show_select()
					show_disp()
					show_asign()
				}
			})
}


//busca tarifa insert
function show_price(id) {
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('enviosasignacion.create','id') }}",
		data:{id:id},
		success:function(data){
			//alert('Nitido');
			$("#total_f").html(data);
		}
	})
}
//obtiene datos al cambiar tarifa INGRESAR
$(document).on("change", "#id_tarifa", function(){
tarifa=document.getElementById('id_tarifa').value;
show_price(tarifa)
})

//obtiene datos para mostrar en modal
$(document).on("click", "#button_save", function(){
    var id = $(this).data("no_guia");


    var ruta = $(this).data("ruta");
    var tarifa = $(this).data("tarifa");
    var total_msj = $(this).data("total_msj");
    var fecha_entregar = $(this).data("fecha_entregar");


    //muestra datos en input formulario modal
    document.getElementById('no_guiaT').value=id;
    document.getElementById('ruta').value=ruta;

    document.getElementById('tarifa').value=tarifa;
    document.getElementById('total_msjE').value=total_msj;

    document.getElementById('fecha_entregar').value=fecha_entregar;

})

//busca tarifa UPDATE
function show_priceE(id) {
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('asignacionguias.edit','id') }}",
		data:{id:id},
		success:function(data){
			//alert('Nitido');
			$("#total_fE").html(data);
		}
	})
}
//obtiene datos al cambiar tarifa EDITAR
$(document).on("change", "#tarifa", function(){
tarifa=document.getElementById('tarifa').value;
show_priceE(tarifa)
})

//funcion para editar asignacion
function edit_asign() {

	id=document.getElementById('no_guiaT').value
	ruta=document.getElementById('ruta').value;
    tarifa=document.getElementById('tarifa').value;
    total_msj=document.getElementById('total_msjE').value;

	fecha_entregar = document.getElementById("fecha_entregar").value;
	check = document.getElementById("check_dev").checked;

			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'PUT',
				url:"{{ route('enviosasignacion.update','id') }}",
				data:{id:id,ruta:ruta,tarifa:tarifa,total_msj:total_msj,fecha_entregar:fecha_entregar,check:check},
				success:function(data){
					show_select()
					show_disp()
					show_asign()
				}
			})
}

function back_to(no_guia) {

			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'DELETE',
				url:"{{ route('asignacionguias.destroy','id') }}",
				data:{no_guia:no_guia},
				success:function(data){
					show_select()
					show_disp()
					show_asign()
				}
			})
}



</script>
@endsection