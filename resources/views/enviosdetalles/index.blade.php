

		<div class="table-responsive">
			<table class="table  table-hover" >
				<thead class="table-primary">
					<tr>
						<th>Datos Guia</th>
						
						<th scope="col" >Total</th>
						<th scope="col" >Observaciones</th>
						<th scope="col" ><i class="fa fa-wrench" aria-hidden="true"></i></th>
					</tr>
				</thead>
				@php
					$a=0;
				@endphp
				
			@foreach($detalle_envio as $value)
				<tbody>
					<tr>
						<td><b>No. {{$value->no_guia}}</b><br>
							<small><b>Destinatario: </b>{{$value->destinatario}}</small><br>
							<small><b>Telefóno:</b> {{$value->telefono}}</small><br>
							<small><b>Dirección:</b> {{$value->direccion}} </small><br>
							<small><b>Fecha entrega</b> {{date('d/m/Y', strtotime($value->fecha_entregar))}}</small>
						</td>
						<td>Q{{ number_format($value->total_paquete,2) }}</td>
						<td>{{$value->observaciones}}</td>
						<td>
							<button 
								class="btn btn-warning" 
								data-toggle='modal'
								id="btn_editEnv" 
								data-target='#editEnv'
								title="Editar"
								data-no_guia="{{$value->no_guia}}"
								data-destinatario="{{$value->destinatario}}"
								data-telefono="{{$value->telefono}}"
								data-direccion="{{$value->direccion}}"
								data-total="{{$value->total_paquete}}"
								data-fecha="{{$value->fecha_entregar}}"
								data-observaciones="{{$value->observaciones}}"
								data-no_envio="{{$value->no_envio}}" 
								>
								<i class="fa fa-edit"></i>
							</button>
							<button class="btn btn-danger btn-sm" title="Eliminar" onclick="deletdetalle('{{$value->no_guia}}',{{$value->total_paquete}})"  ><i class="fa fa-trash"></i></button>
						</td>
					</tr>
				</tbody>
				@php
					$a+=$value->total_paquete;
				@endphp
				
			@endforeach
				<tfoot class="table-primary">
					<tr>
						<th >Total:</th>
						<th colspan="5">Q {{ number_format($a,2)  }} </th>
					</tr>
				</tfoot>

			</table>
		</div>

<div class="modal fade" id="editEnv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_edit">
          @csrf
          <input type="hidden" id="no_guia_e">
          <input type="hidden" id="valor_b">
          <input type="hidden" id="no_envio_e">

          <div id="dest_f" class="form-group">
            <label>Destinatario:</label>
            <input class="form-control" type="text" name="destinatario_e" id="destinatario_e" maxlength="100" onkeyup="mayus(this);">
            <span style="display: none; color:red;" class="form-text" id="dest_error"></span>
          </div>
          <div id="tel_f" class="form-group">
            <label>Telefono:</label>
            <input class="form-control" id="telefono_e" name="telefono_e" type="text" maxlength="20"></input>
            <span style="display: none; color:red;" class="form-text" id="tel_error"></span>
          </div>
          <div id="dirr_f" class="form-group">
            <label>Dirección:</label>
            <input class="form-control" type="text" name="direccion_e" id="direccion_e" maxlength="200">
            <span style="display: none; color:red;" class="form-text" id="dirr_error"></span>
          </div>

          <div id="total_f" class="form-group">
            <label>Total:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  Q
                </span>
              </div>
              <input type="number" class="form-control" name="total_paquete_e" id="total_paquete_e" step="0.01">
            </div>
            <span style="display: none; color:red;" class="form-text" id="total_error"></span>
          </div>
          <div class="form-group">
            <label>Fecha entrega:</label>
            <input  class="form-control" type="date" name="fecha_entrega_e" id="fecha_entrega_e" value="{{ date('Y-m-d') }}">
          </div>
          <div class="form-group">
            <label>Observaciones:</label>
            <textarea class="form-control" id="observaciones_e"></textarea>
          </div>
                  
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveEdit()">Guardar</button>
      </div>
    </div>
  </div>
</div>

