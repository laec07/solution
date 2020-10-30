 <div class="container">
   <h2> 
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" id="btn_new" data-target="#Nuevo"><i class="fa fa-plus"></i> Agregar</button> 
    </h2>
 </div>


<div class="modal fade" id="Nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" id="nombre" class="form-control" maxlength="200">
          </div>

          <div class="form-group">
            <label>Direción</label>
            <input type="text" id="direccion" class="form-control" maxlength="200">
          </div>
          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" id="telefono" class="form-control" maxlength="20">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" id="email" class="form-control" maxlength="100">
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
        <button type="button" onclick="saveRecord()" data-dismiss="modal" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
