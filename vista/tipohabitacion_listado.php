<?php
	require_once('../modelo/clsTipoHabitacion.php');

	$obTipoHabitacion = new clsTipoHabitacion();

	$nombre = $_POST['nombre'];
	$estado = $_POST['estado'];

	$listaTipoHabitacion = $obTipoHabitacion->listarTipoHabitacion($nombre, $estado);
	$listaTipoHabitacion = $listaTipoHabitacion->fetchAll(PDO::FETCH_NAMED);


?>
<table id="tableTipoCategoria" class="table table-bordered table-striped">
	<thead class="bg-lightblue">
		<tr>
			<th>COD</th>
			<th>NOMBRE</th>
			<th>PRECIO</th>
			<th>ESTADO</th>
			<th>EDITAR</th>
			<th>ANULAR</th>
			<th>ELIMINAR</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaTipoHabitacion as $key => $value) { 
			$class = "";
			if($value['estado']==0){
				$class = "text-red";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['id_tipohabitacion'] ?></td>
			<td><?= $value['nombre'] ?></td>
			<td><?= $value['precio'] ?></td>
			<td>
				<?php
					if($value['estado']==1){
						echo "Activo";
					}else{
						echo "Anulado";
					}
				?>		
			</td>
			<td>
				<button type="button" class="btn btn-info btn-sm" onclick="editarTipoHabitacion(<?= $value['id_tipohabitacion'] ?>)"><i class="fa fa-edit"></i> Editar</button>
			</td>
			<td>
				<?php if($value['estado']==1){ ?>
				<button type="button" class="btn btn-warning btn-sm" onclick="cambiarEstadoTipoHabitacion(<?= $value['id_tipohabitacion'] ?>,0)"><i class="fas fa-times"></i> Anular</button>
				<?php }else{ ?>
				<button type="button" class="btn btn-success btn-sm" onclick="cambiarEstadoTipoHabitacion(<?= $value['id_tipohabitacion'] ?>,1)"><i class="fa fa-check"></i> Activar</button>
				<?php } ?>
			</td>
			<td><button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstadoTipoHabitacion(<?= $value['id_tipohabitacion'] ?>,2)"><i class="fa fa-trash"></i> Eliminar</button></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	$("#tableTipoCategoria").DataTable({
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
    }).buttons().container().appendTo('#tableTipoCategoria_wrapper .col-md-6:eq(0)');

    function editarTipoHabitacion(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contTipoHabitacion.php",
    		data: {
    			accion: 'CONSULTAR_TIPOHABITACION',
    			tipohabitacion: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
    		console.log(resultado);
    		$('#nombre').val(resultado.nombre);
    		$('#estado').val(resultado.estado);
    		$('#precio').val(resultado.precio);
    		
	    	$('#idTipoHabitacion').val(id);
	    	$('#modalTipoHabitacion').modal('show');
    	});    	
    }

    function cambiarEstadoTipoHabitacion(idtipohabitacion, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> el Tipo de Habitacion?";
    	accion = "EjecutarcambiarEstadoTipoHabitacion("+idtipohabitacion+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarcambiarEstadoTipoHabitacion(idtipohabitacion,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contTipoHabitacion.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_TIPOHABITACION',
    			'idtipohabitacion': idtipohabitacion,
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