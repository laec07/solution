
		<div class="table-responsive">
			<table class="table  table-hover" >
				<thead class="table-primary">
					<tr>
						<th>Datos Guía</th>

						<th scope="col" >Total</th>
						
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
							<small><b>Observaciones: </b> 
							@if($value->devolucion=='S')
							{{$value->observaciones}} ASIGNADO PARA DEVOLUCION A CLIENTE
							@else
							{{$value->observaciones}}
							@endif
							</small>

						</td>
						


						<td>Q{{ number_format($value->total_paquete,2) }}</td>
						
	
						<td>
							@if($value->estado == '3' || $value->estado == '11')
							<a class="btn btn-primary" title="Aceptar" onclick="receiver('{{$value->no_guia}}','4')"><i class="fa fa-check"  ></i> </a>
							@else
							<a class="btn btn-danger" title="Cancelar" onclick="receiver('{{$value->no_guia}}','3')"><i class="fa fa-times"  ></i> </a>
							<button class="btn btn-success" id="btn_traslate" title="Traslado" data-toggle="modal" data-no_guia='{{$value->no_guia}}' data-target="#traslado"><i class="fas fa-exchange-alt"></i> </button>							
							@endif

						</td>
					</tr>
				</tbody>
				@php
					$a+=$value->total_paquete;
					if($value->estado=='3'){
						$p+=1;
					}
				@endphp

			@empty
			    	<div class="alert alert-danger" role="alert">
					  No tiene asignado guías!!!
					</div>
			@endforelse
				<tfoot class="table-primary">
					<tr>
						<th >Total:</th>
						<th colspan="3">Q {{ number_format($a,2)  }} </th>

					</tr>
				</tfoot>

			</table>
			<input type="hidden" name="vbutton" id="vbutton" value={{$p}} >
		</div>

<!-- Modal -->
<div class="modal fade" id="traslado" tabindex="-1" role="dialog" aria-labelledby="traslado" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Traslado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
			<label>Mensajero</label>
			<select class="form-control" id="id_mensajero">
				@foreach($mensajero as $data)
				<option value="{{$data->id}}">{{$data->name}}</option>
				@endforeach
			</select>
        </div>
        <input type="hidden" id="no_guiaT" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="traslate()">Guardar</button>
      </div>
    </div>
  </div>
</div>


