<?php
/*****************************************************************/
/****************  MAGIC QUOTES ******************/
/*****************************************************************/
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
	//$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	$theValue = (!false) ? addslashes($theValue) : $theValue;
	switch ($theType) {

		case "text":
		$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;    
		case "long":

		case "int":
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		break;

		case "double":
		$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		break;

		case "date":
		$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;

		case "defined":
		$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		break;

	}
	return $theValue;
}

//Funcion Camellizar Todo
function CamellizarConGuiones($toClean) {
	//$toClean = utf8_decode ($toClean);
	$normalizeChars = array(
	'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 
	'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 
	'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 
	'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 
	'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 
	'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 
	'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f'
	);

	$toClean = str_replace('¿', '', $toClean);//Cambiamos ¿ por vacio
 	$toClean = str_replace('?', '', $toClean);//Cambiamos ? por vacio

	$toClean = strtr($toClean, $normalizeChars);//Normalizamos caracteres raros
	$toClean = strtolower($toClean);//Volvemos todas las letras en minusculas
	$toClean = str_replace('&', '-and-', $toClean);//Cambiamos el simbolo "&"
	$toClean = trim(preg_replace('/[^\w\d_ -]/si', '', $toClean));//removemos caracteres ilegales
	$toClean = str_replace(' ', ' ', $toClean);//Cambiamos espacios por guiones
	$toClean = str_replace('-', ' ', $toClean);//Cambiamos espacios por guiones
	$toClean = preg_replace('/__+/', '_', $toClean);
	$toClean = preg_replace('/\s\s+/', ' ', $toClean);
	$toClean = str_replace(' ', '-', $toClean);//Cambiamos espacios por guiones
	return $toClean;
}

function formatBytes($bytes, $precision = 2) { 
	$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

	$bytes = max($bytes, 0); 
	$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	$pow = min($pow, count($units) - 1); 

	$bytes /= pow(1024, $pow);

	return round($bytes, $precision) . ' ' . $units[$pow]; 
}

function dirSize($dir, $contador) {
	if (is_dir($dir)){
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if($object != _carpetaAdministrador){
					if (filetype($dir."/".$object) == "dir") $contador = dirSize($dir."/".$object, $contador); else $contador+=filesize($dir."/".$object);
				}
			}
		}
	}

	return $contador;
}

function contar_archivos($dir, $contador) {
	if (is_dir($dir)){
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if($object != _carpetaAdministrador){
					if (filetype($dir."/".$object) == "dir") $contador = contar_archivos($dir."/".$object, $contador); else $contador++;
				}
			}
		}
	}

	return $contador;
}

function revisarZip($dir, $arrayZips) {
	if (is_dir($dir)){
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir"){
					$arrayZips = revisarZip($dir."/".$object, $arrayZips);
				}else{
					$extension = end(explode(".", $object));
					if ($extension != "zip") {
						unlink($dir."/".$object);
					}else{
						$arrayZips[] = $object;
					}
				}
			}
		}
	}

	return $arrayZips;
}

function crearZip($dir, $zip) {
	if (is_dir($dir)){
		$zip -> addEmptyDir($dir);
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir"){
					crearZip($dir."/".$object, $zip);
				}else{
					$zip -> addFile($dir."/".$object, $dir."/".$object);
				}
			}
		}
	}
}

function download_file($archivo, $downloadfilename = null) {
	if (file_exists($archivo)) {
		$downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $downloadfilename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($archivo));

		ob_clean();
		flush();
		readfile($archivo);
		exit;
	}
}

//Limpiar comillas
function limpiar_comillas($toClean) {
	$toClean = str_replace("“", "\"", $toClean);
	$toClean = str_replace("”", "\"", $toClean);
	$toClean = str_replace("‘", "'", $toClean);
	$toClean = str_replace("’", "'", $toClean);
	return $toClean;
}

function quitar_comillas($toClean){
	$toClean = str_replace("\"", "", $toClean);
	$toClean = str_replace("'", "", $toClean);
	return $toClean;
}

//Validar Fecha
function isValidDate($string) {
	if (preg_match('/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/',$string)){
		return true;
	}else{ return false; }
}

//Validar Hora
function isValidHora($string) {
	if (preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',$string)){
		return true;
	}else{ return false; }
}

