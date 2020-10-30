
@php
/******************************************************************/
header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=RepGeneral_".date('dmyH:m:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");
/****************************************************************/
@endphp

<table>
	<tr>
		<th style="text-align: left;" colspan="8" >SOLUTION EXPRESS - Reporte Generl</th>

		<!--<th style="text-align: right; "><img src="asset('dist/img/SolutionExpLogo.png')}}"  height="20px" ></th>-->
	</tr>

</table>

<b>Del:</b> <u> {{date('d/m/Y',strtotime($f1))}} </u> <br>
<b>Al:</b> <u> {{ date('d/m/Y',strtotime($f2))}} </u><br>
<b>Generado por:</b> {{$user_genera->username	}}
<br>
<br>
		
			<table class="table table-hover table-striped" id="example3">
				<thead>
					<tr>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Fecha</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Envío</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Guía</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Mensajero Recibe.</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Cliente</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Destinatario</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Dirección</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Cobro</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Mensajería</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Fecha Entrega</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Mensajero entrega</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Estado</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Observaciones</th>
					</tr>
				</thead>
				<tbody>
					@php
					$total=0;
					$msj=0;
					$items=0;	
					@endphp
					@forelse($detalle_envio as $value)
					<tr>
						<td style='border:1px solid #000;' >{{date('d/m/Y',strtotime($value->fecha_envio)) }}</td>
						<td style='border:1px solid #000;' >{{$value->no_envio}}</td>
						<td style='border:1px solid #000;' >{{$value->no_guia}}</td>
						<td style='border:1px solid #000;' >{{$value->mensajeroR}}</td>
						<td style='border:1px solid #000;' >{{$value->cliente}}</td>
						<td style='border:1px solid #000;' >{{$value->destinatario}}</td>
						<td style='border:1px solid #000;' >{{$value->direccion}}</td>
						<td style='border:1px solid #000;' >Q{{number_format($value->total_paquete,2)}}</td>
						<td style='border:1px solid #000;' >Q{{number_format($value->total_msj,2)}}</td>
						<td style='border:1px solid #000;' >
							@if($value->fecha_entrega=="")
							---
							@else
							{{date('d/m/Y',strtotime($value->fecha_entrega)) }}
							@endif
							
						</td>
						<td style='border:1px solid #000;' >{{$value->mensajeroE}}</td>
						<td style='border:1px solid #000;' >{{$value->descripcion}}</td>
						<td style='border:1px solid #000;' >{{$value->observaciones}}
							@foreach($guia_movimientos as $mov)
								@if($value->no_guia_mov== $mov->no_guia)
								{{$mov->observaciones}}
								@endif
							@endforeach()	
						</td>
					</tr>
					@php
						$total+= $value->total_paquete;
						$msj += $value->total_msj;
						$items += 1;

					@endphp
					
					@empty
					<div class="alert alert-success">No se encontraron registros para criterios seleccionados!!!</div>
					@endforelse
				</tbody>
				<tfoot>
					<tr>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' colspan="7">Total:</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Q{{number_format($total,2)}}</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;'  >Q{{number_format($msj,2)}}</th>
						<th style='border:1px solid #000;background: #82B0EA;color:#000;text-align: center;' colspan="4"></th>

					</tr>
				</tfoot>
			</table>

<br>

<table border="1px" cellspacing="0">
	<tr>
		<td><b>Items:</b> </td>
		<td>{{$items}}</td>
	</tr>
	<tr>
		<td><b>Mensajería:</b></td> 
		<td> Q{{number_format($msj,2)}}</td>
	</tr>
	<tr>
		<td><b> Valor paquetes </b></td>
		<td>Q{{number_format($total,2)}}</td>
	</tr>
</table>
		