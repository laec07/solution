            <div class="form-group">
              <label>Cuenta cliente</label>
              <select id="cuenta_cliente" class="form-control">
              	@foreach($cuentas as $cuenta)
              	<option value="{{$cuenta->id}}" >{{$cuenta->no_cuenta}} - {{ $cuenta->descripcion}} </option>
              	@endforeach
                
              </select>
            </div> 