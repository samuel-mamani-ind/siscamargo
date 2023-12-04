<?php
    require_once('../modelo/clsTipoHabitacion.php');
  require_once('../modelo/clsHabitacion.php');

    $objTipoHabitacion = new clsTipoHabitacion();

    $listaTipoHabitacion = $objTipoHabitacion->listarTipoHabitacion('','1');
    $listaTipoHabitacion = $listaTipoHabitacion->fetchAll(PDO::FETCH_NAMED);

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning collapsed-card shadow">
      <div class="card-header">
        <h3 class="card-title">Listado de Habitaciones</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Habitacion</span>
              </div>
              <!-- Con el evento onkeyup puedes realizar la busquedad cada vez que escriba una letra onkeyup="verListado()" -->
              <input type="text" class="form-control" name="txtBusquedaHabitacion" id="txtBusquedaHabitacion" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Tipo de Habitacion</span>
              </div>
              <select class="form-control" name="cboBusquedadTipoHabitacion" id="cboBusquedadTipoHabitacion" onchange="verListado()">
                <option value="">- Todos -</option>
                <?php foreach($listaTipoHabitacion as $k=>$v){ ?>
                <option value="<?= $v['id_tipohabitacion'] ?>"><?= $v['nombre'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
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
          <div class="col-md-3">
            <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
            <button type="button" class="btn btn-success" onclick="abrirModalHabitacion()"><i class="fa fa-plus"></i> Nuevo</button>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoHabitacion">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modalHabitacion">
  <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-lightblue">
              <h4 class="modal-title">Datos de la Habitacion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formHabitacion" id="formHabitacion">
                    <div class="form-group">
                      <label for="codigo">Habitacion</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Número de la habitación">
                      <input type="hidden" name="idhabitacion" id="idhabitacion">
                    </div>
                    <div class="form-group">
                      <label for="idTipoHabitacion">Tipo Habitacion</label>
                      <select name="idTipoHabitacion" id="idTipoHabitacion" class="form-control">
                          <option value="">- Seleccione -</option>
                          <?php foreach($listaTipoHabitacion as $k=>$v){ ?>
                            <option value="<?= $v['id_tipohabitacion'] ?>"><?= $v['nombre'] ?></option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="estado">Estado</label>
                      <select name="estado" id="estado" class="form-control">
                        <option value="1">ACTIVO</option>
                        <option value="0">ANULADO</option>
                      </select>
                    </div>
              </form>
            </div>
            <div class="modal-footer justify-content-around">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarHabitacion()" ><i class="fa fa-save"></i> Registrar</button>
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
      url: "vista/habitaciones_listado.php",
      data:{
        estado: $('#cboBusquedadEstado').val(),
        idtipohabitacion: $('#cboBusquedadTipoHabitacion').val(),
        habitacion: $('#txtBusquedaHabitacion').val()
      }
    })
    .done(function(resultado){
      $('#divListadoHabitacion').html(resultado);
    })
}

verListado();

function guardarHabitacion(){
    if(validarFormulario()){
      var datos = $('#formHabitacion').serializeArray();
      var idhabitacion = $('#idhabitacion').val();
      if(idhabitacion!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }else{
        datos.push({name: "accion", value: "NUEVO"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contHabitaciones.php",
        data: datos,
        dataType: 'json'
      })
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          $('#modalHabitacion').modal('hide');
          $('#formHabitacion').trigger('reset');
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
}

  function validarFormulario(){
    let correcto = true;
    let codigo = $('#codigo').val();
    let idTipoHabitacion = $('#idTipoHabitacion').val();

    $('.obligatorio').removeClass('is-invalid');

    if(codigo==""){
      toastError('Ingrese el codigo de la habitacion');
      $('#codigo').addClass('is-invalid');
      correcto = false;
    }else if(idTipoHabitacion==0){
      toastError('Seleccione un tipo de habitacion');
      $('#idTipoHabitacion').addClass('is-invalid');
      correcto = false;
    }else{
      $('#idTipoHabitacion').removeClass('is-invalid');
    }

    return correcto;
  }

  function abrirModalHabitacion(){
        $('#formHabitacion').trigger('reset');
        $('#idhabitacion').val("");
        $('#modalHabitacion').modal('show');
        $('.obligatorio').removeClass('is-invalid');
  }

</script>