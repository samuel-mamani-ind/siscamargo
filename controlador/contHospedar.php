<?php
require_once('../modelo/clsHospedar.php');

controlador($_POST['accion']);

function controlador($accion){
	$objHospedar = new clsHospedar();

	switch ($accion) {
			case 'CONSULTAR_HUESPED':
				try {
					$nrodoc = $_POST['nrodoc'];
					$tipodoc = $_POST['tipodoc'];
					
					$resultado = $objHospedar->consultarHuesped($nrodoc, $tipodoc);
					$resultado = $resultado->fetch(PDO::FETCH_NAMED);
					echo json_encode($resultado);
					
				} catch (Exception $e) {
					$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
					echo json_encode($resultado);
				}
				break;
			
			case 'NUEVO_HUESPED_HOSPEDAJE':
				$resultado = array();
				try {
	
					$id_huesped = $_POST['id_huesped'];
					$procedencia = $_POST['procedencia'];
					$idhospedaje = $_POST['idhospedaje'];
	
					$existeHuesped = $objHospedar->verificarHuespedHospedajeDuplicado($id_huesped);
					if($existeHuesped->rowCount()>0){
						throw new Exception("El huesped ya esta registrado en una habitacion", 1);
						
					}
						
					$objHospedar->insertarHuespedHospedaje($id_huesped,$procedencia,$idhospedaje);
					$resultado['correcto']=1;
					$resultado['mensaje'] = 'Huesped agregado al hospedaje de forma satisfactoria.';
	
					echo json_encode($resultado);
					
				} catch (Exception $e) {
					$resultado['correcto']=0;
					$resultado['mensaje'] = $e->getMessage();
					echo json_encode($resultado);
				}
				break;
		
		default:
			echo "No ha definido una accion";
			break;
	}

}

?>