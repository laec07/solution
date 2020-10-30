@extends('../layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
@foreach($result_envio as $result )

<div class="card card-primary">
	<div class="card-header">
		<h4>Guias Liquidación</h4>
		<div class="row">
			<div class="col">
				<p> <b>No. Envio</b> <input type="hidden" name="id_envio" id="id_envio" value="{{$result->no_envio}}"> {{$result->no_envio}}
				<br>
				<b> Cliente:</b>
					{{$result->clientes->nombre}}
				</p>
			</div>

		</div>
		
	</div>
	<div class="card-body">
		<div id="show_data"></div>
	</div>
	<div class="card-footer">

		<div id="button_g" style="padding: 4px;" ></div>
		

		<a href="{{url('liquidaciones')}}" class="btn btn-secondary btn-block"><i class="fa fa-undo"></i> Regresar   </a>
	</div>
</div>

@endforeach

@endsection

@section('scripts')
<script>

function show_data() {
var id = document.getElementById('id_envio').value;
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('liquidaciones.show','id') }}",
		data:{id:id},
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
		}
	})
}
show_data();

//Edita total a pagar
function edit_total() {
	var id = document.getElementById('no_guia_e').value
	var total = document.getElementById('total_paquete_e').value
	var total_b = document.getElementById('total_b').value
	var no_envio = document.getElementById('no_envio_e').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('liquidaciones.update','id') }}",
		data:{id:id,total:total,total_b:total_b,no_envio:no_envio},
		success:function(data){
			show_data();
		}		
	})

}

//trae datos para modal edición de precio y carga en modal
$(document).on("click", "#bt_EdPrice", function(){

    var id = $(this).data("no_guia");
    var total = $(this).data("total");
    var no_envio = $(this).data("no_envio");

    document.getElementById('no_guia_e').value=id;
    document.getElementById('total_paquete_e').value=total;
    document.getElementById('total_b').value=total;
    document.getElementById('no_envio_e').value=no_envio;

})

//Guardar liquidacion
function save_liq() {
	var id = document.getElementById('no_guia_l').value

	var total_msj = document.getElementById('total_msj').value
	var tp_msj = document.getElementById('tp_msj').value
	var total_liquidar = document.getElementById('total_liquidar').value		

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'POST',
		url:"{{ route('liquidaciones.store','id') }}",
		data:{id:id,total_msj:total_msj,total_liquidar:total_liquidar,tp_msj:tp_msj},
		success:function(data){
			show_data();
		}		
	})

}
//trae datos para liquidación y muestra en modal
$(document).on("click", "#modalLiq", function(){

	var no_guia_l = $(this).data("no_guia_l");
	var totalP_l = $(this).data("total_l");
	var tp_msj = $(this).data("tp_msj");
	var total_msj = $(this).data("total_msj");
	var total_liq = totalP_l - total_msj;

	if (tp_msj=="") {
		tp_msj="1";
	}

	document.getElementById('totalP_l').value=totalP_l
	document.getElementById('no_guia_l').value=no_guia_l;
	document.getElementById('tp_msj').value=tp_msj;
	document.getElementById('total_msj').value=total_msj;
	document.getElementById('total_liquidar').value=total_liq;

	$("#no_guia_t").text(no_guia_l);
})

function calc_liq() {
	var totalP_l = document.getElementById('totalP_l').value;
	var total_msj = document.getElementById('total_msj').value;

	var t_liq = totalP_l - total_msj;

	document.getElementById('total_liquidar').value=t_liq;
}



</script>
@endsection