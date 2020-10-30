@extends('../layouts.app')

@section('content')

@include('depositos.modalInsertPay')
@include('depositos.modalHistory')

<div class="car card-primary">
	<div class="card-header">
		<h2>Liquidaciones pendientes de depósitos</h2>
	</div>
	<div class="card-body">
		<div id="show_data"></div>
	</div>
</div>

@endsection

@section('scripts')
<script>

//Muestra información
function show_data() {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('depositos.edit','id') }}",
		data:{},
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
			
		}
	})
}
show_data();

//trae datos para modal edición de precio y carga en modal
$(document).on("click", "#btn_isertPay", function(){
	limpiacamposinsert()
	//obtiene dataset
    var no_envio = $(this).data("no_envio");
    var id_cliente = $(this).data("id_cliente");
    var cliente = $(this).data("cliente");
    var total_liquidar = $(this).data("total_liquidar");

    if (total_liquidar =='') {
    	total_liquidar=0;
    }
    //carga datos a DOM
    document.getElementById('no_envio_p').value=no_envio;
    document.getElementById('id_cliente_p').value=id_cliente;
    document.getElementById('total_liquidar_p').value=total_liquidar;
    document.getElementById('total_saldo').value=total_liquidar;
 	//Muestra info DOM   
    $("#info_envio").text(no_envio);
    $("#info_cliente").text(cliente);
    //ejecuta función cuenta de cliente
    show_cuenta(id_cliente)

})
//calcula saldo
function calcsaldo() {
	var total_liquidar = document.getElementById('total_liquidar_p').value
	var total_pago = document.getElementById('total_pago').value

	var a = document.getElementById('total_saldo').value=total_liquidar-total_pago

	if (a < 0) {
		$('#total_lerror').show("slow");
	    $("#total_lerror").text('Total pago no puede ser mayor a Total a liquidar');
	    $('#total_l').removeClass("form-group")
	    $('#total_l').addClass("form-group has-warning")		
	}else{
		$('#total_lerror').hide("slow");
	    $('#total_l').addClass("form-group")
	    $('#total_l').removeClass("form-group has-warning")		
	}

}

//función que trae cuenta de cliente
function show_cuenta(id) {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('liquidaciones.create','id') }}",
		data:{id:id},
		success:function(data){
			//alert('Nitido');
			$("#show_cuenta").html(data);
		}
	})
}
//obtiene datos al cambiar tipo_cuenta
$(document).on("change", "#tarifa", function(){
tarifa=document.getElementById('tarifa').value;
show_cuenta(tarifa)
})

function val_tpago() {
    var lista = document.getElementById('tipo_pago')
    var opcion = lista.options[lista.selectedIndex].value;

    if (opcion == '1' || opcion == '4' ) {
      document.getElementById('bancario').style.display='none';

    }else{
      document.getElementById('bancario').style.display='block';

    }	
}

function limpiacamposinsert() {

	document.getElementById('total_pago').value='0';
	document.getElementById('no_documento').value='';

			    $('#total_lerror').hide("slow");
			    $('#totalP_error').hide("slow");
			    $('#nodoc_error').hide("slow");
}

