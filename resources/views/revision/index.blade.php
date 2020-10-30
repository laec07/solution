@extends('../layouts.app')

@section('content')

<div class="card card-primary">
	<div class="card-header">
		<h3>Revisión guias asignadas</h3>
	</div>
	<div class="card-body">
		<div id="show_datas" ></div>
	</div>
</div>



@endsection
@section('scripts')
<script>

function show_data() {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('revision.show','id') }}",
		data:{},
		success:function(data){
			$("#show_datas").html(data);

		}
	})
}
show_data();


function receiver(id,estado) {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('revision.update','id') }}",
		data:{id:id,estado:estado},
		success:function(data){

			show_data();
		}
	})
}


function traslate() {

	var id_mensajero = document.getElementById('id_mensajero').value;
	var no_guia = document.getElementById('no_guiaT').value;


	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'POST',
		url:"{{ route('revision.store','id') }}",
		data:{id_mensajero:id_mensajero,no_guia:no_guia},
		success:function(data){

			show_data();
		}
	})
}

//obtiene datos para mostrar en modal
$(document).on("click", "#btn_traslate", function(){
    var id = $(this).data("no_guia");

    //muestra datos en input formulario modal
    document.getElementById('no_guiaT').value=id;


})
</script>
@endsection



