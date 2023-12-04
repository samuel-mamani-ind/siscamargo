<?php

  require_once('../modelo/clsHuesped.php');

  $objHues = new clsHuesped();

    $listaTipoDocumento = $objHues->consultarTipoDocumento();
    $listaTipoDocumento = $listaTipoDocumento->fetchAll(PDO::FETCH_NAMED);

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning collapsed-card shadow">
      <div class="card-header">
        <h3 class="card-title">Historial de Hospedaje</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Nro</span>
              </div>
              <input type="nunber" class="form-control" name="txtBusquedaNroDoc" id="txtBusquedaNroDoc" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
          <div class="input-group input-group-sm">
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
          <div class="col-md-3">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Ingreso</span>
              </div>
              <input type="date" class="form-control " name="BusquedaFeIng" id="BusquedaFeIng" onchange="verListado()" >
            </div>
          </div>
          <div class="col-md-3">
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
                <span class="input-group-text">Hora de Ingreso</span>
              </div>
              <input type="time" class="form-control " name="BusquedaHoraIng" id="BusquedaHoraIng" onchange="verListado()">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Hora de Salida</span>
              </div>
              <input type="time" class="form-control" name="BusquedaHoraSal" id="BusquedaHoraSal" onchange="verListado()" >
            </div>
          </div>
<!--           <div class="col-md-4">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text">Filtro automático</span>
              </div>
              <select class="form-control" name="cboBusquedadEstado" id="cboBusquedadEstado" onchange="verListado()">
                <option value="">- Todos -</option>
                <option value="1">Activos</option>
                <option value="0">Anulados</option>
              </select>
            </div>
          </div> -->
          <div class="col-md-2">
            <button type="button" class="btn btn-primary btn-sm" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoReporte">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    
function verListado(){
    $.ajax({
      method: "POST",
      url: "vista/reportes_listado.php",
      data:{
        nrodoc: $('#txtBusquedaNroDoc').val(),
        tipodoc: $('#cboBusquedadTipoDoc').val(),
        fechaingreso: $('#BusquedaFeIng').val(),
        fechasalida: $('#BusquedaFeSal').val(),
        horaingreso: $('#BusquedaHoraIng').val(),
        horasalida: $('#BusquedaHoraSal').val()
      }
    })
    .done(function(resultado){
      $('#divListadoReporte').html(resultado);
    })
}

verListado();

</script>