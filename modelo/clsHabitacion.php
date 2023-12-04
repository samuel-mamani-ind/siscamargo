<?php
require_once('conexion.php');

class clsHabitacion{

	function listarHabitacion($habitacion, $idtipohabitacion, $estado){
		$sql = "SELECT hab.*, tipohab.nombre as 'nombre_tipohabitacion' FROM habitacion hab INNER JOIN tipohabitacion tipohab ON hab.id_tipohabitacion=tipohab.id_tipohabitacion WHERE hab.estado<2 AND tipohab.estado<2";
		$parametros = array();

		if($habitacion!=""){
			$sql .= " AND hab.codigohabitacion LIKE :codigohabitacion ";
			$parametros[':codigohabitacion'] = "%".$habitacion."%";
		}

		if($idtipohabitacion!=""){
			$sql .= " AND hab.id_tipohabitacion = :id_tipohabitacion ";
			$parametros[':id_tipohabitacion'] = $idtipohabitacion; 
		}

		if($estado!=""){
			$sql .= " AND hab.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY hab.codigohabitacion ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function insertarHabitacion($codigo,$idTipoHabitacion,$estado){
		$sql = "INSERT INTO habitacion(codigohabitacion, id_tipohabitacion, estado) VALUES(:codigohabitacion, :id_tipohabitacion, :estado)";
		$parametros = array(
			":codigohabitacion"=>$codigo, 
			":id_tipohabitacion"=>$idTipoHabitacion, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($codigo, $id_habitacion=0){
		$sql = "SELECT * FROM habitacion WHERE estado<2 AND codigohabitacion=:codigo AND id_habitacion<>:id_habitacion";
		$parametros = array(":codigo"=>$codigo, ":id_habitacion"=>$id_habitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarHabitacion($idhabitacion){
		$sql = "SELECT * FROM habitacion WHERE id_habitacion=:idhabitacion ";
		$parametros = array(":idhabitacion"=>$idhabitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarHabitacion($idhabitacion, $codigo,$idTipoHabitacion,$estado){
		$sql = "UPDATE habitacion SET codigohabitacion=:codigo, id_tipohabitacion=:idTipoHabitacion, estado=:estado WHERE id_habitacion=:idhabitacion";
		$parametros = array(
			":codigo"=>$codigo, 
			":idTipoHabitacion"=>$idTipoHabitacion, 
			":estado"=>$estado, 
			":idhabitacion"=>$idhabitacion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoHabitacion($idhabitacion, $estado){
		$sql = "UPDATE habitacion SET estado=:estado WHERE id_habitacion=:idhabitacion";
		$parametros = array(":estado"=>$estado, ":idhabitacion"=>$idhabitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


}
?>