<table class="table">
	<thead class="thead-dark">
		<tr>

			<th>Documento</th>

			<th>Cuenta cliente</th>
			<th>Total</th>
			<th>usuario ingreso</th>
			<th>Fecha ingreso</th>
			<th><i class="fa fa-wrench" aria-hidden="true"></i></th>
		</tr>
	</thead>
	<tbody>
	@php
		$a=0;
	@endphp
	@forelse($pagos as $pago)
		<tr>
			

			<td><small><b> No.</b> {{$pago->no_documento}}<br> <b>Fecha:</b>{{date('d/m/Y', strtotime($pago->fecha_documento)) }}  </small></td>
			<td><small> <b>No.</b> {{$pago->no_cuenta}} <br> <b>Banco:</b> {{$pago->banco}}</small></td>
			<td>Q{{ number_format($pago->total,2)  }}</td>
			<td>{{$pago->username}}</td>
			<td>{{date('d/m/Y H:m', strtotime($pago->created_at))}}</td>

			<td>
				<button 
					class="btn btn-danger btn-sm" 
					title="Eliminar" 
					onclick="deletdetalle('{{$pago->id}}',{{$pago->total}})"  
					><i class="fa fa-trash"></i></button> 
				</td>	
		</tr>
		@php
			$a += $pago->total;
		@endphp
	@empty
	<div class="alert alert-danger" role="alert">
	  No existen pagos registrados para este envío!!!
	</div>

	@endforelse
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">Total</th>
			<th colspan="3">Q {{ number_format($a,2)  }} </th>
		</tr>
	</tfoot>
</table>