//Eliminar Archivos de una Carpeta.
function eli_archivos($dir) {
	if (is_dir($dir)){
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") eli_archivos($dir."/".$object); else unlink($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

/* Validamos que se encuentre logueado */
function validarLogueado($_conection){
    if (!isset($_SESSION[_sessionAdmin])) {
		return false;
	}else{
		$sql = 	sprintf("	SELECT * FROM a_tbl_cuentas 
							WHERE cue_id=%s AND cue_estado=1",
					GetSQLValueString($_SESSION[_sessionAdmin], "int")
				);
		$rs_sql = mysqli_query($_conection->connect(), $sql);
		if (!$rs_sql)
			return false;
	}

	return true;
}

function btnEstado($estado, $id){
	$checkedestado = ($estado) ? 'checked' : '';
	return '<input type="checkbox" '.$checkedestado.' class="btn-estado-table" data-id="'.$id.'" data-size="mini" data-on-text="Activado" data-off-text="Desactivado"> ';
	//return '<input type="checkbox" '.$checkedestado.' class="make-switch btn-estado-table" data-id="'.$id.'" data-size="mini" data-on-text="Activado" data-off-text="Desactivado"> ';
}

function btnDestacado($destacado, $id){
	$checkeddestacado = ($destacado) ? 'checked' : '';
	return '<input type="checkbox" '.$checkeddestacado.' class="btn-destacado-table" data-id="'.$id.'" data-size="mini" data-on-text="Activado" data-off-text="Desactivado"> ';
	//return '<input type="checkbox" '.$checkeddestacado.' class="make-switch btn-destacado-table" data-id="'.$id.'" data-size="mini" data-on-text="Activado" data-off-text="Desactivado"> ';
}

function btnVistaPrevia($link){
	return sprintf('<a href="%s" class="btn btn-xs yellow margin-bottom-5" target="_blank"><i class="fa fa-search"></i> Vista Previa</a>', $link);
}

function btnEditar($link, $id){
	return sprintf('<a href="inicio.php?page=%s&id=%s" class="btn btn-xs green margin-bottom-5"><i class="fa fa-edit"></i> Editar</a>', $link, $id);
}

function btnVer($variablesVer, $id){
	$datas = ' data-id="'.$id.'" ';
	foreach ($variablesVer as $key => $value) {
		$datas .= ' data-'.$key.'="'.$value.'" ';
	}
	return sprintf('<a href="javascript:;" %s class="btn btn-xs green js-funcion-ver margin-bottom-5"><i class="fa fa-search"></i> Ver</a>', $datas);
}

function btnEliminar($id){
	return sprintf('<a href="javascript:;" data-id="%s" class="btn btn-xs red js-btn-eliminar margin-bottom-5"><i class="fa fa-trash"></i> Eliminar</a>', $id);
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

function cambiar_format($fecha){
	list($dia, $mes, $anho) = explode("/", $fecha);
	return date($anho.'-'.$mes.'-'.$dia);
}

function cambiar_format_mostrar($fecha){
	list($anho, $mes, $dia) = explode("-", $fecha);
	list($dia, $hora) = explode(" ", $dia);
	return date($dia.'/'.$mes.'/'.$anho);
}

function eliminarRegistrosTabla($_conection, $tabTipo, $arrayUno, $arrayRegistrosAsociados){
	//Extraemos el primer elemento y lo quitamos del arreglo
	$arrayDos = array_shift($arrayRegistrosAsociados);
	$tabIdRegistro = $arrayUno["id"];
	$tabNombre = $arrayUno["nombreTabla"];
	$tabPrefijo = $arrayUno["prefijo"];
	$carpetaArchivos = $arrayUno["nombreTabla"];
	
	$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
	$idTabla = $tabPrefijo.'id';

	if ($tabTipo == 'a_') {
		$pathFile = _carpetaA;
	}elseif ($tabTipo == 'g_') {
		$pathFile = _carpetaG;
	}else{
		$pathFile = _carpetaN;
	}

	if (($arrayUno["nombreTabla"]=="cuentas" || $arrayUno["nombreTabla"]=="gruposeccion") && $arrayUno["id"]==1) {
		return array('error' => true, 'mensaje' => 'No se puede eliminar el super administrador' );
	}

	$sql = sprintf("SELECT * FROM ".$tabTipo."tbl_".$arrayUno["nombreTabla"]." WHERE ".$arrayUno["prefijo"]."id=%s",
		GetSQLValueString($arrayUno["id"], "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		if (is_array($arrayDos)) {
			$sql_s = sprintf("SELECT * FROM ".$tabTipo."tbl_".$arrayDos["nombreTabla"]." WHERE ".$arrayDos["prefijo"].$arrayUno["prefijo"]."id=%s",
				GetSQLValueString($arrayUno["id"], "int")
			);
			$rs_sql_s = mysqli_query($_conection->connect(), $sql_s);
			while($row_sql_s = mysqli_fetch_assoc($rs_sql_s)){
				$arrayDos["id"] = $row_sql_s[$arrayDos["prefijo"]."id"];
				eliminarRegistrosTabla($_conection, $tabTipo, $arrayDos, $arrayRegistrosAsociados);
			}
		}

		//Eliminamos común y corriente
		$sql = sprintf("DELETE FROM ".$nombreTabla." WHERE ".$idTabla."=%s",
			GetSQLValueString($tabIdRegistro,"int")
		);
		$rs_sql = mysqli_query($_conection->connect(), $sql);
		if (!$rs_sql) {
			$error = _errorSql;
		}else{
			//Eliminamos los Metas del registro en la BD
			$sql = sprintf("DELETE FROM g_tbl_posicionamiento WHERE psc_tabla=%s AND psc_id_tabla=%s",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			//Eliminamos txtbanner del registro en la BD
			$sql = sprintf("DELETE FROM g_tbl_txtbanner WHERE txtb_tabla=%s AND txtb_id_tabla=%s AND (txtb_tipo_tabla=%s OR txtb_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			$sql = sprintf("DELETE FROM g_tbl_txtbanneren WHERE txtben_tabla=%s AND txtben_id_tabla=%s AND (txtben_tipo_tabla=%s OR txtben_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			$sql = sprintf("DELETE FROM g_tbl_txtbanner2campos WHERE txtcampos_tabla=%s AND txtcampos_id_tabla=%s AND (txtcampos_tipo_tabla=%s OR txtcampos_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			$sql = sprintf("DELETE FROM g_tbl_txtbanner2camposen WHERE txtencampos_tabla=%s AND txtencampos_id_tabla=%s AND (txtencampos_tipo_tabla=%s OR txtencampos_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			//Eliminamos audios del registro en la BD
			$sql = sprintf("DELETE FROM g_tbl_audios WHERE aud_tabla=%s AND aud_id_tabla=%s AND (aud_tipo_tabla=%s OR aud_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			//Eliminamos videos del registro en la BD
			$sql = sprintf("DELETE FROM g_tbl_videos WHERE vid_tabla=%s AND vid_id_tabla=%s AND (vid_tipo_tabla=%s OR vid_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			//Eliminamos carpeta del registro
			$nombreCarpeta = $pathFile.$carpetaArchivos.'/'.$tabIdRegistro.'/';
			if (file_exists($nombreCarpeta)){
				eli_archivos($nombreCarpeta);
			}

			//Eliminamos imágenes del registro en la BD
			$sql = sprintf("DELETE FROM g_tbl_imagenes WHERE img_tabla=%s AND img_id_tabla=%s AND (img_tipo_tabla=%s OR img_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);

			//Eliminamos descargas del registro en la BD
			$sql = sprintf("DELETE FROM g_tbl_archivos WHERE arc_tabla=%s AND arc_id_tabla=%s AND (arc_tipo_tabla=%s OR arc_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
		}
	}
}

function guardarPosicionamiento($data, $variables, $id, $_conection){
	$pscTitle		= 	utf8_decode($data["psc-title"]);
	$pscTags		= 	utf8_decode($data["psc-tags"]);
	$pscDescripcion	= 	utf8_decode($data["psc-descripcion"]);
	$pscFocuskeyword= 	utf8_decode($data["psc-focus-keyword"]);
	$pscTabla		= 	$variables['dbNombre'];
	$pscId = $id;

	//reemplazar espacios por comas
	$pscTags = str_replace(",", " ", $pscTags);
	$pscTags = preg_replace('/\s\s+/', ' ', $pscTags);
	$pscTags = str_replace(" ", ",", $pscTags);

	//Revisamos si se encuentra en base de datos ya
	$sql = sprintf("SELECT * FROM g_tbl_posicionamiento WHERE psc_tabla=%s AND psc_id_tabla=%s",
		GetSQLValueString($pscTabla,"text"),
		GetSQLValueString($pscId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$row_sql = mysqli_fetch_assoc($rs_sql);
	if (!$row_sql['psc_id_tabla']) {
		$sql = sprintf("	INSERT INTO g_tbl_posicionamiento 
								(
									psc_tabla,
									psc_id_tabla,
									psc_titulo,
									psc_tags,
									psc_descripcion,
									psc_focuskeyword
								)
								VALUES (%s,%s,%s,%s,%s,%s)",
			GetSQLValueString($pscTabla,"text"),
			GetSQLValueString($pscId, "int"),
			GetSQLValueString($pscTitle, "text"),
			GetSQLValueString($pscTags, "text"),
			GetSQLValueString($pscDescripcion, "text"),
			GetSQLValueString($pscFocuskeyword, "text")
		);
	}else{
		$sql = sprintf("	UPDATE g_tbl_posicionamiento 
								SET
									psc_titulo=%s,
									psc_tags=%s,
									psc_descripcion=%s,
									psc_focuskeyword=%s
								 WHERE psc_tabla=%s AND psc_id_tabla=%s",
			GetSQLValueString($pscTitle, "text"),
			GetSQLValueString($pscTags, "text"),
			GetSQLValueString($pscDescripcion, "text"),
			GetSQLValueString($pscFocuskeyword, "text"),
			GetSQLValueString($pscTabla,"text"),
			GetSQLValueString($pscId, "int")
		);
	}

	$rs_sql = mysqli_query($_conection->connect(), $sql);
	if ($rs_sql) {
		return true;
	}

	return false;
}

function mostrarPosicionamiento($data, $variables, $id, $_conection){
	$pscTitle		= 	utf8_decode($data["psc-title"]);
	$pscTags		= 	utf8_decode($data["psc-tags"]);
	$pscDescripcion	= 	utf8_decode($data["psc-descripcion"]);
	$pscTabla		= 	$variables['dbNombre'];
	$pscId = $id;

	//reemplazar espacios por comas
	$pscTags = str_replace(",", " ", $pscTags);
	$pscTags = preg_replace('/\s\s+/', ' ', $pscTags);
	$pscTags = str_replace(" ", ",", $pscTags);

	//Revisamos si se encuentra en base de datos ya
	$sql = sprintf("SELECT * FROM g_tbl_posicionamiento WHERE psc_tabla=%s AND psc_id_tabla=%s",
		GetSQLValueString($pscTabla,"text"),
		GetSQLValueString($pscId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$row_sql = mysqli_fetch_assoc($rs_sql);

	$psc['psc_titulo'] = utf8_encode($row_sql['psc_titulo']);
	$psc['psc_tags'] = utf8_encode($row_sql['psc_tags']);
	$psc['psc_descripcion'] = utf8_encode($row_sql['psc_descripcion']);
	$psc['psc_focuskeyword'] = utf8_encode($row_sql['psc_focuskeyword']);

	return $psc;
}

//Mostrar Archivos

function templateArchivos($tipoArchivo, $variables, $tabIdRegistro, $atributosArchivo){
	//Info Tabla Archivo
	$tabTipo = utf8_decode($variables['dbTipo']);
	$tabIdRegistro = utf8_decode($tabIdRegistro);
	$tabNombre = utf8_decode($variables['dbNombre']);
	$tabPrefijo = utf8_decode($variables['dbPrefijo']);
	$carpetaArchivos = utf8_decode($variables['dbNombre']);
	
	//Archivos
	$id = 'manejoarchivo-'.$tipoArchivo.'-'.$tabIdRegistro.'-'.$atributosArchivo['id'];
	$arc_nombre = $atributosArchivo['nombre'];
	$arc_extension = $atributosArchivo['extension'];
	$arc_principal = $atributosArchivo['principal'];
	$arc_rotate = $atributosArchivo['rotate'];
	$arc_cropboxdata = $atributosArchivo['cropboxdata'];
	$arc_canvasdata = $atributosArchivo['canvasdata'];
	$arc_link = $atributosArchivo['link'];

	$arc_nombrecompleto = $arc_nombre.'.'.$arc_extension;
	if ($tabTipo == 'a_') {
		$pathFile = _carpetaA;
		$pathFileMostrar = _carpetaMostrarA;
	}elseif ($tabTipo == 'g_') {
		$pathFile = _carpetaG;
		$pathFileMostrar = _carpetaMostrarG;
	}else{
		$pathFile = _carpetaN;
		$pathFileMostrar = _carpetaMostrarN;
	}
	$dir = $pathFile.$carpetaArchivos.'/'.$tabIdRegistro.'/';
	$dirMostrar = $pathFileMostrar.$carpetaArchivos.'/'.$tabIdRegistro.'/';

	if ($arc_nombrecompleto && file_exists($dir.$arc_nombrecompleto)) {
		if ($tipoArchivo == 1) {
			$prefijoTable = 'img_';
			$tablebd = 'g_tbl_imagenes';
			$checkPrincipal = '';
		}else{
			$prefijoTable = 'arc_';
			$tablebd = 'g_tbl_archivos';
			$checkPrincipal = 'hidden';
		}

		$checked = ($arc_principal) ? 'checked' : '';

		$random = rand(0,100);
		if ($tablebd == 'g_tbl_imagenes') {
			$data_Tipo = 'imagenes';
			$mArchivo = '<img alt="Gallery Image" class="image-seccion" src="'.$dirMostrar.$arc_nombrecompleto.'?nocache='.$random.'">';
			$btnExtrasImagen = '<a class="btn green-adele btn-xs fancybox-button" href="'.$dirMostrar.$arc_nombrecompleto.'" title="'.$arc_nombrecompleto.'" data-rel="fancybox-button"><i class="fa fa-search"></i></a> ';
			$btnExtrasImagen .= '<a class="btn green-adele btn-xs js-recortar-imagen" data-id="'.$id.'" href="javascript:;" ><i class="fa fa-crop"></i></a> ';
			$mCapasImagenes = '<div class="mascara-opacity-negro"></div><div class="mascara-png"></div>';
			$mImagenCheckbox = ($variables['atributoImageIndividual']) ? '<label><input type="checkbox" class="uniform-checkbox-items-image check-image" name="items-check-image" value="'.$atributosArchivo['id'].'"> Id #'.$atributosArchivo['id'].'</label>' : '';
		}else{
			$data_Tipo = 'archivos';
			$mArchivo = '<i class="fa fa-file"></i><br>'.$arc_nombre.'.'.$arc_extension;
		}

		$infoArchivo = pathinfo($dir.$arc_nombre);

		//Para GY
		if ($variables['dbNombre'] == 'fotos') {
			$inputLink = '<br><input type="text" class="form-control qtipmensaje editarArchivoLinkInput" placeholder="Link" value="'.$arc_link.'">';
		}
		
		$archivo = '<div class="col-md-3 manejoarchivos"
						id="'.$id.'"
						data-tipo="'.$data_Tipo.'"
						data-bd-id="'.$tabIdRegistro.'"
						data-tb-id="'.$atributosArchivo['id'].'"
						data-principal="'.$arc_principal.'"
						data-nombre="'.$arc_nombre.'"
						data-cropboxdata="'.$arc_cropboxdata.'"
						data-canvasdata="'.$arc_canvasdata.'"
						data-rotate="'.$arc_rotate.'"
						data-link="'.$arc_link.'"
					>
						<div class="thumbnail">
							'.$mImagenCheckbox.'
							<div data-id="'.$id.'" class="thumbnail-view text-center pos-relative">
								'.$mArchivo.'
								'.$mCapasImagenes.'
							</div>
							<div class="caption text-center">
								<div class="editarNombre hidden">
									<input type="text" class="form-control qtipmensaje editarArchivoInput" placeholder="Nombre Archivo" value="'.$infoArchivo['filename'].'">
									'.$inputLink.'
									<div class="checkbox '.$checkPrincipal.'">
										<label>
											<input type="checkbox" class="editarArchivoCheck" '.$checked.'>
											Principal
										</label>
									</div>

									<a class="guardar-archivos btn btn-xs btn-success margin-right-5" data-id="'.$id.'" href="javascript:;">Guardar</a>
									<a class="cancelar-archivos btn btn-xs btn-danger" data-id="'.$id.'" href="javascript:;">Cancelar</a>
								</div>

								<div class="editarCambiarTamano hidden">
									<div class="js-tamanos-recortar-opciones"></div>
									<a class="cancelar-archivos btn btn-xs btn-danger" data-id="'.$id.'" href="javascript:;">Cancelar</a>
								</div>

								<div class="accionesArchivos btn-group">
									'.$btnExtrasImagen.'
									<a class="editar-archivos btn green-adele btn-xs tooltips" data-container="body" data-id="'.$id.'" href="javascript:;"><i class="fa fa-pencil"></i></a>
									<a class="js-btn-eliminar-archivo btn green-adele btn-xs tooltips" data-container="body" data-id="'.$id.'" href="javascript:;"><i class="fa fa-trash-o"></i></a>
								</div>
							</div>
						</div>
					</div>';
	}
	return $archivo;
}

function guardarAudios($data, $variables, $id, $_conection){
	$soundclouds = $data["soundcloud"];
	$audTabla =	$variables['dbNombre'];
	$audId = $id;

	$sql = sprintf("DELETE FROM g_tbl_audios WHERE aud_tabla=%s AND aud_id_tabla=%s",
		GetSQLValueString($audTabla,"text"),
		GetSQLValueString($audId, "int")	
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);

	foreach ($soundclouds as $key => $audio) {
		$inicia = strrpos($audio, '<iframe');
		$termina = strrpos($audio, '</iframe>') + 9;
		$audio = substr($audio, $inicia, $termina);

		$url = strrpos($audio, 'https://w.soundcloud.com/player/?url=');
		if ( ($inicia>=0) && ($termina>=0) && ($url>=0) ) {
			$sql = sprintf("	INSERT INTO g_tbl_audios 
									(
										aud_tabla,
										aud_id_tabla,
										aud_link
									)
									VALUES (%s,%s,%s)",
				GetSQLValueString($audTabla,"text"),
				GetSQLValueString($audId, "int"),
				GetSQLValueString($audio, "text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
		}
	}

	return false;
}

function guardarVideos($data, $variables, $id, $_conection){
	$regYoutube = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";
	$regVimeo = "/^.*(vimeo\.com\/)((channels\/[A-z]+\/)|video\/|(groups\/[A-z]+\/videos\/))?([0-9]+)/";

	$videos = $data["videos"];
	$start = $data["start"];
	$end = $data["end"];
	$vidTabla =	$variables['dbNombre'];
	$vidId = $id;

	$sql = sprintf("DELETE FROM g_tbl_videos WHERE vid_tabla=%s AND vid_id_tabla=%s",
		GetSQLValueString($vidTabla,"text"),
		GetSQLValueString($vidId, "int")	
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);

	$contVideos = 0;
	foreach ($videos as $key => $video) {
		$error = 0;
		if(preg_match($regYoutube, $video, $matches)){
			$video = '//www.youtube.com/embed/'.$matches[7];
		}elseif(preg_match($regVimeo, $video, $matches)){
			$video = '//player.vimeo.com/video/'.$matches[5];
		}else{
			$error = 1;
		}
		$video = str_replace(" ", "", $video);

		if ($error == 0) {
			$sql = sprintf("	INSERT INTO g_tbl_videos 
									(
										vid_tabla,
										vid_id_tabla,
										vid_url,
										vid_start,
										vid_end
									)
									VALUES (%s,%s,%s,%s,%s)",
				GetSQLValueString($vidTabla,"text"),
				GetSQLValueString($vidId, "int"),
				GetSQLValueString($video, "text"),
				GetSQLValueString($start[$contVideos], "text"),
				GetSQLValueString($end[$contVideos], "text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
		}

		$contVideos++;
	}

	return false;
}

function guardarTxtbanner($data, $variables, $id, $_conection){
	$txtbanners		= 	$data["txtbanner"];
	$txtbannerfuente		= 	$data["txtbannerfuente"];
	$txtbTabla =	$variables['dbNombre'];
	$txtbId = $id;

	$sql = sprintf("DELETE FROM g_tbl_txtbanner WHERE txtb_tabla=%s AND txtb_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")	
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$i = 0;
	foreach ($txtbanners as $key => $txtbanner) {
		$error = 0;

		if ($error == 0) {
			$sql = sprintf("	INSERT INTO g_tbl_txtbanner 
									(
										txtb_tabla,
										txtb_id_tabla,
										txtb_texto,
										txtb_fuente
									)
									VALUES (%s,%s,%s,%s)",
				GetSQLValueString($txtbTabla,"text"),
				GetSQLValueString($txtbId, "int"),
				GetSQLValueString(utf8_decode($txtbanner), "text"),
				GetSQLValueString($txtbannerfuente[$i], "int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
		}
		$i++;
	}

	return false;
}

function guardarTxtbanneren($data, $variables, $id, $_conection){
	$txtbanners		= 	$data["txtbanneren"];
	$txtbannerfuente		= 	$data["txtbannerenfuente"];
	$txtbTabla =	$variables['dbNombre'];
	$txtbId = $id;

	$sql = sprintf("DELETE FROM g_tbl_txtbanneren WHERE txtben_tabla=%s AND txtben_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")	
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$i = 0;
	foreach ($txtbanners as $key => $txtbanner) {
		$error = 0;

		if ($error == 0) {
			$sql = sprintf("	INSERT INTO g_tbl_txtbanneren
									(
										txtben_tabla,
										txtben_id_tabla,
										txtben_texto,
										txtben_fuente
									)
									VALUES (%s,%s,%s,%s)",
				GetSQLValueString($txtbTabla,"text"),
				GetSQLValueString($txtbId, "int"),
				GetSQLValueString(utf8_decode($txtbanner), "text"),
				GetSQLValueString($txtbannerfuente[$i], "int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
		}
		$i++;
	}

	return false;
}

function guardarTxtbanner2campos($data, $variables, $id, $_conection){
	$txtbanners				= 	$data["txtbanner2campos"];
	$txtbannersdescripcion	= 	$data["txtbanner2camposdescripcion"];
	$txtbTabla 				=	$variables['dbNombre'];
	$txtbId 				= 	$id;

	$sql = sprintf("DELETE FROM g_tbl_txtbanner2campos WHERE txtcampos_tabla=%s AND txtcampos_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")	
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$i = 0;
	foreach ($txtbanners as $key => $txtbanner) {
		$error = 0;

		if ($error == 0) {
			$sql = sprintf("	INSERT INTO g_tbl_txtbanner2campos
									(
										txtcampos_tabla,
										txtcampos_id_tabla,
										txtcampos_titulo,
										txtcampos_descripcion
									)
									VALUES (%s,%s,%s,%s)",
				GetSQLValueString($txtbTabla,"text"),
				GetSQLValueString($txtbId, "int"),
				GetSQLValueString(utf8_decode($txtbanner), "text"),
				GetSQLValueString(utf8_decode($txtbannersdescripcion[$i]), "text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
		}
		$i++;
	}

	return false;
}

function guardarTxtbannercampos($data, $variables, $id, $_conection){
	$txtbanners				= 	$data["txtbannercampos"];
	$txtbannersdescripcion	= 	$data["txtbannercamposdescripcion"];
	$txtbTabla 				=	$variables['dbNombre'];
	$txtbId 				= 	$id;

	$sql = sprintf("DELETE FROM g_tbl_txtbanner2camposen WHERE txtencampos_tabla=%s AND txtencampos_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")	
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$i = 0;
	foreach ($txtbanners as $key => $txtbanner) {
		$error = 0;

		if ($error == 0) {
			$sql = sprintf("	INSERT INTO g_tbl_txtbanner2camposen
									(
										txtencampos_tabla,
										txtencampos_id_tabla,
										txtencampos_titulo,
										txtencampos_descripcion
									)
									VALUES (%s,%s,%s,%s)",
				GetSQLValueString($txtbTabla,"text"),
				GetSQLValueString($txtbId, "int"),
				GetSQLValueString(utf8_decode($txtbanner), "text"),
				GetSQLValueString(utf8_decode($txtbannersdescripcion[$i]), "text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
		}
		$i++;
	}

	return false;
}

function mostrarAudios($data, $variables, $id, $_conection){
	$audTabla		= 	$variables['dbNombre'];
	$audId = $id;

	$sql = sprintf("SELECT * FROM g_tbl_audios WHERE aud_tabla=%s AND aud_id_tabla=%s",
		GetSQLValueString($audTabla,"text"),
		GetSQLValueString($audId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		$audios[] = $row_sql['aud_link'];
	}

	return $audios;
}

function mostrarVideos($data, $variables, $id, $_conection){
	$vidTabla		= 	$variables['dbNombre'];
	$vidId = $id;

	$sql = sprintf("SELECT * FROM g_tbl_videos WHERE vid_tabla=%s AND vid_id_tabla=%s",
		GetSQLValueString($vidTabla,"text"),
		GetSQLValueString($vidId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$contVideos = 0;
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		$videos[$contVideos]['videos'] = $row_sql['vid_url'];
		$videos[$contVideos]['start'] = $row_sql['vid_start'];
		$videos[$contVideos]['end'] = $row_sql['vid_end'];
		$contVideos++;
	}

	return $videos;
}

function mostrarTxtbanner($data, $variables, $id, $_conection){
	$txtbTabla		= 	$variables['dbNombre'];
	$txtbId = $id;

	$sql = sprintf("SELECT * FROM g_tbl_txtbanner WHERE txtb_tabla=%s AND txtb_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		$txtbanner[] = utf8_encode($row_sql['txtb_texto']);
		$txtbannerfuente[] = $row_sql['txtb_fuente'];
	}

	return array($txtbanner, $txtbannerfuente);
}

function mostrarTxtbanneren($data, $variables, $id, $_conection){
	$txtbTabla		= 	$variables['dbNombre'];
	$txtbId = $id;

	$sql = sprintf("SELECT * FROM g_tbl_txtbanneren WHERE txtben_tabla=%s AND txtben_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		$txtbanner[] = utf8_encode($row_sql['txtben_texto']);
		$txtbannerfuente[] = $row_sql['txtben_fuente'];
	}

	return array($txtbanner, $txtbannerfuente);
}

function mostrarTxtbanner2campos($data, $variables, $id, $_conection){
	$txtbTabla		= 	$variables['dbNombre'];
	$txtbId = $id;

	$sql = sprintf("SELECT * FROM g_tbl_txtbanner2campos WHERE txtcampos_tabla=%s AND txtcampos_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		$txtbanner[] = utf8_encode($row_sql['txtcampos_titulo']);
		$txtbannerdescripcion[] = nl2br(utf8_encode($row_sql['txtcampos_descripcion']));
		$txtbannerfuente[] = $row_sql['txtcampos_fuente'];
	}

	return array($txtbanner, $txtbannerdescripcion, $txtbannerfuente);
}

function mostrarTxtbannercampos($data, $variables, $id, $_conection){
	$txtbTabla		= 	$variables['dbNombre'];
	$txtbId = $id;

	$sql = sprintf("SELECT * FROM g_tbl_txtbanner2camposen WHERE txtencampos_tabla=%s AND txtencampos_id_tabla=%s",
		GetSQLValueString($txtbTabla,"text"),
		GetSQLValueString($txtbId, "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		$txtbanner[] = utf8_encode($row_sql['txtencampos_titulo']);
		$txtbannerdescripcion[] = nl2br(utf8_encode($row_sql['txtencampos_descripcion']));
		$txtbannerfuente[] = $row_sql['txtcamposen_fuente'];
	}

	return array($txtbanner, $txtbannerdescripcion, $txtbannerfuente);
}

function calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection){
	$progressCadaItem = 100/$progressPestanas;
	$progressReturnArray;
	$TotalPorcentaje = 0;
	foreach ($progressPestanasArray as $tipo => $cantidad) {
		if ($cantidad == 0){
			$progressReturnArray[$tipo] = 100;
			$TotalPorcentaje += ($progressReturnArray[$tipo] * $progressCadaItem) / 100;
		}else{
			if ($tipo == 'posicionamiento') {
				$prefijo = 'psc_';
				$sql = sprintf("SELECT * FROM g_tbl_".$tipo." WHERE ".$prefijo."tabla=%s AND ".$prefijo."id_tabla=%s",
					GetSQLValueString($variables['dbNombre'],"text"),
					GetSQLValueString($id, "int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				$row_sql = mysqli_fetch_assoc($rs_sql);

				$totalGeneral = 0;
				if ($row_sql[$prefijo."titulo"])
					$totalGeneral++;		
				if ($row_sql[$prefijo."tags"])
					$totalGeneral++;
				if ($row_sql[$prefijo."descripcion"])
					$totalGeneral++;

				$progressReturnArray[$tipo] = (($totalGeneral/$cantidad) * 100);
				$TotalPorcentaje += ($progressReturnArray[$tipo] * $progressCadaItem) / 100;

			}elseif ($tipo == 'imagenes'){
				$prefijo = 'img_';
				if ($cantidad == 1) {
					$sql = sprintf("SELECT count(*) AS total FROM g_tbl_".$tipo." WHERE ".$prefijo."tabla=%s AND (".$prefijo."tipo_tabla=%s OR ".$prefijo."tipo_tabla IS NULL) AND ".$prefijo."id_tabla=%s AND ".$prefijo."principal=1",
						GetSQLValueString($variables['dbNombre'],"text"),
						GetSQLValueString($variables['dbTipo'],"text"),
						GetSQLValueString($id, "int")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
					$row_sql = mysqli_fetch_assoc($rs_sql);

					if($row_sql['total'] > 1)
						$row_sql['total'] = 1;

					$progressReturnArray[$tipo] = (($row_sql['total']/$cantidad) * 100);
					$TotalPorcentaje += ($progressReturnArray[$tipo] * $progressCadaItem) / 100;
				}else{
					$sql = sprintf("SELECT count(*) AS total FROM g_tbl_".$tipo." WHERE ".$prefijo."tabla=%s AND (".$prefijo."tipo_tabla=%s OR ".$prefijo."tipo_tabla IS NULL) AND ".$prefijo."id_tabla=%s",
						GetSQLValueString($variables['dbNombre'],"text"),
						GetSQLValueString($variables['dbTipo'],"text"),
						GetSQLValueString($id, "int")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
					$row_sql = mysqli_fetch_assoc($rs_sql);
					if ($row_sql['total'] > $cantidad){
						$progressReturnArray[$tipo] = 100;
						$TotalPorcentaje += ($progressReturnArray[$tipo] * $progressCadaItem) / 100;
					}else{
						$progressReturnArray[$tipo] = (($row_sql['total']/$cantidad) * 100);
						$TotalPorcentaje += ($progressReturnArray[$tipo] * $progressCadaItem) / 100;
					}
				}
			}elseif ($tipo == 'imagenes_secundarias'){
				$tipo = "imagenes";
				$prefijo = 'img_';
				if ($cantidad == 1) {
					$sql = sprintf("SELECT count(*) AS total FROM g_tbl_".$tipo." WHERE ".$prefijo."tabla=%s AND (".$prefijo."tipo_tabla=%s OR ".$prefijo."tipo_tabla IS NULL) AND ".$prefijo."id_tabla=%s AND ".$prefijo."principal=1",
						GetSQLValueString($variables['dbNombre']."-secundarias","text"),
						GetSQLValueString($variables['dbTipo'],"text"),
						GetSQLValueString($id, "int")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
					$row_sql = mysqli_fetch_assoc($rs_sql);

					if($row_sql['total'] > 1)
						$row_sql['total'] = 1;

					$progressReturnArray[$tipo."_secundarias"] = (($row_sql['total']/$cantidad) * 100);
					$TotalPorcentaje += ($progressReturnArray[$tipo."_secundarias"] * $progressCadaItem) / 100;
				}else{
					$sql = sprintf("SELECT count(*) AS total FROM g_tbl_".$tipo." WHERE ".$prefijo."tabla=%s AND (".$prefijo."tipo_tabla=%s OR ".$prefijo."tipo_tabla IS NULL) AND ".$prefijo."id_tabla=%s",
						GetSQLValueString($variables['dbNombre']."-secundarias","text"),
						GetSQLValueString($variables['dbTipo'],"text"),
						GetSQLValueString($id, "int")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
					$row_sql = mysqli_fetch_assoc($rs_sql);
					if ($row_sql['total'] > $cantidad){
						$progressReturnArray[$tipo."_secundarias"] = 100;
						$TotalPorcentaje += ($progressReturnArray[$tipo."_secundarias"] * $progressCadaItem) / 100;
					}else{
						$progressReturnArray[$tipo."_secundarias"] = (($row_sql['total']/$cantidad) * 100);
						$TotalPorcentaje += ($progressReturnArray[$tipo."_secundarias"] * $progressCadaItem) / 100;
					}
				}
			}else{
				if ($tipo == 'audios') {
					$prefijo = 'aud_';
				}elseif($tipo == 'videos'){
					$prefijo = 'vid_';
				}elseif($tipo == 'archivos'){
					$prefijo = 'arc_';
				}elseif($tipo == 'txtbanner'){
					$prefijo = 'txtb_';
				}elseif($tipo == 'txtbanneren'){
					$prefijo = 'txtben_';
				}elseif($tipo == 'txtbanner2campos'){
					$prefijo = 'txtcampos_';
				}

				$sql = sprintf("SELECT count(*) AS total FROM g_tbl_".$tipo." WHERE ".$prefijo."tabla=%s AND (".$prefijo."tipo_tabla=%s OR ".$prefijo."tipo_tabla IS NULL) AND ".$prefijo."id_tabla=%s",
					GetSQLValueString($variables['dbNombre'],"text"),
					GetSQLValueString($variables['dbTipo'],"text"),
					GetSQLValueString($id, "int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				$row_sql = mysqli_fetch_assoc($rs_sql);
				if ($row_sql['total'] > $cantidad){
					$progressReturnArray[$tipo] = 100;
					$TotalPorcentaje += ($progressReturnArray[$tipo] * $progressCadaItem) / 100;
				}else{
					$progressReturnArray[$tipo] = (($row_sql['total']/$cantidad) * 100);
					$TotalPorcentaje += ($progressReturnArray[$tipo] * $progressCadaItem) / 100;
				}
			}
		}
	}//Termina foreach
	return array($TotalPorcentaje, $progressReturnArray);
}

function progressTabla($porcentaje){
	if ($porcentaje >=0 && $porcentaje<=50) {
		$classProgress = 'danger';
	}elseif ($porcentaje >50 && $porcentaje<=75) {
		$classProgress = 'warning';
	}else{
		$classProgress = 'success';
	}
	
	return '<div class="progress progress-striped active progress-adele">
		<div class="progress-bar progress-bar-'.$classProgress.'" role="progressbar" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$porcentaje.'%">
			<span class="sr-only">
			'.$porcentaje.'% Complete ('.$classProgress.') </span>
		</div>
	</div>';
}

function correosPHPMAILER($Correos){
	$arregloCorreos = explode(',', $Correos);
	foreach($arregloCorreos as $correo){
		$correo = str_replace(" ", "", $correo);
		if (preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#", $correo)) {
			$correosContacto .= $correo.',';
		}
	}
	$correosContacto = trim($correosContacto, ',');
	return $correosContacto;
}

/* Nivel  Página */
function url_exists($url){
	$url = str_replace("http://", "", $url);
	if (strstr($url, "/")) {
		$url = explode("/", $url, 2);
		$url[1] = "/".$url[1];
	} else {
		$url = array($url, "/");
	}

	$fh = fsockopen($url[0], 80);
	if ($fh) {
		fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
		if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
		else { return TRUE;    }
	} else { return FALSE;}
}

function url_exists_js( $url = NULL ) {
    if(( $url == '' ) ||( $url == NULL ) )
        return false;
    $headers = @get_headers( $url );
    sscanf($headers[0], 'HTTP/%*d.%*d %d', $httpcode);
    //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
    $accepted_response = array(200,301,302);
    if( in_array( $httpcode, $accepted_response ) )
        return true;
    else
        return false;
}

/*PARTE PÁGINA*/
function extraerMetas($_conection, $tabNombre, $id, $seo = false){
	$sql = sprintf("SELECT * FROM g_tbl_posicionamiento WHERE psc_tabla=%s AND psc_id_tabla=%s",
		GetSQLValueString($tabNombre,"text"),
		GetSQLValueString($id,"int")	
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
		$psc['psc_titulo'] = utf8_encode($row_sql['psc_titulo']);
		$psc['psc_tags'] = utf8_encode($row_sql['psc_tags']);
		$psc['psc_descripcion'] = utf8_encode($row_sql['psc_descripcion']);
	}

	//Extraer SEO
	if ($seo) {
		$prefijo = $seo["prefijo"];
		$tabla = "tbl_" . $tabNombre;

		//Tabla donde buscaremos el Title y la Descripción del SEO
		$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
			GetSQLValueString($id,"int")
		);
		$rs_sql = mysqli_query($_conection->connect(), $sql);
		$row_seccion = mysqli_fetch_assoc($rs_sql);

		//Armamos el Snippet
		$sql = sprintf("SELECT pag_titulo FROM a_tbl_pagina WHERE pag_id=1");
		$rs_sql = mysqli_query($_conection->connect(), $sql);
		$row_sql = mysqli_fetch_assoc($rs_sql);

		$title = $row_seccion[$prefijo.$seo["title"]];
		if (!$psc['psc_titulo']) 
			$psc['psc_titulo'] = utf8_encode($title . ' - ' . $row_sql['pag_titulo']);

		if (!$psc['psc_descripcion'])
			$psc['psc_descripcion'] = utf8_encode(substr(strip_tags($row_seccion[$prefijo.$seo["contenido"]]), 0, 156));
	}

	return $psc;
}

function extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras){
	if($img_principal == 'ambas'){
		$busqueda_principal = ' ORDER BY img_principal DESC, img_nombre ASC';
	}else if($img_principal == 1){
		$busqueda_principal = ' AND img_principal=1 ORDER BY img_nombre ASC';
	}else{
		$busqueda_principal = ' AND img_principal!=1 ORDER BY img_nombre ASC';
	}

	$carpetaImagenes = 'imagenes-contenidos/';

	if ($variablesExtras['administrador'])
		$carpetaImagenes = _carpetaMostrarN;
	
	if ($variablesExtras['datatable'])
		$carpetaImagenes = _carpetaN;

	if ($variablesExtras['campana'])
		$carpetaImagenes = '../imagenes-contenidos/';

	if ($variablesExtras['carpeta_admin'])
		$carpetaImagenes = _carpetaA;

	$sql = sprintf("SELECT * FROM g_tbl_imagenes WHERE img_tabla=%s AND (img_tipo_tabla=%s OR img_tipo_tabla IS NULL) AND img_id_tabla=%s ".$busqueda_principal,
		GetSQLValueString($tabNombre,"text"),
		GetSQLValueString($tabTipo,"text"),
		GetSQLValueString($id,"int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$i=0;
	while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
		$id = $row_sql['img_id_tabla'];
		$nombre = $row_sql['img_nombre'];
		$extension = $row_sql['img_extension'];
		$thumb = $row_sql['img_thumb'];
		//$link[] = $row_sql['img_link'];

		$nombreImagen = $nombre.'.'.$extension;
		$carpetaImagen = $carpetaImagenes.$tabNombre.'/'.$id.'/';

		if ($variablesExtras['thumbnail'] == 'si') {
			if(file_exists($carpetaImagen.$nombreImagen)){
				$imagenesTh[$i][0] = $carpetaImagen.$nombreImagen;
			}

			if ($thumb == 1 && file_exists($carpetaImagen.'thumbnail/'.$nombreImagen)) {
				$imagenesTh[$i][1] = $carpetaImagen.'thumbnail/'.$nombreImagen;
			}
		}

		if ($thumb == 1) {
			if(file_exists($carpetaImagen.'thumbnail/'.$nombreImagen))
				$imagenes[] = $carpetaImagen.'thumbnail/'.$nombreImagen;
			else
				$imagenes[] = $carpetaImagen.$nombreImagen;
		}else{
			if(file_exists($carpetaImagen.$nombreImagen)){
				$imagenes[] = $carpetaImagen.$nombreImagen;
			}else{
				//$imagenes[] = '';
			}
		}

		$i++;
	}

	if ($variablesExtras['thumbnail'] == 'si')
		return $imagenesTh;

	if ($linktrue == 'link')
		return array($imagenes, $link);

	return $imagenes;
}

function extraerArchivos($_conection, $tabNombre, $tabTipo, $id, $variablesExtras){

	$carpetaImagenes = 'imagenes-contenidos/';

	if ($variablesExtras['administrador'])
		$carpetaImagenes = _carpetaMostrarN;
	
	if ($variablesExtras['datatable'])
		$carpetaImagenes = _carpetaN;

	if ($variablesExtras['campana'])
		$carpetaImagenes = '../imagenes-contenidos/';

	$sql = sprintf("SELECT * FROM g_tbl_archivos WHERE arc_tabla=%s AND (arc_tipo_tabla=%s OR arc_tipo_tabla IS NULL) AND arc_id_tabla=%s ",
		GetSQLValueString($tabNombre,"text"),
		GetSQLValueString($tabTipo,"text"),
		GetSQLValueString($id,"int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
		$id = $row_sql['arc_id_tabla'];
		$nombre = $row_sql['arc_nombre'];
		$extension = $row_sql['arc_extension'];

		$nombreImagen = $nombre.'.'.$extension;
		$carpetaImagen = $carpetaImagenes.$tabNombre.'/'.$id.'/';

		if ($thumb == 1) {
			if(file_exists($carpetaImagen.'thumbnail/'.$nombreImagen))
				$archivos[] = $carpetaImagen.'thumbnail/'.$nombreImagen;
			else
				$archivos[] = $carpetaImagen.$nombreImagen;
		}else{
			if(file_exists($carpetaImagen.$nombreImagen)){
				$archivos[] = $carpetaImagen.$nombreImagen;
			}else{
				$archivos[] = '';
			}
		}
	}

	if ($linktrue == 'link') {
		return array($archivos, $link);
	}
	return $archivos;
}

function extraerAudios($_conection, $tabNombre, $tabTipo, $id){
	$sql = sprintf("SELECT * FROM g_tbl_audios WHERE aud_tabla=%s AND (aud_tipo_tabla=%s OR aud_tipo_tabla IS NULL) AND aud_id_tabla=%s ",
		GetSQLValueString($tabNombre,"text"),
		GetSQLValueString($tabTipo,"text"),
		GetSQLValueString($id,"int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
		$id = $row_sql['aud_id_tabla'];
		$audios[] = $row_sql['aud_link'];
	}

	return $audios;
}

function extraerVideos($_conection, $tabNombre, $tabTipo, $id){
	$sql = sprintf("SELECT * FROM g_tbl_videos WHERE vid_tabla=%s AND (vid_tipo_tabla=%s OR vid_tipo_tabla IS NULL) AND vid_id_tabla=%s ",
		GetSQLValueString($tabNombre,"text"),
		GetSQLValueString($tabTipo,"text"),
		GetSQLValueString($id,"int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$contVideos = 0;
	while($row_sql = mysqli_fetch_assoc($rs_sql)){
		$videos[$contVideos]['videos'] = $row_sql['vid_url'];
		$videos[$contVideos]['start'] = $row_sql['vid_start'];
		$videos[$contVideos]['end'] = $row_sql['vid_end'];
		$contVideos++;
	}

	return $videos;
}

function functionNombreImagen($msg){
	$msg = end(explode("/", $msg));
	$extension = end(explode(".", $msg));
	$msg = str_replace(".".$extension, "", $msg);
	$msg = CamellizarConGuiones($msg);
	return $msg;
}

/**
 * corta el texto en x caracteres sin perder el cierre de los tags html
 * @param <string> $text
 * @param <integer> $length
 * @param <array> $options
 * @return <string>
 */
function cortarTexto($text, $length = 100, $options = array()) {
	$default = array(
		'ending' => '...', 'exact' => true, 'html' => true
	);
	$options = array_merge($default, $options);
	extract($options);

	if ($html) {
		if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		$totalLength = mb_strlen(strip_tags($ending));
		$openTags = array();
		$truncate = '';

		preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
		foreach ($tags as $tag) {
			if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
				if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
					array_unshift($openTags, $tag[2]);
				} else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
					$pos = array_search($closeTag[1], $openTags);
					if ($pos !== false) {
						array_splice($openTags, $pos, 1);
					}
				}
			}
			$truncate .= $tag[1];

			$contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
			if ($contentLength + $totalLength > $length) {
				$left = $length - $totalLength;
				$entitiesLength = 0;
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
					foreach ($entities[0] as $entity) {
						if ($entity[1] + 1 - $entitiesLength <= $left) {
							$left--;
							$entitiesLength += mb_strlen($entity[0]);
						} else {
							break;
						}
					}
				}

				$truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
				break;
			} else {
				$truncate .= $tag[3];
				$totalLength += $contentLength;
			}
			if ($totalLength >= $length) {
				break;
			}
		}
	} else {
		if (mb_strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = mb_substr($text, 0, $length - mb_strlen($ending));
		}
	}
	if (!$exact) {
		$spacepos = mb_strrpos($truncate, ' ');
		if (isset($spacepos)) {
			if ($html) {
				$bits = mb_substr($truncate, $spacepos);
				preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
				if (!empty($droppedTags)) {
					foreach ($droppedTags as $closingTag) {
						if (!in_array($closingTag[1], $openTags)) {
							array_unshift($openTags, $closingTag[1]);
						}
					}
				}
			}
			$truncate = mb_substr($truncate, 0, $spacepos);
		}
	}
	$truncate .= $ending;

	if ($html) {
		foreach ($openTags as $tag) {
			$truncate .= '</'.$tag.'>';
		}
	}

	return $truncate;
}

function get_time_difference_php($created_time){
	//date_default_timezone_set('Asia/Calcutta'); //Change as per your default time
	$str = strtotime($created_time);
	$today = strtotime(date('Y-m-d H:i:s'));

	// It returns the time difference in Seconds...
	$time_differnce = $today-$str;

	// To Calculate the time difference in Years...
	$years = 60*60*24*365;

	// To Calculate the time difference in Months...
	$months = 60*60*24*30;

	// To Calculate the time difference in Days...
	$days = 60*60*24;

	// To Calculate the time difference in Hours...
	$hours = 60*60;

	// To Calculate the time difference in Minutes...
	$minutes = 60;

	if(intval($time_differnce/$years) > 1){
		return intval($time_differnce/$years)." años antes";
	}else if(intval($time_differnce/$years) > 0) {
		return intval($time_differnce/$years)." año antes";
	}else if(intval($time_differnce/$months) > 1){
		return intval($time_differnce/$months)." meses antes";
	}else if(intval(($time_differnce/$months)) > 0){
		return intval(($time_differnce/$months))." mes antes";
	}else if(intval(($time_differnce/$days)) > 1){
		return intval(($time_differnce/$days))." días antes";
	}else if (intval(($time_differnce/$days)) > 0) {
		return intval(($time_differnce/$days))." día antes";
	}else if (intval(($time_differnce/$hours)) > 1) {
		return intval(($time_differnce/$hours))." horas antes";
	}else if (intval(($time_differnce/$hours)) > 0) {
		return intval(($time_differnce/$hours))." hora antes";
	}else if (intval(($time_differnce/$minutes)) > 1) {
		return intval(($time_differnce/$minutes))." minutos antes";
	}else if (intval(($time_differnce/$minutes)) > 0) {
		return intval(($time_differnce/$minutes))." minuto antes";
	}else if (intval(($time_differnce)) > 1) {
		return intval(($time_differnce))." segundos antes";
	}else{
		return "hace unos segundos.";
	}
}

//Funciones Duplicar
function sql_backquote( $a_name ) {
    if ( ! empty( $a_name ) && $a_name !== '*' ) {
    	if ( is_array( $a_name ) ) {
    		$result = array();
    		reset( $a_name );
    		while ( list( $key, $val ) = each( $a_name ) )
    			$result[$key] = '`' . $val . '`';
    		return $result;
    	} else {
    		return '`' . $a_name . '`';
    	}
    } else {
    	return $a_name;
    }
}

function sql_addslashes( $a_string = '', $is_like = false ) {
    if ( $is_like )
    	$a_string = str_replace( '\\', '\\\\\\\\', $a_string );
    else
    	$a_string = str_replace( '\\', '\\\\', $a_string );
    $a_string = str_replace( '\'', '\\\'', $a_string );
    return $a_string;
}

function full_copy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }
 
        $d->close();
    }else {
        copy( $source, $target );
    }
}

function duplicarItem($arrayDatos){
	//$arrayDatos["tipo"];
	//$arrayDatos["idBuscar"];
	//$arrayDatos["idIdiomaDuplicar"];
	//$arrayDatos["nombreTabla"];
	//$arrayDatos["dbPrefijo"];
	//$arrayDatos["duplicarCarpetas"];
	//$arrayDatos["nombreCarpetas"];
	//$arrayDatos["nombreTablasDuplicar"];

	//Columnas Existentes
	$query = 'SELECT * FROM ' . sql_backquote($arrayDatos["nombreTabla"]);
	$resultTabla = mysqli_query($query);
	if ( $resultTabla ) {
		$fields_cnt = mysql_num_fields( $resultTabla );
		$rows_cnt   = mysql_num_rows( $resultTabla );
	}

	$search   = array( '\x00', '\x0a', '\x0d', '\x1a' );
	$replace  = array( '\0', '\n', '\r', '\Z' );

	//Elementos a duplicar
	if (!$arrayDatos["tipoTabla"]) {
		$sql =  sprintf("SELECT * FROM ".$arrayDatos["nombreTabla"]." WHERE ".$arrayDatos["dbPrefijo"]."id=%s",
			GetSQLValueString($arrayDatos["idBuscar"], "int")
		);
	}else{
		$sql =  sprintf("SELECT * FROM ".$arrayDatos["nombreTabla"]." WHERE ".$arrayDatos["dbPrefijo"]."tabla=%s AND ".$arrayDatos["dbPrefijo"]."id_tabla=%s",
			GetSQLValueString($arrayDatos["dbNombre"], "text"),
			GetSQLValueString($arrayDatos["idBuscar"], "int")
		);
	}

	$rs_sql = mysqli_query($sql);
	while ( $row_sql = mysqli_fetch_assoc($rs_sql) ){
		//Buscar si ya existe en el otro idioma (Casos Individuales)
		if ($arrayDatos["tipo"] == 'individual') {
			$sqlIdioma =  sprintf("SELECT * FROM ".$arrayDatos["nombreTabla"]." WHERE ".$arrayDatos["dbPrefijo"]."idi_id=%s",
				GetSQLValueString($arrayDatos["idIdiomaDuplicar"], "int")
			);
			$rs_sqlIdioma = mysqli_query($sqlIdioma);
			$row_sqlIdioma = mysqli_fetch_assoc($rs_sqlIdioma);
		}

		if ($row_sqlIdioma[$arrayDatos["dbPrefijo"]."idi_id"]) {
			//No permitir
			$result["error"] = "Lo sentimos, ya se encuentra el registro en el otro idioma";
		}else{
			//Insertar Nuevo
			$entries = 'INSERT INTO ' . sql_backquote( $arrayDatos["nombreTabla"] ) . ' (';
			unset($columnasSQL);
			unset($columnasSQLValue);

			for ( $j = 0; $j < $fields_cnt; $j++ ) {
				//Armar SQL
				$nombreColumna = mysql_field_name( $resultTabla, $j );
				$type = mysql_field_type( $resultTabla, $j );

				if( $nombreColumna ==  $arrayDatos["dbPrefijo"]."idi_id" ){
					//Cambiamos al idioma que queremos duplicar
					$columnasSQL[] = sql_backquote( $nombreColumna );
					$columnasSQLValue[] = $arrayDatos["idIdiomaDuplicar"];
				}elseif($nombreColumna ==  $arrayDatos["dbPrefijo"]."id"){
					if ($arrayDatos["tipo"] == 'individual') {
						$columnasSQL[] = sql_backquote( $nombreColumna );
						$columnasSQLValue[] = $arrayDatos["idIdiomaDuplicar"];
					}
				}elseif($nombreColumna ==  $arrayDatos["dbPrefijo"]."id_tabla"){
					$columnasSQL[] = sql_backquote( $nombreColumna );
					$columnasSQLValue[] = $arrayDatos["idNuevo"];
				}else{
					$columnasSQL[] = sql_backquote( $nombreColumna );

					//Entero o no
					if ( $type === 'tinyint' || $type === 'smallint' || $type === 'mediumint' || $type === 'int' || $type === 'bigint')
						$field_num = true;
					else
						$field_num = false;

					//Armar TEXTO
					if ( ! isset($row_sql[$nombreColumna] ) ) {
						$columnasSQLValue[]     = 'NULL';
					} elseif ( $row_sql[$nombreColumna] === '0' || $row_sql[$nombreColumna] !== '' ) {
					    // a number
					    if ( $field_num ){
					    	$columnasSQLValue[] = $row_sql[$nombreColumna];
					    }else{
					    	$columnasSQLValue[] = "'" . str_replace( $search, $replace, sql_addslashes( $row_sql[$nombreColumna] ) ) . "'";
					    }
					} else {
						$columnasSQLValue[] = "''";
					}
				}
			}

			$sqlFinal = $entries . implode( ', ', $columnasSQL ) . ") VALUES ( " . implode( ', ', $columnasSQLValue ) . " ) ;";
			$rs_slqFinal = mysqli_query($sqlFinal);
			$idNuevo = mysql_insert_id();

			//duplicar carpetas
			if ($arrayDatos["duplicarCarpetas"]) {
				foreach ($arrayDatos["nombreCarpetas"] as $key => $carpeta) {
					$source ='../../'._carpetaImagenesGlobal.'/'.$carpeta.'/'.$arrayDatos["idBuscar"].'/';
					$destination ='../../'._carpetaImagenesGlobal.'/'.$carpeta.'/'.$idNuevo.'/';
					full_copy($source, $destination);
				}
			}

			//duplicar tablas
			foreach ($arrayDatos["nombreTablasDuplicar"] as $key => $tablas) {
				$arrayDatosInternos["tipo"];
				$arrayDatosInternos["idBuscar"] = $arrayDatos["idBuscar"];
				$arrayDatosInternos["idIdiomaDuplicar"] = $arrayDatos["idIdiomaDuplicar"];
				$arrayDatosInternos["nombreTabla"] = $tablas["tipo"]."tbl_".$tablas["nombre"];
				$arrayDatosInternos["dbPrefijo"] = $tablas["prefijo"];
				$arrayDatosInternos["dbNombre"] = $arrayDatos["dbNombre"];
				$arrayDatosInternos["duplicarCarpetas"] = false;
				$arrayDatosInternos["nombreCarpetas"];
				$arrayDatosInternos["nombreTablasDuplicar"];
				$arrayDatosInternos["tipoTabla"] = true;
				$arrayDatosInternos["idNuevo"] = $idNuevo;

				if ($tablas["nombre"] == 'imagenes') {
					foreach ($arrayDatos["nombreCarpetas"] as $key => $carpeta) {
						$arrayDatosInternos["dbNombre"] = $carpeta;
						duplicarItem($arrayDatosInternos);
					}
				}else{
					duplicarItem($arrayDatosInternos);
				}
			}

			$result["id"] = $idNuevo;
			$result["success"] = "Se ha guardado en el idioma seleccionada";
		}
	}

	mysql_free_result( $resultTabla );
	mysql_free_result( $rs_sql );
	mysql_free_result( $rs_sqlIdioma );

	return $result;
}


function duplicarItemImage($arrayDatos){
	//$arrayDatos["tipo"];
	//$arrayDatos["idBuscar"];
	//$arrayDatos["idIdiomaDuplicar"];
	//$arrayDatos["nombreTabla"];
	//$arrayDatos["dbPrefijo"];
	//$arrayDatos["duplicarCarpetas"];
	//$arrayDatos["nombreCarpetas"];
	//$arrayDatos["nombreTablasDuplicar"];

	//Columnas Existentes
	$query = 'SELECT * FROM ' . sql_backquote($arrayDatos["nombreTabla"]);
	$resultTabla = mysqli_query($query);
	if ( $resultTabla ) {
		$fields_cnt = mysql_num_fields( $resultTabla );
		$rows_cnt   = mysql_num_rows( $resultTabla );
	}

	$search   = array( '\x00', '\x0a', '\x0d', '\x1a' );
	$replace  = array( '\0', '\n', '\r', '\Z' );

	//Elementos a duplicar
	if (!$arrayDatos["tipoTabla"]) {
		$sql =  sprintf("SELECT * FROM ".$arrayDatos["nombreTabla"]." WHERE ".$arrayDatos["dbPrefijo"]."id=%s",
			GetSQLValueString($arrayDatos["idBuscar"], "int")
		);
	}else{
		$sql =  sprintf("SELECT * FROM ".$arrayDatos["nombreTabla"]." WHERE ".$arrayDatos["dbPrefijo"]."tabla=%s AND ".$arrayDatos["dbPrefijo"]."id=%s",
			GetSQLValueString($arrayDatos["dbNombre"], "text"),
			GetSQLValueString($arrayDatos["idBuscar"], "int")
		);
	}

	$rs_sql = mysqli_query($sql);
	while ( $row_sql = mysqli_fetch_assoc($rs_sql) ){
		//Insertar Nuevo
		$entries = 'INSERT INTO ' . sql_backquote( $arrayDatos["nombreTabla"] ) . ' (';
		unset($columnasSQL);
		unset($columnasSQLValue);
		$nombreImage = $extensionImage = '';

		for ( $j = 0; $j < $fields_cnt; $j++ ) {
			//Armar SQL
			$nombreColumna = mysql_field_name( $resultTabla, $j );
			$type = mysql_field_type( $resultTabla, $j );

			if( $nombreColumna ==  $arrayDatos["dbPrefijo"]."id_tabla" ){
				//Cambiamos al idioma que queremos duplicar
				$columnasSQL[] = sql_backquote( $nombreColumna );
				$columnasSQLValue[] = $arrayDatos["idIdiomaDuplicar"];
			}elseif( $nombreColumna ==  $arrayDatos["dbPrefijo"]."id" ){
			}else{
				$columnasSQL[] = sql_backquote( $nombreColumna );
				if($nombreColumna ==  $arrayDatos["dbPrefijo"]."nombre"){
					$nombreImage = $row_sql[$nombreColumna];
				}
				if($nombreColumna ==  $arrayDatos["dbPrefijo"]."extension"){
					$extensionImage = $row_sql[$nombreColumna];
				}

				//Entero o no
				if ( $type === 'tinyint' || $type === 'smallint' || $type === 'mediumint' || $type === 'int' || $type === 'bigint')
					$field_num = true;
				else
					$field_num = false;

				//Armar TEXTO
				if ( ! isset($row_sql[$nombreColumna] ) ) {
					$columnasSQLValue[]     = 'NULL';
				} elseif ( $row_sql[$nombreColumna] === '0' || $row_sql[$nombreColumna] !== '' ) {
				    // a number
				    if ( $field_num ){
				    	$columnasSQLValue[] = $row_sql[$nombreColumna];
				    }else{
				    	$columnasSQLValue[] = "'" . str_replace( $search, $replace, sql_addslashes( $row_sql[$nombreColumna] ) ) . "'";
				    }
				} else {
					$columnasSQLValue[] = "''";
				}
			}
		}

		$sqlFinal = $entries . implode( ', ', $columnasSQL ) . ") VALUES ( " . implode( ', ', $columnasSQLValue ) . " ) ;";
		
		$sqlRepeat =  sprintf("SELECT * FROM ".$arrayDatos["nombreTabla"]." WHERE ".$arrayDatos["dbPrefijo"]."tabla=%s AND ".$arrayDatos["dbPrefijo"]."id_tabla=%s AND ".$arrayDatos["dbPrefijo"]."nombre=%s AND ".$arrayDatos["dbPrefijo"]."extension=%s",
			GetSQLValueString($arrayDatos["dbNombre"], "text"),
			GetSQLValueString($arrayDatos["idIdiomaDuplicar"], "int"),
			GetSQLValueString($nombreImage, "text"),
			GetSQLValueString($extensionImage, "text")
		);
		$rs_slqRepeat = mysqli_query($sqlRepeat);
		$result["success"] = "Se ha guardado en el idioma seleccionada";
		$row_sqlRepeat = mysqli_fetch_assoc($rs_slqRepeat);
		if (!$row_sqlRepeat[$arrayDatos["dbPrefijo"]."id"]) {
			$rs_slqFinal = mysqli_query($sqlFinal);
			//$idNuevo = mysql_insert_id();

			//duplicar imágenes
			$source ='../../'._carpetaImagenesGlobal.'/'.$arrayDatos["nombreCarpeta"].'/'.$_SESSION[_sessionIdioma].'/';
			$destination ='../../'._carpetaImagenesGlobal.'/'.$arrayDatos["nombreCarpeta"].'/'.$arrayDatos["idIdiomaDuplicar"].'/';
			mkdir($destination);
			mkdir($destination.'thumbnail/');
			copy($source.$nombreImage.'.'.$extensionImage, $destination.$nombreImage.'.'.$extensionImage);
			copy($source.'thumbnail/'.$nombreImage.'.'.$extensionImage, $destination.'thumbnail/'.$nombreImage.'.'.$extensionImage);

			$result["success"] = "Se ha guardado en el idioma seleccionada";
		}else{
			$result["error"] = "Esa imagen ya se encuentra en el otro idioma";
		}
	}

	mysql_free_result( $resultTabla );
	mysql_free_result( $rs_sql );
	mysql_free_result( $rs_sqlIdioma );

	return $result;
}

function crearToken($id, $tipo, $email){
	$header = '{"typ": "JWT","alg": "HS256"}';
	$payload = '{"sub": "'.$id.'", "tipo": "'.$tipo.'", "email": "'.$email.'"}';
	$secret = _SECRET_TOKEN;

	$headerH = base64_encode($header);
	$payloadH = base64_encode($payload);
	$secretH = base64_encode(hash_hmac('sha256',"$headerH.$payloadH",$secret,true));
	$token = $headerH.'.'.$payloadH.'.'.$secretH;
	return $token;
}

//list($validacion, $id) = validarToken($token);
function validarToken($_conection, $token){
	$partes = explode('.', $token);
	$signature = bin2hex(base64_decode(strtr($partes[2],'-_','+/')));
	$secret = _SECRET_TOKEN;

	//Token Invalido
	if( $signature!=hash_hmac('sha256',"$partes[0].$partes[1]",$secret) ){
		return array(false);
	}

	$arrayDatos = json_decode(base64_decode($partes[1]));
	$sqlRepeat =  sprintf("SELECT usu_id FROM tbl_usuarios WHERE usu_id=%s AND usu_tipo=%s",
		GetSQLValueString($arrayDatos->sub, "text"),
		GetSQLValueString($arrayDatos->tipo, "text")
	);
	$rs_sqlRepeat = mysqli_query($_conection->connect(), $sqlRepeat);
	$row_sqlRepeat = mysqli_fetch_assoc($rs_sqlRepeat);
	if (!$row_sqlRepeat["usu_id"]) {
		return array(false);
	}
	//Existe 

	return array(true, $arrayDatos->sub);
}

require_once __DIR__.'/clases/NumberToLetterConverter.php';
//Funcion Contrato Definido
// require_once '../dompdf/autoload.inc.php';
// reference the Dompdf namespace
// use Dompdf\Dompdf;

// instantiate and use the dompdf class
require_once __DIR__.'/../dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

function crearFunctionContratoDefinido($id, $_conection){
	$conexion = $_conection->connect();
	$arrayPeriodos = array('', 'diario','semanal','quincenal','mensual');
	$arrayTerminos = array('', 'por hora','por día','mensual');
	$arrayMeses = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	$sqlUsuario = sprintf("SELECT * FROM tbl_usuarios INNER JOIN tbl_empleados ON emp_usu_id=usu_id WHERE emp_id=%s",
		GetSQLValueString($id, "double")
	);
	$rs_sqlUsuario = mysqli_query($_conection->connect(), $sqlUsuario);
	$row_sqlUsuario = mysqli_fetch_assoc($rs_sqlUsuario);
	if( $row_sqlUsuario['usu_nacionalidad'] == 'colombia'){
		$usu_nacionalidad = ' Colombia';
	}else{
		$usu_nacionalidad = ' Panamá';
	}

	$sqlEmpleados =  sprintf("SELECT `emp_id`, `emp_usu_id`, `emp_tipo`, `emp_perfil`, `emp_perfil_nombre`, `emp_contrato`, `emp_tipo_definido`, `emp_tipo_definido_value`, `emp_dor_nombre`, `emp_dor_apellido`, `emp_dor_hombre`, `emp_dor_mujer`, `emp_dor_nacionalidad`, `emp_dor_nacionalidad_value`, `emp_dor_no_identidad`, `emp_dor_domicilio`, `emp_do_nombre`, `emp_do_hombre`, `emp_do_mujer`, `emp_do_nacionalidad`, `emp_do_nacionalidad_value`, `emp_do_no_identidad`, `emp_do_domicilio`, `emp_do_edad`, `emp_cond_jornada`, `emp_cond_semanas`, `emp_cond_fecha_relacion`, `emp_cond_termino`, `emp_cond_sueldo`, `emp_cond_periodo`, `emp_cond_auxilio`, `emp_cond_generacion`, `emp_contribuciones`, `emp_promedio`, `emp_anho1`, `emp_anho1_valor`, `emp_anho2`, `emp_anho2_valor`, `emp_vacaciones`, `emp_dias`, `emp_estado`, `emp_imagen`, emp_nombre_padre, emp_nombre_madre, emp_ce_nombre, emp_ce_cedula, emp_ce_pasaporte, emp_ce_parentesco, emp_ce_telefono, emp_ce_direccion, `emp_ie_tiposangre`, `emp_ie_alergias`, `emp_ie_medico`, `emp_ie_telefono`, `emp_ie_notas`
							 FROM tbl_empleados WHERE emp_id=%s",
		GetSQLValueString($id, "double")
	);
	$rs_sqlEmpleados = mysqli_query($_conection->connect(), $sqlEmpleados);
	$row_sqlEmpleados = mysqli_fetch_assoc($rs_sqlEmpleados);

	$sqlDependientes =  sprintf("SELECT `dp_usu_id`, `dp_emp_id`, `dp_nombres`, `dp_parentesco`
							 FROM tbl_dependientes WHERE dp_emp_id=%s LIMIT 0,1",
		GetSQLValueString($id, "double")
	);
	$rs_sqlDependientes = mysqli_query($_conection->connect(), $sqlDependientes);
	$row_sqlDependientes = mysqli_fetch_assoc($rs_sqlDependientes);
	$emp_cond_dependiente = $row_sqlDependientes["dp_nombres"];
	if (!$emp_cond_dependiente) {
		$emp_cond_dependiente = ' N/A ';
	}
	// $empleado["emp_cond_parentesco"] = $row_sqlDependientes["dp_parentesco"];

	//Empleador
	$emp_dor_nombre = $row_sqlEmpleados["emp_dor_nombre"];
	$emp_dor_apellido = $row_sqlEmpleados["emp_dor_apellido"];
	if ($row_sqlEmpleados["emp_dor_hombre"] == 'true') {
		$emp_dor_sexo = 'hombre, ';
	}elseif ($row_sqlEmpleados["emp_dor_mujer"] == 'true') {
		$emp_dor_sexo = 'mujer, ';
	}
	$emp_dor_nacionalidad_value = $row_sqlEmpleados["emp_dor_nacionalidad_value"];
	$emp_dor_no_identidad = $row_sqlEmpleados["emp_dor_no_identidad"];
	$emp_dor_domicilio = $row_sqlEmpleados["emp_dor_domicilio"];
	
	//Empleado
	$emp_do_nombre = $row_sqlEmpleados["emp_do_nombre"];
	$emp_do_nombreCam = CamellizarConGuiones(utf8_encode($emp_do_nombre));
	if ($row_sqlEmpleados["emp_do_hombre"] == 'true') {
		$emp_do_sexo = 'hombre, ';
	}elseif ($row_sqlEmpleados["emp_do_mujer"] == 'true') {
		$emp_do_sexo = 'mujer, ';
	}
	$emp_do_nacionalidad_value = $row_sqlEmpleados["emp_do_nacionalidad_value"];
	$emp_do_edad = $row_sqlEmpleados["emp_do_edad"];
	$emp_do_no_identidad = $row_sqlEmpleados["emp_do_no_identidad"];
	$emp_do_domicilio = $row_sqlEmpleados["emp_do_domicilio"];

	$emp_tipo_definido = $row_sqlEmpleados["emp_tipo_definido"];
	$emp_cond_jornada = $row_sqlEmpleados["emp_cond_jornada"];
	$emp_cond_semanas = $row_sqlEmpleados["emp_cond_semanas"];
	if ($emp_cond_jornada == 1) {
		$emp_diassemana = '5 ';
	}elseif ($emp_cond_jornada == 2) {
		$emp_diassemana = '6 ';
	}elseif ($emp_cond_jornada == 3) {
		$emp_diassemana = count( explode(',', $emp_cond_semanas)) .' ';
	}

	$emp_cond_periodo = $arrayPeriodos[$row_sqlEmpleados["emp_cond_periodo"]];
	$emp_cond_termino = $arrayTerminos[$row_sqlEmpleados["emp_cond_termino"]];
	$emp_cond_sueldo = number_format($row_sqlEmpleados["emp_cond_sueldo"]);
	list($anho, $mes, $dia) = explode('-', $row_sqlEmpleados["emp_cond_fecha_relacion"]);
	$emp_cond_fecha_relacion = $dia.' de '.$arrayMeses[(int)$mes].' del '.$anho;

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();

	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
	<h2 style="text-align:center;">CONTRATO DE TRABAJO</h2>

	<p>Los suscritos a saber, '.utf8_encode($emp_dor_nombre.' '.$emp_dor_apellido).', '.utf8_encode($emp_dor_sexo).''.utf8_encode($emp_dor_nacionalidad_value).', mayor de edad, con número de identificación personal No. '.utf8_encode($emp_dor_no_identidad).' y con domicilio en '.utf8_encode($emp_dor_domicilio).', quien en adelante se llamará EL EMPLEADOR, por una parte y por la otra '.utf8_encode($emp_do_nombre).', '.utf8_encode($emp_do_sexo).', '.utf8_encode($emp_do_nacionalidad_value).', con '.utf8_encode($emp_do_edad).' años de edad, número de identidad personal No. '.utf8_encode($emp_do_no_identidad).' y con domicilio en '.utf8_encode($emp_do_domicilio).', quien en lo sucesivo se denominará EL TRABAJADOR, hemos celebrado el presente contrato individual de trabajo, sujeto a las siguientes cláusulas:</p>

	<p><span style="text-decoraction: underline;"><b>PRIMERA:</b></span> EL TRABAJADOR prestará sus servicios bajo las órdenes de EL EMPLEADOR, en calidad de EMPLEADO(A) DOMÉSTICO(A), en la residencia de EL EMPLEADOR.</p>

	<p><span style="text-decoraction: underline;"><b>SEGUNDA:</b></span> El presente contrato se celebra por tiempo definido de '.utf8_encode($emp_tipo_definido).' meses, sujeto a las normas que regulan los contratos especiales de trabajadores domésticos, de acuerdo con el Título VII, Capítulo I, Artículos 230 y subsiguientes. Se establece un periodo de prueba de 3 meses de conformidad con el artículo 78 del Código de Trabajo.</p>

	<p><span style="text-decoraction: underline;"><b>TERCERA:</b></span> El lugar de trabajo será en la residencia de EL EMPLEADOR, ubicada en '.utf8_encode($emp_dor_domicilio).' </p>

	<p><span style="text-decoraction: underline;"><b>CUARTA:</b></span> EL TRABAJADOR se obliga a presentarse diariamente por sus propios medios en el sitio de trabajo a la hora acordada y a acatar las instrucciones de EL EMPLEADOR o quien la represente, ejecutando sus labores con la intensidad, cuidado y eficiencia que sean compatibles con sus aptitudes, preparación y destreza. </p>

	<p><span style="text-decoraction: underline;"><b>QUINTA:</b></span>  La jornada de trabajo de EL TRABAJADOR será de '.utf8_encode($emp_diassemana).' días a la semana, en el horario especial de trabajadores domésticos que establece el Artículo 231, numeral 2 del Código de Trabajo. </p>

	<p><span style="text-decoraction: underline;"><b>SEXTA:</b></span>Los servicios de EL TRABAJADOR serán remunerados a partir de la firma del presente contrato, mediante el pago de un salario de $'.utf8_encode($emp_cond_sueldo).' '.$emp_cond_termino.', que se cancelarán mediante las formas y periodos de pago que establece el Código de Trabajo. En caso de pagos mensuales, los pagos se harán en dos partidas que no excederán de 15 días entre cada partida. </p>

	<p><span style="text-decoraction: underline;"><b>SÉPTIMA:</b></span>Se deja constancia que EL TRABAJADOR inició servicios en favor de EL EMPLEADOR, el día '.utf8_encode($emp_cond_fecha_relacion).'. </p>

	<p><span style="text-decoraction: underline;"><b>OCTAVA:</b></span> Declara EL TRABAJADOR que las siguientes personas dependen o viven con el: '.utf8_encode($emp_cond_dependiente).'</p>

	<p>Para constancia se firma este en tres ejemplares del mismo, uno para cada parte y otro  para ser registrado en el Ministerio de Trabajo y Desarrollo Laboral, en la Ciudad de '.$usu_nacionalidad.' al día ___ del mes ________ del año _______.</p>

	<br><br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
		<div style="text-align:center"><b>EL EMPLEADOR</b></div>
		<br>
		<br>
________________________________________________
	</div>
	<div style="width:50%; display:inline-block; vertical-align: top;">
	<div style="text-align:center"><b>EL TRABAJADOR</b></div>
		<br>
		<br>
________________________________________________
	</div>
</body>
</html>
';
	
	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'empleados';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta.'/'.$id;
	//Creamos Carpeta Archivo
	if(!file_exists($pathFileId) && $id){
		mkdir($pathFileId,0777);
	}

	file_put_contents($pathFileId."/contrato-laboral-".$emp_do_nombreCam.".pdf", $pdf);
}

function crearFunctionContratoIndefinido($id, $_conection){
	$conexion = $_conection->connect();
	$arrayPeriodos = array('', 'diario','semanal','quincenal','mensual');
	$arrayTerminos = array('', 'por hora','por día','mensual');
	$arrayMeses = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	$sqlUsuario = sprintf("SELECT * FROM tbl_usuarios INNER JOIN tbl_empleados ON emp_usu_id=usu_id WHERE emp_id=%s",
		GetSQLValueString($id, "double")
	);
	$rs_sqlUsuario = mysqli_query($_conection->connect(), $sqlUsuario);
	$row_sqlUsuario = mysqli_fetch_assoc($rs_sqlUsuario);
	if( $row_sqlUsuario['usu_nacionalidad'] == 'colombia'){
		$usu_nacionalidad = ' Colombia ';
	}else{
		$usu_nacionalidad = ' Panamá ';
	}

	$sqlEmpleados =  sprintf("SELECT `emp_id`, `emp_usu_id`, `emp_tipo`, `emp_perfil`, `emp_perfil_nombre`, `emp_contrato`, `emp_tipo_definido`, `emp_tipo_definido_value`, `emp_dor_nombre`, `emp_dor_apellido`, `emp_dor_hombre`, `emp_dor_mujer`, `emp_dor_nacionalidad`, `emp_dor_nacionalidad_value`, `emp_dor_no_identidad`, `emp_dor_domicilio`, `emp_do_nombre`, `emp_do_hombre`, `emp_do_mujer`, `emp_do_nacionalidad`, `emp_do_nacionalidad_value`, `emp_do_no_identidad`, `emp_do_domicilio`, `emp_do_edad`, `emp_cond_jornada`, `emp_cond_semanas`, `emp_cond_fecha_relacion`, `emp_cond_termino`, `emp_cond_sueldo`, `emp_cond_periodo`, `emp_cond_auxilio`, `emp_cond_generacion`, `emp_contribuciones`, `emp_promedio`, `emp_anho1`, `emp_anho1_valor`, `emp_anho2`, `emp_anho2_valor`, `emp_vacaciones`, `emp_dias`, `emp_estado`, `emp_imagen`, emp_nombre_padre, emp_nombre_madre, emp_ce_nombre, emp_ce_cedula, emp_ce_pasaporte, emp_ce_parentesco, emp_ce_telefono, emp_ce_direccion, `emp_ie_tiposangre`, `emp_ie_alergias`, `emp_ie_medico`, `emp_ie_telefono`, `emp_ie_notas`
							 FROM tbl_empleados WHERE emp_id=%s",
		GetSQLValueString($id, "double")
	);
	$rs_sqlEmpleados = mysqli_query($_conection->connect(), $sqlEmpleados);
	$row_sqlEmpleados = mysqli_fetch_assoc($rs_sqlEmpleados);

	$sqlDependientes =  sprintf("SELECT `dp_usu_id`, `dp_emp_id`, `dp_nombres`, `dp_parentesco`
							 FROM tbl_dependientes WHERE dp_emp_id=%s LIMIT 0,1",
		GetSQLValueString($id, "double")
	);
	$rs_sqlDependientes = mysqli_query($_conection->connect(), $sqlDependientes);
	$row_sqlDependientes = mysqli_fetch_assoc($rs_sqlDependientes);
	$emp_cond_dependiente = $row_sqlDependientes["dp_nombres"];
	if (!$emp_cond_dependiente) {
		$emp_cond_dependiente = ' N/A ';
	}
	// $empleado["emp_cond_parentesco"] = $row_sqlDependientes["dp_parentesco"];

	//Empleador
	$emp_dor_nombre = $row_sqlEmpleados["emp_dor_nombre"];
	$emp_dor_apellido = $row_sqlEmpleados["emp_dor_apellido"];
	if ($row_sqlEmpleados["emp_dor_hombre"] == 'true') {
		$emp_dor_sexo = 'hombre';
	}elseif ($row_sqlEmpleados["emp_dor_mujer"] == 'true') {
		$emp_dor_sexo = 'mujer';
	}
	$emp_dor_nacionalidad_value = $row_sqlEmpleados["emp_dor_nacionalidad_value"];
	$emp_dor_no_identidad = $row_sqlEmpleados["emp_dor_no_identidad"];
	$emp_dor_domicilio = $row_sqlEmpleados["emp_dor_domicilio"];
	
	//Empleado
	$emp_do_nombre = $row_sqlEmpleados["emp_do_nombre"];
	$emp_do_nombreCam = CamellizarConGuiones(utf8_encode($emp_do_nombre));
	if ($row_sqlEmpleados["emp_do_hombre"] == 'true') {
		$emp_do_sexo = 'hombre';
	}elseif ($row_sqlEmpleados["emp_do_mujer"] == 'true') {
		$emp_do_sexo = 'mujer';
	}
	$emp_do_nacionalidad_value = $row_sqlEmpleados["emp_do_nacionalidad_value"];
	$emp_do_edad = $row_sqlEmpleados["emp_do_edad"];
	$emp_do_no_identidad = $row_sqlEmpleados["emp_do_no_identidad"];
	$emp_do_domicilio = $row_sqlEmpleados["emp_do_domicilio"];

	$emp_tipo_definido = $row_sqlEmpleados["emp_tipo_definido"];
	$emp_cond_jornada = $row_sqlEmpleados["emp_cond_jornada"];
	$emp_cond_semanas = $row_sqlEmpleados["emp_cond_semanas"];
	if ($emp_cond_jornada == 1) {
		$emp_diassemana = '5 ';
	}elseif ($emp_cond_jornada == 2) {
		$emp_diassemana = '6 ';
	}elseif ($emp_cond_jornada == 3) {
		$emp_diassemana = count( explode(',', $emp_cond_semanas)) .' ';
	}

	$emp_cond_periodo = $arrayPeriodos[$row_sqlEmpleados["emp_cond_periodo"]];
	$emp_cond_termino = $arrayTerminos[$row_sqlEmpleados["emp_cond_termino"]];
	$emp_cond_sueldo = number_format($row_sqlEmpleados["emp_cond_sueldo"]);
	list($anho, $mes, $dia) = explode('-', $row_sqlEmpleados["emp_cond_fecha_relacion"]);
	$emp_cond_fecha_relacion = $dia.' de '.$arrayMeses[(int)$mes].' del '.$anho;

	$dompdf = new Dompdf();

	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
	<h2 style="text-align:center;">CONTRATO DE TRABAJO</h2>

	<p>Los suscritos a saber, '.utf8_encode($emp_dor_nombre.' '.$emp_dor_apellido).', '.utf8_encode($emp_dor_sexo).', '.utf8_encode($emp_dor_nacionalidad_value).', mayor de edad, con número de identificación personal No. '.utf8_encode($emp_dor_no_identidad).' y con domicilio en '.utf8_encode($emp_dor_domicilio).', quien en adelante se llamará EL EMPLEADOR, por una parte y por la otra '.utf8_encode($emp_do_nombre).', '.utf8_encode($emp_do_sexo).', '.utf8_encode($emp_do_nacionalidad_value).', con '.utf8_encode($emp_do_edad).' años de edad, número de identidad personal No. '.utf8_encode($emp_do_no_identidad).' y con domicilio en '.utf8_encode($emp_do_domicilio).', quien en lo sucesivo se denominará EL TRABAJADOR, hemos celebrado el presente contrato individual de trabajo, sujeto a las siguientes cláusulas:</p>

	<p><span style="text-decoraction: underline;"><b>PRIMERA:</b></span> EL TRABAJADOR prestará sus servicios bajo las órdenes de EL EMPLEADOR, en calidad de EMPLEADO(A) DOMÉSTICO(A), en la residencia de EL EMPLEADOR.</p>

	<p><span style="text-decoraction: underline;"><b>SEGUNDA:</b></span> El presente contrato se celebra por tiempo indefinido, sujeto a las normas que regulan los contratos especiales de trabajadores domésticos, de acuerdo con el Título VII, Capítulo I, Artículos 230 y subsiguientes. Se establece un periodo de prueba de 3 meses de conformidad con el artículo 78 del Código de Trabajo.</p>

	<p><span style="text-decoraction: underline;"><b>TERCERA:</b></span> El lugar de trabajo será en la residencia de EL EMPLEADOR, ubicada en '.utf8_encode($emp_dor_domicilio).' </p>

	<p><span style="text-decoraction: underline;"><b>CUARTA:</b></span> EL TRABAJADOR se obliga a presentarse diariamente por sus propios medios en el sitio de trabajo a la hora acordada y a acatar las instrucciones de EL EMPLEADOR o quien la represente, ejecutando sus labores con la intensidad, cuidado y eficiencia que sean compatibles con sus aptitudes, preparación y destreza. </p>

	<p><span style="text-decoraction: underline;"><b>QUINTA:</b></span>  La jornada de trabajo de EL TRABAJADOR será de '.utf8_encode($emp_diassemana).' días a la semana, en el horario especial de trabajadores domésticos que establece el Artículo 231, numeral 2 del Código de Trabajo. </p>

	<p><span style="text-decoraction: underline;"><b>SEXTA:</b></span>Los servicios de EL TRABAJADOR serán remunerados a partir de la firma del presente contrato, mediante el pago de un salario de $'.utf8_encode($emp_cond_sueldo).' '.$emp_cond_termino.', que se cancelarán mediante las formas y periodos de pago que establece el Código de Trabajo. En caso de pagos mensuales, los pagos se harán en dos partidas que no excederán de 15 días entre cada partida. </p>

	<p><span style="text-decoraction: underline;"><b>SÉPTIMA:</b></span>Se deja constancia que EL TRABAJADOR inició servicios en favor de EL EMPLEADOR, el día '.utf8_encode($emp_cond_fecha_relacion).'. </p>

	<p><span style="text-decoraction: underline;"><b>OCTAVA:</b></span> Declara EL TRABAJADOR que las siguientes personas dependen o viven con el: '.utf8_encode($emp_cond_dependiente).'</p>

	<p>Para constancia se firma este en tres ejemplares del mismo, uno para cada parte y otro  para ser registrado en el Ministerio de Trabajo y Desarrollo Laboral, en la Ciudad de '.$usu_nacionalidad.' al día ___ del mes ________ del año _______.</p>

	<br><br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
		<div style="text-align:center"><b>EL EMPLEADOR</b></div>
		<br>
		<br>
________________________________________________
	</div>
	<div style="width:50%; display:inline-block; vertical-align: top;">
	<div style="text-align:center"><b>EL TRABAJADOR</b></div>
		<br>
		<br>
________________________________________________
	</div>
</body>
</html>
';
		
	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'empleados';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta.'/'.$id;
	//Creamos Carpeta Archivo
	if(!file_exists($pathFileId) && $id){
		mkdir($pathFileId,0777);
	}

	file_put_contents($pathFileId."/contrato-laboral-".$emp_do_nombreCam.".pdf", $pdf);
}

function checkInRange($start_date, $end_date, $evaluame) {
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($evaluame);
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}


function simuladorTiempo($fechaActual, $fechaReferencia, $test = 0 ){
	/*$datetimeReferencia = date_create($fechaReferencia);
	//$datetimeActual = date_create($fechaActual);
	$datetimeActual = date_create(date($fechaActual));
	$interval = date_diff($datetimeReferencia, $datetimeActual);
	
	$hora = $interval->format("%H");
	$minuto = $interval->format("%I");
	$segundo = $interval->format("%S");

	// 1 día por 2 minutos.
	$diastranscurridos = floor((($hora*60)+$minuto + $interval->days * 24 * 60)/2);
	date_add($datetimeActual, date_interval_create_from_date_string($diastranscurridos.' days'));
	return date_format($datetimeActual, 'Y-m-d');*/
	
	$datetimeActual = date_create(date($fechaActual));
	return date_format($datetimeActual, 'Y-m-d');
}

function validar_tarjeta ($number) {
	$odd = true;
	$sum = 0;

	foreach ( array_reverse(str_split($number)) as $num) {
		$sum += array_sum( str_split(($odd = !$odd) ? $num*2 : $num) );
	}

	return (($sum % 10 == 0) && ($sum != 0));
}

function guardarToken ($_conection, $usu_id, $accessTokenUkuIncdustry, $platform, $model){
	//Registrar Token FCM
	$sqlUuid = sprintf("SELECT * FROM tbl_usuarios_token WHERE ut_uuid=%s",
		GetSQLValueString($model, "text")
	);
	$rs_sqlUuid = mysqli_query($_conection->connect(), $sqlUuid);
	$row_sqlUuid = mysqli_fetch_assoc($rs_sqlUuid);
	if ($row_sqlUuid['ut_token'] && $accessTokenUkuIncdustry) {
		$sqlToken = sprintf("UPDATE tbl_usuarios_token SET ut_usu_id=%s, ut_token=%s WHERE ut_uuid=%s",
			GetSQLValueString($usu_id, "text"),
			GetSQLValueString($accessTokenUkuIncdustry, "text"),
			GetSQLValueString($model, "text")
		);
		$rs_sqlToken = mysqli_query($_conection->connect(), $sqlToken);
	}elseif($accessTokenUkuIncdustry){
		$sqlExist = sprintf("SELECT * FROM tbl_usuarios_token WHERE ut_token=%s",
			GetSQLValueString($accessTokenUkuIncdustry, "text")
		);
		$rs_sqlExist = mysqli_query($_conection->connect(), $sqlExist);
		$row_sqlExist = mysqli_fetch_assoc($rs_sqlUuid);
		if ($row_sqlExist['ut_token'] && $accessTokenUkuIncdustry) {
			$sqlToken = sprintf("UPDATE tbl_usuarios_token SET ut_usu_id=%s, ut_platform=%s WHERE ut_token=%s",
				GetSQLValueString($usu_id, "text"),
				GetSQLValueString($platform, "text"),
				GetSQLValueString($accessTokenUkuIncdustry, "text")
			);
			$rs_sqlToken = mysqli_query($_conection->connect(), $sqlToken);
		}else{
			$sqlToken = sprintf("INSERT INTO tbl_usuarios_token (ut_usu_id,ut_token,ut_platform,ut_uuid) VALUES (%s,%s,%s,%s)",
				GetSQLValueString($usu_id, "text"),
				GetSQLValueString($accessTokenUkuIncdustry, "text"),
				GetSQLValueString($platform, "text"),
				GetSQLValueString($model, "text")
			);
			$rs_sqlToken = mysqli_query($_conection->connect(), $sqlToken);
		}
	}
}

function envioNotificacionesPush($title, $body, $registrationIds, $platform = '' ){
	if ($registrationIds[0]) {
		$notification = array
		(
			"title" => $title,
		    "body" => $body,
		    "style" => "inbox",
		    "icon" => "icon_2",
			"color" => "#E03D3D",
		    "sound" => "default",
		    "priority"=> 1,
		    "content-available" => '1'
		);

		$data = array
		(
			"badge" => "badge"
		);

		if ($platform == 'android') {
			$fields = array
			(
				"registration_ids" 	=> $registrationIds,
				"data" => $notification,
				"priority" => "high",
				"content-available" => 1
			);
		}else{
			$fields = array
			(
				"registration_ids" 	=> $registrationIds,
				"content_available" => true,
				"notification" => $notification,
				"data" => $notification,
				"priority" => "high"
			);
		}
		
		 
		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		// var_dump($result);
	}
}

//Dias Transcurridos Entre 2 Fechas
// diasTranscurridosEntreFechas('2017-09-01','2017-09-30', array('Saturday','Friday') );
function diasTranscurridosEntreFechas($fechaInicial, $fechaFinal, $arrayDias){
	$contadorDias=0;
	$startDate = DateTime::createFromFormat('Y-m-d', $fechaInicial);
	$endDate = DateTime::createFromFormat('Y-m-d', $fechaFinal);
	while($startDate->getTimestamp() <= $endDate->getTimestamp()){
		if (in_array($startDate->format('l'), $arrayDias)) {
			$contadorDias++;
		}
	    $startDate->modify("+1 days");
	}
	return $contadorDias;
}

function crearConfirmacionPagoSalario($id, $_conection, $firmaEmp = ''){
	$conexion = $_conection->connect();
	// $arrayPeriodos = array('', 'diario','semanal','quincenal','mensual');
	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	$sqlEmpleadoNoti = sprintf("SELECT * FROM tbl_empleados_notificaciones INNER JOIN tbl_empleados ON emp_id=en_emp_id WHERE en_id=%s",
		GetSQLValueString($id, "double")
	);
	$rs_sqlEmpleadoNoti = mysqli_query($_conection->connect(), $sqlEmpleadoNoti);
	$row_sqlEmpleadoNoti = mysqli_fetch_assoc($rs_sqlEmpleadoNoti);
	$en_valor = $row_sqlEmpleadoNoti['en_valor'];
	$en_tipo = $row_sqlEmpleadoNoti['en_tipo'];
	$en_ss = $row_sqlEmpleadoNoti['en_ss'];
	$en_se = $row_sqlEmpleadoNoti['en_se'];
	$en_descuento = $row_sqlEmpleadoNoti['en_descuento'];
	$en_total = $row_sqlEmpleadoNoti['en_total'];

	$en_xiii = $row_sqlEmpleadoNoti["en_xiii"];
	$en_xiii_ss = $row_sqlEmpleadoNoti["en_xiii_ss"];
	$en_xiii_total = $row_sqlEmpleadoNoti["en_xiii_total"];

	$en_nombre = utf8_encode($row_sqlEmpleadoNoti['emp_do_nombre']);

	$en_au_numeros = $row_sqlEmpleadoNoti["en_au_numeros"];
	$en_au_descuento = $row_sqlEmpleadoNoti["en_au_descuento"];
	$en_vac_descuento = $row_sqlEmpleadoNoti["en_vac_descuento"];

	if ( $row_sqlEmpleadoNoti["en_fecha_empieza"] == $row_sqlEmpleadoNoti["en_fecha"] ) {
		list($year, $month, $day) = explode("-", $row_sqlEmpleadoNoti["en_fecha_empieza"]);
		$en_fecha = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;
	}else{
		list($yearE, $monthE, $dayE) = explode("-", $row_sqlEmpleadoNoti["en_fecha_empieza"]);
		list($yearT, $monthT, $dayT) = explode("-", $row_sqlEmpleadoNoti["en_fecha"]);
		if ( $monthE == $monthT ) {
			$en_fecha = $dayE . " al " . $dayT . " de " . $arrayMesesGlobal[(int)$monthT] . " de " . $yearT;
		}elseif ( $yearE == $yearT ) {
			$en_fecha = $dayE . " de " . $arrayMesesGlobal[(int)$monthE] . " al " . $dayT . " de " . $arrayMesesGlobal[(int)$monthT] . " de " . $yearT;
		}else{
			$en_fecha = $dayE . " de " . $arrayMesesGlobal[(int)$monthE] . " de " . $yearE . " al " . $dayT . " de " . $arrayMesesGlobal[(int)$monthT] . " de " . $yearT;
		}
	}

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	if( $en_ss || $en_se ) {
		$stContribuciones = '<p><b>Contribuciones aplicables:</b><br>
S.S. USD <b>'.$en_ss. '</b><br>
S.E. USD <b>'.$en_se. '</b></p>';
	}

	if( $en_au_numeros || $en_vac_descuento ) {
		$stDescuento = '<p><b>Descuentos:</b></p>';
		if ($en_vac_descuento) {
			$stDescuento .= 'Vacaciones: USD <b>'.$en_vac_descuento.'</b>';
		}

		if ($en_au_numeros) {
			$stDescuento .= '<b>'.$en_au_numeros.'</b> Ausencias injustificadas: USD <b>'.$en_au_descuento.'</b>';
		}
	}

	if ($en_tipo == 'vacaciones') {
		$en_valor = $en_valor;

		$diasVacaciones = diferenciaDias($row_sqlEmpleadoNoti["en_fecha_empieza"], $row_sqlEmpleadoNoti["en_fecha"]) + 1;
		$vacaciones = $diasVacaciones.' días <br>';
	}elseif ($en_tipo == 'xiii') {
		$en_total = $en_xiii_total;
		
		if ($en_xiii_ss > 0) {
			$stXiii = '<p><b>Contribuciones aplicables:</b><br>
S.S. USD <b>'.$en_xiii_ss. '</b><br>';
		}
	}

	if ($en_tipo == 'salario' && $en_xiii > 0) {
		$stXiii = '<p><b>XIII:</b> USD <b>'.$en_xiii. '</b></p>';
		if ($en_xiii_ss > 0) {
			$stXiii .= '<p><b>Contribuciones aplicables:</b><br>
S.S. USD <b>'.$en_xiii_ss. '</b><br>';
		}
	}

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
<div style="border: 1px solid #000; padding: 30px;">
	<h2 style="text-align:center;">COMPROBANTE DE PAGO</h2>
	
	<p><b>'.$en_nombre.'</b><br>
	Fecha: '.$en_fecha.'</p>

	'.$vacaciones.'
	<p><b>'.ucwords($en_tipo).':</b> USD <b>'.$en_valor. '</b></p>
	'.$stContribuciones.'
	'.$stDescuento.'
	'.$stXiii.'
	<p><b>Total:</b> USD <b style="font-size:16px;">'.$en_total. '</b></p>
	<br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
		<div style="text-align:center"><b>EMPLEADO</b></div>
'.$imgFirmaEmp.'<br>________________________________________________
	</div>
</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'confirmaciones-pagos';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/confirmacion-pago-".$id.".pdf", $pdf);
}

/*
	No esta en uso la firma
		<br>
		<div style="width:50%; display:inline-block; vertical-align: top;">
			<div style="text-align:center"><b>EMPLEADO</b></div>
	'.$imgFirmaEmp.'<br>________________________________________________
		</div>
*/

function crearComprobanteDiasFeriados($id, $nombre, $dia, $cantidad, $valor, $fecha, $firmaEmp, $_conection){
	$conexion = $_conection->connect();
	$arrayTiposAdelantos = array('', 'Salario');
	$arrayPeriodos = array('', 'diarias','semanales','quincenales','mensuales');
	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	list($year, $month, $day) = explode("-",$fecha);

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
<div style="border: 1px solid #000; padding: 30px;">
	<h2 style="text-align:center;">COMPROBANTE DE DÍA DE DESCANSO, DOMINGO O FERIADOS</h2>
	
	<p><b>'.$nombre.'</b><br>
	Fecha: '.$day.' de '.$arrayMesesGlobal[(int)$month].' de '.$year.' </p>

	<p><b>Concepto:</b> <b>Recargo por '.$dia.'</b></p>
	<p><b>Monto:</b> USD <b style="font-size:16px;">'.$valor. '</b></p>
	<br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
		<div style="text-align:center"><b>EMPLEADO</b></div>
'.$imgFirmaEmp.'<br>________________________________________________
	</div>
</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'confirmaciones-diaespecial';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/confirmacion-diaespecial-".$id.".pdf", $pdf);
}

function crearComprobantePrestamoAdelanto($tipo, $id, $nombre, $monto, $periodo, $cuota, $fecha, $firmaEmp, $_conection){
	$conexion = $_conection->connect();
	$arrayTiposAdelantos = array('', 'Salario');
	$arrayPeriodos = array('', 'diarias','semanales','quincenales','mensuales');
	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	list($year, $month, $day) = explode("-",$fecha);

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	if ($tipo == 1) {
		$periodo = '<p><b>Período:</b> <b> '.$cuota.'</b> cuotas '. $arrayPeriodos[(int)$periodo] . '</p>';
	}else{
		$periodo = '<p><b>Tipo Adelanto:</b> <b> '.$arrayTiposAdelantos[$periodo].'</b> </p>';
	}

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
<div style="border: 1px solid #000; padding: 30px;">
	<h2 style="text-align:center;">COMPROBANTE DE ADELANTO O PRÉSTAMO</h2>
	
	<p><b>'.$nombre.'</b><br>
	Fecha: '.$day.' de '.$arrayMesesGlobal[(int)$month].' de '.$year.' </p>

	'.$periodo.'
	<p><b>Concepto:</b> <b>' . (($tipo==1) ? "Préstamo" : "Adelanto" ) . '</b></p>
	<p><b>Monto:</b> USD <b style="font-size:16px;">'.$monto. '</b></p>
	<br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
		<div style="text-align:center"><b>EMPLEADO</b></div>
'.$imgFirmaEmp.'<br>________________________________________________
	</div>
</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'confirmaciones-adelanto-o-prestamo';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/confirmacion-adelanto-o-prestamo-".$id.".pdf", $pdf);
}

function crearConfirmacionLiquidacion($id, $_conection, $datos, $consulta, $firmaEmp = ''){
	$conexion = $_conection->connect();
	// $arrayPeriodos = array('', 'diario','semanal','quincenal','mensual');
	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	$en_total = 0;
	if ($datos["vacacionesPendientes"] > 0) {
		$informacionDet .= '<p><b>Vacaciones proporcionales:</b> USD <b>'.$datos["vacacionesPendientes"]. '</b></p>';
		$en_total += $datos["vacacionesPendientes"];
	}

	if ($datos["primaAntiguedad"] > 0 && $datos["termino"] == 'indefinido') {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["primaAntiguedad"]. '</b></p>';
		$en_total += $datos["primaAntiguedad"];
	}

	if ($datos["xiiiPendientes"] > 0) {
		$informacionDet .= '<p><b>Décimo tercer mes pendiente:</b> USD <b>'.$datos["xiiiPendientes"]. '</b></p>';
		$en_total += $datos["xiiiPendientes"];
	}

	if ($datos["indemnizacion"] > 0) {
		$informacionDet .= '<p><b>Indemnización:</b> USD <b>'.$datos["indemnizacion"]. '</b></p>';
		$en_total += $datos["indemnizacion"];
	}

	if ($datos["preaviso"] > 0 && $datos["termino"] == 'indefinido') {
		$informacionDet .= '<p><b>Preaviso:</b> USD <b>'.$datos["preaviso"]. '</b></p>';	
		$en_total += $datos["preaviso"];
	}

	list($year, $month, $day) = explode("-", $datos["fecha_liquidar"]);
	$en_fecha = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
<div style="border: 1px solid #000; padding: 30px;">
	<h2 style="text-align:center;">DOCUMENTO DE LIQUIDACIÓN</h2>
	
	<p><b>'.utf8_encode($consulta["emp_do_nombre"]).'</b><br>
	Fecha: '.$en_fecha.'</p>

	'.$informacionDet.'
	<p><b>Total:</b> USD <b style="font-size:16px;">'.$en_total.'</b></p>
	<br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
		<div style="text-align:center"><b>EMPLEADO</b></div>
'.$imgFirmaEmp.'<br>________________________________________________
	</div>
</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'documentos-liquidacion';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/documento-de-liquidacion-".$id.".pdf", $pdf);
}

function crearCartaRenuncia($id, $_conection, $datos, $consulta, $firmaEmp = ''){
	$conexion = $_conection->connect();

	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	$en_total = 0;
	if ($datos["vacacionesPendientes"] > 0) {
		$informacionDet .= '<p><b>Vacaciones proporcionales:</b> USD <b>'.$datos["vacacionesPendientes"]. '</b></p>';
		$en_total += $datos["vacacionesPendientes"];
	}

	if ($datos["primaAntiguedad"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["primaAntiguedad"]. '</b></p>';
		$en_total += $datos["primaAntiguedad"];
	}

	if ($datos["xiiiPendientes"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["xiiiPendientes"]. '</b></p>';
		$en_total += $datos["xiiiPendientes"];
	}

	if ($datos["indemnizacion"] > 0) {
		$informacionDet .= '<p><b>Indemnización:</b> USD <b>'.$datos["indemnizacion"]. '</b></p>';
		$en_total += $datos["indemnizacion"];
	}

	if ($datos["preaviso"] > 0) {
		$informacionDet .= '<p><b>Preaviso:</b> USD <b>'.$datos["preaviso"]. '</b></p>';	
		$en_total += $datos["preaviso"];
	}

	list($year, $month, $day) = explode("-", $datos["fecha_liquidar"]);
	$en_fecha = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;


	list($year, $month, $day) = explode("-", $consulta["emp_cond_fecha_relacion"]);
	$emp_cond_fecha_relacion = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;

	if($consulta["emp_do_hombre"]=="true"){
		$empGenero = 'masculino';
	}elseif($consulta["emp_do_mujer"]=="true"){
		$empGenero = 'femenino';
	}

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
<div style="padding: 5px;">
	<p>Panamá, '.$en_fecha.'</p>
	
	<br>
	Señor(a)<br>
	'.utf8_encode($consulta["emp_dor_nombre"].' '.$consulta["emp_dor_apellido"]).'<br>
	E.S.M.

	<p>
Por este medio yo, '.utf8_encode($consulta["emp_do_nombre"]).' '.$empGenero.', '.utf8_encode($consulta["emp_do_nacionalidad_value"]).', mayor de edad, con número de identificación personal No. '.utf8_encode($consulta["emp_do_no_identidad"]).' le comunico mi formal renuncia efectiva a partir del '.$en_fecha.'
	</p>

	Sin ningún otro particular me despido.<br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
'.$imgFirmaEmp.'<br>________________________________________________
		<div style="text-align:center"><b>'.utf8_encode($consulta["emp_do_nombre"]).'</b></div>
	</div>
	<br><br>
	Fecha de inicio de la relación laboral: '.$emp_cond_fecha_relacion.' <br>
	Cargo: '.utf8_encode($consulta["emp_perfil_nombre"]).'<br><br>
	Salario: USD '.round($datos["salarioMensual"],2).' mensuales.<br><br>

	<div style="font-style: italic; font-size:11px; text-align:center;">ESTA CARTA DE RENUNCIA NO ES VÁLIDA SIN EL REFRENDO DEL MINISTERIO DE TRABAJO Y DESARROLLO LABORAL.</div>

</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'documentos-liquidacion';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/carta-de-renuncia-".$id.".pdf", $pdf);
}

function crearDespidoDosAnhos($id, $_conection, $datos, $consulta, $firmaEmp = ''){
	$conexion = $_conection->connect();

	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	$en_total = 0;
	if ($datos["vacacionesPendientes"] > 0) {
		$informacionDet .= '<p><b>Vacaciones proporcionales:</b> USD <b>'.$datos["vacacionesPendientes"]. '</b></p>';
		$en_total += $datos["vacacionesPendientes"];
	}

	if ($datos["primaAntiguedad"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["primaAntiguedad"]. '</b></p>';
		$en_total += $datos["primaAntiguedad"];
	}

	if ($datos["xiiiPendientes"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["xiiiPendientes"]. '</b></p>';
		$en_total += $datos["xiiiPendientes"];
	}

	if ($datos["indemnizacion"] > 0) {
		$informacionDet .= '<p><b>Indemnización:</b> USD <b>'.$datos["indemnizacion"]. '</b></p>';
		$en_total += $datos["indemnizacion"];
	}

	if ($datos["preaviso"] > 0) {
		$informacionDet .= '<p><b>Preaviso:</b> USD <b>'.$datos["preaviso"]. '</b></p>';	
		$en_total += $datos["preaviso"];
	}

	list($year, $month, $day) = explode("-", $datos["fecha_liquidar"]);
	$en_fecha = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;


	list($year, $month, $day) = explode("-", $datos["emp_cond_fecha_relacion"]);
	$emp_cond_fecha_relacion = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;

	if($consulta["emp_do_hombre"]=="true"){
		$empGenero = 'masculino';
	}elseif($consulta["emp_do_mujer"]=="true"){
		$empGenero = 'femenino';
	}

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
<div style="padding: 5px;">
	<p>Panamá, '.$en_fecha.'</p>
	
	<br>
	Señor(a)<br>
	'.utf8_encode($consulta["emp_do_nombre"]).'<br>
	E.S.M.

	<p>
Cumpliendo con lo dispuesto en el artículo 214 del Código de trabajo, se le notifica por este medio, que hemos decidido  dar por terminada la relación de trabajo que se venía manteniendo con usted a partir del día '.$en_fecha.'
	</p>

La terminación de la relación de trabajo se fundamenta en el Artículo 212, Numeral 1 del Código de Trabajo. <br>
Atentamente,<br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
'.$imgFirmaEmp.'<br>________________________________________________
		<div style="text-align:center"><b>'.utf8_encode($consulta["emp_dor_nombre"] . ' ' . $consulta["emp_dor_apellido"]).'</b></div>
	</div>
</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'documentos-liquidacion';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/despido-menos-dos-".$id.".pdf", $pdf);
}

function crearMutuoAcuerdo($id, $_conection, $datos, $consulta, $firmaEmp = ''){
	$conexion = $_conection->connect();

	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	$en_total = 0;
	if ($datos["vacacionesPendientes"] > 0) {
		$informacionDet .= '<p><b>Vacaciones proporcionales:</b> USD <b>'.$datos["vacacionesPendientes"]. '</b></p>';
		$en_total += $datos["vacacionesPendientes"];
	}

	if ($datos["primaAntiguedad"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["primaAntiguedad"]. '</b></p>';
		$en_total += $datos["primaAntiguedad"];
	}

	if ($datos["xiiiPendientes"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["xiiiPendientes"]. '</b></p>';
		$en_total += $datos["xiiiPendientes"];
	}

	if ($datos["indemnizacion"] > 0) {
		$informacionDet .= '<p><b>Indemnización:</b> USD <b>'.$datos["indemnizacion"]. '</b></p>';
		$en_total += $datos["indemnizacion"];
	}

	if ($datos["preaviso"] > 0) {
		$informacionDet .= '<p><b>Preaviso:</b> USD <b>'.$datos["preaviso"]. '</b></p>';	
		$en_total += $datos["preaviso"];
	}

	list($year, $month, $day) = explode("-", $datos["fecha_liquidar"]);
	$en_fecha = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;


	list($year, $month, $day) = explode("-", $datos["emp_cond_fecha_relacion"]);
	$emp_cond_fecha_relacion = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;

	if($consulta["emp_do_hombre"]=="true"){
		$empGenero = 'masculino';
	}elseif($consulta["emp_do_mujer"]=="true"){
		$empGenero = 'femenino';
	}

	$numberLetter = new NumberToLetterConverter();

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:12px;">
<div style="padding: 30px;">
	<h2 style="text-align:center;"><b>MUTUO ACUERDO Y FINIQUITO</b></h2>
	<p>Panamá, '.$en_fecha.'</p>
	
	<br>

<div style="text-align:justify;">Los que suscriben, a saber, <b>'.utf8_encode($consulta["emp_dor_nombre"] . ' ' . $consulta["emp_dor_apellido"]).'</b> quien en lo sucesivo se denominará <b>EL EMPLEADOR</b>, por una parte, y por la otra, '.utf8_encode($consulta["emp_do_nombre"]).' '.$empGenero.', '.utf8_encode($consulta["emp_do_nacionalidad_value"]).', mayor de edad, con número de identificación personal No. '.utf8_encode($consulta["emp_do_no_identidad"]).' en adelante <b>EL TRABAJADOR</b>, y conjuntamente <b>LAS PARTES</b>, acuerdan celebrar el presente <b>FINIQUITO</b> y convenio de terminación de la relación de trabajo, sujeto a las siguientes cláusulas:<br><br></div>

<div style="text-align:justify;"><b>PRIMERA</b>: Declaran Las Partes que por este medio han convenido voluntariamente, por mutuo acuerdo, ponerle término a la relación de trabajo que los vincula actualmente, de conformidad con lo previsto en el Artículo 210, numeral 1, del Código de Trabajo panameño, a partir del '.$en_fecha.'<br><br></div>

<div style="text-align:justify;"><b>SEGUNDA:</b> En virtud del acuerdo anterior, <b>EL EMPLEADOR</b> reconoce pagar a <b>EL TRABAJADOR</b> la suma única y total de '.$numberLetter->to_word($en_total,'USD').' (USD$'.$en_total.'), desglosados de la siguiente forma: <br><br></div>
	'.$informacionDet.'<br>

De dicho monto se harán los descuentos legales que sean aplicables. <br><br>

<div style="text-align:justify;"><b>TERCERA</b>:  Reconoce y acepta EL TRABAJADOR, que los montos arriba descritos, en especial el pago de indemnización, cubren en exceso cualesquiera horas extras, sobre tiempo en día domingo, de fiesta o duelo nacional, que en algún momento haya podido laborar EL TRABAJADOR para EL EMPLEADOR, así como los derechos adquiridos que pudiesen haberse generado por estos conceptos, al igual de cualesquiera diferencias en concepto de vacaciones, décimo tercer mes, prima de antigüedad u otras prestaciones laborales que le pudiesen corresponder o que pudiesen haberse originado, por lo que no tiene ningún tipo de reclamo bajo estos conceptos.<br><br></div>

<div style="text-align:justify;"><b>CUARTA</b>: Declara <b>EL TRABAJADOR</b> que en virtud de lo pactado en las cláusulas anteriores, no tiene reclamaciones pasadas, presentes, ni futuras que formular en contra de <b>EL EMPLEADOR</b>, de cualquier naturaleza, producto de la relación laboral que existió, así como de su terminación y que ésta no le adeuda suma alguna de dinero. <br><br></div>

Asimismo manifiesta <b>EL TRABAJADOR</b>  que el presente convenio no implica renuncia de sus derechos.<br><br>

Dado en la ciudad de Panamá a los '.$en_fecha.'<br><br>
	
	<div style="width:50%; display:inline-block; vertical-align: top;">
		<div style="text-align:center"><b>EL EMPLEADOR</b></div>
		<br>
		<br>
	________________________________________________
	</div>
	<div style="width:50%; display:inline-block; vertical-align: top;">
	<div style="text-align:center"><b>EL TRABAJADOR</b></div>
		<br>
		<br>
	________________________________________________
	</div>

</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'documentos-liquidacion';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/mutuo-acuerdo-".$id.".pdf", $pdf);
}

function crearExpiracionContrato($id, $_conection, $datos, $consulta, $firmaEmp = ''){
	$conexion = $_conection->connect();

	$arrayMesesGlobal = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

	if ($firmaEmp) {
		$imgFirmaEmp = '<img style="height:70px;" src="'.$firmaEmp.'">';
	}else{
		$imgFirmaEmp = '<br><br>';
	}

	$en_total = 0;
	if ($datos["vacacionesPendientes"] > 0) {
		$informacionDet .= '<p><b>Vacaciones proporcionales:</b> USD <b>'.$datos["vacacionesPendientes"]. '</b></p>';
		$en_total += $datos["vacacionesPendientes"];
	}

	if ($datos["primaAntiguedad"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["primaAntiguedad"]. '</b></p>';
		$en_total += $datos["primaAntiguedad"];
	}

	if ($datos["xiiiPendientes"] > 0) {
		$informacionDet .= '<p><b>Prima de antigüedad:</b> USD <b>'.$datos["xiiiPendientes"]. '</b></p>';
		$en_total += $datos["xiiiPendientes"];
	}

	if ($datos["indemnizacion"] > 0) {
		$informacionDet .= '<p><b>Indemnización:</b> USD <b>'.$datos["indemnizacion"]. '</b></p>';
		$en_total += $datos["indemnizacion"];
	}

	if ($datos["preaviso"] > 0) {
		$informacionDet .= '<p><b>Preaviso:</b> USD <b>'.$datos["preaviso"]. '</b></p>';	
		$en_total += $datos["preaviso"];
	}

	$fechaIniciaRelacion = new DateTime($consulta['emp_cond_fecha_relacion']);
	$fechaIniciaRelacion->modify("+".$consulta['emp_tipo_definido']." months");

	list($year, $month, $day) = explode("-", $fechaIniciaRelacion->format('Y-m-d'));
	$en_fecha = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;


	list($year, $month, $day) = explode("-", $datos["fecha_liquidar"]);
	$fecha_liquidar = $day . " de " . $arrayMesesGlobal[(int)$month] . " de " . $year;

	if($consulta["emp_do_hombre"]=="true"){
		$empGenero = 'masculino';
	}elseif($consulta["emp_do_mujer"]=="true"){
		$empGenero = 'femenino';
	}

	$dompdf = new Dompdf();
	$contenido_pdf = '
<!doctype html><html><head><title>title</title></head>
<body style="font-family: Times New Roman, Times, serif, Arial, Helvetica; font-size:13px;">
<div style="padding: 5px;">
	<p>Panamá, '.$fecha_liquidar.'</p>
	
	<br>
	Señor(a)<br>
	'.utf8_encode($consulta["emp_do_nombre"]).'<br>
	E.S.M.

	<p>
Por este medio le hacemos de su conocimiento que su contrato de trabajo a término definido expira el '.$en_fecha.'.  Por tal motivo, a partir del '.$en_fecha.' termina la relación de trabajo que manteníamos con usted, en virtud del Artículo 210, numeral 2 del Código de Trabajo. 
	</p>

	Sin ningún otro particular me despido.<br>
	<div style="width:50%; display:inline-block; vertical-align: top;">
'.$imgFirmaEmp.'<br>________________________________________________
		<div style="text-align:center"><b>'.utf8_encode($consulta["emp_dor_nombre"] . ' ' . $consulta["emp_dor_apellido"]).'</b></div>
	</div>

</div>
</body>
</html>';

	// $contenido_pdf = iconv('UTF-8','ISO-8859-1',$contenido_pdf);
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->load_html($contenido_pdf);
	$dompdf->set_paper("letter","portrait");
	$dompdf->render();
	$pdf = $dompdf->output();

	//Crear carpeta si no se ha creado
	$pathFile = '../../imagenes-contenidos/';
	$carpeta = 'documentos-liquidacion';
	//Creamos Carpeta Global
	if(!file_exists($pathFile.$carpeta) && $carpeta){
		mkdir($pathFile.$carpeta,0777);
	}
	$pathFileId = $pathFile.$carpeta;
	file_put_contents($pathFileId."/expiracion-contrato-".$id.".pdf", $pdf);
}

function diferenciaDias($inicio, $fin)
{
    $inicio = strtotime($inicio);
    $fin = strtotime($fin);
    $dif = $fin - $inicio;
    $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
    return ceil($diasFalt);
}

function getUltimoDiaMes($elAnio,$elMes) {
  return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
}

?>