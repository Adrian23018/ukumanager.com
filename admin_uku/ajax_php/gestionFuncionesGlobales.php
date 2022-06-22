<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	
	if($_POST['tipo'] == 'cambiarIdioma'){
		if(validarLogueado($_conection)){
			$result['error'] = '';	
			$_SESSION[_sessionIdioma] = (int)$_POST["value"];
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	

	if($_POST['tipo'] == 'cambiarEstado'){
		if(validarLogueado($_conection)){
			$result['error'] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabIdRegistro = utf8_decode($_POST['tabIdRegistro']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			//Buscamos el Estado en la Base De Datos
			$select_estado = sprintf("SELECT * FROM ".$nombreTabla." WHERE ".$idTabla."=%s", 
				GetSQLValueString($tabIdRegistro,"int")
			);
			$rs_estado = mysqli_query($_conection->connect(), $select_estado);
			$row_estado = mysqli_fetch_assoc($rs_estado);
			if($row_estado[$tabPrefijo."estado"]==1){
				$nuevo_estado = 0;
			}else{
				$nuevo_estado = 1;
			}

			$sql = sprintf("UPDATE ".$nombreTabla." SET ".$tabPrefijo."estado=%s WHERE ".$idTabla."=%s",
				$nuevo_estado,
				GetSQLValueString($tabIdRegistro,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			if ($rs_sql) {
				$result['success'] = '';
			}else{
				$result['error'] = _errorSql;
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina cambiarEstado

	if($_POST['tipo'] == 'cambiarDestacado'){
		if(validarLogueado($_conection)){
			$result['error'] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabIdRegistro = utf8_decode($_POST['tabIdRegistro']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			//Buscamos el Estado en la Base De Datos
			$select_estado = sprintf("SELECT * FROM ".$nombreTabla." WHERE ".$idTabla."=%s", 
				GetSQLValueString($tabIdRegistro,"int")
			);
			$rs_estado = mysqli_query($_conection->connect(), $select_estado);
			$row_estado = mysqli_fetch_assoc($rs_estado);
			if($row_estado[$tabPrefijo."destacado"]==1){
				$nuevo_estado = 0;
			}else{
				$nuevo_estado = 1;
			}

			$sql = sprintf("UPDATE ".$nombreTabla." SET ".$tabPrefijo."destacado=%s WHERE ".$idTabla."=%s",
				$nuevo_estado,
				GetSQLValueString($tabIdRegistro,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			if ($rs_sql) {
				$result['success'] = '';
			}else{
				$result['error'] = _errorSql;
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina cambiarDestacado

	if($_POST['extra']['tipo'] == 'cambiarPosicion'){
		if (validarLogueado($_conection)) {
			$tabTipo = utf8_decode($_POST['extra']['variables']['dbTipo']);
			$tabNombre = utf8_decode($_POST['extra']['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['extra']['variables']['dbPrefijo']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';
			$posicion = $tabPrefijo.'posicion';

			$id           = $_POST['id'];
			$fromPosition = is_array($_POST['fromPosition']) ? $_POST['fromPosition'][0] : $_POST['fromPosition'];
			$toPosition   = $_POST['toPosition'];
			$direction    = $_POST['direction'];
			$aPosition    = ($direction === "back") ? $toPosition+1 : $toPosition-1;

			$resultShow = mysqli_query("SHOW COLUMNS FROM ".$nombreTabla." LIKE '".$tabPrefijo."idi_id'");
			$exists = (mysql_num_rows($resultShow))?true:false;
			if ($exists) {
				$toIdioma = " AND ".$tabPrefijo."idi_id=".$_SESSION[_sessionIdioma]." ";
			}
 
			$sql = mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion=0 WHERE $posicion='".$toPosition."' $toIdioma");
			mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion=$toPosition WHERE $idTabla='".$id."' $toIdioma");
	 
			if($direction === "back") {
				mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion = $posicion + 1 WHERE ($toPosition <= $posicion AND $posicion <= $fromPosition) and $idTabla != $id and $posicion != 0 $toIdioma ORDER BY $posicion DESC;");
			} // backward direction
	  
			if($direction === "forward") {    
				mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion = $posicion - 1 WHERE ($fromPosition <= $posicion AND $posicion <= $toPosition) and $idTabla != $id and $posicion != 0 $toIdioma ORDER BY $posicion ASC;");
			} // Forward Direction

			mysqli_query($_conection->connect(),  "UPDATE $nombreTabla SET $posicion = $aPosition WHERE $posicion = 0 $toIdioma ;");
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

	if($_POST['tipo'] == 'cambiarVisto'){
		if(validarLogueado($_conection)){
			$result['error'] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabIdRegistro = utf8_decode($_POST['id']);
			$tabNombre = utf8_decode($_POST['table']);
			$tabPrefijo = utf8_decode($_POST['table_prefijo']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			$sql = sprintf("UPDATE ".$nombreTabla." SET ".$tabPrefijo."visto=%s WHERE ".$idTabla."=%s",
				1,
				GetSQLValueString($tabIdRegistro,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			if ($rs_sql) {
				$result['success'] = '';
			}else{
				$result['error'] = _errorSql;
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina cambiarVisto

	if($_POST['tipo'] == 'eliminarItem'){
		if (validarLogueado($_conection)) {
			$result['error'] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabIdRegistro = utf8_decode($_POST['tabIdRegistro']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);
			$carpetaArchivos = utf8_decode($_POST['variables']['dbNombre']);
			$arrayRegistrosAsociados = $_POST['variables']['arrayRegistrosAsociados'];

			$arrayUno = array(
								'nombreTabla' => $tabNombre, 
								'prefijo' => $tabPrefijo,
								'id' => $tabIdRegistro
							);
			//Elimina los registros y sus subcategorias...
			$variable = eliminarRegistrosTabla($_conection, $tabTipo, $arrayUno, $arrayRegistrosAsociados);
			if($variable["error"]){
				$result['error'] = $variable["mensaje"];
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//eliminarItem

	//Traer Imágenes
	if ($_POST['tipo'] == 'formTraerImagenes') {
		if (validarLogueado($_conection)) {
			$result['error'] = '';

			if ($_POST['dbNombre']) {
				$_POST['variables']['dbNombre'] = $_POST['dbNombre'];
			}
			
			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabIdRegistro = utf8_decode($_POST['tabIdRegistro']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);
			$carpetaArchivos = utf8_decode($_POST['variables']['dbNombre']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			if ($tabTipo == 'a_') {
				$pathFile = _carpetaA;
			}elseif ($tabTipo == 'g_') {
				$pathFile = _carpetaG;
			}else{
				$pathFile = _carpetaN;
			}

			//Imagenes
			$sql = sprintf("SELECT * FROM g_tbl_imagenes WHERE img_tabla=%s AND img_id_tabla=%s AND (img_tipo_tabla=%s OR img_tipo_tabla IS NULL) ORDER BY img_principal DESC, img_nombre ASC",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$contImagenes = 1;
			while ( $row_sql = mysqli_fetch_assoc($rs_sql) ){
				$atributosArchivo['id'] = $row_sql['img_id'];
				$atributosArchivo['nombre'] = $row_sql['img_nombre'];
				$atributosArchivo['extension'] = $row_sql['img_extension'];
				$atributosArchivo['principal'] = $row_sql['img_principal'];
				$atributosArchivo['cropboxdata'] = $row_sql['img_cropboxdata'];
				$atributosArchivo['canvasdata'] = $row_sql['img_canvasdata'];
				$atributosArchivo['rotate'] = $row_sql['img_rotate'];
				$atributosArchivo['link'] = $row_sql['img_link'];
				//templateArchivos en /includes/configFunciones
				$archivos .= templateArchivos(1, $_POST['variables'], $tabIdRegistro, $atributosArchivo);
				$contImagenes++;
			}

			$result['archivos'] = $archivos;
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//formTraerImagenes

	//Traer Descargas
	if ($_POST['tipo'] == 'formTraerDescargas') {
		if (validarLogueado($_conection)) {
			$result['error'] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabIdRegistro = utf8_decode($_POST['tabIdRegistro']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);
			$carpetaArchivos = utf8_decode($_POST['variables']['dbNombre']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			if ($tabTipo == 'a_') {
				$pathFile = _carpetaA;
			}elseif ($tabTipo == 'g_') {
				$pathFile = _carpetaG;
			}else{
				$pathFile = _carpetaN;
			}

			//Archivos
			$sql = sprintf("SELECT * FROM g_tbl_archivos WHERE arc_tabla=%s AND arc_id_tabla=%s AND (arc_tipo_tabla=%s OR arc_tipo_tabla IS NULL)",
				GetSQLValueString($tabNombre,"text"),
				GetSQLValueString($tabIdRegistro,"int"),
				GetSQLValueString($tabTipo,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$contImagenes = 1;
			while ( $row_sql = mysqli_fetch_assoc($rs_sql) ){
				$atributosArchivo['id'] = $row_sql['arc_id'];
				$atributosArchivo['nombre'] = $row_sql['arc_nombre'];
				$atributosArchivo['extension'] = $row_sql['arc_extension'];
				$atributosArchivo['principal'] = $row_sql['arc_principal'];
				//templateArchivos en /includes/configFunciones
				$archivos .= templateArchivos(2, $_POST['variables'], $tabIdRegistro, $atributosArchivo);
				$contImagenes++;
			}

			$result['archivos'] = $archivos;
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//formTraerDescargas
	

	if ($_POST['tipo'] == 'guardarArchivo') {
		if (validarLogueado($_conection)) {
			$result['error'] = '';

			$data_tipo = utf8_decode($_POST['dataArchivos']['data_tipo']);
			$data_bd_id = utf8_decode($_POST['dataArchivos']['data_bd_id']);
			$data_tb_id = utf8_decode($_POST['dataArchivos']['data_tb_id']);
			$data_principal = utf8_decode($_POST['dataArchivos']['data_principal']);
			$data_nombre = utf8_decode($_POST['dataArchivos']['data_nombre']);

			$dataInputNuevo = utf8_decode(CamellizarConGuiones($_POST['dataInput']));
			$dataInputLink = utf8_decode($_POST['dataInputLink']);
			$dataCheckActivo = utf8_decode($_POST['dataCheckActivo']);

			if ($data_tipo == 'imagenes') {
				$prefijoTable = 'img_';
				$tablebd = 'g_tbl_imagenes';
			}else{
				$prefijoTable = 'arc_';
				$tablebd = 'g_tbl_archivos';
			}

			//Cambiar Link
			$sqlUpdateLink =	sprintf("UPDATE ".$tablebd." 
								SET 
									".$prefijoTable."link=%s 
								WHERE 
									".$prefijoTable."id_tabla=%s AND 
									".$prefijoTable."id=%s",
						GetSQLValueString($dataInputLink,"text"),
						GetSQLValueString($data_bd_id,"int"),
						GetSQLValueString($data_tb_id,"int")
					);
			$rs_sqlUpdateLink = mysqli_query($_conection->connect(), $sqlUpdateLink);

			$sql = 	sprintf("SELECT * FROM ".$tablebd." 
								WHERE  
									".$prefijoTable."id_tabla=%s AND 
									".$prefijoTable."id=%s",
						GetSQLValueString($data_bd_id,"int"),
						GetSQLValueString($data_tb_id,"int")
					);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			$tabla = $row_sql[$prefijoTable."tabla"];
			$dataInput = $row_sql[$prefijoTable."nombre"];
			$dataInputExtension = $row_sql[$prefijoTable."extension"];
			//Validar

			$sqlNombre = 	sprintf("SELECT * FROM ".$tablebd." 
										WHERE  
											".$prefijoTable."id_tabla=%s AND 
											".$prefijoTable."tabla=%s AND 
											".$prefijoTable."id!=%s AND 
											".$prefijoTable."nombre=%s AND 
											".$prefijoTable."extension=%s",
						GetSQLValueString($data_bd_id,"int"),
						GetSQLValueString($tabla,"text"),
						GetSQLValueString($data_tb_id,"int"),
						GetSQLValueString($dataInputNuevo,"text"),
						GetSQLValueString($dataInputExtension,"text")
					);
			$rs_sqlNombre = mysqli_query($_conection->connect(), $sqlNombre);
			$row_sqlNombre = mysqli_fetch_assoc($rs_sqlNombre);
			if (!$row_sqlNombre[$prefijoTable."id"]) {
				//Podemos Guardar

				if ($row_sql[$prefijoTable."tipo_tabla"] == 'a_') {
					$pathFile = _carpetaA;
				}elseif ($row_sql[$prefijoTable."tipo_tabla"] == 'g_') {
					$pathFile = _carpetaG;
				}else{
					$pathFile = _carpetaN;
				}

				if ($data_tipo == 'imagenes') {
					if ($dataCheckActivo == 1) {
						$sqlUpdate = 	sprintf("UPDATE ".$tablebd." 
											SET 
												".$prefijoTable."principal=0 
											WHERE 
												".$prefijoTable."id_tabla=%s AND 
												".$prefijoTable."tabla=%s
											",
									GetSQLValueString($data_bd_id,"int"),
									GetSQLValueString($tabla,"text")
								);
						$rs_sqlUpdate = mysqli_query($_conection->connect(), $sqlUpdate);
					}

					
					$sqlUpdate =	sprintf("UPDATE ".$tablebd." 
										SET 
											".$prefijoTable."principal=%s 
										WHERE 
											".$prefijoTable."id_tabla=%s AND 
											".$prefijoTable."id=%s",
								GetSQLValueString($dataCheckActivo,"int"),
								GetSQLValueString($data_bd_id,"int"),
								GetSQLValueString($data_tb_id,"int")
							);
					$rs_sqlUpdate = mysqli_query($_conection->connect(), $sqlUpdate);
				}
				
				$dir = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/'.$dataInput.'.'.$dataInputExtension;
				$dirNuevo = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/'.$dataInputNuevo.'.'.$dataInputExtension;
				
				$dirThumb = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/thumbnail/'.$dataInput.'.'.$dataInputExtension;
				$dirThumbNuevo = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/thumbnail/'.$dataInputNuevo.'.'.$dataInputExtension;

				if ($dir != $dirNuevo) {
					if(rename($dir, $dirNuevo)){
						rename($dirThumb, $dirThumbNuevo);
						$sqlUpdate =	sprintf("UPDATE ".$tablebd." 
											SET 
												".$prefijoTable."nombre=%s
											WHERE 
												".$prefijoTable."id_tabla=%s AND 
												".$prefijoTable."id=%s",
									GetSQLValueString($dataInputNuevo,"text"),
									GetSQLValueString($data_bd_id,"int"),
									GetSQLValueString($data_tb_id,"int")
								);
						$rs_sqlUpdate = mysqli_query($_conection->connect(), $sqlUpdate);
					}
				}
				$result["success"] = _informacionEditada;
			}else{
				$result["error"] = _errorArchivo;
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina guardarArchivo

	//Eliminar Archivo
	if($_POST['tipo'] == 'eliminarArchivo'){
		if (validarLogueado($_conection)) {
			$result['error'] = '';

			$data_tipo = utf8_decode($_POST['dataArchivos']['data_tipo']);
			$data_bd_id = utf8_decode($_POST['dataArchivos']['data_bd_id']);
			$data_tb_id = utf8_decode($_POST['dataArchivos']['data_tb_id']);
			$data_principal = utf8_decode($_POST['dataArchivos']['data_principal']);
			$data_nombre = utf8_decode($_POST['dataArchivos']['data_nombre']);

			if ($data_tipo == 'imagenes') {
				$prefijoTable = 'img_';
				$tablebd = 'g_tbl_imagenes';
			}else{
				$prefijoTable = 'arc_';
				$tablebd = 'g_tbl_archivos';
			}

			$sql = 	sprintf("SELECT * FROM ".$tablebd." 
								WHERE  
									".$prefijoTable."id_tabla=%s AND 
									".$prefijoTable."id=%s",
						GetSQLValueString($data_bd_id,"int"),
						GetSQLValueString($data_tb_id,"int")
					);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			$dataInput = $row_sql[$prefijoTable."nombre"];
			$dataInputExtension = $row_sql[$prefijoTable."extension"];

			if ($row_sql[$prefijoTable."tipo_tabla"] == 'a_') {
				$pathFile = _carpetaA;
			}elseif ($row_sql[$prefijoTable."tipo_tabla"] == 'g_') {
				$pathFile = _carpetaG;
			}else{
				$pathFile = _carpetaN;
			}

			$dir = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/'.$dataInput.'.'.$dataInputExtension;
			if(unlink($dir)){
				$sqlDelete =	sprintf("DELETE FROM ".$tablebd." 
									WHERE 
										".$prefijoTable."id_tabla=%s AND 
										".$prefijoTable."id=%s",
							GetSQLValueString($data_bd_id,"int"),
							GetSQLValueString($data_tb_id,"int")
						);
				$rs_sqlDelete = mysqli_query($_conection->connect(), $sqlDelete);
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina eliminarArchivo

	if ($_POST['tipo'] == 'guardarImagenCortado') {
		if (validarLogueado($_conection)) {
			$result['error'] = '';
			$result['success'] = '';

			$data_tipo = utf8_decode($_POST['dataArchivos']['data_tipo']);
			$data_bd_id = utf8_decode($_POST['dataArchivos']['data_bd_id']);
			$data_tb_id = utf8_decode($_POST['dataArchivos']['data_tb_id']);
			$data_nombre = utf8_decode($_POST['dataArchivos']['data_nombre']);

			$x = utf8_decode($_POST['dataArchivos']['data_x']);
			$y = utf8_decode($_POST['dataArchivos']['data_y']);
			$w = utf8_decode($_POST['dataArchivos']['data_w']);
			$h = utf8_decode($_POST['dataArchivos']['data_h']);
			$degrees = utf8_decode($_POST['dataArchivos']['data_rotate']);
			$cropboxdata = $_POST['dataArchivos']['cropboxdata'];
			$canvasdata = $_POST['dataArchivos']['canvasdata'];
			$wimg = utf8_decode($_POST['dataArchivos']['data_wimg']);
			$himg = utf8_decode($_POST['dataArchivos']['data_himg']);

			if ($data_tipo == 'imagenes') {
				$prefijoTable = 'img_';
				$tablebd = 'g_tbl_imagenes';
				$sql = 	sprintf("SELECT * FROM ".$tablebd." 
									WHERE  
										".$prefijoTable."id_tabla=%s AND 
										".$prefijoTable."id=%s",
							GetSQLValueString($data_bd_id,"int"),
							GetSQLValueString($data_tb_id,"int")
						);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				$row_sql = mysqli_fetch_assoc($rs_sql);
				$dataInput = $row_sql[$prefijoTable."nombre"];
				$dataInputExtension = $row_sql[$prefijoTable."extension"];
				//Validar

				if ($row_sql[$prefijoTable."tipo_tabla"] == 'a_') {
					$pathFile = _carpetaA;
				}elseif ($row_sql[$prefijoTable."tipo_tabla"] == 'g_') {
					$pathFile = _carpetaG;
				}else{
					$pathFile = _carpetaN;
				}

				$targ_w = $_POST['dataArchivos']['aspectRatioW'];
				$targ_h = $_POST['dataArchivos']['aspectRatioH'];

				if (!$targ_w) {
					$error = true;
					$result['error'] = 'Error imagen seleccionada';	
				}

				$jpeg_quality = 90;
				$png_quality = 9;

				$src = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/'.$dataInput.'.'.$dataInputExtension;
				if ($dataInputExtension == "jpg") {
					$img_r = imagecreatefromjpeg($src);
				}elseif ($dataInputExtension == "png") {
					$img_r = imagecreatefrompng($src);
				}else{
					$error = true;
					$result['error'] = 'No se puede cortar el archivo con extensión "' . $dataInputExtension .'"';
				}

				if (!$error) {
					list($width_img, $height_img, $type_img, $attr_img) = getimagesize($src);
					
					$src_img_w = $width_img;
					$src_img_h = $height_img;

					// Rotate the source image
					if (is_numeric($degrees) && $degrees != 0) {
						// PHP's degrees is opposite to CSS's degrees
						$new_img = imagerotate( $img_r, -$degrees, imagecolorallocatealpha($img_r, 255, 255, 255, 127) );

						imagedestroy($img_r);
						$img_r = $new_img;

						$deg = abs($degrees) % 180;
						$arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

						$src_img_w = $width_img * cos($arc) + $height_img * sin($arc);
						$src_img_h = $width_img * sin($arc) + $height_img * cos($arc);

						// Fix rotated image miss 1px issue when degrees < 0
						$src_img_w -= 1;
						$src_img_h -= 1;
					}

					$tmp_img_w = $w;
					$tmp_img_h = $h;

					$src_x = $x;
					$src_y = $y;

					if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
						$src_x = $src_w = $dst_x = $dst_w = 0;
					} else if ($src_x <= 0) {
						$dst_x = -$src_x;
						$src_x = 0;
						$src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
					} else if ($src_x <= $src_img_w) {
						$dst_x = 0;
						$src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
					}

					if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
						$src_y = $src_h = $dst_y = $dst_h = 0;
					} else if ($src_y <= 0) {
						$dst_y = -$src_y;
						$src_y = 0;
						$src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
					} else if ($src_y <= $src_img_h) {
						$dst_y = 0;
						$src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
					}

					// Scale to destination position and size
					$ratio = $tmp_img_w / $targ_w;
					$dst_x /= $ratio;
					$dst_y /= $ratio;
					$dst_w /= $ratio;
					$dst_h /= $ratio;

					//$x = ($x / $wimg) * $width_img;
					//$y = ($y / $himg) * $height_img;
					//$w = ($w / $wimg) * $width_img;
					//$h = ($h / $himg) * $height_img;

					$dst_r = imagecreatetruecolor( $targ_w, $targ_h );

					imagefill($dst_r, 0, 0, imagecolorallocatealpha($dst_r, 255, 255, 255, 127));
        			imagesavealpha($dst_r, true);
					$resultado = imagecopyresampled($dst_r, $img_r, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

					//$result =imagecopyresampled($dst_r,$img_r,0,0,intval($x),intval($y), $targ_w,$targ_h, intval($w),intval($h));

					$srcDestino = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/thumbnail/';
					if (!file_exists($srcDestino)) {
						mkdir($srcDestino, 0777);
					}

					$imagenDestino = $srcDestino.$dataInput.'.'.$dataInputExtension;
					if ($dataInputExtension == "jpg") {
						$resultcrop = imagejpeg($dst_r,$imagenDestino,$jpeg_quality);
					}elseif ($dataInputExtension == "png") {
						$resultcrop = imagepng($dst_r,$imagenDestino,$png_quality);
					}

					if ($resultcrop) {
						//Guardamos en la base de datos
						$sqlUpdate =	sprintf("UPDATE ".$tablebd." 
											SET 
												".$prefijoTable."thumb=1,
												".$prefijoTable."x=%s,
												".$prefijoTable."y=%s,
												".$prefijoTable."width=%s,
												".$prefijoTable."height=%s,
												".$prefijoTable."rotate=%s,
												".$prefijoTable."cropboxdata=%s,
												".$prefijoTable."canvasdata=%s
											WHERE 
												".$prefijoTable."id_tabla=%s AND 
												".$prefijoTable."id=%s",
									GetSQLValueString($x,"text"),
									GetSQLValueString($y,"text"),
									GetSQLValueString($w,"text"),
									GetSQLValueString($h,"text"),
									GetSQLValueString($degrees,"text"),
									GetSQLValueString($cropboxdata,"text"),
									GetSQLValueString($canvasdata,"text"),
									GetSQLValueString($data_bd_id,"int"),
									GetSQLValueString($data_tb_id,"int")
								);
						$rs_sqlUpdate = mysqli_query($_conection->connect(), $sqlUpdate);
						if ($rs_sqlUpdate) {
							$result['success'] = 'Se ha recortado la imagen satisfactoriamente';
						}else{
							$result['error'] = _errorSql;
						}
					}

					imagedestroy($img_r);
					imagedestroy($dst_r);
				}
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}//Termina guardarImagenCortado

	if ($_POST['tipo'] == 'eliminarImagenCortado') {
		if (validarLogueado($_conection)) {
			$result['error'] = '';
			$result['success'] = '';

			$data_tipo = utf8_decode($_POST['dataArchivos']['data_tipo']);
			$data_bd_id = utf8_decode($_POST['dataArchivos']['data_bd_id']);
			$data_tb_id = utf8_decode($_POST['dataArchivos']['data_tb_id']);
			$data_nombre = utf8_decode($_POST['dataArchivos']['data_nombre']);

			$x = utf8_decode($_POST['dataArchivos']['data_x']);
			$y = utf8_decode($_POST['dataArchivos']['data_y']);
			$w = utf8_decode($_POST['dataArchivos']['data_w']);
			$h = utf8_decode($_POST['dataArchivos']['data_h']);
			$degrees = utf8_decode($_POST['dataArchivos']['data_rotate']);
			$cropboxdata = $_POST['dataArchivos']['cropboxdata'];
			$canvasdata = $_POST['dataArchivos']['canvasdata'];
			$wimg = utf8_decode($_POST['dataArchivos']['data_wimg']);
			$himg = utf8_decode($_POST['dataArchivos']['data_himg']);
			if ($data_tipo == 'imagenes') {
				$prefijoTable = 'img_';
				$tablebd = 'g_tbl_imagenes';
				$sql = 	sprintf("SELECT * FROM ".$tablebd." 
									WHERE  
										".$prefijoTable."id_tabla=%s AND 
										".$prefijoTable."id=%s",
							GetSQLValueString($data_bd_id,"int"),
							GetSQLValueString($data_tb_id,"int")
						);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				$row_sql = mysqli_fetch_assoc($rs_sql);
				$dataInput = $row_sql[$prefijoTable."nombre"];
				$dataInputExtension = $row_sql[$prefijoTable."extension"];
				//Validar

				if ($row_sql[$prefijoTable."tipo_tabla"] == 'a_') {
					$pathFile = _carpetaA;
				}elseif ($row_sql[$prefijoTable."tipo_tabla"] == 'g_') {
					$pathFile = _carpetaG;
				}else{
					$pathFile = _carpetaN;
				}

				if (!$error) {
					$srcDestino = $pathFile.$row_sql[$prefijoTable."tabla"].'/'.$data_bd_id.'/thumbnail/';
					if (!file_exists($srcDestino)) {
						mkdir($srcDestino, 0777);
					}

					$imagenDestino = $srcDestino.$dataInput.'.'.$dataInputExtension;
					if (unlink($imagenDestino)) {
						//Guardamos en la base de datos
						$sqlUpdate =	sprintf("UPDATE ".$tablebd." 
											SET 
												".$prefijoTable."thumb=0,
												".$prefijoTable."x=%s,
												".$prefijoTable."y=%s,
												".$prefijoTable."width=%s,
												".$prefijoTable."height=%s,
												".$prefijoTable."rotate=%s,
												".$prefijoTable."cropboxdata=%s,
												".$prefijoTable."canvasdata=%s
											WHERE 
												".$prefijoTable."id_tabla=%s AND 
												".$prefijoTable."id=%s",
									GetSQLValueString('',"text"),
									GetSQLValueString('',"text"),
									GetSQLValueString('',"text"),
									GetSQLValueString('',"text"),
									GetSQLValueString('',"text"),
									GetSQLValueString('',"text"),
									GetSQLValueString('',"text"),
									GetSQLValueString($data_bd_id,"int"),
									GetSQLValueString($data_tb_id,"int")
								);
						$rs_sqlUpdate = mysqli_query($_conection->connect(), $sqlUpdate);
						if ($rs_sqlUpdate) {
							$result['success'] = 'Se ha eliminado el recorte';
						}else{
							$result['error'] = _errorSql;
						}
					}
				}
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}//Termina eliminarImagenCortado

	// --------------- DESTACADOS -------------------	
	//Configuración dataTable cargarDestacados
	if($_POST['tipo'] == 'formCargarDestacados'){
		if(validarLogueado($_conection)){
			$variables = $_POST['variables'];
			
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Imagen';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = null;

			$resultShow = mysqli_query("SHOW COLUMNS FROM ".$tabla." LIKE '".$prefijo."idi_id'");
			$exists = (mysql_num_rows($resultShow))?true:false;
			if ($exists) {
				$toIdioma = " AND ".$prefijo."idi_id=".$_SESSION[_sessionIdioma]." ";
			}

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."destacado=1 ".$toIdioma." ORDER BY ".$prefijo."posicion_destacado ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion_destacado=%s WHERE ".$prefijo."destacado=1 ".$toIdioma." AND ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."destacado=1 ".$toIdioma." ORDER BY ".$prefijo."posicion_destacado ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;
		
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$nombre = utf8_encode($row_sql[$prefijo.$_POST["variableNombre"]]);
				$descripcion = utf8_encode($row_sql[$prefijo.$_POST["variableDescripcion"]]);
				$visitas = utf8_encode($row_sql[$prefijo."visitas"]);
				$posicion_destacado = utf8_encode($row_sql[$prefijo."posicion_destacado"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="70" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}

				//Acciones
				$acciones = '<a href="javascript:;" data-id-tor="'.$_POST['idSeccion'].'" data-id-equ="'.$id.'" class="btn btn-xs red js-btn-eliminar-equipo margin-bottom-5"><i class="fa fa-trash"></i> Eliminar</a>';
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$result['rows']['id'][$i][] = $id;
				$result['rows']['tbody'][$i][] = $posicion_destacado;
				$result['rows']['tbody'][$i][] = $imagen;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion;
				$i++;
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina de configurar tabla Destacados

	//Cambiar Posicion Destacado
	if($_POST['extra']['tipo'] == 'cambiarPosicionDestacado'){
		if (validarLogueado($_conection)) {
			$tabTipo = utf8_decode($_POST['extra']['variables']['dbTipo']);
			$tabNombre = utf8_decode($_POST['extra']['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['extra']['variables']['dbPrefijo']);
			$tabId = utf8_decode($_POST['extra']['idSeccion']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';
			$posicion = $tabPrefijo.'posicion_destacado';
			
			$resultShow = mysqli_query("SHOW COLUMNS FROM ".$nombreTabla." LIKE '".$tabPrefijo."idi_id'");
			$exists = (mysql_num_rows($resultShow))?true:false;
			if ($exists) {
				$toIdioma = " AND ".$tabPrefijo."idi_id=".$_SESSION[_sessionIdioma]." ";
			}

			$id           = $_POST['id'];
			$fromPosition = is_array($_POST['fromPosition']) ? $_POST['fromPosition'][0] : $_POST['fromPosition'];
			$toPosition   = $_POST['toPosition'];
			$direction    = $_POST['direction'];
			$aPosition    = ($direction === "back") ? $toPosition+1 : $toPosition-1;
 
			$sql = mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion=0 WHERE $whereEqu $posicion='".$toPosition."' $toIdioma");
			mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion=$toPosition WHERE $whereEqu $idTabla='".$id."' $toIdioma");
	 
			if($direction === "back") {
				mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion = $posicion + 1 WHERE $whereEqu ($toPosition <= $posicion AND $posicion <= $fromPosition) and $idTabla != $id and $posicion != 0 $toIdioma ORDER BY $posicion DESC;");
			} // backward direction
	  
			if($direction === "forward") {    
				mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion = $posicion - 1 WHERE $whereEqu ($fromPosition <= $posicion AND $posicion <= $toPosition) and $idTabla != $id and $posicion != 0 $toIdioma ORDER BY $posicion ASC;");
			} // Forward Direction

			mysqli_query($_conection->connect(), "UPDATE $nombreTabla SET $posicion = $aPosition WHERE $whereEqu $posicion = 0 $toIdioma ;");
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina cambiarPosicionDestacado

	// --------------- SEO -------------------
	if ($_POST['tipo'] == 'cargarSEO') {
		if (validarLogueado($_conection)) {
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables = $_POST['variables'];

			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			//Revisamos si se permite el SEO
			if($variables['SEO']['permitir'] == 1){
				//Tabla donde buscaremos el Title y la Descripción del SEO
				$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
					GetSQLValueString($id,"int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				$row_seccion = mysqli_fetch_assoc($rs_sql);

				//Armamos el Snippet
				$sql = sprintf("SELECT * FROM g_tbl_pagina WHERE pag_idi_id=%s",
					GetSQLValueString($_SESSION[_sessionIdioma], "int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				if ($rs_sql) { $row_sql = mysqli_fetch_assoc($rs_sql); }

				$title = $row_seccion[$prefijo.$variables['SEO']['title']];
				$psc = mostrarPosicionamiento('', $variables, $id, $_conection);
				if ($psc['psc_titulo']) 
					$titleSnippet = utf8_decode($psc['psc_titulo']);
				else
					$titleSnippet = $title . ' - ' . $row_sql['pag_titulo'];

				if ($psc['psc_descripcion'])
					$descripcionSnippet = utf8_decode($psc['psc_descripcion']);
				else
					$descripcionSnippet = substr(strip_tags($row_seccion[$prefijo.$variables['SEO']['contenido']]), 0, 156);

				$url = '/'.CamellizarConGuiones(utf8_encode($title));
				$result["title"] = utf8_encode($title . ' - ' . $row_sql['pag_titulo']);
				$result["titlepage"] = ' - ' . utf8_encode($row_sql['pag_titulo']);
				$result["descripcion"] = utf8_encode(substr(strip_tags($row_seccion[$prefijo.$variables['SEO']['contenido']]), 0, 156));

				$titleSnippet = sprintf('<a class="title">%s</a>', $titleSnippet);
				$url = sprintf('<span class="url">%s</span>', $url);
				$descripcionSnippet = sprintf('<p class="desc">%s</p>', $descripcionSnippet);

				$result["snippet"] = utf8_encode($titleSnippet.$url.$descripcionSnippet);

				//Armamos los resultados de la palabra focuskeyword
				if ($psc['psc_focuskeyword']) {
					$job['pageUrl'] = $url;
					$job['pageSlug'] = $url;
					$job['title'] = $titleSnippet;
					$job['keyword'] = $psc['psc_focuskeyword'];
					$job['keyword_folded'] = strip_separators_and_fold( $job['keyword'] );

					//keyword
					score_keyword( $job['keyword'] , $results );

					//title
					score_title( $job, $results );

					//metadescripcion
					score_description( $job, $results, $descripcionSnippet, 155 );

					//body
					$body   = get_body( $row_seccion[$prefijo.$variables['SEO']['contenido']] );
					$firstp = get_first_paragraph( $body );
					score_body( $job, $results, $body, $firstp );

					//url
					score_url( $job, $results );

					//Extraer imágenes
					$tabTipo = '';
					$img_principal = 'ambas';
					$variablesExtras['datatable'] = true;
					$imagenes = extraerImagenes($_conection, $variables['dbNombre'], $tabTipo, $id, $img_principal,'',$variablesExtras);
					$imgs['alts'] = array();
					$imgs['count'] = 0;
					foreach ($imagenes as $key => $imagen) {
						$imgs['count']++;
						$imgs['alts'][] = functionNombreImagen($imagen);
					}
					score_images_alt_text( $job, $results, $imgs );

					aasort( $results, 'val' );

					if ( is_array( $results ) && $results !== array() ) {
						$output     = '<table class="wpseoanalysis">';
						//$perc_score = absint( $results['total'] );
						//unset( $results['total'] ); // Unset to prevent echoing it.

						foreach ( $results as $result2 ) {
							if ( is_array( $result2 ) ) {
								$score = translate_score( $result2['val'] );
								$output .= '<tr><td class="score"><div class="wpseo-score-icon '.$score.'"></div></td><td>' . $result2['msg'] . '</td></tr>';
							}
						}
						//unset( $result, $score );
						$output .= '</table>';

						// if ( WP_DEBUG === true || ( defined( 'WPSEO_DEBUG' ) && WPSEO_DEBUG === true ) ) {
							// $output .= '<p><small>(' . $perc_score . '%)</small></p>';
						// }
					}

					$result["results"] = '
							<h4><b>Análisis de página</b></h4>
							<div class="note note-warning">
								<p>
									Para actualizar el análisis de la página, guarde este ó actualice esta pestaña de nuevo.
								</p>
							</div>
							'.$output;
				}else{
					$result["results"] = '<div class="note note-warning">
								<h4 class="block">Advertencia! Palabra/Frase clave principal vacía</h4>
								<p>
									 No se ha establecido una palabra/frase clave en la que enfocarse para esta sección. Si no establece una palabra clave foco, no se podrá calcular puntuación.
								</p>
							</div>';
				}
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

	if ($_REQUEST['tipo'] == 'focuskeyword') {
		if (validarLogueado($_conection)) {
			$query = $_REQUEST["query"];

			$results = array();
			$resultado = file_get_contents( 'https://www.google.com/complete/search?output=toolbar&q=' . urlencode($query));
			preg_match_all( '`suggestion data="([^"]+)"/>`u', $resultado, $matches );

			if ( isset( $matches[1] ) && ( is_array( $matches[1] ) && $matches[1] !== array() ) ) {
				foreach ( $matches[1] as $match ) {
					$results[] = array('value' => html_entity_decode( $match, ENT_COMPAT, 'UTF-8' ));
				}
			}
			echo json_encode($results);
			exit();
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

	//FUNCION DUPLICAR
	//INDIVIDUAL O GRUPAL
	if ( $_POST["tipo"] == 'duplicarItemIndividual' ) {
		if(validarLogueado($_conection)){
			$result['error'] = $result["success"] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);
			$arrayDatosDuplicar = utf8_decode($_POST['variables']['arrayDatosDuplicar']['carpetasExtra']);

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			//Si no existe registro del que queremos duplicar, lo creamos
			$sql =  sprintf("SELECT * FROM ".$tabNombre." WHERE ".$tabPrefijo."id=%s",
				GetSQLValueString($_SESSION[_sessionIdioma], "int")
			);
			$rs_sql = mysqli_query($sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if (!$row_sql[$tabPrefijo."id"]) {
				mysqli_query("INSERT INTO tbl_".$tabNombre." (".$tabPrefijo."id, ".$tabPrefijo."idi_id) VALUES (".$_SESSION[_sessionIdioma].", ".$_SESSION[_sessionIdioma].") ");
			}


			$arrayDatos["tipo"] = 'individual';
			$arrayDatos["idBuscar"] = $_SESSION[_sessionIdioma];
			$arrayDatos["idIdiomaDuplicar"] = $_POST['idIdioma'];
			$arrayDatos["nombreTabla"] = $nombreTabla;
			$arrayDatos["dbNombre"] = $tabNombre;
			$arrayDatos["dbPrefijo"] = $tabPrefijo;
			$arrayDatos["duplicarCarpetas"] = true;
			$arrayDatos["nombreCarpetas"][] = $tabNombre;
			foreach ($arrayDatosDuplicar as $key => $carpetaExtras) {
				$arrayDatos["nombreCarpetas"][] = $carpetaExtras;
			}
			$arrayDatos["nombreTablasDuplicar"] = array(
													array('tipo' => 'g_', 'nombre' => 'imagenes', 'prefijo' => 'img_' ),
													array('tipo' => 'g_', 'nombre' => 'videos', 'prefijo' => 'vid_' ),
													array('tipo' => 'g_', 'nombre' => 'archivos', 'prefijo' => 'arc_'),
													array('tipo' => 'g_', 'nombre' => 'audios', 'prefijo' => 'aud_' )
												  );
			$result = duplicarItem($arrayDatos);
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

	function recorrerTablasInternas($arrayTablasInternos, $arrayDatosTablasDuplicar){
		foreach ($arrayTablasInternos as $key => $arrayTabla) {

			$arrayDatos["tipo"] = '';
			$arrayDatos["idBuscar"] = $arrayDatosTablasDuplicar['idDuplicar'];
			$arrayDatos["idIdiomaDuplicar"] = $_POST['idIdioma'];
			$arrayDatos["nombreTabla"] = $nombreTabla;
			$arrayDatos["dbNombre"] = $tabNombre;
			$arrayDatos["dbPrefijo"] = $tabPrefijo;
			$arrayDatos["duplicarCarpetas"] = true;
			$arrayDatos["nombreCarpetas"][] = $tabNombre;
			foreach ($arrayDatosDuplicar as $key => $carpetaExtras) {
				$arrayDatos["nombreCarpetas"][] = $carpetaExtras;
			}


			$arrayDatosTablasDuplicar['idDuplicar'] = $itemIndividual;
			$arrayDatosTablasDuplicar['idCategoria'] = $result["id"];

			recorrerTablasInternas($arrayTablasInternos,$arrayDatosTablasDuplicar);
		}
	}

	if ( $_POST["tipo"] == 'duplicarItemGrupal' ) {
		if(validarLogueado($_conection)){
			$result['error'] = $result["success"] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);
			$arrayDatosDuplicar = $_POST['variables']['arrayDatosDuplicar'][0]['carpetasExtra'];

			$arregloItems =$_POST['arregloItems'];

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			$arrayTablasInternos = $_POST['variables']['arrayTablasInternos'];
			
			$arrayDatos["tipo"] = '';
			$arrayDatos["idBuscar"] = $_SESSION[_sessionIdioma];
			$arrayDatos["idIdiomaDuplicar"] = $_POST['idIdioma'];
			$arrayDatos["nombreTabla"] = $nombreTabla;
			$arrayDatos["dbNombre"] = $tabNombre;
			$arrayDatos["dbPrefijo"] = $tabPrefijo;
			$arrayDatos["duplicarCarpetas"] = true;
			$arrayDatos["nombreCarpetas"][] = $tabNombre;
			foreach ($arrayDatosDuplicar as $key => $carpetaExtras) {
				$arrayDatos["nombreCarpetas"][] = $carpetaExtras;
			}
			$arrayDatos["nombreTablasDuplicar"] = array(
													array('tipo' => 'g_', 'nombre' => 'imagenes', 'prefijo' => 'img_' ),
													array('tipo' => 'g_', 'nombre' => 'videos', 'prefijo' => 'vid_' ),
													array('tipo' => 'g_', 'nombre' => 'archivos', 'prefijo' => 'arc_'),
													array('tipo' => 'g_', 'nombre' => 'audios', 'prefijo' => 'aud_' )
												  );
			foreach ($arregloItems as $key => $itemIndividual) {
				$arrayDatos["idBuscar"] = $itemIndividual;
				$result = duplicarItem($arrayDatos);

				//Adicional
				//$arrayDatosTablasDuplicar['idDuplicar'] = $itemIndividual;
				//$arrayDatosTablasDuplicar['idCategoria'] = $result["id"];
				//$arrayDatosTablasDuplicar['nombreTablasDuplicar'] = $arrayDatos["nombreTablasDuplicar"];
				//recorrerTablasInternas($arrayTablasInternos,$arrayDatosTablasDuplicar);
			}

		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	
	//Duplicar solo imágenes...
	if ( $_POST["tipo"] == 'duplicarItemIndividualImage' ) {
		if(validarLogueado($_conection)){
			$result['error'] = $result["success"] = '';

			$tabTipo = utf8_decode($_POST['variables']['dbTipo']);
			$tabNombre = utf8_decode($_POST['variables']['dbNombre']);
			$tabPrefijo = utf8_decode($_POST['variables']['dbPrefijo']);
			$arrayDatosDuplicar = utf8_decode($_POST['variables']['arrayDatosDuplicar']['carpetasExtra']);

			$arregloItems =$_POST['arregloItems'];

			$nombreTabla = $tabTipo.'tbl_'.$tabNombre;
			$idTabla = $tabPrefijo.'id';

			$arrayDatos["tipo"] = 'individual';
			$arrayDatos["idBuscar"] = $_SESSION[_sessionIdioma];
			$arrayDatos["idIdiomaDuplicar"] = $_POST['idIdioma'];
			$arrayDatos["nombreTabla"] = 'g_tbl_imagenes';
			$arrayDatos["dbNombre"] = $tabNombre;
			$arrayDatos["dbPrefijo"] = 'img_';
			$arrayDatos["nombreCarpeta"] = $tabNombre;
			$arrayDatos["tipoTabla"] = true;
			foreach ($arregloItems as $key => $itemIndividual) {
				$arrayDatos["idBuscar"] = $itemIndividual;
				$result = duplicarItemImage($arrayDatos);
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

}
	//Devolvemos un arreglo con los datos
	$response->result = $result;
	echo json_encode($response);
	//Cerramos conección con la Base de Datos
	$_conection->desconnect();
?>