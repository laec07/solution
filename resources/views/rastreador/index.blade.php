@extends('layouts.app')

@section('content')

<div class="card card-primary">
	<div class="card-header">
		<h3>Rastreador de guías</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<input type="text" id="no_guia" class="form-control" placeholder="Ingresar número de guía" >
			</div>
			<div class="col-md-6">
				<button class="btn btn-primary btn-block" onclick="result_report()"><i class="fa fa-search"  ></i> </button>
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
	var no_guia = document.getElementById('no_guia').value;


		$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('rastreador.show','id') }}",
		data:{no_guia:no_guia},
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