//Guarda
function saveItem() {
	var no_liq_p = document.getElementById('no_envio_p').value;

	var total_liquidar_p = document.getElementById('total_liquidar_p').value;
	var total_pago = document.getElementById('total_pago').value;
	var tipo_pago = document.getElementById('tipo_pago').value;
	var cuenta_cliente = document.getElementById('cuenta_cliente').value;
	var no_documento = document.getElementById('no_documento').value;
	var fecha_documento = document.getElementById('fecha_documento').value;
	var observaciones = document.getElementById('observaciones').value;

	if (total_liquidar_p <= 0) {
		$('#total_lerror').show("slow");
	    $("#total_lerror").text('No puede liquidar saldos a 0, verifique!!');
	    $('#total_l').removeClass("form-group")
	    $('#total_l').addClass("form-group has-warning")
	}else{
		if (total_pago==0 || total_pago=="") {
			$('#totalP_error').show("slow");
		    $("#totalP_error").text('Monto no valido');
		    $('#total_l').removeClass("form-group")
		    $('#total_l').addClass("form-group has-warning")
		    $('#total_lerror').hide("slow");			
		}else{
			if (no_documento=="") {
				$('#nodoc_error').show("slow");
			    $("#nodoc_error").text('Ingrese número de documento');
			    $('#total_lerror').hide("slow");
			    $('#totalP_error').hide("slow");				
			}else{

			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'DELETE',
				url:"{{ route('liquidaciones.destroy','id') }}",
				data:{no_liq_p:no_liq_p,total_liquidar_p:total_liquidar_p,total_pago:total_pago,tipo_pago:tipo_pago,cuenta_cliente:cuenta_cliente,no_documento:no_documento,fecha_documento:fecha_documento,observaciones:observaciones},
				success:function(data){

					show_data();
					$('#InsertPay').modal('hide')

					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000,
					  timerProgressBar: true,
					  didOpen: (toast) => {
					    toast.addEventListener('mouseenter', Swal.stopTimer)
					    toast.addEventListener('mouseleave', Swal.resumeTimer)
					  }
					})

					Toast.fire({
					  icon: 'success',
					  title: 'Depósito ingresado correctamente'
					})
	///////////////////////////
				}
			})	
			}	
		}
	}
}

//función que trae historial de pagos
function HistoryPay() {
	var no_liquidacion = document.getElementById('no_liq_h').value;

		$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('liquidacionescierre.show','id') }}",
		data:{no_liquidacion:no_liquidacion},
		success:function(data){
			$("#dataHistory").html(data);

		}
	})
	
}
//trae datos para modal historial de pago
$(document).on("click", "#btn_history", function(){

	//obtiene dataset
    var no_liq = $(this).data("no_liq");

    //carga datos a DOM
    document.getElementById('no_liq_h').value=no_liq;

 	//Muestra info DOM   
    $("#info_envioh").text(no_liq);

    HistoryPay()

})
//Función para cierre de liquidacion.
function CierreEnvios(id_liquidacion) {
Swal
    .fire({
        title: "Liquidación #"+id_liquidacion,
        text: "¿Desea continuar con cierre de Liquidación?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Guardar",
        cancelButtonText: "Cancelar",
    })
    .then(resultado => {
        if (resultado.value) {
            // Hicieron click en "Sí"
				$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'PUT',
				url:"{{ route('liquidacionescierre.update','id') }}",
				data:{id_liquidacion:id_liquidacion},
				success:function(data){


					show_data();
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000,
					  timerProgressBar: true,
					  didOpen: (toast) => {
					    toast.addEventListener('mouseenter', Swal.stopTimer)
					    toast.addEventListener('mouseleave', Swal.resumeTimer)
					  }
					})

					Toast.fire({
					  icon: 'success',
					  title: 'Cierre realizado correctamente'
					})
	///////////////////////////
					
				}
			})
        } else {
            // Dijeron que no
            console.log("*NO se realiza cierre*");
        }
    });
}
//elimina depósito
function deletdetalle(id,total) {

	var id=id;
	var no_liq_h = document.getElementById('no_liq_h').value;

				$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'DELETE',
				url:"{{ route('liquidacionescierre.destroy','id') }}",
				data:{id:id,no_liq_h:no_liq_h,total:total},
				success:function(data){

					show_data();
					$('#HistoryPay').modal('hide');
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000,
					  timerProgressBar: true,
					  didOpen: (toast) => {
					    toast.addEventListener('mouseenter', Swal.stopTimer)
					    toast.addEventListener('mouseleave', Swal.resumeTimer)
					  }
					})

					Toast.fire({
					  icon: 'warning',
					  title: 'Eliminado correctamente'
					})
				}
			})	
			
}
</script>
@endsection