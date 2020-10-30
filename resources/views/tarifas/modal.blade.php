<div class="container">
   <h2> 
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#Nuevo"><i class="fa fa-plus"></i> Agregar</button> 
    </h2>
 </div>


<div class="modal fade" id="Nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos tarifa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label>Descripción</label>
            <input type="text" id="descripcion" class="form-control" maxlength="200">
          </div>

          <div class="form-group">
            <label>Total</label>
            <input type="text" id="total" class="form-control" maxlength="100">
          </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado" id="estado" class="form-control" >
              <option value="A">Activo</option>
              <option value="I">Inactivo</option>
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
