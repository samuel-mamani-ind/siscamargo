<?php
	require_once('../modelo/clsHuesped.php');

	$objHues = new clsHuesped();

	$nroDoc = $_POST['nroDoc'];
	$tipoDoc = $_POST['tipoDoc'];
	$nomHue = $_POST['nomHue'];
	$estado = $_POST['estado'];

	$listaHuesped = $objHues->listarHuesped($nroDoc, $tipoDoc, $nomHue, $estado);
	$listaHuesped = $listaHuesped->fetchAll(PDO::FETCH_NAMED);


?>
<table id="tableHuesped" class="table table-bordered table-striped">
	<thead class="bg-lightblue">
		<tr>
			<th>COD</th>
			<th>NOMBRE</th>
			<th>NACIONALIDAD</th>
			<th>NRO</th>
			<th>DOCUMENTO</th>
			<th>FECHA DE NACIMIENTO</th>
			<th>PROFESIÓN</th>
			<th>ESTADO</th>
			<th>OPCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaHuesped as $key => $value) { 
			$class = "";
			$tdclass = "";
			if($value['estado']==0){
				$class = "text-red";
				$tdclass = "bg-danger";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['id_huesped'] ?></td>
			<td><?= $value['nombcomp'] ?></td>
			<td><?= $value['nacionalidad'] ?></td>
			<td><?= $value['nrodocumento'] ?></td>
			<td><?= $value['tipdoc'] ?></td>
			<td><?= $value['fechanac'] ?></td>
			<td><?= $value['profesion'] ?></td>
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
						<a class="dropdown-item bg-olive" href="#" onclick="hospedarHuesped(<?= $value['id_huesped'] ?>)"><i class="fa fa-luggage-cart"></i> Hospedar</a>
						<a class="dropdown-item" href="#" onclick="editarHuesped(<?= $value['id_huesped'] ?>)"><i class="fa fa-edit"></i> Editar</a>
						<?php if($value['estado']==1){ ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoHuesped(<?= $value['id_huesped'] ?>,0)"><i class="fa fa-trash"></i> Anular</a>
						<?php }else{ ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoHuesped(<?= $value['id_huesped'] ?>,1)"><i class="fa fa-check"></i> Activar</a>
						<?php } ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoHuesped(<?= $value['id_huesped'] ?>,2)"><i class="fa fa-times"></i> Eliminar</a>
					</div>
        </div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$("#tableHuesped").DataTable({
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
    }).buttons().container().appendTo('#tableHuesped_wrapper .col-md-6:eq(0)');

    function editarHuesped(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contHuesped.php",
    		data: {
    			accion: 'CONSULTAR_HUESPED',
    			idhuesped: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
	    	$('#idhuesped').val(id);
    		$('#nomhuesped').val(resultado.nombcomp);
    		$('#nacionalidad').val(resultado.nacionalidad);
    		$('#nrodoc').val(resultado.nrodocumento);
    		$('#profesion').val(resultado.profesion);
    		$('#fenac').val(resultado.fenac);
    		$('#tipodoc').val(resultado.id_tipodocumento);
    		$('#estado').val(resultado.estado);

				$('#modalHuesped').modal('show');
				$('#inf-hospedaje').addClass('d-none');
    	});    	
    }

		function hospedarHuesped(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contHuesped.php",
    		data: {
    			accion: 'CONSULTAR_HUESPED',
    			idhuesped: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
	    	$('#id_huesped').val(id);
    		$('#nom_huesped').val(resultado.nombcomp);

				$('#modalHospedar').modal('show');
        $('#habhospedar').removeClass('is-invalid');
    	});    	
    }

    function cambiarEstadoHuesped(idhuesped, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> el registro del huesped?";
    	accion = "EjecutarCambiarEstadoHuesped("+idhuesped+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoHuesped(idhuesped,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contHuesped.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_HUESPED',
    			'idhuesped': idhuesped,
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