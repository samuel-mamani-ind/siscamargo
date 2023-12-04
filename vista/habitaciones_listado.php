<?php
	require_once('../modelo/clsHabitacion.php');

	$objHabitacion = new clsHabitacion();

	$estado = $_POST['estado'];
	$idtipohabitacion = $_POST['idtipohabitacion'];
	$habitacion = $_POST['habitacion'];

	$listaHabitacion = $objHabitacion->listarHabitacion($habitacion,  $idtipohabitacion, $estado);
	$listaHabitacion = $listaHabitacion->fetchAll(PDO::FETCH_NAMED);


?>

<table id="tableHabitacion" class="table table-bordered table-striped">
	<thead class="bg-lightblue">
		<tr>
			<th>COD</th>
			<th>HABITACION</th>
			<th>TIPO</th>
			<th>ESTADO</th>
			<th>EDITAR</th>
			<th>ANULAR</th>
			<th>ELIMINAR</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaHabitacion as $key => $value) { 
			$class = "";
			if($value['estado']==0){
				$class = "text-red";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['id_habitacion'] ?></td>
			<td>
				<?= $value['codigohabitacion'] ?>
			</td>
			<td><?= $value['nombre_tipohabitacion'] ?></td>
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
				<button type="button" class="btn btn-info btn-sm" onclick="editarHabitacion(<?= $value['id_habitacion'] ?>)"><i class="fa fa-edit"></i> Editar</button>
			</td>
			<td>
				<?php if($value['estado']==1){ ?>
				<button type="button" class="btn btn-warning btn-sm" onclick="cambiarEstadoHabitacion(<?= $value['id_habitacion'] ?>,0)"><i class="fas fa-times"></i> Anular</button>
				<?php }else{ ?>
				<button type="button" class="btn btn-success btn-sm" onclick="cambiarEstadoHabitacion(<?= $value['id_habitacion'] ?>,1)"><i class="fa fa-check"></i> Activar</button>
				<?php } ?>
			</td>
			<td>
				<button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstadoHabitacion(<?= $value['id_habitacion'] ?>,2)"><i class="fa fa-trash"></i> Eliminar</button>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	$("#tableHabitacion").DataTable({
    	"responsive": true, 
    	"lengthChange": true, 
    	"autoWidth": false,
    	"searching": false,
    	"ordering": true,
    	//Mantener la Cabecera de la tabla Fija
    	// "scrollY": '200px',
        // "scrollCollapse": true,
        // "paging": false,
    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
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
    }).buttons().container().appendTo('#tableHabitacion_wrapper .col-md-6:eq(0)');

    function editarHabitacion(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contHabitaciones.php",
    		data: {
    			accion: 'CONSULTAR_HABITACION',
    			idhabitacion: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
    		$('#idhabitacion').val(id);
    		$('#codigo').val(resultado.codigohabitacion);
    		$('#idTipoHabitacion').val(resultado.id_tipohabitacion);
    		$('#estado').val(resultado.estado);

	    	$('#modalHabitacion').modal('show');
    	});    	
    }

    function cambiarEstadoHabitacion(idhabitacion, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> la habitacion?";
    	accion = "EjecutarCambiarEstadoHabitacion("+idhabitacion+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoHabitacion(idhabitacion,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contHabitaciones.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_HABITACION',
    			'idhabitacion': idhabitacion,
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

</script>