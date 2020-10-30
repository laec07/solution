@extends('../layouts.app')

@section('content')

@include('entregas.modal')

<div class="card card-primary">
	<div class="card-header">
		<h3>Guias a entregar <small> <span class="badge badge-light" id="notify"></span></small></h3>
	</div>
	<div class="card-body">
		<div id="show_datas" ></div>
	</div>
</div>

@endsection

@section('scripts')
<script>

function show_alert() {
	a = document.getElementById('vbutton').value

	$("#notify").text(a);
}

function show_data() {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('entregas.show','id') }}",
		data:{},
		success:function(data){
			$("#show_datas").html(data);
			muestra_totales();
			show_alert()

		}
	})
}
show_data();

function receiver(id,estado) {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('entregas.update','id') }}",
		data:{id:id,estado:estado},
		success:function(data){

			show_data();
		}
	})
}

function limpiacamposinsert() {

	document.getElementById('estado').value='5';
	document.getElementById('recibe').value='';

	document.getElementById('tipo_pago').value='1';

	document.getElementById('observaciones').value ='';

	$('#recib_error').hide("slow");
	$('#obs_error').hide("slow");

}

function saveItem() {
	var id = document.getElementById('no_guia_e').value;
	var estado = document.getElementById('estado').value;
	var recibe = document.getElementById('recibe').value;
	var tipo_pago = document.getElementById('tipo_pago').value;
	var observaciones = document.getElementById('observaciones').value;
	var dev = document.getElementById('dev_e').value;

	if (estado==5 && recibe=='') {
	$('#recib_error').show("slow");
    $("#recib_error").text('Ingrese nombre quien recibe');
    $('#recib_f').removeClass("form-group")
    $('#recib_f').addClass("form-group has-warning")
	}else{
		if (estado>5  && observaciones =='') {
		$('#obs_error').show("slow");
	    $("#obs_error").text('Justifique estado');
	    $('#obs_f').removeClass("form-group")
	    $('#obs_f').addClass("form-group has-warning")
				
		}else{
			if (tipo_pago>1 && observaciones ==''  ) {
			$('#obs_error').show("slow");
		    $("#obs_error").text('Justifique tipo de pago');
		    $('#obs_f').removeClass("form-group")
		    $('#obs_f').addClass("form-group has-warning")

		    $('#recib_error').hide("slow");
		    $('#recib_f').addClass("form-group")
		    $('#recib_f').removeClass("form-group has-warning")
			}else{
				if (dev == 'S' && estado!='12' ) {
					$('#estado_error').show("slow");
		    		$("#estado_error").text('Guia tiene estade de devolucion, seleccione opción correcta!!!');
				}else{
					$.ajax({
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						type:'POST',
						url:"{{ route('entregas.store') }}",
						data:{id:id,estado:estado,recibe:recibe,tipo_pago:tipo_pago,observaciones:observaciones},
						success:function(data){
							$('#SaveShipping').modal('hide')
							show_data();
							
						}
					})//finaliza ajax					
				}

			}
		}
	}
}

	//muestra/oculta opciones segun tipo de pago
  function tipo_es(){
    var lista = document.getElementById('estado')
    var opcion = lista.options[lista.selectedIndex].value;

    if (opcion != '5') {
      document.getElementById('recib_f').style.display='none';
      document.getElementById('t_pago').style.display='none';
    }else{
      document.getElementById('recib_f').style.display='block';
     document.getElementById('t_pago').style.display='block'; 
    }
  }

//carga datos al modal de fila seleccionada
$(document).on("click", "#bt_save", function(){
	limpiacamposinsert();

    var lista = document.getElementById('estado')
    var opcion = lista.options[lista.selectedIndex].value;


    if (opcion != '5') {
      document.getElementById('recib_f').style.display='none';
      document.getElementById('t_pago').style.display='none';
    }else{
      document.getElementById('recib_f').style.display='block';
     document.getElementById('t_pago').style.display='block'; 
    }

    var id = $(this).data("no_guia_e");
    var dev = $(this).data("devolucion");
    //carga estado devolucion en caso lo sea

    if (dev=='S') {
	document.getElementById('estado').value='12';
    }

    document.getElementById('no_guia_e').value=id;
    document.getElementById('dev_e').value=dev;

    $("#txt_no_guia").text(id);  

})

// carga resultados en encabezado tabla
function muestra_totales() {
	var total_efect = document.getElementById('total_efect').value;


	$("#e_total").text(total_efect);


}
</script>
@endsection