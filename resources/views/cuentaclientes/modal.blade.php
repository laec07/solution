 <div class="container">
   <h2> 
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#Nuevo"><i class="fa fa-plus"></i> Agregar</button> 
    </h2>
 </div>


<div class="modal fade" id="Nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cuentas cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label>Cliente</label>
            <select class="form-control" id="id_cliente" >
              @foreach($clientes as $cliente)
              <option value="{{$cliente->id}}" >{{$cliente->nombre}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>No. Cuenta</label>
            <input type="text" id="no_cuenta" class="form-control" maxlength="100" placeholder="000-0000-00" >
          </div>
          <div class="form-group">
            <label>Banco</label>
            <select class="form-control" id="id_banco" >
              @foreach($bancos as $banco)
              <option value="{{$banco->id}}" >{{$banco->descripcion}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Tipo</label>
            <select class="form-control" id="tipo" >
              <option>MONETARIA</option>
              <option>AHORRO</option>
            </select>
          </div>
          <div class="form-group">
            <label>Estado</label>
            <select name="estado" id="estado" class="form-control" >
              <option value="A">ACTIVO</option>
              <option value="I">INACTIVO</option>
            </select>
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" onclick="saveRecord()" class="btn btn-primary" data-dismiss="modal" id="btn_new" >Guardar</button>
      </div>
    </div>
  </div>
</div>