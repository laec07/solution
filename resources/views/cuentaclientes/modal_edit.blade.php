

<div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <input type="hidden" id="id">
          <div class="form-group">
            <label>Cliente</label>
            <select class="form-control" id="id_cliente_e" >
              @foreach($clientes as $cliente)
              <option value="{{$cliente->id}}" >{{$cliente->nombre}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>No. Cuenta</label>
            <input type="text" id="no_cuenta_e" class="form-control" maxlength="100" placeholder="000-0000-00" >
          </div>
          <div class="form-group">
            <label>Banco</label>
            <select class="form-control" id="id_banco_e" >
              @foreach($bancos as $banco)
              <option value="{{$banco->id}}" >{{$banco->descripcion}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Tipo</label>
            <select class="form-control" id="tipo_e" >
              <option>MONETARIA</option>
              <option>AHORRO</option>
            </select>
          </div>
          <div class="form-group">
            <label>Estado</label>
            <select name="estado" id="estado_e" class="form-control" >
              <option value="A">ACTIVO</option>
              <option value="I">INACTIVO</option>
            </select>
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" onclick="EditRecord()" class="btn btn-primary" data-dismiss="modal"  >Guardar</button>
      </div>
    </div>
  </div>
</div>