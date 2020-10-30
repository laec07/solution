@extends('../layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

@foreach($result_envio as $result )

<div class="card">
	<div class="card-header">
		<h4>Guias asignar</h4>
		<div class="row">
			<div class="col">
				<p> <b>No. Envio</b> <input type="hidden" name="id_envio" id="id_envio" value="{{$result->no_envio}}"> {{$result->no_envio}}
				<br>
				<b> Cliente:</b>
					@foreach($clientes as $cliente)
			        	@if($result->id_cliente == $cliente->id)
			        	{{$cliente->nombre}}
			        	@endif 
					@endforeach
				</p>
			</div>

		</div>
		
	</div>
	<div class="card-body">
		<div id="show_data"></div>
	</div>
	<div class="card-footer">

		<div id="button_g" style="padding: 4px;" ></div>
		

		<a href="{{url('enviosasignacion')}}" class="btn btn-secondary btn-block">Cancelar</a>
	</div>
</div>

@endforeach

@endsection

@section('scripts')
<script>

function validabutton() {
	var a = document.getElementById('vbutton').value
	if (a>0) {
				$("#button_g").html('<button title="Tiene guias pendientes de asignar " class="btn btn-primary  btn-block" disabled>Guardar</button>');
	}else{
		$("#button_g").html('<a href=" {{ url('/enviosasignacion/'.$result->no_envio.'/estado') }} " class="btn btn-primary btn-block">Guardar</a>');
	}
}

function show_data() {
var id = document.getElementById('id_envio').value;
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('enviosasignacion.show','id') }}",
		data:{id:id},
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
			validabutton();
		}
	})
}
show_data();

function receiver() {

	id=document.getElementById('no_guiaT').value
	ruta=document.getElementById('ruta').value;
    piloto=document.getElementById('piloto').value;
    tarifa=document.getElementById('tarifa').value;
    total_msj=document.getElementById('total_msj').value;
	estado=document.getElementById('estadoT').value;
	fecha_entregar = document.getElementById("fecha_entregar").value;
	check = document.getElementById("check_dev").checked;


	if (piloto=='Seleccione piloto') {
		alert('Seleccione piloto');
	}else{
		if (ruta =='Seleccione Ruta' ) {
			alert('Seleccione Ruta');
		}else{
			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'PUT',
				url:"{{ route('enviosasignacion.update','id') }}",
				data:{id:id,estado:estado,piloto:piloto,ruta:ruta,tarifa:tarifa,total_msj:total_msj,fecha_entregar:fecha_entregar,check:check},
				success:function(data){
					show_data();
				}
			})
		}
	}
}
//obtiene datos para mostrar en modal
$(document).on("click", "#button_save", function(){
    var id = $(this).data("no_guia");
    var estado = $(this).data("estado");
    var piloto = $(this).data("piloto");
    var ruta = $(this).data("ruta");
    var tarifa = $(this).data("tarifa");
    var total_msj = $(this).data("total_msj");
    var fecha_entregar = $(this).data("fecha_entregar");

    //si no hay dato, coloca valor 0 para mostrar "seleccione..."
    if (piloto=="") {
    	piloto=0;
    }
    //si no hay dato, coloca valor 0 para mostrar "seleccione..."
    if (ruta=="") {
    	ruta=0;
    }
    //coloca tarifa a 0 si no hay costo aún
    if (total_msj=="") {
    	tarifa=0;
    }
    //muestra checkbox si es reasignación
    if (estado=='ASR') {
    	document.getElementById('devolucion_f').style.display='block';
    }else{
    	document.getElementById('devolucion_f').style.display='none';
    }
    //muestra datos en input formulario modal
    document.getElementById('no_guiaT').value=id;
    document.getElementById('ruta').value=ruta;
    document.getElementById('piloto').value=piloto;
    document.getElementById('tarifa').value=tarifa;
    document.getElementById('total_msj').value=total_msj;
    document.getElementById('estadoT').value=estado;
    document.getElementById('fecha_entregar').value=fecha_entregar;

})
//función que trae precio a mostrar en modal
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
//obtiene datos al cambiar tarifa
$(document).on("change", "#tarifa", function(){
tarifa=document.getElementById('tarifa').value;
show_price(tarifa)
})
</script>
@endsection