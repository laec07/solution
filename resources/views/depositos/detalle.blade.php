<div class="table-responsive">
	<table class="table table-hover">
		<thead class="table-primary">
			<tr>
				<th>ID</th>
				<th>Cliente</th>
				<th>Total</th>
				<th>Total Mensajería</th>
				<th>Total a depositar</th>
				<th>Total Depósitos</th>
				<th>Pendiente</th>
				<th><i class="fa fa-wrench" aria-hidden="true"></i></th>
			</tr>
		</thead>
		<tbody>
			@forelse($liquidacion as $data)
			<tr>
			<td>{{$data->id}}</td>
			<td>{{$data->nombre}} <br>
				@forelse($cuentas as $cuenta)
					@if($data->id_cliente == $cuenta->id_cliente )
					{{$cuenta->no_cuenta}} - {{$cuenta->descripcion}}
					<br>
					@endif 
				@empty
				Cliente no tiene cuentas configuradas
				@endforelse
			</td>
			<td>Q {{number_format($data->total_paquete,2) }}</td>
			<td>Q {{number_format($data->total_mensajeria,2)}}</td>
			<td>Q {{number_format($data->total_liquidar,2)}}</td>
			<td>Q {{number_format($data->total_depositos,2)}}</td>
			<td>
				@if($data->total_liquidar - $data->total_depositos != 0) 
				<label class="badge badge-danger">Q {{number_format($data->total_liquidar - $data->total_depositos,2)}}</label>
				@else
				<label class="badge badge-success" >Q {{number_format($data->total_liquidar - $data->total_depositos,2)}}</label>
				@endif
			</td>
			<td>
			      	<!--Boton para mostrar formulario para ingreso de pago-->
			      	<button 
			      		class="btn btn-warning btn-sm" 
			      		data-toggle='modal' 
			      		data-target='#InsertPay' 
			      		id="btn_isertPay"
			      		data-no_envio='{{$data->id}}'
			      		data-id_cliente='{{$data->id_cliente}}'
			      		data-cliente='{{$data->nombre}}'
			      		data-total_liquidar='{{$data->total_liquidar - $data->total_depositos}}'
			      		title="Ingreso de pagos" 
			      	>
			      		<i class="fa fa-money-bill-alt"></i> 
			      	</button>


			      	<!--Boton para mostrar historial de pago-->
			      	<button 
			      		class="btn btn-secondary btn-sm " 
			      		data-toggle='modal' 
			      		data-target='#HistoryPay' 
			      		title="Historial de pagos"
			      		id="btn_history" 
			      		data-no_liq="{{$data->id}}" 
			      	><i class="fa fa-history"></i> 
			      	</button>
			      	<!--Boton para mostrar formulario cierre-->
			      	@if($data->total_liquidar - $data->total_depositos == 0)
			      	<button 
			      		class="btn btn-success btn-sm " 
			      		title="Cierre de envios"
			      		onclick="CierreEnvios({{$data->id}})" 
			      		>
			      		<i class="fa fa-save"></i> 
			      	</button>
			      	@else
			      	<button 
			      		class="btn btn-success btn-sm " 
			      		title="Pendiente de liquidaciones"  
			      		disabled>
			      		<i class="fa fa-save"></i> 
			      	</button>
			      	@endif
			</td>
			</tr>
			@empty
						<div class="alert alert-danger" role="alert">
						  No existen Liquidaciones pendientes de depósito!!!
						</div>
			@endforelse
		</tbody>
		
	</table>
</div>


