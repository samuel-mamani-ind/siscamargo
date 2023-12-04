<?php
  require_once('../modelo/clsHuesped.php');

  $objHues = new clsHuesped();

  $listaTipoDocumento = $objHues->consultarTipoDocumento();
  $listaTipoDocumento = $listaTipoDocumento->fetchAll(PDO::FETCH_NAMED);

  $listaHabitacion = $objHues->consultarHabitacion();
  $listaHabitacion = $listaHabitacion->fetchAll(PDO::FETCH_NAMED);

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning collapsed-card shadow">
      <div class="card-header">
        <h3 class="card-title">Listado de Huespedes</h3>
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
                <span class="input-group-text">Nro</span>
              </div>
              <input type="nunber" class="form-control" name="txtBusquedaNroDoc" id="txtBusquedaNroDoc" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Documento</span>
              </div>
              <select class="form-control" name="cboBusquedadTipoDoc" id="cboBusquedadTipoDoc" onchange="verListado()">
                <option value="">- Todos -</option>
                <?php foreach($listaTipoDocumento as $k=>$v){ ?>
                <option value="<?= $v['id_tipodocumento'] ?>"><?= $v['nombre'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nombre</span>
              </div>
              <input type="text" class="form-control" name="txtBusquedaNombHue" id="txtBusquedaNombHue" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nacionalidad</span>
              </div>
              <select class="form-control" name="cboBusquedadNacionalidad" id="cboBusquedadNacionalidad" onchange="verListado()">
                <option value="">- Todos -</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row mt-3">
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
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
              <button type="button" class="btn btn-success" onclick="abrirModalHuesped()"><i class="fas fa-plus-circle"></i> Nuevo</button>
            </div>
          </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoHuesped">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modalHuesped" data-backdrop="static">
  <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-lightblue">
              <h4 class="modal-title">Datos del Huesped</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formHuesped" id="formHuesped">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nomhuesped">Nombre y Apellidos</label>
                      <input type="text" class="form-control" id="nomhuesped" name="nomhuesped" placeholder="Nombre(s) y apellidos">
                      <input type="hidden" name="idhuesped" id="idhuesped" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="profesion">Profesión</label>
                      <input type="text" class="form-control" id="profesion" name="profesion" placeholder="Ocupación">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nrodoc">Número de Documento</label>
                      <input type="text" class="form-control" id="nrodoc" name="nrodoc" placeholder="Número de identidad">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipodoc">Tipo de Documento</label>
                        <select name="tipodoc" id="tipodoc" class="form-control">
                          <option value="">- Seleccione -</option>
                          <?php foreach($listaTipoDocumento as $k=>$v){ ?>
                            <option value="<?= $v['id_tipodocumento'] ?>"><?= $v['nombre'] ?></option>
                          <?php } ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="nacionalidad">Nacionalidad</label>
                        <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="Boliviano">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fenac">Fecha de Nacimiento</label>
                      <input type="date" class="form-control" id="fenac" name="fenac">
                    </div>
                  </div>
                </div>
                <div id="inf-hospedaje">
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
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-around">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarHuesped()" ><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalHospedar" data-backdrop="static">
  <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-lightblue">
              <h4 class="modal-title">Datos del Hospedaje</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formHospedar" id="formHospedar">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nom_huesped">Nombre y Apellidos</label>
                      <input type="text" class="form-control" id="nom_huesped" name="nom_huesped" disabled>
                      <input type="hidden" name="id_huesped" id="id_huesped">
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
                      <label for="habhospedar">Habitacion</label>
                      <select name="habhospedar" id="habhospedar" class="form-control">
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
      url: "vista/huespedes_listado.php",
      data:{
        nroDoc: $('#txtBusquedaNroDoc').val(),
        tipoDoc: $('#cboBusquedadTipoDoc').val(),
        nomHue: $('#txtBusquedaNombHue').val(),
        estado: $('#cboBusquedadEstado').val()
      }
    })
    .done(function(resultado){
      $('#divListadoHuesped').html(resultado);
    })
  }

  verListado();

  function guardarHuesped(){
    if(validarFormulario()){
      var datos = $('#formHuesped').serializeArray();
      var idhuesped = $('#idhuesped').val();
      if(idhuesped!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }else{
        datos.push({name: "accion", value: "NUEVO"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contHuesped.php",
        data: datos,
        dataType: 'json'
      })
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          $('#modalHuesped').modal('hide');
          $('#formHuesped').trigger('reset');
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
  }

  function validarFormulario(){
    let correcto = true;
    let nrodoc = $('#nrodoc').val();

    $('.obligatorio').removeClass('is-invalid');

    if(nrodoc==""){
      toastError('Ingrese el número de documento del huesped');
      $('#nrodoc').addClass('is-invalid');
      correcto = false;
    }

    return correcto;
  }

  function abrirModalHuesped(){
        $('#formHuesped').trigger('reset');
        $('#idhuesped').val("");
        $('#modalHuesped').modal('show');
        $('#nrodoc').removeClass('is-invalid');

				$('#inf-hospedaje').removeClass('d-none');
  }

  function validarFormularioHospedaje(){
    let correcto = true;
    let habitacion = $('#habhospedar').val();

    $('.obligatorio').removeClass('is-invalid');

    if(habitacion==""){
      toastError('Seleccione una habitacion para el huesped');
      $('#habhospedar').addClass('is-invalid');
      correcto = false;
    }

    return correcto;
  }

  function guardarHospedaje(){
    if(validarFormularioHospedaje()){
      var datos = $('#formHospedar').serializeArray();
      var id_huesped = $('#id_huesped').val();
      if(id_huesped!=""){
        datos.push({name: "accion", value: "NUEVO_HOSPEDAJE"});
      }

      $.ajax({
        method: "POST",
        url: "controlador/contHuesped.php",
        data: datos,
        dataType: 'json'
      })
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          $('#modalHospedar').modal('hide');
          $('#formHospedar').trigger('reset');
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
  }

</script>