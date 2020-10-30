@extends('layouts.app')

@section('content')

<div class="card card-primary ">
	<div class="card-header">
		<h3>Reporte general</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-2">
				<label>CLIENTE</label>
				<select class="form-control" id="cliente">
					<option>TODOS</option>
					@foreach($clientes as $cliente)
					<option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-2">
				<label>Mensajero recibe</label>
				<select class="form-control" id="mensajeroR">
					<option>TODOS</option>
					@foreach($user as $value)
					<option value="{{$value->id}}">{{$value->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-2">
				<label>Mensajero entrega</label>
				<select class="form-control" id="mensajeroE">
					<option>TODOS</option>
					@foreach($user as $values)
					<option value="{{$values->id}}">{{$values->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-2">
				<label>Del:</label>
				<input type="date" class="form-control" id="f1" value="{{ date('Y-m-d') }}" >
			</div>
			<div class="col-md-2">
				<label>Al:</label>
				<input type="date" class="form-control" id="f2" value="{{ date('Y-m-d') }}" >
			</div>
			<div class="col-md-2">
				<label></label>
				<button class="btn btn-primary btn-block" onclick="result_report()" > <i class="fa fa-search"></i></button>
			</div>
		</div>
	</div>
</div>

<div id="show_data"></div>

@endsection

@section('scripts')
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}" defer ></script>

<script>
//función que trae datos reporte
function result_report() {
	var f1 = document.getElementById('f1').value;
	var f2 = document.getElementById('f2').value;
	var cliente = document.getElementById('cliente').value;
	var mensajeroR = document.getElementById('mensajeroR').value;
	var mensajeroE = document.getElementById('mensajeroE').value;

		$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('reportgeneral.edit','id') }}",
		data:{f1:f1,f2:f2,cliente:cliente,mensajeroR:mensajeroR,mensajeroE:mensajeroE},
            beforeSend: function(){
              $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
              
            },
		success:function(data){
			$("#show_data").html(data);
		}
	})
	
}
</script>
@endsection
