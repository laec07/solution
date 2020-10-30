<div class="table-responsive">
	<table class="table" id="example4">
		<thead>
			<th >Datos Guia</th>
			<th></th>

		</thead>
		<tbody>
			@forelse($detalle_envios as $value)
			<tr>
				
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
					<button class="btn btn-outline-primary" onclick="asig_mod2('{{$value->no_guia}}')" ><i class="fa fa-arrow-alt-circle-right"></i></button>
				</td>
			</tr>
			@empty
			<div class="alert alert-danger">No existen guías disponibles</div>
			@endforelse
		</tbody>
	</table>
	
</div>

<script>
	//
  $(function () {

    $('#example4').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
