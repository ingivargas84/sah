<!-- Modal -->
<div class="modal fade" id="modalAsignaUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form method="POST" id="AsignaForm">
      {{--{{ method_field('put') }}--}}

    <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Asignar Usuario</h4>
            </div>

            <div class="modal-body">

              <div class="row">     
                <div class="form-group col-sm-12 {{ $errors->has('usuarios') ? 'has-error': '' }}">
                  <label for="usuarios">Usuario:</label>
                  <select class="form-control" name="usuarios" title="Seleccione" id="usuarios_id">
                  </select>
                  {!! $errors->first('usuarios', '<span class="help-block">:message</span>') !!}
                </div>
              </div>

              <input type="hidden" name="_token" id="tokenAsignar" value="{{ csrf_token() }}">
              <input type="hidden" name="id">
              <input type="hidden" name="user_id">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btnAsignaModal" >Asignar</button>
            </div>
          </div>
    </div>
  </form>
</div>

@push('scripts')
  <script>
    function cargarSelectUser(){
    $('#usuarios_id').empty();
    $("#usuarios_id").append('<option value="" selected>Seleccione Usuario</option>');
    var user_id = $("input[name='user_id']").val();
    $.ajax({
      type: "GET",
      url: "{{route('users.cargar')}}", 
      dataType: "json",
      data: "user_id=" + user_id,
      success: function(data){
        $.each(data,function(key, registro) {
          if(registro.id == user_id){
          $("#usuarios_id").append('<option value='+registro.id+' selected>'+registro.name+'</option>');
          
          }else{
          $("#usuarios_id").append('<option value='+registro.id+'>'+registro.name+'</option>');
          }	

        });
    
      },
      error: function(data) {
        alert('error');
      }
      });
      }
  </script>
@endpush