<?php
require_once('../modelo/clsTipoHabitacion.php');

controlador($_POST['accion']);

function controlador($accion){
	$objTipoHabitacion = new clsTipoHabitacion();

	switch ($accion) {
		case 'NUEVO':
			$resultado = array();
			try {

				
				$nombre = $_POST['nombre'];
				$estado = $_POST['estado'];
				$precio = $_POST['precio'];

				$existeTipoHabitacion = $objTipoHabitacion->verificarDuplicado($nombre);
				if($existeTipoHabitacion->rowCount()>0){
					throw new Exception("Ya existe un Tipo de Habitacion registrado con el mismo nombre", 1);
					
				}
					
				$objTipoHabitacion->insertarTipoHabitacion($nombre, $precio, $estado);
				$resultado['correcto']=1; 
				$resultado['mensaje'] = 'Tipo de Habitacion registrada con exito.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_TIPOHABITACION':
			try {
				$tipohabitacion = $_POST['tipohabitacion'];

				$resultado = $objTipoHabitacion->consultarTipoHabitacion($tipohabitacion);
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
				$idTipoHabitacion = $_POST['idTipoHabitacion'];
				$nombre = $_POST['nombre'];
				$precio = $_POST['precio'];
				$estado = $_POST['estado'];

				$existeTipoHabitacion = $objTipoHabitacion->verificarDuplicado($nombre, $idTipoHabitacion);
				if($existeTipoHabitacion->rowCount()>0){
					throw new Exception("Existe un Tipo de Habitacion registrado con el mismo nombre", 1);
					
				}

				$objTipoHabitacion->actualizarTipoHabitacion($idTipoHabitacion, $nombre, $precio, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']="Tipo de Habitacion actualizado de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		case 'CAMBIAR_ESTADO_TIPOHABITACION':
			$resultado = array();
			try {
				$idtipohabitacion = $_POST['idtipohabitacion'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADO','ACTIVADO','ELIMINADO');

				$objTipoHabitacion->actualizarEstadoTipoHabitacion($idtipohabitacion, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='El Tipo de Habitacion ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

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