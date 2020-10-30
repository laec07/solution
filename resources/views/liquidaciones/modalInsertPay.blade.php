

{!! Form::open(['url' => 'liquidaciones.index']) !!}
{{Form::token()}} 
<div class="modal fade" id="InsertPay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar pago <br><span id="info_cliente"></span> || Envío No. <span id="info_envio"></span>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_ingreso">
          @csrf
          <input type="hidden" name="no_envio_p" id="no_envio_p" >
          <input type="hidden" name="id_cliente_p" id="id_cliente_p" >

          <div class="row" id="total_l">
            <div class="col-md-6">
              <div  class="form-group">
                <label>Total a liquidar:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      Q
                    </span>
                  </div>
                  <input type="number" class="form-control" name="total_liquidar_p" id="total_liquidar_p" step="0.01" readonly="">
                </div>
                
              </div>             
            </div>
            <div class="col-md-6">
              <div id="total_f" class="form-group">
                <label>Saldo:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      Q
                    </span>
                  </div>
                  <input type="number" class="form-control" name="total_saldo" id="total_saldo" step="0.01" readonly="">
                </div>
              </div>               
            </div>
            <div class="form-group">
             <span style="display: none; color:red;" class="form-text text-center" id="total_lerror"></span> 
            </div>
            
          </div>


          <div id="total_P" class="form-group">
            <label>Total pago:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  Q
                </span>
              </div>
              <input type="number" class="form-control" name="total_pago" id="total_pago" value="0" step="0.01" onkeyup="calcsaldo()" >
            </div>
            <span style="display: none; color:red;" class="form-text" id="totalP_error"></span>
          </div>

          <div class="form-group" >
            <label>Tipo pago:</label>
            <select id="tipo_pago" class="form-control" onchange="val_tpago()">
              @foreach($tipo_pagos as $tipo_pago)
              <option value="{{$tipo_pago->id}}" @if($tipo_pago->id==3) selected="selected" @endif >{{$tipo_pago->descripcion}}</option>
              @endforeach
            </select>
          </div>

        <div id="bancario">
        
          <div id="show_cuenta">
          
          </div>

          <div class="form-group">
            <label>No. documento</label>
            <input type="text" name="no_documento" maxlength="20" id="no_documento" class="form-control">
            <span style="display: none; color:red;" class="form-text" id="nodoc_error"></span>
          </div>

          <div class="form-group">
            <label>Fecha documento:</label>
            <input  class="form-control" type="date" name="fecha_documento" id="fecha_documento" value="{{ date('Y-m-d') }}">
          </div>

        </div>

          <div class="form-group">
            <label>Observaciones:</label>
            <textarea class="form-control" id="observaciones" maxlength="500"></textarea>
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