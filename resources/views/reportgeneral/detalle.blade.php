<div class="card card-info">
	<div class="card-header">
		<h3>Resultados</h3>
	</div>
	<div class="card-body">
<a class="btn btn-success" title="Exportar EXCEL" href="{{ route('reportgeneral.show',array('f1' => $f1,'f2' => $f2,'cliente' => $cliente,'mensajeroE' => $mensajeroE,'mensajeroR' => $mensajeroR, 'id') ) }}" target="_blank"><i class="far fa-file-excel"></i></a>		
		<div class="table-responsive">
		
			<table class="table table-hover table-striped" id="example3">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Envío</th>
						<th>Guía</th>
						<th>Mensajero Recibe.</th>
						<th>Cliente</th>
						<th>Destinatario</th>
						<th>Dirección</th>
						<th>Cobro</th>
						<th>Mensajería</th>
						<th>Fecha Entrega</th>
						<th>Mensajero entrega</th>
						<th>Estado</th>
						<th>Observaciones</th>
					</tr>
				</thead>
				<tbody>
					@php
					$total=0;	
					@endphp
					@forelse($detalle_envio as $value)
					<tr>
						<td>{{date('d/m/Y',strtotime($value->fecha_envio)) }}</td>
						<td>{{$value->no_envio}}</td>
						<td>{{$value->no_guia}}</td>
						<td>{{$value->mensajeroR}}</td>
						<td>{{$value->cliente}}</td>
						<td>{{$value->destinatario}}</td>
						<td>{{$value->direccion}}</td>
						<td>Q{{number_format($value->total_paquete,2)}}</td>
						<td>Q{{number_format($value->total_msj,2)}}</td>
						<td>
							@if($value->fecha_entrega=="")
							---
							@else
							{{date('d/m/Y',strtotime($value->fecha_entrega)) }}
							@endif
							
						</td>
						<td>{{$value->mensajeroE}}</td>
						<td>{{$value->descripcion}}</td>
						<td>{{$value->observaciones}}
							@foreach($guia_movimientos as $mov)
								@if($value->no_guia_mov== $mov->no_guia)
								{{$mov->observaciones}}
								@endif
							@endforeach()	
						</td>
					</tr>
					@empty
					<div class="alert alert-success">No se encontraron registros para criterios seleccionados!!!</div>
					@endforelse
				</tbody>
			</table>
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