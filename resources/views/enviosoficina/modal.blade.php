 <div class="container">
   <h2> 
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#NuevoEnvio"><i class="fa fa-plus" id="btn_primary"></i> Agregar</button> 
    </h2>
 </div>

{!! Form::open(['url' => 'enviosoficina']) !!}
{{Form::token()}} 
<div class="modal fade" id="NuevoEnvio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccione cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label>Cliente:</label>
            <select name="id_cliente" id="id_cliente" class="form-control" >
              <option>Seleccione</option>
              @foreach($clientes as $cliente)
              <option value=" {{$cliente->id}} " >{{$cliente->nombre}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Mensajero:</label>
            <select id="id_mensajero" name="id_mensajero" class="form-control">
              <option>Seleccione mensajero</option>
              @foreach($mensajeros as $mensajero)
              <option value="{{$mensajero->id}}" >{{$mensajero->name}}</option>
              @endforeach

            </select>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Iniciar</button>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}