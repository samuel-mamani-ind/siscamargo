<?php
require_once('conexion.php');

class clsReporte{

	function listarReporte($tipodoc,$nrodoc,$fechaingreso,$fechasalida,$horaingreso,$horasalida){
		/* $sql = "SELECT hospe.id_hospedar,hospe.estado, hue.nombcomp as 'huesped', hue.nrodocumento as 'nrodoc', tipdoc.nombre as 'tipodoc', hab.codigohabitacion as 'habitacion', hos.fechaingreso, hos.fechasalida, hos.horaingreso, hos.horasalida, hospe.procedencia, hue.profesion, TIMESTAMPDIFF(YEAR, hue.fenac, CURDATE()) as edad, nac.nombre as nacionalidad
		FROM hospedar hospe 
		INNER JOIN huesped hue 
		ON hospe.id_huesped=hue.id_huesped
		INNER JOIN nacionalidad nac 
		ON hue.id_nacionalidad=nac.id_nacionalidad
		INNER JOIN tipodocumento tipdoc 
		ON hue.id_tipodocumento=tipdoc.id_tipodocumento
		INNER JOIN hospedaje hos 
		ON hospe.id_hospedaje=hos.id_hospedaje
		INNER JOIN habitacion hab 
		ON hos.id_habitacion=hab.id_habitacion        
		WHERE hos.estado=1 AND hospe.estado=1"; */

		/* ===================== HUESPEDES ACTUALES ===================== */
		/* $sql = "SELECT hospe.id_hospedar,hospe.estado, hue.nombcomp AS 'huesped', 
		hue.nrodocumento AS 'nrodoc', tipdoc.nombre AS 'tipodoc', hab.codigohabitacion AS 'habitacion', 
		DATE_FORMAT(hos.fechaingreso, '%d-%m-%Y') AS fechaingreso, DATE_FORMAT(hos.fechasalida, '%d-%m-%Y') AS fechasalida, 
		DATE_FORMAT(hos.horaingreso, '%H:%i') AS horaingreso, DATE_FORMAT(hos.horasalida, '%H:%i') AS horasalida,
		hospe.procedencia, hue.profesion, 
		TIMESTAMPDIFF(YEAR, hue.fenac, CURDATE()) AS edad, nac.nombre AS nacionalidad
		FROM hospedar hospe 
		INNER JOIN huesped hue 
		ON hospe.id_huesped=hue.id_huesped
		INNER JOIN nacionalidad nac 
		ON hue.id_nacionalidad=nac.id_nacionalidad
		INNER JOIN tipodocumento tipdoc 
		ON hue.id_tipodocumento=tipdoc.id_tipodocumento
		INNER JOIN hospedaje hos 
		ON hospe.id_hospedaje=hos.id_hospedaje
		INNER JOIN habitacion hab 
		ON hos.id_habitacion=hab.id_habitacion        
		WHERE hos.fechasalida>CURDATE()"; */

		/* ===================== HUESPEDES NUEVOS ===================== */
		/* $sql = "SELECT hospe.id_hospedar,hospe.estado, hue.nombcomp AS 'huesped', 
		hue.nrodocumento AS 'nrodoc', tipdoc.nombre AS 'tipodoc', hab.codigohabitacion AS 'habitacion', 
		DATE_FORMAT(hos.fechaingreso, '%d-%m-%Y') AS fechaingreso, DATE_FORMAT(hos.fechasalida, '%d-%m-%Y') AS fechasalida, 
		DATE_FORMAT(hos.horaingreso, '%H:%i') AS horaingreso, DATE_FORMAT(hos.horasalida, '%H:%i') AS horasalida,
		hospe.procedencia, hue.profesion, 
		TIMESTAMPDIFF(YEAR, hue.fenac, CURDATE()) AS edad, nac.nombre AS nacionalidad
		FROM hospedar hospe 
		INNER JOIN huesped hue 
		ON hospe.id_huesped=hue.id_huesped
		INNER JOIN nacionalidad nac 
		ON hue.id_nacionalidad=nac.id_nacionalidad
		INNER JOIN tipodocumento tipdoc 
		ON hue.id_tipodocumento=tipdoc.id_tipodocumento
		INNER JOIN hospedaje hos 
		ON hospe.id_hospedaje=hos.id_hospedaje
		INNER JOIN habitacion hab 
		ON hos.id_habitacion=hab.id_habitacion        
		WHERE hos.fechaingreso=DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND hos.horaingreso>'07:00'"; */

		/* ===================== HUESPEDES QUE SALIERON ===================== */
		$sql = "SELECT hospe.id_hospedar,hospe.estado, hue.nombcomp AS 'huesped', 
		hue.nrodocumento AS 'nrodoc', tipdoc.nombre AS 'tipodoc', hab.codigohabitacion AS 'habitacion', 
		DATE_FORMAT(hos.fechaingreso, '%d-%m-%Y') AS fechaingreso, DATE_FORMAT(hos.fechasalida, '%d-%m-%Y') AS fechasalida, 
		DATE_FORMAT(hos.horaingreso, '%H:%i') AS horaingreso, DATE_FORMAT(hos.horasalida, '%H:%i') AS horasalida,
		hospe.procedencia, hue.profesion, 
		TIMESTAMPDIFF(YEAR, hue.fenac, CURDATE()) AS edad, nac.nombre AS nacionalidad
		FROM hospedar hospe 
		INNER JOIN huesped hue 
		ON hospe.id_huesped=hue.id_huesped
		INNER JOIN nacionalidad nac 
		ON hue.id_nacionalidad=nac.id_nacionalidad
		INNER JOIN tipodocumento tipdoc 
		ON hue.id_tipodocumento=tipdoc.id_tipodocumento
		INNER JOIN hospedaje hos 
		ON hospe.id_hospedaje=hos.id_hospedaje
		INNER JOIN habitacion hab 
		ON hos.id_habitacion=hab.id_habitacion        
		WHERE hos.fechasalida=DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND hos.horasalida>'07:00'";


		$parametros = array();

		if($nrodoc!=""){
			$sql .= " AND hue.nrodocumento LIKE :nrodoc ";
			$parametros[':nrodoc'] = "%".$nrodoc."%";
		}

		if($tipodoc!=""){
			$sql .= " AND hue.id_tipodocumento = :tipodoc ";
			$parametros[':tipodoc'] = $tipodoc; 
		}

		if($fechaingreso!=""){
			$sql .= " AND hos.fechaingreso LIKE :fechaingreso ";
			$parametros[':fechaingreso'] = "%".$fechaingreso."%";
		}

		if($fechasalida!=""){
			$sql .= " AND hos.fechasalida = :fechasalida ";
			$parametros[':fechasalida'] = $fechasalida; 
		}

		if($horaingreso!=""){
			$sql .= " AND hos.horaingreso LIKE :horaingreso ";
			$parametros[':horaingreso'] = "%".$horaingreso."%";
		}

		if($horasalida!=""){
			$sql .= " AND hos.horasalida = :horasalida ";
			$parametros[':horasalida'] = $horasalida; 
		}

		$sql .= " ORDER BY hospe.id_hospedar DESC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


}
?>