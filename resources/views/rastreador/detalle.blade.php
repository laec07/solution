<div class="card bg-gradient">
	<div class="card-header border-0"> 
		<h3 class="card-title"></h3>
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
						<th>Resumen</th>
					</tr>
				</thead>
				@php
					$a=0;
					$p=0;
				@endphp				
			@forelse($detalle_envio as $value)
				<tbody>
					<tr>
						<td>
							<h3> 
							<b>No. guía</b> {{$value->no_guia}} ||
							<b># Envío: </b> {{$value->no_envio}}  ||
							<b>Destinatario:</b> {{$value->destinatario}} || 
							<b>Cliente:</b> {{$value->cliente}}
							</h3><br>
							<b>Telefóno:</b> {{$value->telefono}} ||
							<b>Dirección:</b> {{$value->direccion}} ||
							<b>Fecha entregar</b> {{date('d/m/Y', strtotime($value->fecha_entregar))}} ||
							<b>Mensajero:</b> {{$value->mensajero}} || 
							<b>Total:</b> Q{{ number_format($value->total_paquete,2) }} || 
							<b>Observaciones: </b>
							@if($value->devolucion=='S')
							 {{$value->observaciones}} - DEVOLUCION A CLIENTE ||
							@elseif($value->observaciones=='')
							Ninguno
							@else
							 {{$value->observaciones}} 
							@endif
							||
							<b>Estado:</b> {{$value->descripcion}}
						</td>
					</tr>
				</tbody>
			@empty
			    	<div class="alert alert-danger" role="alert">
					  No se encontro registro!!
					</div>				
			@endforelse
			</table>
		</div>
	<!-- ./ card body -->	
	</div>
</div>

<div class="card" >
	<div class="card-header">
		<h3>Movimientos de Guía</h3>
	</div>
	<div class="card-body">
		<table class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>Movimiento</th>
					<th>usuario</th>
					<th>Observaciones</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				@forelse($guia_movimientos as $mov)
				<tr>
					<td>{{$mov->descripcion}}</td>
					<td>{{$mov->username}}</td>
					<td>{{$mov->observaciones}}</td>
					<td>{{date('d/m/Y H:m:s', strtotime($mov->created_at))}}</td>
				</tr>
				@empty
				<div class="alert alert-info">No tiene moviminetos!!!</div>
				@endforelse
			</tbody>
		</table>
	</div>
</div>