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
						<th>Dirección</th>
						<th>Telefono</th>
						<th>Email</th>
						<th>Estado</th>
						<th><i class="fa fa-wrench"></i> </th>
					</tr>
				</thead>
				<tbody>
					@forelse($clientes as $cliente)
					<tr>
						<td>{{$cliente->id}}</td>
						<td>{{$cliente->nombre}}</td>
						<td>{{$cliente->direccion}}</td>
						<td>{{$cliente->telefono}}</td>
						<td>{{$cliente->email}}</td>
						<td>
							@if($cliente->estado =='A')
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
								data-id='{{$cliente->id}}'
								data-nombre='{{$cliente->nombre}}'
								data-direccion='{{$cliente->direccion}}'
								data-telefono='{{$cliente->telefono}}'
								data-email='{{$cliente->email}}'
								data-estado='{{$cliente->estado}}'
								>
								<i class="fa fa-edit"></i> 
							</button>

							<button class="btn btn-danger" onclick="DeleteRecord({{$cliente->id}})"><i class="fa fa-trash"></i> </button>
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
	//Hace funcionar tabla
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