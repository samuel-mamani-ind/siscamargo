<?php
require_once('conexion.php');

class clsTipoHabitacion{

	function listarTipoHabitacion($nombre, $estado){
		$sql = "SELECT * FROM tipohabitacion WHERE estado<2";
		$parametros = array();

		if($nombre!=""){
			$sql .= " AND nombre LIKE :nombre ";
			$parametros[':nombre'] = "%".$nombre."%";
		}

		if($estado!=""){
			$sql .= " AND estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY precio ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function insertarTipoHabitacion($nombre, $precio, $estado){
		$sql = "INSERT INTO tipohabitacion VALUES(null,:nombre,:precio,:estado)";
		$parametros = array(":nombre"=>$nombre, ":precio"=>$precio, ":estado"=>$estado);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($nombre, $id_tipohabitacion=0){
		$sql = "SELECT * FROM tipohabitacion WHERE estado<2 AND nombre=:nombre AND id_tipohabitacion<>:id_tipohabitacion";
		$parametros = array(":nombre"=>$nombre, ":id_tipohabitacion"=>$id_tipohabitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarTipoHabitacion($tipohabitacion){
		$sql = "SELECT * FROM tipohabitacion WHERE id_tipohabitacion=:id_tipohabitacion";
		$parametros = array(":id_tipohabitacion"=>$tipohabitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarTipoHabitacion($idTipoHabitacion, $nombre, $precio, $estado){
		$sql = "UPDATE tipohabitacion SET nombre=:nombre, precio=:precio, estado=:estado WHERE id_tipohabitacion=:idTipoHabitacion";
		$parametros = array(':idTipoHabitacion'=>$idTipoHabitacion, ':nombre'=>$nombre, ':precio'=>$precio, ':estado'=>$estado);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoTipoHabitacion($idtipohabitacion, $estado){
		$sql = "UPDATE tipohabitacion SET estado=:estado WHERE id_tipohabitacion=:idtipohabitacion";
		$parametros = array(":estado"=>$estado, ":idtipohabitacion"=>$idtipohabitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

}


?>