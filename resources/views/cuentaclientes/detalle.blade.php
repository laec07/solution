<div class="card card-info">
	<div class="card-header">
		<h3></h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table  " id="example3" >
				<thead>
					<tr>
						<th>Cliente</th>
						<th>No. cuenta</th>
						<th>Banco</th>
						<th>Tipo</th>
						<TH>Estado</TH>
						<th><i class="fa fa-wrench"></i></th>
					</tr>
				</thead>
				<tbody>
					@forelse($cuentas as $cuenta)
					<tr>
						
						<td>{{$cuenta->cliente}}</td>
						<td> {{$cuenta->no_cuenta}}</td>
						<td>{{$cuenta->banco}}</td>

						<td>{{$cuenta->tipo}}</td>
						<td>
							@if ($cuenta->estado=='A')
							<label class="badge badge-success">ACTIVO</label>
							@else
							<label class="badge badge-danger">INACTIVO</label>
							@endif

						</td>
							<td>
							<button
								id='btn_edit' 
								class="btn btn-warning" 
								data-toggle="modal" 
								data-target="#Edit" 
								data-id='{{$cuenta->id}}'
								data-id_cliente='{{$cuenta->id_cliente}}'
								data-no_cuenta='{{$cuenta->no_cuenta}}'
								data-id_banco='{{$cuenta->id_banco}}'
								data-tipo='{{$cuenta->tipo}}'
								data-estado='{{$cuenta->estado}}'
								>
								<i class="fa fa-edit"></i> 
							</button>

							<button class="btn btn-danger" onclick="DeleteRecord({{$cuenta->id}})"><i class="fa fa-trash"></i> </button>
													
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