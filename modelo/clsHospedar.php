<?php
require_once('conexion.php');

class clsHospedar{

	function listarHospedar($tipodoc, $nrodoc, $estado){
		$sql = "SELECT hospe.id_hospedar,hospe.estado, hue.nombcomp as 'huesped', hue.nrodocumento as 'nrodoc', tipdoc.nombre as 'tipodoc', hab.codigohabitacion as 'habitacion'
		FROM hospedar hospe 
		INNER JOIN huesped hue 
		ON hospe.id_huesped=hue.id_huesped
		INNER JOIN tipodocumento tipdoc 
		ON hue.id_tipodocumento=tipdoc.id_tipodocumento
		INNER JOIN hospedaje hos 
		ON hospe.id_hospedaje=hos.id_hospedaje
		INNER JOIN habitacion hab 
		ON hos.id_habitacion=hab.id_habitacion        
		WHERE hospe.estado<2";
		$parametros = array();

		if($nrodoc!=""){
			$sql .= " AND hue.nrodocumento LIKE :nrodoc ";
			$parametros[':nrodoc'] = "%".$nrodoc."%";
		}

		if($tipodoc!=""){
			$sql .= " AND hue.id_tipodocumento = :tipodoc ";
			$parametros[':tipodoc'] = $tipodoc; 
		}

		if($estado!=""){
			$sql .= " AND hospe.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY hab.codigohabitacion ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function insertarHospedar($idhuesped,$idhospedaje,$estado){
		$sql = "INSERT INTO hospedar(id_huesped, id_hospedaje, estado) VALUES(:idhuesped, :idhospedaje, :estado)";
		$parametros = array(
			":idhuesped"=>$idhuesped, 
			":idhospedaje"=>$idhospedaje, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($idhuesped, $idhospedar){
		$sql = "SELECT * FROM hospedar WHERE estado=1 AND id_huesped=:idhuesped AND id_hospedar<>:idhospedar";
		$parametros = array(':idhuesped'=>$idhuesped, ':idhospedar'=>$idhospedar);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarHospedar($id_hospedar){
		$sql = "SELECT hospe.*, hue.nombcomp, hue.nrodocumento, hue.id_tipodocumento
		FROM hospedar hospe
		INNER JOIN huesped hue
		ON hospe.id_huesped=hue.id_huesped
		INNER JOIN hospedaje hos
		ON hospe.id_hospedaje=hos.id_hospedaje
		INNER JOIN habitacion hab
		ON hos.id_habitacion=hab.id_habitacion
		WHERE id_hospedar=:id_hospedar ";

		$parametros = array(":id_hospedar"=>$id_hospedar);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarHospedar($idhospedar, $idhuesped,$idhospedaje,$estado){
		$sql = "UPDATE hospedar SET id_huesped=:idhuesped, id_hospedaje=:idhospedaje, estado=:estado WHERE id_hospedar=:idhospedar";
		$parametros = array(
			":idhospedar"=>$idhospedar, 
			":idhuesped"=>$idhuesped, 
			":idhospedaje"=>$idhospedaje, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoHospedar($idhospedar, $estado){
		$sql = "UPDATE hospedar SET estado=:estado WHERE id_hospedar=:idhospedar";
		$parametros = array(":estado"=>$estado, ":idhospedar"=>$idhospedar);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarHuesped($nrodoc, $tipodoc){
		$sql = "SELECT id_huesped, nombcomp AS nombrehuesped FROM huesped WHERE estado=1 AND nrodocumento=:nrodoc AND id_tipodocumento=:tipodoc";
		$parametros = array(":nrodoc"=>$nrodoc, ":tipodoc"=>$tipodoc);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function consultarHabHospedaje(){
		$sql = "SELECT hosp.id_hospedaje, hosp.id_habitacion, hab.codigohabitacion, tiphab.nombre AS tipohabitacion FROM hospedaje hosp 
		INNER JOIN habitacion hab
		ON hosp.id_habitacion = hab.id_habitacion
		INNER JOIN tipohabitacion tiphab
		ON hab.id_tipohabitacion = tiphab.id_tipohabitacion
		WHERE hosp.estado=1";

		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function insertarHuespedHospedaje($id_huesped,$procedencia,$idhospedaje){
		$sql = "INSERT INTO hospedar(id_huesped, procedencia, id_hospedaje) VALUES(:idhuesped, :procedencia, :idhospedaje)";
		$parametros = array(
			":idhuesped"=>$id_huesped, 
			":procedencia"=>$procedencia,
			":idhospedaje"=>$idhospedaje 
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* Validar por fecha */
	function verificarHuespedHospedajeDuplicado($id_huesped){
		$sql = "SELECT hospe.*, hos.fechasalida 
		FROM hospedar hospe
		INNER JOIN hospedaje hos
		ON hospe.id_hospedaje=hos.id_hospedaje
		WHERE hospe.estado<2 AND hos.fechasalida>CURDATE() AND id_huesped=:idhuesped";
		$parametros = array(':idhuesped'=>$id_huesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


}
?>