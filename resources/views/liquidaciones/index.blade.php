@extends('../layouts.app')

@section('content')

@include('liquidaciones.modalInsertPay')
@include('liquidacionescierre.modalHistory')

<div class="card card-primary">
	<div class="card-header">
		<h3>Liquidación por envíos </h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">		
		<table class="table table-hover">
			  <thead>
			    <tr>
			      <th scope="col">No. Envio</th>

			      <th scope="col">Cliente</th>
			      <th scope="col">Total Envío</th>
			      <th scope="col">Total Mensajería</th>
			      <th scope="col">Total Liquidar</th>
			      <th scope="col">Liquidado</th>
			      <th scope="col">Pendiente liquidar</th>
			      <th scope="col">Guias</th>
			      <th scope="col">Guias liquidadas</th>
			      <th scope="col">Guias pendientes</th>
			      <th scope="col"><i class="fa fa-wrench"></i>  </th>
			    </tr>
			  </thead>
			  <tbody>
			  	@forelse($envios as $envio)
			    <tr>
			      <td> {{$envio->no_envio}} <br>
			      	<small>
			      		<b>Recolección:</b> <br>
			      		{{date('d/m/Y H:m', strtotime($envio->created_at))}}
			      	</small> <b></b>
			      </td>

			      <td>
   						{{$envio->cliente}}
			      </td>

			      <td>Q{{ number_format($envio->total_envio,2) }} </td>
			      <td>Q{{ number_format($envio->total_msj,2) }} </td>
			      <td>Q{{ number_format($envio->total_liquidar,2) }} </td>
			      <td>Q{{ number_format($envio->total_general,2) }}</td>
			      @if($envio->total_liquidar >0 && ($envio->total_liquidar - $envio->total_general) > 0 )
			      <td> <label class="badge badge-danger" > Q{{ number_format($envio->total_liquidar - $envio->total_general,2) }}</label></td>
			      @elseif($envio->total_liquidar >0 && ($envio->total_liquidar - $envio->total_general) < 0 )
			      <td> <label class="badge badge-danger" > Q{{ number_format($envio->total_liquidar - $envio->total_general,2) }}</label></td>
			      @elseif($envio->total_liquidar >0 == $envio->total_general)
			      <td> <label class="badge badge-success" > Q{{ number_format($envio->total_liquidar - $envio->total_general,2) }}</label></td>
			      @else
			      <td> <label > ---</label></td>
			      @endif
			      
			      <td>{{$envio->item}}</td>
			      <td>{{$envio->item_liquidado}}</td>
			      @if($envio->item-$envio->item_liquidado > 0)
			      <td><label class="badge badge-danger"> {{$envio->item-$envio->item_liquidado}}</label>  </td>
			      @else
			      <td><label class="badge badge-success">  {{$envio->item-$envio->item_liquidado}}</label>  </td>
			      @endif
			      <td>
			      	<!--Boton para mostrar detalle guias-->
			      	<a 
			      		class="btn btn-primary btn-sm" 
			      		title="Detalle envíos" 
			      		href=" {{ route('liquidaciones.edit',$envio->no_envio) }} " 
			      	>
			      		<i class="fa fa-eye"></i> 
			      	</a>
			      	<!--Boton para mostrar formulario para ingreso de pago-->
			      	<button 
			      		class="btn btn-warning btn-sm" 
			      		data-toggle='modal' 
			      		data-target='#InsertPay' 
			      		id="btn_isertPay"
			      		data-no_envio='{{$envio->no_envio}}'
			      		data-id_cliente='{{$envio->id_cliente}}'
			      		data-cliente='{{$envio->cliente}}'
			      		data-total_liquidar='{{$envio->total_liquidar - $envio->total_general}}'
			      		title="Ingreso de pagos" 
			      	>
			      		<i class="fa fa-money-bill-alt"></i> 
			      	</button>

			      	<!--Boton para mostrar historial de pago-->
			      	<button 
			      		class="btn btn-secondary btn-sm " 
			      		data-toggle='modal' 
			      		data-target='#HistoryPay' 
			      		title="Historial de pagos"
			      		id="btn_history" 
			      		data-no_envio="{{$envio->no_envio}}" 
			      	><i class="fa fa-history"></i> 
			      	</button>
			      	<!--Boton para mostrar historial de pago-->
			      	@if($envio->total_liquidar >0 && $envio->total_liquidar  == $envio->total_general && ($envio->item-$envio->item_liquidado) == 0)
			      	<button 
			      		class="btn btn-success btn-sm " 
			      		title="Cierre de envios"
			      		onclick="CierreEnvios({{$envio->no_envio}})" 
			      		>
			      		<i class="fa fa-save"></i> 
			      	</button>
			      	@else
			      	<button 
			      		class="btn btn-success btn-sm " 
			      		title="Pendiente de liquidaciones"  
			      		disabled>
			      		<i class="fa fa-save"></i> 
			      	</button>
			      	@endif
			      	




			      </td>
			    </tr>
			    @empty
			    	<div class="alert alert-success" role="alert">
					  No existen Envíos pendientes de liquidar!!!
					</div>
			    @endforelse

			  </tbody>
			</table>
		</div>		
	</div>
</div>

@endsection

@section('scripts')
<script>

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

function saveItem() {
	var no_envio_p = document.getElementById('no_envio_p').value;

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
				data:{no_envio_p:no_envio_p,total_liquidar_p:total_liquidar_p,total_pago:total_pago,tipo_pago:tipo_pago,cuenta_cliente:cuenta_cliente,no_documento:no_documento,fecha_documento:fecha_documento,observaciones:observaciones},
				success:function(data){

					location.reload();
				}
			})	
			}	
		}
	}
}

function limpiacamposinsert() {

	document.getElementById('total_pago').value='0';
	document.getElementById('no_documento').value='';

			    $('#total_lerror').hide("slow");
			    $('#totalP_error').hide("slow");
			    $('#nodoc_error').hide("slow");
}

/////////////Cierre liquidaciones ///////////
//función que trae historial de pagos
function HistoryPay() {
	var no_enviof = document.getElementById('no_envio_h').value;

		$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('liquidacionescierre.show','id') }}",
		data:{no_envio:no_enviof},
		success:function(data){
			$("#dataHistory").html(data);
		}
	})
	
}

//trae datos para modal historial de pago
$(document).on("click", "#btn_history", function(){

	//obtiene dataset
    var no_envio = $(this).data("no_envio");

    //carga datos a DOM
    document.getElementById('no_envio_h').value=no_envio;

 	//Muestra info DOM   
    $("#info_envioh").text(no_envio);

    HistoryPay()

})


function deletdetalle(id,total) {

	var id=id;
	var no_envio = document.getElementById('no_envio_h').value;

				$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				type:'DELETE',
				url:"{{ route('liquidacionescierre.destroy','id') }}",
				data:{id:id,no_envio:no_envio,total:total},
				success:function(data){

					location.reload();
				}
			})	
			
}

function CierreEnvios(no_envio) {
Swal
    .fire({
        title: "Envío #"+no_envio,
        text: "¿Desea continuar con cierre de Envío?",
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
				data:{no_envio:no_envio},
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


</script>
@endsection



