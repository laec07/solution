<div class="card">
	<div class="card-header" >
		<div class="row">

			<div class="col-md-3">
				<div class="alert alert-warning" role="alert">
				  <h3> Total: <br><span id="m_totalg" >Q 4,300</span> </h3>
				</div>				
			</div>
			<div class="col-md-3">
				<div class="alert alert-danger" role="alert">
				  <h3> Total Mensajeria:<br> <span id="m_totalm" >Q 4,300</span> </h3>
				</div>				
			</div>
			<div class="col-md-3">
				<div class="alert alert-success" role="alert">
				  <h3> Total a liquidar:<br> <span id="m_totalL" >Q 0</span> </h3>
				</div>				
			</div>
			<div class="col-md-2">
				<div id="button_g" style="padding: 4px;" ></div>

				<button
					id="btn_calcLiq" 
					class="btn btn-success btn-block" 
					title="Calcular liquidación" 
					onclick="calc_liq_general()" > 
					<i class="fa fa-calculator"></i> 
					Calcular liquidación
				</button>

				<button
					id="btn_saveLiq" 
					class="btn btn-primary btn-block" 
					title="Guardar" 
					onclick="save_liq_general()" > 
					<i class="fa fa-save"></i> 
					Guardar 
				</button>

			</div>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
					<table class="table  table-hover" >
						<thead class="table-primary">
							<tr>
								<th>Datos Guia</th>
								<th scope="col" >Tipo pago</th>
								<th scope="col" >Recibe</th>
								<th scope="col" >Obs. entrega</th>
								<th scope="col" >Mensajero</th>
								<th scope="col" >Total</th>
								<th scope="col" >Total Mensajería</th>
								<th scope="col" >Total liquidar</th>
								
								<th scope="col" ><i class="fa fa-wrench" aria-hidden="true"></i></th>
							</tr>
						</thead>
						@php
							$a=0;
							$p=0;
							$tms=0;
							$tliq=0;
							$val=0;

						@endphp
						
					

					@forelse($detalle_envio as $value)
						<tbody>
							<tr>
								<td>{{$value->no_guia}} <br>
										<small> 
											<b>Destinatario:</b> <br>
												{{$value->destinatario}} 
										</small> <br>
										<small>
											<b>Fecha entrega:</b><br>
											{{date('d/m/Y', strtotime($value->fecha_entregar))}}
										</small><br>
										
											<b>Envío #: {{$value->no_envio}}</b>
										

								</td>


								<td>{{$value->pago}}</td>
	

								<td>{{$value->recibe}} </td>
								<td>{{$value->obs_entrega}}</td>
								<td>{{$value->mensajero}}</td>

								@if($value->id_mov=='5'|| $value->id_mov=='13')
								<td><button 
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
								</td>
								@else
								<td>Q{{ number_format($value->total_paquete,2) }}</td>
								@endif

								
								<td>Q{{ number_format($value->total_msj,2) }}</td>

								<td>Q{{ number_format($value->total_liquidar,2) }}</td>





								<td>
									@if($value->estado == '6' ||  $value->estado == '8' ||  $value->estado == '7' )
									<a title="Reprogramar"   class="btn btn-success" href=" {{ route('enviosasignacion.edit',$value->no_envio) }} "    ><i class="fa fa-clock" ></i> </a>
									@elseif($value->estado == '5' || $value->estado == '10' || $value->estado == '13' )

									<button 
										title="Registar pago"   
										class="btn btn-primary" 
										data-toggle='modal' 
										id="modalLiq" 
										data-target='#Pay'
										data-total_l='{{$value->total_paquete}}'
										data-no_guia_l='{{$value->no_guia}}'
										data-tp_msj='{{$value->tp_msj}}'
										data-total_msj='{{$value->total_msj}}'
										>
										<i class="fa fa-money-bill-alt" ></i> 
									</button>
									@endif

								</td>
							</tr>
						</tbody>
						@php
							
							if($value->id_mov=='13' || $value->id_mov=='10'){
								$a+=$value->total_paquete;
							}
							$tms+=$value->total_msj;
							$tliq+=$value->total_liquidar;
							$val+=1;
						@endphp
					@empty
						<div class="alert alert-danger" role="alert">
						  No existen Guias pendientes de liquidar para cliente seleccionado!!!
						</div>					
					@endforelse
						<tfoot class="table-primary">
							<tr>
								<th colspan="5">Total:</th>
								<th colspan="">Q {{ number_format($a,2)  }} </th>
								<th colspan="">Q {{ number_format($tms,2)  }} </th>
								<th colspan="3">Q {{ number_format($tliq,2)  }} </th>

							</tr>
						</tfoot>

					</table>
					<!--se utiliza para mostrar totales con formato-->
					<input type="hidden" id="total_mg" value="{{ number_format($a,2)  }}">
					<input type="hidden" id="total_ms" value="{{ number_format($tms,2)  }}">
					<input type="hidden" id="total_mL" value="{{ number_format($tliq,2)  }}">
					<!--se utiliza para trasladar datos a BD-->
					<input type="hidden" id="total_mgBD" value="{{ $a}}">
					<input type="hidden" id="total_msBD" value="{{ $tms }}">
					<input type="hidden" id="total_mLBD" value="{{ $tliq }}">

					<input type="hidden" id="valida_datos" value="{{$val}}">

					
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

		<!-- //////////    Modal Pay ////////////////////////// -->
		<div class="modal fade" id="Pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Detalles del liquidación Guia No <span id="no_guia_t"></span></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form >
		          @csrf
		          <input type="hidden" name="no_guia_l" id="no_guia_l">


		          <div class="form-group">
		            <label>Total:</label>
		            <div class="input-group">
		              <div class="input-group-prepend">
		                <span class="input-group-text">
		                  Q
		                </span>
		              </div>
		              <input type="number" class="form-control" name="totalP_l" id="totalP_l" readonly="" >
		            </div>
		            <span style="display: none; color:red;" class="form-text" id="total_error"></span>
		          </div>

		          <div class="form-group">
		          	<div class="row">
		          		<div class="col-md-6">
				          <div class="form-group">
				            <label>Total mensajeria:</label>
				            <div class="input-group">
				              <div class="input-group-prepend">
				                <span class="input-group-text">
				                  Q
				                </span>
				              </div>
				              <input type="number" class="form-control" name="total_msj" id="total_msj" onkeyup="calc_liq()" >
				            </div>
				            <span style="display: none; color:red;" class="form-text" id="total_error"></span>
				          </div>
		          		</div>

		          		<div class="col-md-6">
					      <div class="form-group">
					      	<!--<label>Tipo pago mensajería</label>-->
					      	<input type="hidden" id="tp_msj" class="form-control" value="1">

					      </div>          			
		          		</div>
		          		
		          	</div>
		          	
		          <div class="form-group">
		            <label>Total liquidar:</label>
		            <div class="input-group">
		              <div class="input-group-prepend">
		                <span class="input-group-text">
		                  Q
		                </span>
		              </div>
		              <input type="number" class="form-control" name="total_liquidar" id="total_liquidar" >
		            </div>
		            <span style="display: none; color:red;" class="form-text" id="total_error"></span>
		          </div> 


		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary"  onclick="save_liq()" data-dismiss="modal">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>




