<?php
require_once('../modelo/clsHospedaje.php');

controlador($_POST['accion']);

function controlador($accion){
	$objHosp = new clsHospedaje();

	switch ($accion) {
		case 'NUEVO':
			$resultado = array();
			try {

				$habitacion = $_POST['habitacion'];
				$feing = $_POST['feing'];
				$fesal = $_POST['fesal'];
				$horaing = $_POST['horaing'];
				$horasal = $_POST['horasal'];
				$obs = $_POST['obs'];
				$estado = $_POST['estado'];

				$existeHospedaje = $objHosp->verificarDuplicado($habitacion);
				if($existeHospedaje->rowCount()>0){
					throw new Exception("La habitacion esta registrada en un hospedaje en curso", 1);
					
				}
					
				$objHosp->insertarHospedaje($feing,$fesal,$horaing,$horasal,$habitacion,$obs,$estado);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Hospedaje registrado de forma satisfactoria.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_HOSPEDAJE':
			try {
				$idhospedaje = $_POST['idhospedaje'];

				$resultado = $objHosp->consultarHospedaje($idhospedaje);
				$resultado = $resultado->fetch(PDO::FETCH_NAMED);
				echo json_encode($resultado);
			
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

		case 'ACTUALIZAR':
			$resultado = array();
			try {
				$idhospedaje = $_POST['idhospedaje'];

				$habitacion = $_POST['habitacion'];
				$procedencia = $_POST['procedencia'];
				$feing = $_POST['feing'];
				$fesal = $_POST['fesal'];
				$observacion = $_POST['obs'];

				/* $existeHospedaje = $objHosp->verificarDuplicado($habitacion, $idhospedaje);
				if($existeHospedaje->rowCount()>0){
					throw new Exception("La habitacion ya esta registrada en otro hospedaje", 1);
					
				} */

				$objHosp->actualizarHospedaje($idhospedaje,$procedencia,$feing,$fesal,$habitacion,$observacion);

				$resultado['correcto']=1;
				$resultado['mensaje']="Datos del Hospedaje actualizados de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;


		case 'CAMBIAR_ESTADO_HOSPEDAJE':
			$resultado = array();
			try {
				$idhospedaje = $_POST['idhospedaje'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');

				$objHosp->actualizarEstadoHospedaje($idhospedaje, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='El registro del hospedaje ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;
		
		default:
			echo "No ha definido una accion";
			break;
	}

}

?>