@extends('../layouts.app')

@section('content')

<div class="card card-primary">

	<div class="card-header">
		<h4>Liquidaciones por mensajero</h4>

	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<label>Mensajero</label>
				<select class="form-control" id="user_id" >
					<option>Seleccione mensajero:</option>
					@foreach($users as $user)
					<option value="{{$user->id}}">{{$user->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3">
				<label></label>
				<button class="btn btn-primary btn-block" onclick="show_data()" >Buscar: <i class="fa fa-search"> </i> </button>
			</div>
		</div>		
	</div>

	<div id="show_data"></div>

		
</div>


@endsection

@section('scripts')


<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}" defer ></script>


<script>

function show_data() {
var id = document.getElementById('user_id').value;
	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('liquidacionespiloto.show','id') }}",
		data:{id:id},
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
			m_total();
		}
	})
}

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

function m_total() {
	var a = document.getElementById('total_m').value;
	var b = document.getElementById('item_m').value;



	$("#m_total").text(a);
	$("#m_item").text(b);

}

function Guardapiloto() {

var user_id = document.getElementById('user_id').value
var total = document.getElementById('m_total').text
var pending = document.getElementById('pending').value

if (pending > 0) 
{
			Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'No puede liquidar con '+ pending +' guias pendientes de entrega, verifique!!',
			})
}
else{

	Swal
	    .fire({
	        title: "Confirmar",
	        text: "¿Desea guardar liquidación mensajero?",
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
					url:"{{ route('liquidacionespiloto.update','id') }}",
					data:{user_id:user_id},
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
}//fin if


</script>
@endsection