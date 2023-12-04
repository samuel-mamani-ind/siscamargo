<?php
require_once('../modelo/clsHabitacion.php');

controlador($_POST['accion']);

function controlador($accion){
	$objHab = new clsHabitacion();

	switch ($accion) {
		case 'NUEVO':
			$resultado = array();
			try {

				$codigo = $_POST['codigo'];
				$idTipoHabitacion = $_POST['idTipoHabitacion'];
				$estado = $_POST['estado'];

				$existeHabitacion = $objHab->verificarDuplicado($codigo);
				if($existeHabitacion->rowCount()>0){
					throw new Exception("Ya Existe una habitacion registrada con el mismo número", 1);
				}
					
				$objHab->insertarHabitacion($codigo,$idTipoHabitacion,$estado);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Habitacion Registrada de forma satisfactoria.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_HABITACION':
			try {
				$idhabitacion = $_POST['idhabitacion'];

				$resultado = $objHab->consultarHabitacion($idhabitacion);
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
				$idhabitacion = $_POST['idhabitacion'];
				$codigo = $_POST['codigo'];
				$idTipoHabitacion = $_POST['idTipoHabitacion'];
				$estado = $_POST['estado'];

				$existeHabitacion= $objHab->verificarDuplicado($codigo, $idhabitacion);
				if($existeHabitacion->rowCount()>0){
					throw new Exception("Ya Existe una Habitacion Registrada con el mismo codigo", 1);
					
				}

				$objHab->actualizarHabitacion($idhabitacion, $codigo,$idTipoHabitacion,$estado);

				$resultado['correcto']=1;
				$resultado['mensaje']="Habitacion actualizada de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		case 'CAMBIAR_ESTADO_HABITACION':
			$resultado = array();
			try {
				$idhabitacion = $_POST['idhabitacion'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');

				$objHab->actualizarEstadoHabitacion($idhabitacion, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='La Habitacion ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

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