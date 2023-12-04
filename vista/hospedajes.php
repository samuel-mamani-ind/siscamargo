<?php
  require_once('../modelo/clsHospedaje.php');

  $objHosp = new clsHospedaje();

  $listaHabitacion = $objHosp->consultarHabitacion();
  $listaHabitacion = $listaHabitacion->fetchAll(PDO::FETCH_NAMED);


?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning collapsed-card shadow">
      <div class="card-header">
        <h3 class="card-title">Listado de Hospedajes</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
          </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Habitacion</span>
              </div>
              <input type="text" class="form-control" name="txtBusquedaHab" id="txtBusquedaHab" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Ingreso</span>
              </div>
              <input type="date" class="form-control " name="BusquedaFeIng" id="BusquedaFeIng" onchange="verListado()" >
            </div>
          </div>
          <div class="col-md-4">
          <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Salida</span>
              </div>
              <input type="date" class="form-control" name="BusquedaFeSal" id="BusquedaFeSal" onchange="verListado()" >
            </div>
          </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
              <div class="input-group input-group-sm">
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
              <button type="button" class="btn btn-primary btn-sm" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
              <button type="button" class="btn btn-success btn-sm" onclick="abrirmodalHospedaje()"><i class="fas fa-plus-circle"></i> Nuevo</button>
            </div>
          </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoHospedaje">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modalHospedaje" data-backdrop="static">
  <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-lightblue">
              <h4 class="modal-title">Datos del Hospedaje</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formHospedaje" id="formHospedaje">
                <input type="hidden" name="idhospedaje" id="idhospedaje" value="">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nom_huesped">Nombre y Apellidos</label>
                      <input type="text" class="form-control" id="nom_huesped" name="nom_huesped" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="procedencia">Procedencia</label>
                      <input type="text" class="form-control" id="procedencia" name="procedencia" placeholder="Residencia anterior">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="habitacion">Habitacion</label>
                      <select name="habitacion" id="habitacion" class="form-control">
                        <option value="">- Seleccione -</option>
                        <?php foreach($listaHabitacion as $k=>$v){ ?>
                          <option value="<?= $v['id_habitacion'] ?>"><?= $v['codigohabitacion'] . " - " . $v['tipohabitacion'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="feing">Fecha y Hora de Ingreso</label>
                      <input type="datetime-local" class="form-control" id="feing" name="feing">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fesal">Fecha y Hora de Salida</label>
                      <input type="datetime-local" class="form-control" id="fesal" name="fesal">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="obs">Observaciones</label>
                      <textarea class="form-control" rows="3" placeholder="Observaciones durante el hospedaje..." style="resize: none;" name="obs" id="obs"></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-around">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarHospedaje()" ><i class="fa fa-save"></i> Registrar</button>
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
      url: "vista/hospedajes_listado.php",
      data:{
        habitacion: $('#txtBusquedaHab').val(),
        fechaingreso: $('#BusquedaFeIng').val(),
        fechasalida: $('#BusquedaFeSal').val(),
        estado: $('#cboBusquedadEstado').val()
      }
    })
    .done(function(resultado){
      $('#divListadoHospedaje').html(resultado);
    })
  }

  verListado();

  function guardarHospedaje(){
    if(validarFormulario()){
      var datos = $('#formHospedaje').serializeArray();
      var idhospedaje = $('#idhospedaje').val();
      if(idhospedaje!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contHospedaje.php",
        data: datos,
        dataType: 'json'
      })
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          $('#modalHospedaje').modal('hide');
          $('#formHospedaje').trigger('reset');
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
  }

  function validarFormulario(){
    let correcto = true;
    let habitacion = $('#habitacion').val();

    $('.obligatorio').removeClass('is-invalid');

    if(habitacion==""){
      toastError('Seleccione un número de habitación');
      $('#habitacion').addClass('is-invalid');
      correcto = false;
    }

    return correcto;
  }

/*   function abrirmodalHospedaje(){
        $('#formHospedaje').trigger('reset');
        $('#idhospedaje').val("");
        $('#modalHospedaje').modal('show');
        $('.obligatorio').removeClass('is-invalid');
  } */

</script>