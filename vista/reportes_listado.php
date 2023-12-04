<?php
	require_once('../modelo/clsReporte.php');

	$objReporte = new clsReporte();

	$tipodoc = $_POST['tipodoc'];
	$nrodoc = $_POST['nrodoc'];
	$fechaingreso = $_POST['fechaingreso'];
	$fechasalida = $_POST['fechasalida'];
	$horaingreso = $_POST['horaingreso'];
	$horasalida = $_POST['horasalida'];

	$listaReporte = $objReporte->listarReporte($tipodoc,$nrodoc,$fechaingreso,$fechasalida,$horaingreso,$horasalida);
	$listaReporte = $listaReporte->fetchAll(PDO::FETCH_NAMED);


?>

<table id="tableReporte" class="table table-bordered table-striped">
	<thead class="bg-lightblue text-sm">
		<tr>
			<th>COD</th>
			<th>FECHA DE INGRESO</th>
			<th>FECHA DE SALIDA</th>
			<th>HORA DE INGRESO</th>
			<th>HORA DE SALIDA</th>
			<th>NOMBRE</th>
			<th>HABITACION</th>
			<th>PAIS/NACIONALIDAD</th>
			<th>PROCEDENCIA</th>
			<th>PROFESION</th>
			<th>EDAD</th>
			<th>NRO</th>
			<th>DOCUMENTO</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaReporte as $key => $value) { 
			$class = "";
			$tdclass = "";
			if($value['estado']==0){
				$class = "text-red";
				$tdclass = "bg-danger";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['id_hospedar'] ?></td>
			<td>
				<?= $value['fechaingreso'] ?>
			</td>
			<td>
				<?= $value['fechasalida'] ?>
			</td>
			<td>
				<?= $value['horaingreso'] ?>
			</td>
			<td>
				<?= $value['horasalida'] ?>
			</td>
			<td>
				<?= $value['huesped'] ?>
			</td>
			<td>
				<?= $value['habitacion'] ?>
			</td>
			<td>
				<?= $value['nacionalidad'] ?>
			</td>
			<td>
				<?= $value['procedencia'] ?>
			</td>
			<td>
				<?= $value['profesion'] ?>
			</td>
			<td>
				<?= $value['edad'] ?>
			</td>
			<td>
				<?= $value['nrodoc'] ?>
			</td>
			<td>
				<?= $value['tipodoc'] ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	$("#tableReporte").DataTable({
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
    }).buttons().container().appendTo('#tableReporte_wrapper .col-md-6:eq(0)');


</script>