@extends('../layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

@foreach($result_envio as $result )

<div class="card">
	<div class="card-header">
		<h4>Datos envío</h4>
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
			<div class="col">
				@include('envios.modaldetalle')
			</div>
		</div>
		
	</div>
	<div class="card-body">
		<div id="show_data"></div>
	</div>
	<div class="card-footer">
	<form action="{{route('envios.update', $result->no_envio)}}" method="POST">
		@method('PATCH')
		@csrf
	
		<button type="submit" class="btn btn-primary btn-block">Guardar</button>
	</form>
		<a href="{{url('envios')}}" class="btn btn-secondary btn-block">Cancelar</a>
	</div>
</div>
@endforeach

@endsection

@section('scripts')
<script>

function mayus(e) {
    e.value = e.value.toUpperCase();
}

function show_data() {
var id = document.getElementById('id_envio').value;
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('enviosdetalles.index') }}",
		data:{id:id},
		beforeSend: function(){
              $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
              
            },
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
		}
	})
}
show_data();

function limpiacamposinsert() {

	document.getElementById('destinatario').value='';
	document.getElementById('telefono').value='';
	//document.getElementById('piezas').value='';
	document.getElementById('total_paquete').value='';
	document.getElementById('direccion').value='';
	document.getElementById('observaciones').value ='';

	$('#total_error').hide("slow");
	$('#dirr_error').hide("slow");
	$('#tel_f').addClass("form-group")
	$('#dest_error').hide("slow");
}

  function saveItem() {
  	//obtiene variables
  	var id = document.getElementById('id_envio').value;
  	var destinatario = document.getElementById('destinatario').value;
  	var telefono = document.getElementById('telefono').value;
  	var direccion = document.getElementById('direccion').value;
  	//var piezas = document.getElementById('piezas').value;
  	var total_paquete = document.getElementById('total_paquete').value;
  	var fecha_entrega = document.getElementById('fecha_entrega').value;
  	var observaciones = document.getElementById('observaciones').value;
  	var user_id = document.getElementById('usuario_id').value;
  	//valida ingreso correcto de datos, validacion lado frontend
  	if (destinatario =='') {
  //si no se ingresa destinatario
    $('#dest_error').show("slow");
    $("#dest_error").text('Ingrese destinatario');
    $('#dest_f').removeClass("form-group")
    $('#dest_f').addClass("form-group has-warning")
    //elimina atributos en caso sesan agregados para volverlos a validar
    $('#tel_error').hide("slow");
    $('#tel_f').removeClass("form-group has-warning")
    $('#tel_f').addClass("form-group")
    //elimina atributos en caso sesan agregados para volverlos a validar
    $('#dirr_error').hide("slow");
    $('#dirr_f').removeClass("form-group has-warning")
    $('#dirr_f').addClass("form-group")
    //elimina atributos en caso sesan agregados para volverlos a validar
    $('#total_error').hide("slow");
    $('#total_f').removeClass("form-group has-warning")
    $('#total_f').addClass("form-group")
  	}else{
  		if (telefono =='') {
	  //si no se ingresa telefono
	    $('#tel_error').show("slow");
	    $("#tel_error").text('Ingrese telefono');
	    $('#tel_f').removeClass("form-group")
	    $('#tel_f').addClass("form-group has-warning")
	    //elimina atributos en caso sesan agregados para volverlos a validar
	    $('#dest_error').hide("slow");
	    $('#dest_f').removeClass("form-group has-warning")
	    $('#dest_f').addClass("form-group")
	    //elimina atributos en caso sesan agregados para volverlos a validar
	    $('#dirr_error').hide("slow");
	    $('#dirr_f').removeClass("form-group has-warning")
	    $('#dirr_f').addClass("form-group")
	    //elimina atributos en caso sesan agregados para volverlos a validar
	    $('#total_error').hide("slow");
	    $('#total_f').removeClass("form-group has-warning")
	    $('#total_f').addClass("form-group")
  		}else{
  			if (direccion =='') {
		  //si no se ingresa direccion
		    $('#dirr_error').show("slow");
		    $("#dirr_error").text('Ingrese direccion');
		    $('#dirr_f').removeClass("form-group")
		    $('#dirr_f').addClass("form-group has-warning")
		    //elimina atributos en caso sesan agregados para volverlos a validar
		    $('#dest_error').hide("slow");
		    $('#dest_f').removeClass("form-group has-warning")
		    $('#dest_f').addClass("form-group")
		    //elimina atributos en caso sesan agregados para volverlos a validar
		    $('#tel_error').hide("slow");
		    $('#tel_f').removeClass("form-group has-warning")
		    $('#tel_f').addClass("form-group")
		    //elimina atributos en caso sesan agregados para volverlos a validar
		    $('#total_error').hide("slow");
		    $('#total_f').removeClass("form-group has-warning")
		    $('#total_f').addClass("form-group")
		    }else{
		    	if (total_paquete=='') {
			  //si no se ingresa total_paquete
			    $('#total_error').show("slow");
			    $("#total_error").text('Ingrese total');
			    $('#total_f').removeClass("form-group")
			    $('#total_f').addClass("form-group has-warning")
			    //elimina atributos en caso sesan agregados para volverlos a validar
			    $('#dest_error').hide("slow");
			    $('#dest_f').removeClass("form-group has-warning")
			    $('#dest_f').addClass("form-group")
			    //elimina atributos en caso sesan agregados para volverlos a validar
			    $('#tel_error').hide("slow");
			    $('#tel_f').removeClass("form-group has-warning")
			    $('#tel_f').addClass("form-group")
			    //elimina atributos en caso sesan agregados para volverlos a validar
			    $('#dirr_error').hide("slow");
			    $('#dirr_f').removeClass("form-group has-warning")
			    $('#dirr_f').addClass("form-group")
		    	}else{
					$.ajax({
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						type:'POST',
						url:"{{ route('enviosdetalles.store') }}",
						data:{id:id,destinatario:destinatario,telefono:telefono,direccion:direccion,total_paquete:total_paquete,fecha_entrega:fecha_entrega,observaciones:observaciones,user_id:user_id},
						beforeSend: function(){
              				$("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
              
            			},
						success:function(data){
							show_data();
							limpiacamposinsert();
							$('#NuevoItem').modal('hide')
						}
					})//finaliza ajax
		    	}//finaliza total_paquete
		    }//finaliza direccion  			
  		}//finaliza telefono
  	}//finaliza destinatario
  }//finaliza funcion

//carga datos al modal de ingreso
$(document).on("click", "#btn_NuevoItem", function(){

    var user_id = $(this).data("user_id");

    document.getElementById('usuario_id').value=user_id;


})

function deletdetalle(id,total){
	var route = "{{url('enviosdetalles')}}/"+id+"";
	var id=id;
	var id_envio = document.getElementById('id_envio').value;
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'DELETE',
		url:route,
		data:{id:id,id_envio:id_envio,total_paquete:total},
		beforeSend: function(){
              $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
              
            },
		success:function(data) {
			show_data();
		}
	})
}

