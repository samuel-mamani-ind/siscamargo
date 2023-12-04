<?php
	require_once('../modelo/clsHospedaje.php');

	$objHospe = new clsHospedaje();

	$habitacion = $_POST['habitacion'];
	$fechaingreso = $_POST['fechaingreso'];
	$fechasalida = $_POST['fechasalida'];
	$estado = $_POST['estado'];

	$listaHospedaje = $objHospe->listarHospedaje($habitacion, $fechaingreso, $fechasalida, $estado);
	$listaHospedaje = $listaHospedaje->fetchAll(PDO::FETCH_NAMED);



?>
<table id="tableHospedaje" class="table table-bordered table-striped ">
	<thead class="bg-lightblue">
		<tr>
			<th>COD</th>
			<th>HUESPED</th>
			<th>PROCEDENCIA</th>
			<th>HABITACION</th>
			<th>FECHA DE INGRESO</th>
			<th>FECHA DE SALIDA</th>
			<th>OBSERVACION</th>
			<th>ESTADO</th>
			<th>OPCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaHospedaje as $key => $value) { 
			$class = "";
			$tdclass = "";
			if($value['estado']==0){
				$class = "text-red";
				$tdclass = "bg-danger";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['id_hospedaje'] ?></td>
			<td><?= $value['huesped'] ?></td>
			<td><?= $value['procedencia'] ?></td>
			<td><?= $value['habitacion'] ?></td>
			<td><?= $value['fechaingreso'] ?></td>
			<td><?= $value['fechasalida'] ?></td>
			<td><?= $value['observacion'] ?></td>
			<td class="<?= $tdclass; ?>">
				<?php
					if($value['estado']==1){
						echo "Activo";
					}else{
						echo "Anulado";
					}
				?>		
			</td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-info btn-flat btn-sm">Opciones</button>
					<button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon btn-sm" data-toggle="dropdown">
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<div class="dropdown-menu" role="menu">
						<a class="dropdown-item" href="#" onclick="editarHospedaje(<?= $value['id_hospedaje'] ?>)"><i class="fa fa-edit"></i> Editar</a>
						<?php if($value['estado']==1){ ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoHospedaje(<?= $value['id_hospedaje'] ?>,0)"><i class="fa fa-trash"></i> Anular</a>
						<?php }else{ ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoHospedaje(<?= $value['id_hospedaje'] ?>,1)"><i class="fa fa-check"></i> Activar</a>
						<?php } ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoHospedaje(<?= $value['id_hospedaje'] ?>,2)"><i class="fa fa-times"></i> Eliminar</a>
					</div>
        </div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$("#tableHospedaje").DataTable({
    	"responsive": true, 
    	"lengthChange": true, 
    	"autoWidth": false,
    	"searching": false,
    	"ordering": true,
			"order": [[0, "desc"]],
    	//Mantener la Cabecera de la tabla Fija
    	// "scrollY": '200px',
        // "scrollCollapse": true,
        // "paging": false,
    	"lengthMenu": [[5, 15, 50, 100, -1], [5, 15, 50, 100, "Todos"]],
    	"language": {
			"decimal":        "",
		    "emptyTable":     "Sin datos",
		    "info":           "Del _START_ al _END_ de _TOTAL_ filas",
		    "infoEmpty":      "Del 0 a 0 de 0 filas",
		    "infoFiltered":   "(filtro de _MAX_ filas totales)",
		    "infoPostFix":    "",
		    "thousands":      ",",
		    "lengthMenu":     "Ver _MENU_ filas",
		    "loadingRecords": "Cargando...",
		    "processing":     "Procesando...",
		    "search":         "Buscar:",
		    "zeroRecords":    "No se encontraron resultados",
		    "paginate": {
		        "first":      "Primero",
		        "last":       "Ultimo",
		        "next":       "Siguiente",
		        "previous":   "Anterior"
		    },
		    "aria": {
		        "sortAscending":  ": orden ascendente",
		        "sortDescending": ": orden descendente"
		    }
		},
    	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tableHospedaje_wrapper .col-md-6:eq(0)');

    function editarHospedaje(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contHospedaje.php",
    		data: {
    			accion: 'CONSULTAR_HOSPEDAJE',
    			idhospedaje: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
	    	$('#idhospedaje').val(id);
	    	$('#nom_huesped').val(resultado.huesped);
    		$('#habitacion').val(resultado.id_habitacion);
    		$('#procedencia').val(resultado.procedencia);
    		$('#feing').val(resultado.fechaingreso);
    		$('#fesal').val(resultado.fechasalida);
    		$('#obs').val(resultado.observacion);
    		$('#estado').val(resultado.estado);

				$('#modalHospedaje').modal('show');
    	});    	
    }

    function cambiarEstadoHospedaje(idhospedaje, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> el registro del hospedaje?";
    	accion = "EjecutarCambiarEstadoHospedaje("+idhospedaje+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoHospedaje(idhospedaje,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contHospedaje.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_HOSPEDAJE',
    			'idhospedaje': idhospedaje,
    			'estado': estado
    		},
    		dataType: 'json'
    	})
    	.done(function(resultado){
    		if(resultado.correcto==1){
    			toastCorrecto(resultado.mensaje);
    			verListado();
    		}else{
    			toastError(resultado.mensaje);
    		}
    	});
    }

		function cambiarEstadoHuespedHospedaje(idhospedar, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> Huesped del hospedaje?";
    	accion = "EjecutarCambiarEstadoHuespedHospedaje("+idhospedar+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoHuespedHospedaje(idhospedar,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contHospedaje.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_HUESPED_HOSPEDAJE',
    			'idhospedar': idhospedar,
    			'estado': estado
    		},
    		dataType: 'json'
    	})
    	.done(function(resultado){
    		if(resultado.correcto==1){
    			toastCorrecto(resultado.mensaje);
				$('#modalHuespedes_habitacion').modal('hide');
    		}else{
    			toastError(resultado.mensaje);
    		}
    	});
    }

</script>