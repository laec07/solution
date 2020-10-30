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
						<th scope="col" >Estado Mensajería</th>
						<th scope="col" >Total liquidar</th>
						<th scope="col" >Estado</th>
						<th scope="col" ><i class="fa fa-wrench" aria-hidden="true"></i></th>
					</tr>
				</thead>
				@php
					$a=0;
					$p=0;
					$tms=0;
					$tliq=0;

				@endphp
				
			@foreach($detalle_envio as $value)
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
								</small>
						</td>

						@if($value->descripcion=='Entregado' || $value->descripcion=='Liquidado')
						<td>{{$value->pago}}</td>
						@else
						<td>--</td>
						@endif

						<td>{{$value->recibe}}</td>
						<td>{{$value->obs_entrega}}</td>
						<td>{{$value->mensajero}}</td>

						@if($value->id_mov=='5'|| $value->id_mov=='12' || $value->id_mov=='10')
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
						@if($value->tp_msj=='1')
						<td><label class="badge badge-primary">DEBITO</label></td>
						@elseif($value->tp_msj=='2')
						<td><label class="badge badge-danger"> {{$value->tp_msj}}</label></td>
						@else
						<td>--</td>
						@endif
						<td>Q{{ number_format($value->total_liquidar,2) }}</td>

						@if($value->id_mov=='5')
						<td><label class="badge badge-success">{{$value->descripcion}}</label></td>
						@elseif($value->id_mov=='7')
						<td><label class="badge badge-danger">{{$value->descripcion}}</label></td>
						@elseif($value->id_mov=='6')
						<td><label class="badge badge-warning">{{$value->descripcion}}</label></td>
						@elseif($value->id_mov=='8')
						<td><label class="badge badge-warning">{{$value->descripcion}}</label></td>
						@elseif($value->id_mov=='10')
						<td><label class="badge badge-success">{{$value->descripcion}}</label></td>
						@elseif($value->id_mov=='12')
						<td><label class="badge badge-success">{{$value->descripcion}}</label></td>
						@else
						<td><label class="badge badge-secondary">Sin entregar</label></td>
						@endif




						<td>
							@if($value->estado == '6' ||  $value->estado == '8' ||  $value->estado == '7' )
							<a title="Reprogramar"   class="btn btn-success" href=" {{ route('enviosasignacion.edit',$value->no_envio) }} "    ><i class="fa fa-clock" ></i> </a>
							@elseif($value->estado == '5' || $value->estado == '10' || $value->estado == '12' )

							<button 
								title="Registar pago"   
								class="btn btn-primary" 
								data-toggle='modal' 
								id="modalLiq" 
								data-target='#pay'
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
					
					if($value->id_mov=='5' || $value->id_mov=='10'){
						$a+=$value->total_paquete;
					}
					$tms+=$value->total_msj;
					$tliq+=$value->total_liquidar;
				@endphp
			@endforeach
				<tfoot class="table-primary">
					<tr>
						<th colspan="5">Total:</th>
						<th colspan="">Q {{ number_format($a,2)  }} </th>
						<th colspan="2">Q {{ number_format($tms,2)  }} </th>
						<th colspan="3">Q {{ number_format($tliq,2)  }} </th>

					</tr>
				</tfoot>

			</table>
			<input type="hidden" name="vbutton" id="vbutton" value={{$p}} >
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
        <form id="frm_edit">
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
			      	<label>Tipo pago mensajería</label>
			      	<select id="tp_msj" class="form-control">
			      		<option value="1">DEBITO</option>
			      		<option value="2">CREDITO</option>
			      	</select>
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