//carga datos al modal de fila seleccionada
$(document).on("click", "#btn_editEnv", function(){

    var no_guia = $(this).data("no_guia");
    var destinatario = $(this).data("destinatario");
    var telefono = $(this).data("telefono");
    var direccion = $(this).data("direccion");
    var total = $(this).data("total");
    var fecha = $(this).data("fecha");
    var observaciones = $(this).data("observaciones");
    var no_envio = $(this).data("no_envio");

    document.getElementById('no_guia_e').value=no_guia;
    document.getElementById('destinatario_e').value=destinatario;
    document.getElementById('telefono_e').value=telefono;
    document.getElementById('direccion_e').value=direccion;
    document.getElementById('total_paquete_e').value=total;
    document.getElementById('fecha_entrega_e').value=fecha;
    document.getElementById('observaciones_e').value=observaciones;
    document.getElementById('valor_b').value=total;
    document.getElementById('no_envio_e').value=no_envio;

})

function saveEdit() {

    var no_guia = document.getElementById('no_guia_e').value;
    var destinatario = document.getElementById('destinatario_e').value;
    var telefono = document.getElementById('telefono_e').value;
    var direccion = document.getElementById('direccion_e').value;
    var total = document.getElementById('total_paquete_e').value;
    var fecha = document.getElementById('fecha_entrega_e').value;
    var observaciones = document.getElementById('observaciones_e').value;
    var total_b = document.getElementById('valor_b').value;
    var no_envio = document.getElementById('no_envio_e').value;

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('enviosdetalles.update','id') }}",
		data:{no_guia:no_guia,destinatario:destinatario,telefono:telefono,direccion:direccion,total:total,fecha:fecha,observaciones:observaciones,total_b:total_b,no_envio:no_envio},
		beforeSend: function(){
              $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
              
            },
		success:function(data){
			show_data();
			$('#editEnv').modal('hide')

		}
	})//finaliza ajax
}

</script>
@endsection