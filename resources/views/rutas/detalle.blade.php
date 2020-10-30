<div class="card card-info">
	<div class="card-header">
		<h3></h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover table-striped" id="example3" >
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Descripción</th>
						<th>Estado</th>
						<th><i class="fa fa-wrench"></i> </th>
					</tr>
				</thead>
				<tbody>
					@forelse($rutas as $ruta)
					<tr>
						<td>{{$ruta->id}}</td>
						<td>{{$ruta->nombre}}</td>
						<td>{{$ruta->descripcion}}</td>
						<td>
							@if($ruta->estado =='A')
							<label class="badge badge-success">Activo</label>
							@else
							<label class="badge badge-danger">Inactivo</label>
							@endif
						</td>
						<td>
							<button
								id='btn_edit' 
								class="btn btn-warning" 
								data-toggle="modal" 
								data-target="#Edit" 
								data-id='{{$ruta->id}}'
								data-nombre='{{$ruta->nombre}}'
								data-descripcion='{{$ruta->descripcion}}'
								data-estado='{{$ruta->estado}}'
								>
								<i class="fa fa-edit"></i> 
							</button>

							<button class="btn btn-danger" onclick="DeleteRecord({{$ruta->id}})"><i class="fa fa-trash"></i> </button>
						</td>
					</tr>
					@empty
					<div class="alert alert-danger">No existe registros</div>
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