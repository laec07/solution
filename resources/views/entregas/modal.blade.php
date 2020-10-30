

{!! Form::open(['url' => 'entregas.detalle']) !!}
{{Form::token()}} 
<div class="modal fade" id="SaveShipping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle entrega Guia no. <span  id="txt_no_guia"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- almacena no guia para guardar datos bajo este ID--> 
        <input type="hidden" name="" id="dev_e">
      <input type="hidden" name="no_guia_e" id="no_guia_e">
        <form id="frm_ingreso">
          @csrf
          <div id="tel_f" class="form-group">
            <label>Estado:</label>
            <select id="estado" class="form-control" onchange="tipo_es();">
              @foreach($movimientos as $movimiento)
                <option value="{{$movimiento->id}}" >{{$movimiento->descripcion}}</option>
              @endforeach
            </select>
            <span style="display: none; color:red;" class="form-text" id="estado_error"></span>
          </div>
          <div id="recib_f" class="form-group">
            <label>Recibe:</label>
            <input class="form-control" type="text" name="recibe" id="recibe" maxlength="100">
            <span style="display: none; color:red;" class="form-text" id="recib_error"></span>
          </div>
          <div id="t_pago" class="form-group">
            <label>Tipo pago:</label>
            <select id="tipo_pago" class="form-control"> 
              <option value="1">Efectivo</option>
              <option value="2">Transferencia</option>
              <option value="3">Otros</option>
            </select>
          </div>
          <div id="obs_f" class="form-group">
            <label>Observaciones:</label>
            <textarea class="form-control" id="observaciones" maxlength="500"></textarea>
            <span style="display: none; color:red;" class="form-text" id="obs_error"></span>
          </div>
      
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary"  onclick="saveItem()">Guardar</button>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}