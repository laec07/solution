@extends('../layouts.app')

@section('content')

<div class="card">
	<div class="card-header">
		<h3>Asignación envíos </h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			
		
		<table class="table table-hover">
			  <thead>
			    <tr>
			      <th scope="col">No. Envio</th>
			      <th scope="col">Mensajero</th>
			      <th scope="col">Cliente</th>
			      <th scope="col">Fecha Recolección</th>
			      <th scope="col">Total</th>
			      <th scope="col">Items</th>
			      <th scope="col"><i class="fa fa-wrench"></i>  </th>
			    </tr>
			  </thead>
			  <tbody>

			  	@foreach($envios as $envio)
			    <tr>
			      <td> {{$envio->no_envio}} </td>
			      <td>
			      		{{$envio->user->name}}
			      </td>
			      <td>
   						{{$envio->clientes->nombre}}
			      </td>
			      <td> {{date('d/m/Y', strtotime($envio->created_at))}} </td>
			      <td>Q {{ number_format($envio->total_envio,2) }} </td>
			      <td>{{$envio->items}}  </td>
			      <td>
			      	<a class="btn btn-primary" href=" {{ route('enviosasignacion.edit',$envio->no_envio) }} " ><i class="fa fa-eye"></i> </a>
			      </td>
			    </tr>
			    @endforeach

			  </tbody>
			</table>
		</div>		
	</div>
</div>



<!-- Modal -->



@endsection

@section('scripts')
<script>


	function show_data(id) {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('enviosdetalles.show','id') }}",
		data:{id:id},
		beforeSend: function(){
              $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
              
            },
		success:function(data){
			$("#show_data").html(data);
		}
	})
}
</script>

@endsection


