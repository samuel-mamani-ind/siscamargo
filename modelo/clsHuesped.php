<?php
require_once('conexion.php');

class clsHuesped{

	function listarHuesped($nroDoc, $tipoDoc, $nomHue, $estado){
		$sql = "SELECT hue.*, DATE_FORMAT(hue.fenac, '%d-%m-%Y') AS fechanac, tipdoc.nombre as 'tipdoc' FROM huesped hue 
		INNER JOIN tipodocumento tipdoc ON hue.id_tipodocumento=tipdoc.id_tipodocumento
		WHERE hue.estado<2 AND tipdoc.estado<2";
		$parametros = array();

		if($nroDoc!=""){
			$sql .= " AND hue.nrodocumento LIKE :nrodoc ";
			$parametros[':nrodoc'] = "%".$nroDoc."%";
		}

		if($tipoDoc!=""){
			$sql .= " AND hue.id_tipodocumento LIKE :tipodoc ";
			$parametros[':tipodoc'] = "%".$tipoDoc."%";
		}

		if($nomHue!=""){
			$sql .= " AND hue.nombcomp LIKE :nombhue ";
			$parametros[':nombhue'] = "%".$nomHue."%";
		}

		if($estado!=""){
			$sql .= " AND hue.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY hue.id_huesped DESC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function consultarTipoDocumento(){
		$sql = "SELECT * FROM tipodocumento";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function insertarHuesped($nomhuesped,$nacionalidad,$nrodoc,$profesion,$fenac,$tipodoc,$procedencia,$habitacion,$feing,$fesal,$obs) {
    $sqlHuesped = "INSERT INTO huesped (nombcomp, nrodocumento, id_tipodocumento, fenac, nacionalidad, profesion)
                   VALUES (:nombcomp, :nrodocumento, :id_tipodocumento, :fenac, :nacionalidad, :profesion)";
    
    $parametrosHuesped = array(
			":nombcomp" => $nomhuesped,
			":nrodocumento" => $nrodoc,
			":id_tipodocumento" => $tipodoc,
        ":fenac" => $fenac,
        ":nacionalidad" => $nacionalidad,
        ":profesion" => $profesion
		);
			

		global $cnx;
    $preHuesped = $cnx->prepare($sqlHuesped);
    $preHuesped->execute($parametrosHuesped);

    $idhuesped = $cnx->lastInsertId();

    $sqlHospedaje = "INSERT INTO hospedaje (procedencia, id_huesped, id_habitacion, fechaingreso, fechasalida, observacion)
                     VALUES (:procedencia, :idhuesped, :habitacion, :fechaingreso, :fechasalida, :observaciones)";
    
    $parametrosHospedaje = array(
        ":procedencia" => $procedencia,
        ":idhuesped" => $idhuesped,
        ":habitacion" => $habitacion,
        ":fechaingreso" => $feing,
        ":fechasalida" => $fesal,
        ":observaciones" => $obs
    );

    $preHospedaje = $cnx->prepare($sqlHospedaje);
    $preHospedaje->execute($parametrosHospedaje);

    return $preHospedaje;
}


	function verificarDuplicado($nrodoc, $tipodoc, $idhuesped){
		$sql = "SELECT * FROM huesped WHERE estado<2 AND nrodocumento=:nrodoc AND id_tipodocumento=:idtipodoc AND id_huesped<>:idhuesped";
		$parametros = array(":nrodoc"=>$nrodoc, ":idtipodoc"=>$tipodoc,":idhuesped"=>$idhuesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarHuesped($idhuesped){
		$sql = "SELECT * FROM huesped WHERE id_huesped=:idhuesped ";
		$parametros = array(":idhuesped"=>$idhuesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarHuesped($idhuesped, $nomhuesped,$nacionalidad,$nrodoc,$profesion,$fenac,$tipodoc){
		$sql = "UPDATE huesped SET nombcomp=:nombre, nrodocumento	=:nrodoc, id_tipodocumento=:idtipdoc, fenac=:fenac, nacionalidad=:nacionalidad, profesion=:prof WHERE id_huesped=:idhuesped";
		$parametros = array(
			":idhuesped"=>$idhuesped, 
			":nombre"=>$nomhuesped, 
			":nrodoc"=>$nrodoc, 
			":idtipdoc"=>$tipodoc, 
			":fenac"=>$fenac, 
			":nacionalidad"=>$nacionalidad, 
			":prof"=>$profesion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoHuesped($idhuesped, $estado){
		$sql = "UPDATE huesped SET estado=:estado WHERE id_huesped=:idhuesped";
		$parametros = array(":estado"=>$estado, ":idhuesped"=>$idhuesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function insertarHuespedHospedaje($id_huesped,$procedencia,$habitacion,$feing,$fesal,$obs){
		$sql = "INSERT INTO hospedaje(id_huesped, procedencia, id_habitacion,fechaingreso,fechasalida,observacion) VALUES(:idhuesped, :procedencia, :idhabitacion,:fechaingreso, :fechasalida, :observacion)";
		$parametros = array(
			":idhuesped"=>$id_huesped, 
			":procedencia"=>$procedencia,
			":idhabitacion"=>$habitacion,
			":fechaingreso"=>$feing, 
			":fechasalida"=>$fesal,
			":observacion"=>$obs  
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

		/* Validar por fecha */
		function verificarHospedajeDuplicado($id_huesped){
			$sql = "SELECT * FROM hospedaje
			WHERE estado=1 AND fechasalida>CURRENT_TIMESTAMP() AND id_huesped=:idhuesped";
			$parametros = array(':idhuesped'=>$id_huesped);
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute($parametros);
			return $pre;
		}

	/* Consultar habitacion */
	function consultarHabitacion(){
		$sql = "SELECT hab.*, tipohab.nombre as 'tipohabitacion' FROM habitacion hab INNER JOIN tipohabitacion tipohab ON hab.id_tipohabitacion=tipohab.id_tipohabitacion WHERE hab.estado<2 AND tipohab.estado<2";

		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

}
?>