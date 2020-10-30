@extends('../layouts.app')

@section('content')
@include('cuentaclientes.modal_edit')
<div class="card card-primary">
	<div class="card-header">
		<h3>Cuentas clientes - mantenimiento</h3>
	</div>
	<div class="card-body">

	@include('cuentaclientes.modal')	
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
		url:"{{ route('cuentaclientes.show','id') }}",
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
show_data()
//Guarda nuevo registro
function saveRecord() {
if (true) {}
	var id_cliente = document.getElementById('id_cliente').value
	var no_cuenta = document.getElementById('no_cuenta').value
	var id_banco = document.getElementById('id_banco').value
	var tipo = document.getElementById('tipo').value
	var estado = document.getElementById('estado').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'POST',
		url:"{{ route('cuentaclientes.store','id') }}",
		data:{id_cliente:id_cliente,no_cuenta:no_cuenta,id_banco:id_banco,tipo:tipo,estado:estado},
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
    var id_cliente = $(this).data("id_cliente");
    var no_cuenta = $(this).data("no_cuenta");
    var id_banco = $(this).data("id_banco");
    var tipo = $(this).data("tipo");
    var estado = $(this).data("estado");

    //carga datos a DOM
    document.getElementById('id').value=id;
    document.getElementById('id_cliente_e').value=id_cliente;
    document.getElementById('no_cuenta_e').value=no_cuenta;
    document.getElementById('id_banco_e').value=id_banco;
    document.getElementById('tipo_e').value=tipo;
    document.getElementById('estado_e').value=estado;

})
//Limpia campos al cargar modal nuevo
$(document).on("click", "#btn_new", function(){

limpiacamposinsert()

})

function limpiacamposinsert() {

	document.getElementById('no_cuenta').value='';
	document.getElementById('estado').value='A';

}

//EDITA registro
function EditRecord() {
	var id = document.getElementById('id').value
	var id_cliente = document.getElementById('id_cliente_e').value
	var no_cuenta = document.getElementById('no_cuenta_e').value
	var id_banco = document.getElementById('id_banco_e').value
	var tipo = document.getElementById('tipo_e').value
	var estado = document.getElementById('estado_e').value

	$.ajax({
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		type:'PUT',
		url:"{{ route('cuentaclientes.update','id') }}",
		data:{id_cliente:id_cliente,no_cuenta:no_cuenta,id_banco:id_banco,tipo:tipo,estado:estado,id:id},
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
        text: "¿Continuar con la eliminación de cuenta?",
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
			url:"{{ route('cuentaclientes.destroy','id') }}",
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