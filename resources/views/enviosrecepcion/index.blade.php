@extends('../layouts.app')

@section('content')

<div class="card card-primary">
	<div class="card-header">
		<h3>Guías pendientes de recepción <small> <span class="badge badge-light" id="notify"></span></small></h3>

	</div>
	<div class="card-body">
		<div id="show_data"></div>
	</div>
</div>






@endsection

@section('scripts')
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}" defer ></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}" defer ></script>
<script>

function show_alert() {
	a = document.getElementById('vbutton').value

	$("#notify").text(a);
}

function show_data() {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('enviosrecepcion.show','id') }}",
		data:{},
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
			show_alert()
			
		}
	})
}
show_data();

function receiver(id,estado,no_envio) {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('enviosrecepcion.update','id') }}",
		data:{id:id,estado:estado,no_envio:no_envio},
		success:function(data){

			show_data();
		}
	})
}
</script>

@endsection