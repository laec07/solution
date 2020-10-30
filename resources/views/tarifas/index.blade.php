@extends('../layouts.app')

@section('content')
@include('tarifas.modal_edit')

<div class="card card-primary">
	<div class="card-header">
		<h3>Tarifas - mantenimiento</h3>
	</div>
	<div class="card-body">

	@include('tarifas.modal')	
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
//función que trae cuenta de cliente
function show_data() {

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'GET',
		url:"{{ route('tarifas.show','id') }}",
		data:{},
        beforeSend: function(){
          $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
          
        },
		success:function(data){
			//alert('Nitido');
			$("#show_data").html(data);
		}
	})
}
show_data();
//Guarda nuevo registro
function saveRecord() {
	var total = document.getElementById('total').value
	var descripcion = document.getElementById('descripcion').value
	var estado = document.getElementById('estado').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'POST',
		url:"{{ route('tarifas.store','id') }}",
		data:{total:total,descripcion:descripcion,estado:estado},
        beforeSend: function(){
          $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
          
        },
		success:function(data){
			
			show_data()

					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000,
					  timerProgressBar: true,
					  didOpen: (toast) => {
					    toast.addEventListener('mouseenter', Swal.stopTimer)
					    toast.addEventListener('mouseleave', Swal.resumeTimer)
					  }
					})

					Toast.fire({
					  icon: 'success',
					  title: 'Registro ingresado correctamente'
					})
		}
	})

}

//trae datos para modal edición 
$(document).on("click", "#btn_edit", function(){

	//obtiene dataset
    var id = $(this).data("id");
    var total = $(this).data("total");
    var descripcion = $(this).data("descripcion");

    var estado = $(this).data("estado");


    //carga datos a DOM
    document.getElementById('id').value=id;
    document.getElementById('total_e').value=total;
    document.getElementById('descripcion_e').value=descripcion;
    document.getElementById('estado_e').value=estado;



})
//Limpia campos al cargar modal nuevo
$(document).on("click", "#btn_new", function(){

limpiacamposinsert()

})

function limpiacamposinsert() {

	document.getElementById('id').value='';
	document.getElementById('total').value='';
	document.getElementById('descripcion').value='';
	document.getElementById('estado').value='A';

}

//EDITA registro
function EditRecord() {
	var id = document.getElementById('id').value
	var total = document.getElementById('total_e').value
	var descripcion = document.getElementById('descripcion_e').value
	var estado = document.getElementById('estado_e').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('tarifas.update','id') }}",
		data:{total:total,descripcion:descripcion,estado:estado,id:id},
        beforeSend: function(){
          $("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
          
        },
		success:function(data){
			
			show_data()

					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000,
					  timerProgressBar: true,
					  didOpen: (toast) => {
					    toast.addEventListener('mouseenter', Swal.stopTimer)
					    toast.addEventListener('mouseleave', Swal.resumeTimer)
					  }
					})

					Toast.fire({
					  icon: 'success',
					  title: 'Registro actualizado correctamente'
					})
		}
	})

}

// Elimina cliente
function DeleteRecord(id) {


Swal
    .fire({
        title: "Confirmar",
        text: "¿Continuar con la eliminación de tarifa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    })
    .then(resultado => {
        if (resultado.value) {
            // Hicieron click en "Sí"

		$.ajax({
			headers: { 'X-CSRF-TOKEN': $	('meta[name="csrf-token"]').attr('content') },
			type:'DELETE',
			url:"{{ route('tarifas.destroy','id') }}",
			data:{id:id},
			beforeSend: function(){
          		$("#show_data").html("<img src = '{{asset('dist/img/loading4.gif')}}' width='50px'  >");
        },
			success:function(data){
				show_data()
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000,
					  timerProgressBar: true,
					  didOpen: (toast) => {
					    toast.addEventListener('mouseenter', Swal.stopTimer)
					    toast.addEventListener('mouseleave', Swal.resumeTimer)
					  }
					})

					Toast.fire({
					  icon: 'error',
					  title: 'Registro eliminado correctamente'
					})
			}		
		})
        } else {
            // Dijeron que no
            
        }
	});
}	
</script>
@endsection