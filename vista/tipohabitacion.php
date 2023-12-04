<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning collapsed-card shadow">
      <div class="card-header">
        <h3 class="card-title">Listado de Tipos de Habitaciones</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
          </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nombre</span>
              </div>
              <!-- Con el evento onkeyup puedes realizar la busquedad cada vez que escriba una letra onkeyup="verListado()" -->
              <input type="text" class="form-control" name="txtBusquedaNombre" id="txtBusquedaNombre" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-4 mt-3 mt-md-0">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Estado</span>
              </div>
              <select class="form-control" name="cboBusquedadEstado" id="cboBusquedadEstado" onchange="verListado()">
                <option value="">- Todos -</option>
                <option value="1">Activos</option>
                <option value="0">Anulados</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fas fa-search"></i> Buscar</button>
            <button type="button" class="btn btn-success" onclick="abrirModalTipoHabitacion()"><i class="fas fa-plus-circle"></i> Nuevo</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body">
        <div class="row">
        <!-- Mostrar los registro de tipo de habitacion -->
          <div class="col-md-12" id="divListadoTipoHabitacion">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <div class="modal fade" id="modalTipoHabitacion" class="modal-sm">
      <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header bg-lightblue">
                  <h5 class="modal-title">Tipo de Habitacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <form name="formTipoHabitacion" id="formTipoHabitacion">
                    <div class="row">
                        <!-- <div class="col-md-2"></div> -->
                        <div class="col-md-12">
                          <div class="form-group">
                          <label for="nombre">Nombre</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del tipo de habitación">
                          <input type="hidden" name="idTipoHabitacion" id="idTipoHabitacion" value="">
                          </div>
                          <div class="form-group">
                          <label for="precio">Precio</label>
                          <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio en Bolivianos">
                          </div>
                          <div class="form-group" style="display: none;">
                          <label for="estado">Estado</label>
                          <select name="estado" id="estado" class="form-control">
                            <option value="1">ACTIVO</option>
                            <option value="0">ANULADO</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </form>

                </div>
                <div class="modal-footer justify-content-around">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                  <button type="button" class="btn btn-primary" onclick="guardarTipoHabitacion()" ><i class="fa fa-save"></i> Registrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
  </div>
  
<script>
  
  function verListado(){
    $.ajax({
      method: "POST",
      url: "vista/tipohabitacion_listado.php",
      data:{
        nombre: $('#txtBusquedaNombre').val(),
        estado: $('#cboBusquedadEstado').val()
      }
    })
    .done(function(resultado){
      $('#divListadoTipoHabitacion').html(resultado);
    })
  }

  verListado();

  function guardarTipoHabitacion(){
    if(validarFormulario()){
      var datos = $('#formTipoHabitacion').serializeArray();
      var idTipoHabitacion = $('#idTipoHabitacion').val();
      if(idTipoHabitacion!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }else{
        datos.push({name: "accion", value: "NUEVO"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contTipoHabitacion.php",
        data: datos,
        dataType: 'json'
      })
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          $('#modalTipoHabitacion').modal('hide');
          $('#formTipoHabitacion').trigger('reset');
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
  }

  function validarFormulario(){
    let correcto = true;
    let nombre = $('#nombre').val();

    if(nombre==""){
      toastError('Ingrese un nombre de tipo de habitacion')
      correcto = false;
    }

    return correcto;
  }

  function abrirModalTipoHabitacion(){
    $('#formTipoHabitacion').trigger('reset');
    $('#idTipoHabitacion').val("");
    $('#modalTipoHabitacion').modal('show');
  }
</script>