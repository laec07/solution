<div class="card bg-gradient">
	<div class="card-header border-0"> 
		<h3 class="card-title">Guías pendientes de entrega</h3>
		<div class="card-tools">
			<div class="btn-group">
				<button type="button" class="btn btn-tool " data-card-widget="remove">
		            <i class="fas fa-times "></i>
		        </button>
			</div>
		</div>
	</div>
	<div class="card-body pt-0">
<div class="table-responsive">
			<table class="table  table-hover" >
				<thead class="table-primary">
					<tr>
						<th>Datos Guía</th>
						<th scope="col" >Total</th>
						<th scope="col" >Observaciones</th>
						<th scope="col" >Estado</th>
						
					</tr>
				</thead>
				@php
					$a=0;
					$p=0;

				@endphp
				
			@forelse($detalle_envio as $value)
				<tbody>
					<tr>
						<td> <b>No.</b> {{$value->no_guia}}<br>
							<small><b># Envío: </b></small>{{$value->no_envio}} <br>
							<small><b>Ddestinatario:</b>{{$value->destinatario}} </small><br>
							<small><b>Telefóno:</b> {{$value->telefono}}</small><br>
							<small><b>Dirección:</b> {{$value->direccion}}</small><br>
							<small><b>Fecha entregar</b> {{date('d/m/Y', strtotime($value->fecha_entregar))}}</small><br>
							<small><b>Mensajero:</b> {{$value->mensajero}}</small>

						</td>
						


						<td>Q{{ number_format($value->total_paquete,2) }}</td>



						@if($value->devolucion=='S')
						<td>{{$value->observaciones}} - DEVOLUCION A CLIENTE -</td>
						@else
						<td>{{$value->observaciones}}</td>
						@endif
						
						@if($value->estado=='3')
						<td><label class="badge badge-warning">{{$value->descripcion}}</label></td>
						@elseif($value->estado=='4')
						<td><label class="badge badge-success">{{$value->descripcion}}</label></td>
						@else
						<td><label class="badge badge-secondary">Sin definir</label></td>
						@endif



					</tr>
				</tbody>
				@php
				$a+=$value->total_paquete;
				@endphp

			@empty

			    	<div class="alert alert-danger" role="alert">
					  No tiene guías pendientes de entrega!!!
					</div>				
			@endforelse
				<tfoot class="table-primary">
					<tr>
						<th >Total:</th>
						<th colspan="5">Q {{ number_format($a,2)  }} </th>

					</tr>
				</tfoot>

			</table>

		</div>
	<!-- ./ card body -->	
	</div>

</div>

