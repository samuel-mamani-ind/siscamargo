<?php
require_once('conexion.php');

class clsHospedaje{

	function listarHospedaje($habitacion, $fechaingreso, $fechasalida, $estado){
		$sql = "SELECT hos.*, hab.codigohabitacion as 'habitacion', hue.nombcomp as 'huesped' FROM hospedaje hos
		INNER JOIN habitacion hab ON hos.id_habitacion=hab.id_habitacion
		INNER JOIN huesped hue ON hos.id_huesped=hue.id_huesped
		WHERE hos.estado<2 AND hab.estado<2 AND hue.estado<2";
		$parametros = array();

		if($habitacion!=""){
			$sql .= " AND hab.codigohabitacion LIKE :habitacion ";
			$parametros[':habitacion'] = "%".$habitacion."%";
		}

		if($fechaingreso!=""){
			$sql .= " AND hosp.fechaingreso LIKE :fechaingreso ";
			$parametros[':fechaingreso'] = "%".$fechaingreso."%";
		}

		if($fechasalida!=""){
			$sql .= " AND hosp.fechasalida = :fechasalida ";
			$parametros[':fechasalida'] = $fechasalida; 
		}

		if($estado!=""){
			$sql .= " AND hosp.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY hos.id_hospedaje DESC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function consultarHabitacion(){
		$sql = "SELECT hab.*, tiphab.nombre AS tipohabitacion 
		FROM habitacion hab
		INNER JOIN tipohabitacion tiphab
		ON hab.id_tipohabitacion = tiphab.id_tipohabitacion
		WHERE hab.estado=1";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function insertarHospedaje($feing,$fesal,$horaing,$horasal,$habitacion,$obs,$estado){
		$sql = "INSERT INTO hospedaje(fechaingreso, fechasalida, horaingreso, horasalida, id_habitacion, observacion, estado) VALUES(:fechaingreso, :fechasalida, :horaingreso, :horasalida, :id_habitacion, :observacion, :estado)";
		$parametros = array(
			":fechaingreso"=>$feing, 
			":fechasalida"=>$fesal,
			":horaingreso"=>$horaing, 
			":horasalida"=>$horasal,  
			":id_habitacion"=>$habitacion, 
			":observacion"=>$obs, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($habitacion ,$idhospedaje = 0){
		$sql = "SELECT * FROM hospedaje WHERE estado=1 AND id_habitacion=:habitacion AND fechasalida>CURDATE() AND id_hospedaje<>:idhospedaje";
		$parametros = array(":habitacion"=>$habitacion, ":idhospedaje"=>$idhospedaje);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarHospedaje($idhospedaje){
		$sql = "SELECT hos.*, hab.codigohabitacion as 'habitacion', hue.nombcomp as 'huesped' FROM hospedaje hos
		INNER JOIN habitacion hab ON hos.id_habitacion=hab.id_habitacion
		INNER JOIN huesped hue ON hos.id_huesped=hue.id_huesped
		WHERE id_hospedaje=:idhospedaje";
		$parametros = array(":idhospedaje"=>$idhospedaje);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarHospedaje($idhospedaje,$procedencia,$feing,$fesal,$habitacion,$observacion){
		$sql = "UPDATE hospedaje SET procedencia=:procedencia, fechaingreso=:feing, fechasalida	=:fesal, id_habitacion=:habitacion, observacion=:observacion WHERE id_hospedaje=:idhospedaje";
		$parametros = array(
			":idhospedaje"=>$idhospedaje, 

			":procedencia"=>$procedencia, 
			":feing"=>$feing, 
			":fesal"=>$fesal, 
			":habitacion"=>$habitacion, 
			":observacion"=>$observacion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoHospedaje($idhospedaje, $estado){
		$sql = "UPDATE hospedaje SET estado=:estado WHERE id_hospedaje=:idhospedaje";
		$parametros = array(":estado"=>$estado, ":idhospedaje"=>$idhospedaje);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


}
?>