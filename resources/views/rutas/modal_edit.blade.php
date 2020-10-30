

<div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="id">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" id="nombre_e" class="form-control" maxlength="100">
          </div>
          <div class="form-group">
            <label>Descripción</label>
            <input type="text" id="descripcion_e" class="form-control" maxlength="200">
          </div>
          <div class="form-group">
            <label>Estado</label>
            <select name="estado" id="estado_e" class="form-control" >
              <option value="A">Activo</option>
              <option value="I">Inactivo</option>
            </select>
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" onclick="EditRecord()" data-dismiss="modal" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
