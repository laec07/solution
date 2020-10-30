@extends('../layouts.app')

@section('content')

<div class="card card-primary">
	<div class="card-header">
		<h3>Liquidación por clientes</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-4">
				<label>Cliente</label>
				<select class="form-control" id="id_cliente" >
					<option>Seleccione cliente</option>
					@foreach($clientes as $cliente)
					<option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-4">
				<label>Ruta:</label>
				<select class="form-control" id="id_ruta">
					<option value="TODOS">TODOS</option>
					@foreach($rutas as $ruta)
					<option value="{{$ruta->id}}">{{$ruta->descripcion}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3">
				<label></label>
				<button class="btn btn-primary btn-block" onclick="show_data()" title="Buscar" ><i class="fa fa-search"></i>   </button>
			</div>
		</div>		
	</div>

	<div id="show_data"></div>

</div>


@endsection

@section('scripts')
<script>

function show_data() {
var id = document.getElementById('id_cliente').value;
var id_ruta = document.getElementById('id_ruta').value;
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('liquidacionclientes.show','id') }}",
		data:{id:id,id_ruta:id_ruta},
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
			muestra_totales()
			validabutton()

		}
	})



}

//Edita total a pagar
function edit_total() {
	var id = document.getElementById('no_guia_e').value
	var id_ruta = document.getElementById('id_ruta').value;
	var total = document.getElementById('total_paquete_e').value
	var total_b = document.getElementById('total_b').value
	var no_envio = document.getElementById('no_envio_e').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('liquidaciones.update','id') }}",
		data:{id:id,total:total,total_b:total_b,no_envio:no_envio,id_ruta:id_ruta},
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
	var id_ruta = document.getElementById('id_ruta').value;
	var total_msj = document.getElementById('total_msj').value
	var tp_msj = document.getElementById('tp_msj').value
	var total_liquidar = document.getElementById('total_liquidar').value		

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'POST',
		url:"{{ route('liquidaciones.store','id') }}",
		data:{id:id,total_msj:total_msj,total_liquidar:total_liquidar,tp_msj:tp_msj,id_ruta:id_ruta},
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

function calc_liq_general() {
	var user_id = document.getElementById('id_cliente').value
	var id_ruta = document.getElementById('id_ruta').value;



		$.ajax({
		headers: { 'X-CSRF-TOKEN': $	('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('liquidacionclientes.update','id') }}",
		data:{user_id:user_id,id_ruta:id_ruta},
		success:function(data){
			show_data();
		}		
	})
}
// carga resultados en encabezado tabla
function muestra_totales() {
	var total_mg = document.getElementById('total_mg').value;
	var total_ms = document.getElementById('total_ms').value;
	var total_mL = document.getElementById('total_mL').value; 

	$("#m_totalg").text(total_mg);
	$("#m_totalm").text(total_ms);
	$("#m_totalL").text(total_mL);

}

// Guarda liquidación
function save_liq_general() {

	var id_cliente = document.getElementById('id_cliente').value
	var total_mg = document.getElementById('total_mgBD').value;
	var total_ms = document.getElementById('total_msBD').value;
	var total_mL = document.getElementById('total_mLBD').value;
	var id_ruta = document.getElementById('id_ruta').value;

Swal
    .fire({
        title: "Confirmar",
        text: "¿Desea guardar liquidación? \nEsta acción no podrá ser modificada",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Guardar",
        cancelButtonText: "Cancelar",
    })
    .then(resultado => {
        if (resultado.value) {
            // Hicieron click en "Sí"

		$.ajax({
			headers: { 'X-CSRF-TOKEN': $	('meta[name="csrf-token"]').attr('content') },
			type:'POST',
			url:"{{ route('liquidacionclientes.store','id') }}",
			data:{id_cliente:id_cliente,total_mg:total_mg,total_ms:total_ms,total_mL:total_mL,id_ruta:id_ruta},
			success:function(data){
				location.reload();
			}		
		})
        } else {
            // Dijeron que no
            console.log("*NO se realiza cierre*");
        }
	});
}

//validación de botonoes
function validabutton() {
	var a = document.getElementById('valida_datos').value

	if (a==0) {
		document.getElementById('btn_calcLiq').disabled=true;
		document.getElementById('btn_saveLiq').disabled=true;
	}else{
		document.getElementById('btn_calcLiq').disabled=false;
		document.getElementById('btn_saveLiq').disabled=false;
	}
}
</script>
@endsection