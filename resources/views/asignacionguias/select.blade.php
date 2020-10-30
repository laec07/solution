<div class="row">
	<div class="col-md-3">
		
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<select class="form-control select2" id="select_guia" tabindex="1">
				@foreach($detalle_envios as $value)
				<option value="{{$value->no_guia}}">{{$value->no_guia}}</option>
				@endforeach
			</select>			
		</div>

		
	</div>
	<div class="col-md-2">
		<button class="btn btn-primary btn-block" id="btn_asign" tabindex="2"><i class="fa fa-plus" ></i> Agregar  </button>
	</div>
	<div class="col-md-4">
		
	</div>
</div>

<script>
	  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
})
</script>