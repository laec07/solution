

		<div class="table-responsive">
			<table class="table  table-hover" >
				<thead class="table-primary">
					<tr>
						<th>Datos Guía</th>
						


						<th scope="col" >Total</th>
						
						<th scope="col" >Observaciones</th>

					</tr>
				</thead>
				@php
					$a=0;
				@endphp
				
			@foreach($detalle_envio as $value)
				<tbody>
					<tr>
						<td> <b>No.</b> {{$value->no_guia}}<br>
							<small><b>Ddestinatario:</b>{{$value->destinatario}} </small><br>
							<small><b>Telefóno:</b> {{$value->telefono}}</small><br>
							<small><b>Dirección:</b> {{$value->direccion}}</small>
							<small><b>Fecha entregar</b> {{date('d/m/Y', strtotime($value->fecha_entregar))}}</small>

						</td>
						


						<td>Q{{ number_format($value->total_paquete,2) }}</td>
						
						<td>{{$value->observaciones}}</td>

					</tr>
				</tbody>
				@php
					$a+=$value->total_paquete;
				@endphp
				
			@endforeach


			</table>
		</div>

