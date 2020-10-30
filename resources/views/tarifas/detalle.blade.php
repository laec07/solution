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
						<th>Descripción</th>
						<th>Total</th>
						<th>Estado</th>
						<th><i class="fa fa-wrench"></i> </th>
					</tr>
				</thead>
				<tbody>
					@forelse($tarifas as $tarifa)
					<tr>
						<td>{{$tarifa->id}}</td>
						<td>{{$tarifa->descripcion}}</td>
						<td>Q {{$tarifa->total}}</td>
						<td>
							@if($tarifa->estado =='A')
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
								data-id='{{$tarifa->id}}'
								data-total='{{$tarifa->total}}'
								data-descripcion='{{$tarifa->descripcion}}'
								data-estado='{{$tarifa->estado}}'
								>
								<i class="fa fa-edit"></i> 
							</button>

							<button class="btn btn-danger" onclick="DeleteRecord({{$tarifa->id}})"><i class="fa fa-trash"></i> </button>
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