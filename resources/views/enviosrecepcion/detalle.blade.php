		
		<div class="table-responsive">
			<table class="table  table-hover" id="example3" >
				<thead class="table-primary">
					<tr>
						<th>Envío</th>
						<th>No. Guia</th>
						<th>Cliente</th>
						<th>Mensajero</th>
						<th scope="col" >Destinatario</th>
						<th scope="col" >Telefóno</th>
						<th scope="col" >Dirección</th>

						<th scope="col" >Total</th>
						<th scope="col" >Fecha entrega</th>
						<th scope="col" >Observaciones</th>
						<th scope="col" ><i class="fa fa-wrench" aria-hidden="true"></i></th>
					</tr>
				</thead>
				@php
					$a=0;
					$p=0;
				@endphp
				<tbody>
			@forelse($detalle_envio as $value)
				
					<tr>
						<td>{{$value->no_envio}}</td>
						<td>{{$value->no_guia}}</td>
						<td>{{$value->cliente}}</td>
						<td>{{$value->name}}</td>
						<td>{{$value->destinatario}}</td>
						<td>{{$value->telefono}}</td>
						<td>{{$value->direccion}}</td>

						<td>Q{{ number_format($value->total_paquete,2) }}</td>
						<td>{{date('d/m/Y', strtotime($value->fecha_entregar))}}</td>
						<td>{{$value->observaciones}}</td>
						<td>
							@if($value->estado == '1' )
							<a class="btn btn-success" onclick="receiver('{{$value->no_guia}}','2','{{$value->no_envio}}')"><i class="fa fa-check"  ></i> </a>

							@else
							<button class="btn btn-success" onclick="receiver('{{$value->no_guia}}','1')"><i class="fa fa-times"  ></i> </button>							
							@endif

						</td>
					</tr>
				
				@php
					$a+=$value->total_paquete;

						$p+=1;


				@endphp

			@empty
			<div class="alert alert-success">No tiene guías pendientes de recepción</div>
			@endforelse
			</tbody>
				<tfoot class="table-primary">
					<tr>
						<th colspan="7">Total:</th>
						<th colspan="4">Q {{ number_format($a,2)  }} </th>

					</tr>
				</tfoot>

			</table>
			<input type="hidden" name="vbutton" id="vbutton" value={{$p}} >
		</div>



<script>
	//
  $(function () {
    $("#example1").DataTable({
      "responsive": false,
      "autoWidth": false,
    });
    $('#example3').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
    });
  });
</script>