 <div class="container">
    
      <button 
        type="button" 
        class="btn btn-primary float-right" 
        data-toggle="modal"
        id="btn_NuevoItem" 
        data-target="#NuevoItem"
        data-user_id="{{$result->user_id}}"
        >
        <i class="fa fa-plus"></i> 
      Agregar 
    </button> 

 </div>

{!! Form::open(['url' => 'envios.detalle']) !!}
{{Form::token()}} 
<div class="modal fade" id="NuevoItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingrese datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" tabindex="-1">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_ingreso">
          @csrf
          <input type="hidden" id="usuario_id">

          <div id="dest_f" class="form-group">
            <label>Destinatario:</label>
            <input class="form-control" type="text" name="destinatario" id="destinatario" maxlength="100"  tabindex="1" >
            <span style="display: none; color:red;" class="form-text" id="dest_error"></span>
          </div>
          <div id="tel_f" class="form-group">
            <label>Telefono:</label>
            <input class="form-control" id="telefono" name="telefono" type="text" maxlength="20" tabindex="2"></input>
            <span style="display: none; color:red;" class="form-text" id="tel_error"></span>
          </div>
          <div id="dirr_f" class="form-group">
            <label>Dirección:</label>
            <input class="form-control" type="text" name="direccion" id="direccion" maxlength="200" tabindex="3">
            <span style="display: none; color:red;" class="form-text" id="dirr_error"></span>
          </div>
       <!--   <div class="form-group">
            <label>Piezas:</label>
            <input class="form-control" type="number" name="piezas" id="piezas" step="1">
          </div>-->
          <div id="total_f" class="form-group">
            <label>Total:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  Q
                </span>
              </div>
              <input type="number" class="form-control" name="total_paquete" id="total_paquete" step="0.01" tabindex="4">
            </div>
            <span style="display: none; color:red;" class="form-text" id="total_error"></span>
          </div>
          <div class="form-group">
            <label>Fecha entrega:</label>
            <input  class="form-control" type="date" name="fecha_entrega" id="fecha_entrega" value="{{ date('Y-m-d') }}" tabindex="5">
          </div>
          <div class="form-group">
            <label>Observaciones:</label>
            <textarea class="form-control" id="observaciones" tabindex="6"></textarea>
          </div>

                  
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary"  onclick="saveItem()" tabindex="7" accesskey="g">Guardar</button>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}




