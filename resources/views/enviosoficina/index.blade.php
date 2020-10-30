@extends('../layouts.app')

@section('content')

<div class="card card-primary">
	<div class="card-header">
		<h3>Listado de envíos</h3>
	</div>
	<div style="padding: 10px;">
		@include('enviosoficina.modal')
	</div>
	
	<div class="card-body">
		<div class="table-responsive">
			
		
		<table class="table table-hover">
			  <thead>
			    <tr>
			      <th scope="col">Datos envío</th>
			      <th scope="col">Total</th>
			      <th scope="col">Items</th>
			      <th scope="col"><i class="fa fa-wrench"></i>  </th>
			    </tr>
			  </thead>
			  <tbody>

			  	@forelse($envios as $envio)


			    <tr>
			      <td> <b># {{$envio->no_envio}}</b> <br>
			      	<small>
			      		<b>Cliente: </b>
							@foreach($clientes as $cliente)
					        	@if($envio->id_cliente == $cliente->id)
					        	{{$cliente->nombre}}
					        	@endif 
					      	@endforeach 
			      	</small><br>
			      	<small>
			      		<b>Mensajero: </b>
							@foreach($mensajeros as $mensajero)
					        	@if($envio->user_id == $mensajero->id)
					        	{{$mensajero->name}}
					        	@endif 
					      	@endforeach 
			      	</small><br>
			      	<small>
			      		<b>Fecha envío:</b>
			      		{{date('d/m/Y', strtotime($envio->created_at))}}
			      	</small>
			      </td>

			      <td>Q {{ number_format($envio->total_envio,2) }} </td>
			      <td>{{$envio->items}}  </td>
			      <td>
			      	<button class="btn btn-primary" data-toggle="modal"   data-target="#ShowDetalle"  onclick="show_data({{$envio->no_envio}})" ><i class="fa fa-eye"></i> </button>
			      	<a class="btn btn-warning" href=" {{ route('enviosoficina.edit',$envio->no_envio) }} " ><i class="fa fa-edit"></i> </a>
					<a  class="btn btn-danger" href=" {{ url('/envios/'.$envio->no_envio.'/estado') }} " onclick="return confirm('¿Desea continuar eliminando envio?') " ><i class="fa fa-trash" aria-hidden="true"></i></a>
			      </td>
			    </tr>
			   	@empty
			    	<div class="alert alert-danger" role="alert">
					  No existen Envíos !!!
					</div>
			    @endforelse

			  </tbody>
			</table>
		</div>		
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="ShowDetalle" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Detalle envio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      	<div id="show_data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>




	function show_data(id) {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('enviosdetalles.show','id') }}",
		data:{id:id},
		success:function(data){
			$("#show_data").html(data);
		}
	})
}

function foco() {
	$('#btn_primary').focus();
}

foco();



</script>

@endsection