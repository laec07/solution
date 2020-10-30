<div class="table-responsive">
	<table class="table" id="example3">
		<thead>
			<th></th>
			<th>Datos Guia</th>
			<th>Datos asignación</th>
			<th></th>
		</thead>

		<tbody>
			@forelse($detalle_envios as $value)
			<tr>
				<td>
					<button class="btn btn-outline-danger" onclick="back_to('{{$value->no_guia}}')" ><i class="fa fa-arrow-alt-circle-left"  ></i></button>
				</td>
				<td>
					<b>No. Guía:</b> {{$value->no_guia}}<br>
					<b>Destinatario:</b> {{$value->destinatario}}<br>
					<b>Dirección:</b> {{$value->direccion}}<br>
					<b>Teléfono:</b> {{$value->telefono}}<br>
          <b>Cliente:</b> {{$value->nombre}}<br>
					<b>Entregar:</b> {{date('d/m/Y', strtotime($value->fecha_entregar))}}<br>
					<b>Valor:</b> Q {{number_format($value->total_paquete,2)}}<br>

				</td>
				<td>
					<b>Ruta:</b> {{$value->ruta}}<br>
					<b>Tarifa:</b> {{$value->tarifa}}<br>
					<b>Total:</b> Q {{number_format($value->total_msj,2) }}<br>
					
						@if($value->estado=='3')
						 <label class="badge-success">Asignado</label> 
						@elseif($value->estado=='11')
						 <label class="badge-danger">Asignado para devolución</label> 
						@elseif($value->estado=='6')
						 <label class="badge-info">Ausente</label> 
						@elseif($value->estado=='7')
						 <label class="badge-danger">Rechazado</label> 
						@elseif($value->estado=='8')
						 <label class="badge-info">Pospuesto</label> 
						@else 
						 <label class="badge-danger">Sin definir</label> 
						@endif
					
				</td>
				<td>
					<button 
						class="btn btn-warning" 
						id="button_save" 
						data-toggle='modal' 
						data-target='#EditAsign' 
						title="Guardar" 
						data-no_guia='{{$value->no_guia}}' 
						data-estado='AS'
						data-ruta='{{$value->id_ruta}}'
						data-tarifa='{{$value->id_tarifa}}'
						data-total_msj='{{$value->total_msj}}'
						data-fecha_entregar='{{$value->fecha_entregar}}'  
						>
						<i class="fa fa-edit" ></i> 
					</button>					
				</td>

			</tr>
			@empty
			<div class="alert alert-danger">No existen guías asignadas</div>
			@endforelse
		</tbody>
	</table>
	
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
          	<label>Tarifa</label>
          	<select class="form-control" id='tarifa'>
          		<option value="0" >Selecione tarifa</option>
          		@foreach($tarifarios as $tarifario)
          		<option value="{{$tarifario->id}}" >{{$tarifario->descripcion}}</option>
          		@endforeach
          	</select>
          </div>

          <div id="total_fE" class="form-group">
            <label>Total:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  Q
                </span>
              </div>
              <input type="number" class="form-control" name="total_msjE" id="total_msjE" step="0.01">
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

        <button type="button" class="btn btn-primary"  onclick="edit_asign()" data-dismiss="modal">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
	//
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example3').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": false,
    });
  });
</script>
