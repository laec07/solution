
<!DOCTYPE html>
<html>
<head>
	
	 <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<title>Envios SolutionExpress</title>
</head>
<body >
<style type="text/css">
	@media print{
  .ocultar-al-imprimir {
    display:none;
  }
}
</style>

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-3">
				@foreach($result_envio as $data)
				<p> <b>Envío no.</b><input type="hidden" name="id_envio" id="id_envio" value="{{$data->no_envio}}"> {{$data->no_envio}}<br>
					<b>Fecha: {{ date('d/m/Y', strtotime($data->created_at) ) }} </b>
				<br>
					@foreach($clientes as $cliente)
			        	@if($data->id_cliente == $cliente->id)
			        	<b> Cliente: </b>{{$cliente->nombre}}<br>
			        	<b>Dirección: </b>{{$cliente->direccion}}
			        	@endif 
					@endforeach
				</p>
				@endforeach
			</div>
			<div class="col-md-6" style="text-align: center" >
				<p>SOLUTION EXPRESS <br> 31 Av. 14-33 Zona 7 Ciudad de plata II<br>
				Guatemala, Guatemala<br>
				Tels: 2434-9652  2434-9471</p>
			</div>
			<div class="col-md-3">
				<img src="{{asset('dist/img/SolutionExpLogo.png')}}" alt="SolutionExpress" 
           >				
			</div>
		</div>
		
	</div>

	<div class="row ocultar-al-imprimir">

		<div class="col-md-6">
			<button class="btn btn-warning btn-block" onclick="imprimir() " ><i class="fas fa-print"></i></button>
		</div>
		<div class="col-md-6">
			<a href="{{url('envios')}}" class="btn btn-secondary btn-block"><i class="fas fa-undo"></i></a >
			
		</div>
	</div>
	


	<div class="card-body">

	</div>
	<div class="card-footer">
		<div class="table-responsive">
			<table class="table  table-hover" >
				<thead class="table-primary">
					<tr>
						<th style="width: 10px" >No.</th>
						<th>Datos Guia</th>
						<th  >Total</th>
						<th  >Observaciones</th>
						
					</tr>
				</thead>
				@php
					$a=0;
					$b=1;
				@endphp
				
			@foreach($detalle_envio as $value)
				<tbody>
					<tr>
						<td>{{$b}}</td>
						<td><b>No. {{$value->no_guia}}</b><br>
							<small><b>Destinatario: </b>{{$value->destinatario}}</small><br>
							<small><b>Telefóno:</b> {{$value->telefono}}</small><br>
							<small><b>Dirección:</b> {{$value->direccion}} </small><br>
							<small><b>Fecha entrega</b> {{date('d/m/Y', strtotime($value->fecha_entregar))}}</small>
						</td>
						<td>Q{{ number_format($value->total_paquete,2) }}</td>
						<td>{{$value->observaciones}}</td>

					</tr>
				</tbody>
				@php
					$a+=$value->total_paquete;
					$b+=1;
				@endphp
				
			@endforeach
				<tfoot class="table-primary">
					<tr>
						<th colspan="2" >Total:</th>
						<th colspan="3">Q {{ number_format($a,2)  }} </th>
					</tr>
				</tfoot>

			</table>
		</div>
	</div>
</div>

<script>
	
function imprimir() {
	window.print();
}

</script>

</body>
</html>



