		<div class="table-responsive">
			<table class="table  table-hover" >
				<thead class="table-primary">
					<tr>
						<th>No. Guia</th>
						<th scope="col" >Destinatario</th>
						<th scope="col" >Telefóno</th>
						<th scope="col" >Dirección</th>
						<th scope="col" >Total</th>
						<th scope="col" >Fecha entrega</th>
						<th scope="col" >Observaciones</th>
						<th scope="col" >Ruta</th>
						<th scope="col" >Piloto</th>
						<th scope="col" >Total Mensajería</th>
						<th scope="col" >Estado</th>
						<th scope="col" ><i class="fa fa-wrench" aria-hidden="true"></i></th>
					</tr>
				</thead>
				@php
					$a=0;
					$p=0;
				@endphp
			@foreach($detalle_envio as $value)
				<tbody>
					<tr>
						<td>{{$value->no_guia}}</td>
						<td>{{$value->destinatario}}</td>
						<td>{{$value->telefono}}</td>
						<td>{{$value->direccion}}</td>
						<td>Q{{ number_format($value->total_paquete,2) }}</td>
						<td>{{date('d/m/Y', strtotime($value->fecha_entregar))}}</td>
						<td>{{$value->observaciones}}</td>
						<td>{{$value->ruta}}</td>
						<td>{{$value->name}}</td>
						<td>Q{{ number_format($value->total_msj,2)}}</td>
						@if($value->estado=='AS'   )
						<td> <label class="badge-success">Asignado</label> </td>
						@elseif($value->estado=='5')
						<td> <label class="badge-primary">Entregado</label> </td>
						@elseif($value->estado=='R')
						<td> <label class="badge-warning">Pendiente</label> </td>
						@elseif($value->estado=='RP')
						<td> <label class="badge-secondary">En ruta</label> </td>
						@elseif($value->estado=='11')
						<td> <label class="badge-success">Asignado para devolución</label> </td>
						@elseif($value->estado=='10')
						<td> <label class="badge-success">Liquidado</label> </td>
						@else
						<td> <label class="badge-danger">Re-asignar</label> </td>
						@endif
						
						<td>
						@if($value->estado=='5' || $value->estado=='RP' || $value->estado=='10')
					
						@elseif($value->estado=='AS' || $value->estado=='R' )
							<button 
								class="btn btn-warning" 
								id="button_save" 
								data-toggle='modal' 
								data-target='#EditAsign' 
								title="Guardar" 
								data-no_guia='{{$value->no_guia}}' 
								data-estado='AS'
								data-piloto='{{$value->user_id}}'
								data-ruta='{{$value->id_ruta}}'
								data-tarifa='{{$value->id_tarifa}}'
								data-total_msj='{{$value->total_msj}}'
								data-fecha_entregar='{{$value->fecha_entregar}}'  
								>
								<i class="fa fa-edit" ></i> 
							</button>
						@else
							<button 
								class="btn btn-warning" 
								id="button_save" 
								data-toggle='modal' 
								data-target='#EditAsign' 
								title="Guardar" 
								data-no_guia='{{$value->no_guia}}' 
								data-estado='ASR'
								data-piloto='{{$value->user_id}}'
								data-ruta='{{$value->id_ruta}}'
								data-tarifa='{{$value->id_tarifa}}'
								data-total_msj='{{$value->total_msj}}'
								data-fecha_entregar='{{$value->fecha_entregar}}'  
								>
								<i class="fa fa-edit" ></i> 
							</button>	
						@endif


						</td>
					</tr>
				</tbody>
				@php
					$a+=$value->total_paquete;

				if($value->estado=='R'){
					$p+=1;
				}
				@endphp
			@endforeach
				<tfoot class="table-primary">
					<tr>
						<th colspan="4">Total:</th>
						<th colspan="8">Q {{ number_format($a,2)  }} </th>
					</tr>
				</tfoot>
			</table>
			<input type="hidden" name="vbutton" id="vbutton" value={{$p}} >
		</div>

<!-- Modal edit asig-->
<div class="modal fade" id="EditAsign" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos Asignación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_edit">
          @csrf
          <input type="hidden" name="no_guiaT" id="no_guiaT">
          <input type="hidden" name="estadoT" id="estadoT">
          
          <div class="form-group">
          	<label>Ruta</label>
          	<select class="form-control" id="ruta">
          		<option value="0" >Selecione ruta</option>
          		@foreach($rutas as $ruta)
          		<option value="{{$ruta->id}}" >{{$ruta->descripcion}}</option>
          		@endforeach
          	</select>
          </div>

          <div class="form-group">
          	<label>Piloto</label>
          	<select class="form-control" id="piloto">
          		<option value="0">Selecione Piloto</option>
          		@foreach($user as $us)
          		<option value="{{$us->id}}" >{{$us->name}}</option>
          		@endforeach
          	</select>
          </div>

          <div class="form-group">
          	<label>Tarifa</label>
          	<select class="form-control" id='tarifa'>
          		<option value="0" >Selecione tarifa</option>
          		@foreach($tarifarios as $tarifario)
          		<option value="{{$tarifario->id}}" >{{$tarifario->descripcion}}</option>
          		@endforeach
          	</select>
          </div>

          <div id="total_f" class="form-group">
            <label>Total:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  Q
                </span>
              </div>
              <input type="number" class="form-control" name="total_msj" id="total_msj" step="0.01">
            </div>
            <span style="display: none; color:red;" class="form-text" id="total_error"></span>
          </div>
          <div class="form-group">
          	<label>Fecha entrega:</label>
          	<input type="date" id="fecha_entregar" class="form-control">
          </div>
          <div id="devolucion_f" class="form-group">
          	<label>Devolver a cliete:</label>
          	<input type="checkbox" class="form-control" name="" id="check_dev">
          </div>  
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary"  onclick="receiver()" data-dismiss="modal">Guardar</button>
      </div>
    </div>
  </div>
</div>