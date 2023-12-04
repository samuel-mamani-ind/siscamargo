<?php
	require_once('../modelo/clsUsuario.php');

	$objUsu = new clsUsuario();

	$nombre = $_POST['nombre'];
	$estado = $_POST['estado'];

	$listaUsuario = $objUsu->listarUsuario($nombre, $estado);
	$listaUsuario = $listaUsuario->fetchAll(PDO::FETCH_NAMED);


?>
<table id="tableUsuario" class="table table-bordered table-striped">
	<thead class="bg-lightblue">
		<tr>
			<th>COD</th>
			<th>NOMBRE</th>
			<th>USUARIO</th>
			<th>PERFIL</th>
			<th>FOTO</th>
			<th>ESTADO</th>
			<th>OPCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaUsuario as $key => $value) { 
			$class = "";
			if($value['estado']==0){
				$class = "text-red";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['idusuario'] ?></td>
			<td><?= $value['nombre'] ?></td>
			<td><?= $value['usuario'] ?></td>
			<td><?= $value['perfil'] ?></td>
			<td>
				<a href="<?= $value['urlimagen'] ?>" target="_blank">
				<img src="<?= $value['urlimagen'] ?>" style="width: 40px; height: 40px;">
				</a>
			</td>
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
				<div class="btn-group">
					<button type="button" class="btn btn-info btn-flat btn-sm">Opciones</button>
					<button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon btn-sm" data-toggle="dropdown">
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<div class="dropdown-menu" role="menu">
						<a class="dropdown-item" href="#" onclick="subirImagen(<?= $value['idusuario'] ?>)"><i class="fa fa-upload"></i> Subir Imagen</a>
						<a class="dropdown-item" href="#" onclick="editarUsuario(<?= $value['idusuario'] ?>)"><i class="fa fa-edit"></i> Editar</a>
						<?php if($value['estado']==1){ ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoUsuario(<?= $value['idusuario'] ?>,0)"><i class="fa fa-trash"></i> Anular</a>
						<?php }else{ ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoUsuario(<?= $value['idusuario'] ?>,1)"><i class="fa fa-check"></i> Activar</a>
						<?php } ?>
						<a class="dropdown-item" href="#" onclick="cambiarEstadoUsuario(<?= $value['idusuario'] ?>,2)"><i class="fa fa-times"></i> Eliminar</a>
					</div>
        </div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	$("#tableUsuario").DataTable({
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
    }).buttons().container().appendTo('#tableUsuario_wrapper .col-md-6:eq(0)');

    function editarUsuario(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contUsuario.php",
    		data: {
    			accion: 'CONSULTAR_USUARIO',
    			idusuario: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
    		console.log(resultado);
    		$('#nombre').val(resultado.nombre);
    		$('#usuario').val(resultado.usuario);
    		$('#estado').val(resultado.estado);
    		$('#idperfil').val(resultado.idperfil);
    		$('#clave').val("");
    		// $('#formCategoria').trigger('reset');
	    	$('#idusuario').val(id);
	    	$('#modalUsuario').modal('show');
    	});    	
    }

    function cambiarEstadoUsuario(idusuario, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> el usuario?";
    	accion = "EjecutarCambiarEstadoUsuario("+idusuario+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoUsuario(idusuario,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contUsuario.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_USUARIO',
    			'idusuario': idusuario,
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

		function subirImagen(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contUsuario.php",
    		data: {
    			accion: 'CONSULTAR_USUARIO',
    			idusuario: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
    		$('#nombre_usuario').val(resultado.nombre);
    		$('#urlimgusu').val(resultado.urlimagen);

    		// $('#formCategoria').trigger('reset');
	    	$('#idusuario_imagen').val(id);

	    	$("#uploadFile").fileinput({
					language: 'es',
					showRemove: false,
					uploadAsync: true,
					uploadExtraData: {
						accion: 'SUBIR_IMAGEN', 
						idusuario: $('#idusuario_imagen').val()
					},
					uploadUrl: 'controlador/contUsuario.php',
					maxFileCount: 1,
					autoReplace: true, 
					allowedFileExtensions: ['jpg','png','jpeg']
			}).on('fileuploaded', function(event, data, id, index) {
			    $('#modalUsuario_Img').modal('hide');
			    verListado();
			    $('#uploadFile').fileinput('destroy');
			})


	    	$('#modalUsuario_Img').modal('show');
    	});    	
    }
</script>