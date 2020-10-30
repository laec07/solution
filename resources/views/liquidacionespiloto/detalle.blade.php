<div class="card">
	<div class="card-header" >
		<div class="row">
			<input type="hidden" name="" value="{{$user_id}}">
			<div class="col-md-3">
				<div class="alert alert-warning" role="alert">
				  <h2> Devoluciones: <br> <span id="m_item" > </span> Items</h2>
				</div>
			</div>
			<div class="col-md-3">
				<div class="alert alert-info" role="alert">
				  <h2> Efectivo: <br> <span id="m_total" >Q </span> </h2>
				</div>
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary btn-block" onclick="Guardapiloto()"  > Aceptar</button>
			</div>
			
		</div>
		<div align="right" >
			
		
		<a class="btn btn-success" title="Exportar EXCEL" href="{{ route('liquidacionespiloto.edit',$user_id) }}" target="_blank"><i class="far fa-file-excel"></i></a>

		<a class="btn btn-warning" title="Generar vista previa" href="{{ url('/liquidacionespiloto/'.$user_id.'/pdf') }}" target="_blank"><i class="fas fa-print"></i></a>
		</div>
	</div>

	<div class="card-body">
		<div class="table-responsive">
					<table class="table" id="example3" >
						<thead class="table-primary">
							
								<th>Datos Guia</th>
								<th>Tipo pago</th>
								<th>Recibe</th>
								<th>Obs. entrega</th>
								<th>Mensajero</th>
								<th>Total</th>
								<th>Estado</th>
							
						</thead>
						@php
						//Variables para suma de total e items
							$a=0;
							$devItem=0;
							$pending=0;
						@endphp
					<tbody>
					@forelse($detalle_envio as $value)
						
							<tr>
								<!--Datos de envio -->
								<td>{{$value->no_guia}} <br>
										<small> 
											<b>Destinatario:</b> <br>
												{{$value->destinatario}} 
										</small> <br>
										<small>
											<b>Fecha entrega:</b><br>
											{{date('d/m/Y', strtotime($value->fecha_entregar))}}
										</small><br>
										<small>
											<b>Cliente:</b><br>
											{{$value->cliente}}
										</small><br>
											<b>Envío #: {{$value->no_envio}}</b>
								</td>
								<!-- Validaciones para mostrar tipo pago -->
								<td>
								@if($value->id_mov=='5'|| $value->id_mov=='12' || $value->id_mov=='13')
								
									@if ($value->id_pago==1)
										<label class="badge badge-success">{{$value->pago}}</label>
									@else
										<label class="badge badge-warning">{{$value->pago}}</label>
									@endif									
									
								
								@else
								--
								@endif
								</td>
								<!-- Datos entrega -->
								<td>{{$value->recibe}} </td>
								<td>{{$value->obs_entrega}}</td>
								<td>{{$value->mensajero}}</td>
								<!-- Validación para mostrar opción a editar -->
								<td>
								@if($value->id_mov=='5'|| $value->id_mov=='12' || $value->id_mov=='13')
								<button 
										data-toggle='modal' 
										data-target='#EditPrice' 
										id="bt_EdPrice" 
										data-no_guia='{{$value->no_guia}}' 
										data-total='{{$value->total_paquete}}'
										data-no_envio='{{$value->no_envio}}' 
										class="btn btn-sm">
										Q{{ number_format($value->total_paquete,2) }} 
										<i class="fa fa-edit"></i> 
									</button> 
								
								@else
								Q{{ number_format($value->total_paquete,2) }}
								@endif
								</td>
								<!--Estado-->
								@if($value->id_mov=='5')
								<td><label class="badge badge-primary">{{$value->descripcion}}</label></td>
								@elseif($value->id_mov=='7')
								<td><label class="badge badge-danger">{{$value->descripcion}}</label></td>
								@elseif($value->id_mov=='6')
								<td><label class="badge badge-warning">{{$value->descripcion}}</label></td>
								@elseif($value->id_mov=='8')
								<td><label class="badge badge-warning">{{$value->descripcion}}</label></td>
								@elseif($value->id_mov=='13')
								<td><label class="badge badge-success">{{$value->descripcion}}</label></td>
								@elseif($value->id_mov=='12')
								<td><label class="badge badge-success">{{$value->descripcion}}</label></td>
								@elseif($value->id_mov=='4')
								<td><label class="badge badge-secondary">{{$value->descripcion}}</label></td>
								@elseif($value->id_mov=='3')
								<td><label class="badge badge-secondary">{{$value->descripcion}}</label></td>
								@else
								<td><label class="badge badge-secondary">Sin definir</label></td>
								@endif
								<!-- ./ Estado-->

							</tr>
						
						@php
							
							if($value->id_mov=='5' || $value->id_mov=='12'){
								$a+=$value->total_paquete;
							}

							if($value->id_mov!='5' && $value->id_mov!='12'){
								$devItem+=1;
							}

							if($value->id_mov=='3' || $value->id_mov=='4'){
								$pending+=1;
							}
							
						@endphp
					@empty
						<div class="alert alert-danger" role="alert">
						  No existen Guias pendientes de liquidar para mensajero seleccionado!!!
						</div>					
					@endforelse
					</tbody>

					</table>

								<input type="hidden" id="total_m" value="Q {{ number_format($a,2)  }}">
								<input type="hidden" value="{{$devItem}}" id="item_m">
								<input type="hidden" value="{{$pending}}" id="pending">
				</div>

	</div>
	
</div>

		<!-- Modal edit price-->
		<div class="modal fade" id="EditPrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edición de precio total</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form id="frm_edit">
		          @csrf
		          <input type="hidden" name="no_guia_e" id="no_guia_e">
		          <input type="hidden" name="total_b" id="total_b">
		          <input type="hidden" name="no_envio_e" id="no_envio_e">

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
		        </form>
		      </div>
		      <div class="modal-footer">

		        <button type="button" class="btn btn-primary"  onclick="edit_total()" data-dismiss="modal">Guardar</button>
		      </div>
		    </div>
		  </div>
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

		