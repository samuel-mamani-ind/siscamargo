<?php
require_once('../modelo/clsHuesped.php');

controlador($_POST['accion']);

function controlador($accion){
	$objHue = new clsHuesped();

	switch ($accion) {
			case 'NUEVO':
				$resultado = array();
				try {
	
					$nomhuesped = $_POST['nomhuesped'];
					$nacionalidad = $_POST['nacionalidad'];
					$nrodoc = $_POST['nrodoc'];
					$profesion = $_POST['profesion'];
					$fenac = $_POST['fenac'];
					$tipodoc = $_POST['tipodoc'];

					$procedencia = $_POST['procedencia'];
					$habitacion = $_POST['habitacion'];
					$feing = $_POST['feing'];
					$fesal = $_POST['fesal'];
					$obs = $_POST['obs'];
	
					$existeHuesped = $objHue->verificarDuplicado($nrodoc, $tipodoc ,$idhuesped = 0);
					if($existeHuesped->rowCount()>0){
						throw new Exception("El documento ya esta registrado en la base de datos", 1);
						
					}
						
					$objHue->insertarHuesped($nomhuesped,$nacionalidad,$nrodoc,$profesion,$fenac,$tipodoc,$procedencia,$habitacion,$feing,$fesal,$obs);
					$resultado['correcto']=1;
					$resultado['mensaje'] = 'Datos del huesped registrados de forma satisfactoria.';
	
					echo json_encode($resultado);
					
				} catch (Exception $e) {
					$resultado['correcto']=0;
					$resultado['mensaje'] = $e->getMessage();
					echo json_encode($resultado);
				}
				break;

		case 'CONSULTAR_HUESPED':
			try {
				$idhuesped = $_POST['idhuesped'];

				$resultado = $objHue->consultarHuesped($idhuesped);
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
				$idhuesped = $_POST['idhuesped'];

				$nomhuesped = $_POST['nomhuesped'];
				$nacionalidad = $_POST['nacionalidad'];
				$nrodoc = $_POST['nrodoc'];
				$profesion = $_POST['profesion'];
				$fenac = $_POST['fenac'];
				$tipodoc = $_POST['tipodoc'];

				$existeHuesped = $objHue->verificarDuplicado($nrodoc, $tipodoc,$idhuesped);
				if($existeHuesped->rowCount()>0){
					throw new Exception("El documento ya esta registrado en la base de datos", 1);
					
				}

				$objHue->actualizarHuesped($idhuesped, $nomhuesped,$nacionalidad,$nrodoc,$profesion,$fenac,$tipodoc);

				$resultado['correcto']=1;
				$resultado['mensaje']="Datos del Huesped actualizados de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		case 'CAMBIAR_ESTADO_HUESPED':
			$resultado = array();
			try {
				$idhuesped = $_POST['idhuesped'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');

				$objHue->actualizarEstadoHuesped($idhuesped, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='El registro del huesped ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		case 'NUEVO_HOSPEDAJE':
			$resultado = array();
			try {

				$id_huesped = $_POST['id_huesped'];
				$procedencia = $_POST['procedencia'];
				$habitacion = $_POST['habhospedar'];
				$feing = $_POST['feing'];
				$fesal = $_POST['fesal'];
				$obs = $_POST['obs'];

				$existeHospedaje = $objHue->verificarHospedajeDuplicado($id_huesped);
				if($existeHospedaje->rowCount()>0){
					throw new Exception("El huesped esta registrado en una habitacion", 1);
					
				}
					
				$objHue->insertarHuespedHospedaje($id_huesped,$procedencia,$habitacion,$feing,$fesal,$obs);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Hospedaje registrado de forma satisfactoria.';

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