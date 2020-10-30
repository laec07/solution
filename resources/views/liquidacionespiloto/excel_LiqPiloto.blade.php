
@php

/******************************************************************/
header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=Liquidacion_".$mensajero->name."_".date('dmyH:m:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");
/****************************************************************/
@endphp


<table>
	<tr>
		<th style="text-align: left;" colspan="8" >SOLUTION EXPRESS - Liquidación por Mensajero</th>

		<!--<th style="text-align: right; "><img src="asset('dist/img/SolutionExpLogo.png')}}"  height="20px" ></th>-->
	</tr>

</table>

<b>Mensajero:</b> <u> {{$mensajero->name}} </u> <br>
<b>Fecha:</b> <u> {{ date('d/m/Y H:m:s') }} </u><br>
<b>Generado por:</b> {{$user_genera->username	}}
<br>
<br>

					<table cellspacing=0>
						<thead >
							
								<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' >Datos Guia</th>
								<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' >Cliente</th>
								<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' >Tipo pago</th>
								<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' >Recibe</th>
								<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' >Obs. entrega</th>

								<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' >Total</th>
								<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' >Estado</th>
							
						</thead>
						@php
						//Variables para suma de total e items
							$a=0;
							$b=0;
							$devItem=0;
						@endphp
					<tbody>
					@forelse($detalle_envio as $value)
						
							<tr>
								<!--Datos de envio -->
								<td style='border:1px solid #000;'>{{$value->no_guia}} <br>
									<b>Envío #: {{$value->no_envio}}</b>
								</td>
								<td style='border:1px solid #000;'>{{$value->cliente}}</td>
								<!-- Validaciones para mostrar tipo pago -->
								<td style='border:1px solid #000;'>
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
								<td style='border:1px solid #000;'>{{$value->recibe}} </td>
								<td style='border:1px solid #000;'>{{$value->obs_entrega}}</td>
								<!-- Validación para mostrar opción a editar -->
								<td style='border:1px solid #000;'>Q{{ number_format($value->total_paquete,2) }}</td>
								<!--Estado-->
								<td style='border:1px solid #000;'>{{$value->descripcion}}</td>
								<!-- ./ Estado-->

							</tr>
						
						@php
							
							if($value->id_mov=='5' || $value->id_mov=='12'){
								$a+=$value->total_paquete;
								$b+=1;
							}

							if($value->id_mov!='5' && $value->id_mov!='12'){
								$devItem+=1;
							}
							
						@endphp
					@empty
						<div class="alert alert-danger" role="alert">
						  No existen Guias pendientes de liquidar para mensajero seleccionado!!!
						</div>					
					@endforelse
					</tbody>

					</table>
<br>

<table border="1px" cellspacing="0">
	<tr>
		<td><b>Items entregados:</b> </td>
		<td>{{$b}}</td>
	</tr>
	<tr>
		<td><b>Efectivo:</b> 
		<td> Q{{ number_format($a,2) }}</td></td>
	</tr>
	<tr>
		<td><b>Items Devolución</b></td>
		<td>{{$devItem}}</td>
	</tr>
</table>
<br>
<br>
<table>
	<tr>
		<th colspan="4" ><h3></h3></th>
		<th style="text-align: center; width: 500px ">__________________________ <br>{{$mensajero->name}}
		 </th>
		<th style="text-align: right; width: 500px "></th>
	</tr>

</table>
			

	</div>
	
</div>




		