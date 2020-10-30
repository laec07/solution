@extends('../layouts.app')

@section('content')
@include('rutas.modal_edit')

<div class="card card-primary">
	<div class="card-header">
		<h3>Rutas - mantenimiento</h3>
	</div>
	<div class="card-body">

	@include('rutas.modal')	
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
		url:"{{ route('rutas.show','id') }}",
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
	var nombre = document.getElementById('nombre').value
	var descripcion = document.getElementById('descripcion').value
	var estado = document.getElementById('estado').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'POST',
		url:"{{ route('rutas.store','id') }}",
		data:{nombre:nombre,descripcion:descripcion,estado:estado},
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
    var nombre = $(this).data("nombre");
    var descripcion = $(this).data("descripcion");

    var estado = $(this).data("estado");


    //carga datos a DOM
    document.getElementById('id').value=id;
    document.getElementById('nombre_e').value=nombre;
    document.getElementById('descripcion_e').value=descripcion;
    document.getElementById('estado_e').value=estado;



})
//Limpia campos al cargar modal nuevo
$(document).on("click", "#btn_new", function(){

limpiacamposinsert()

})

function limpiacamposinsert() {

	document.getElementById('id').value='';
	document.getElementById('nombre').value='';
	document.getElementById('descripcion').value='';
	document.getElementById('estado').value='A';

}

//EDITA registro
function EditRecord() {
	var id = document.getElementById('id').value
	var nombre = document.getElementById('nombre_e').value
	var descripcion = document.getElementById('descripcion_e').value
	var estado = document.getElementById('estado_e').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('rutas.update','id') }}",
		data:{nombre:nombre,descripcion:descripcion,estado:estado,id:id},
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
        text: "¿Continuar con la eliminación de ruta?",
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
			url:"{{ route('rutas.destroy','id') }}",
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