
			    	<div class="alert alert-primary" role="alert">
					  <h3>Efectivo:</h3>
					  <h2><span id="e_total">Q 0</span></h2>
					</div>
<div class="table-responsive">
			<table class="table  table-hover" >
				<thead class="table-primary">
					<tr>
						<th>Datos Guía</th>
						<th scope="col" >Total</th>
						

						<th scope="col" >Datos entrega</th>

						<th scope="col" ><i class="fa fa-wrench" aria-hidden="true"></i></th>
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
							<small><b>Ddestinatario:</b>{{$value->destinatario}} </small><br>
							<small><b>Telefóno:</b> {{$value->telefono}}</small><br>
							<small><b>Dirección:</b> {{$value->direccion}}</small>
							<small><b>Fecha entregar</b> {{date('d/m/Y', strtotime($value->fecha_entregar))}}</small><br>
							<small>
								<b>Observaciones: </b>
								@if($value->devolucion=='S')
								{{$value->observaciones}} - DEVOLUCION A CLIENTE 
								@else
								{{$value->observaciones}}
								@endif
							</small>
						@if($value->descripcion=='Entregado')
						<label class="badge badge-success">{{$value->descripcion}}</label>
						@elseif($value->descripcion=='Rechazado')
						<label class="badge badge-danger">{{$value->descripcion}}</label>
						@else
						<label class="badge badge-warning">{{$value->descripcion}}</label>
						@endif
						


						</td>
						


						<td>Q{{ number_format($value->total_paquete,2) }}</td>




						
						<td>
						<small>
						<b>Tipo pago:</b>
						@if($value->descripcion=='Entregado')
						 {{$value->pago}}
						@else
						--
						@endif
						</small>
						<br>
						<small> <b>Recibe:</b> {{$value->recibe}}</small><br>
						<small><b>Obs. Entrega:</b> {{$value->obs_entrega}}</small><br>
						</td>

	
						<td>
							@if($value->estado == '4' )
							<button 
								type="button" 
								id="bt_save" 
								class="btn btn-primary" 
								data-toggle="modal"  
								data-no_guia_e='{{$value->no_guia}}'
								data-devolucion='{{$value->devolucion}}'
								data-target="#SaveShipping">
								<i class="fa fa-shipping-fast"  ></i> 
							</button>
							@else
							<a class="btn btn-success" onclick="receiver('{{$value->no_guia}}','4')"><i class="fa fa-times"  ></i> </a>							
							@endif

						</td>
					</tr>
				</tbody>
				@php
					if ($value->estado=='5' && $value->id_pago ==1) {
						$a+=$value->total_paquete;
					}
					

						$p+=1;

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
			<input type="hidden" id="total_efect" value="Q {{ number_format($a,2)  }}">
			<input type="hidden" name="vbutton" id="vbutton" value={{$p}} >
		</div>