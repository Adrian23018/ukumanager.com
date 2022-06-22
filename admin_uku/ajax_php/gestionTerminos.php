<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if($_POST['tipo'] == 'formTraerProgress') {
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
				GetSQLValueString($id,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			// Porcentaje por pestañas
			$progressPestanas = 1;
			$progressPestanasArray = array(
										'general' => 2
									);
			$progressCadaItem = 100/$progressPestanas;
			if(isset($progressPestanasArray['general'])){
				$totalGeneral = 0;
				if ($row_sql[$prefijo."nombre"])
					$totalGeneral++;
				//strip_tags para no contar las etiquetas como texto
				if (strip_tags($row_sql[$prefijo."descripcion"], '<img>'))
					$totalGeneral++;
				$result['progress']['general'] = ($totalGeneral/$progressPestanasArray['general']) * 100;
			}

			$result['progress']['otros'] = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

	if($_POST['tipo'] == 'formTraerDatos') {
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
				GetSQLValueString($id,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			$result[$nombreCampos."-nombre"] = utf8_encode($row_sql[$prefijo.'nombre']);
			$result[$nombreCampos."-descripcion_corta"] = utf8_encode($row_sql[$prefijo.'descripcion_corta']);
			$result[$nombreCampos."-descripcion"] = utf8_encode($row_sql[$prefijo.'descripcion']);
			$result[$nombreCampos."-mostrar"] = utf8_encode($row_sql[$prefijo.'mostrar']);
			$result[$nombreCampos."-fecha"] = cambiar_format_mostrar(utf8_encode($row_sql[$prefijo.'fecha']));

			$psc = mostrarPosicionamiento('', $variables, $id, $_conection);
			$result['psc_titulo'] = $psc['psc_titulo'];
			$result['psc_tags'] = $psc['psc_tags'];
			$result['psc_descripcion'] = $psc['psc_descripcion'];
			$result['psc_focuskeyword'] = $psc['psc_focuskeyword'];

			$audios = mostrarAudios('', $variables, $id, $_conection);
			$result['audios'] = $audios;

			$videos = mostrarVideos('', $variables, $id, $_conection);
			$result['videos'] = $videos;

			list($txtbanner, $txtbannerfuente) = mostrarTxtbanner('', $variables, $id, $_conection);
			$result['txtbanner'] = $txtbanner;
			$result['txtbannerfuente'] = $txtbannerfuente;

			list($txtbanner2campos, $txtbanner2camposdescripcion, $txtbanner2camposfuente) = mostrarTxtbanner2campos('', $variables, $id, $_conection);
			$result['txtbanner2campos'] = $txtbanner2campos;
			$result['txtbanner2camposdescripcion'] = $txtbanner2camposdescripcion;
			$result['txtbanner2camposfuente'] = $txtbanner2camposfuente;

		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}//

	if($_POST['tipo'] == 'formEditarTerminos'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataNombre				= 	utf8_decode($data[$nombreCampos."-nombre"]);
			$dataDescripcion_corta	= 	utf8_decode($data[$nombreCampos."-descripcion_corta"]);
			$dataFecha				=	cambiar_format(utf8_decode($data[$nombreCampos."-fecha"]));
			$dataDescripcion		= 	utf8_decode($data[$nombreCampos."-descripcion2"]);
			$dataMostrar			= 	utf8_decode($data[$nombreCampos."-mostrar"]);

			//Definimos variables a devolver
			$result['id'] = '';

			$result["error"][$nombreCampos."-nombre"] 			= '';
			$result["error"][$nombreCampos."-fecha"] 			= '';
			$result["error"][$nombreCampos."-descripcion_corta"]= '';
			$result["error"][$nombreCampos."-descripcion"]	 	= '';

			$result["success"]["btn-editar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos
			if($dataNombre == ""){
				$result["error"][$nombreCampos."-nombre"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			//verificar que usuario no se encuentre en la base de  datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s AND ".$prefijo."idi_id=%s",
				GetSQLValueString($id, "int"),
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			if ($error == 0) {
				if (!$row_sql[$prefijo."id"]) {
					$sql = sprintf("	INSERT INTO ".$tabla." 
											(
												".$prefijo."id,
												".$prefijo."idi_id,
												".$prefijo."nombre,
												".$prefijo."descripcion,
												".$prefijo."descripcion_corta,
												".$prefijo."mostrar
											)
											VALUES (%s,%s,%s,%s,%s,%s)",
						GetSQLValueString($id,"int"),
						GetSQLValueString($_SESSION[_sessionIdioma],"int"),
						GetSQLValueString($dataNombre,"text"),
						GetSQLValueString($dataDescripcion, "text"),
						GetSQLValueString($dataDescripcion_corta, "text"),
						GetSQLValueString($dataMostrar, "int")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
				} else {
					$sql = sprintf("	UPDATE ".$tabla." 
											SET
												".$prefijo."nombre=%s,
												".$prefijo."descripcion=%s,
												".$prefijo."descripcion_corta=%s,
												".$prefijo."mostrar=%s
											WHERE 
												".$prefijo."id=%s",
						GetSQLValueString($dataNombre,"text"),
						GetSQLValueString($dataDescripcion, "text"),
						GetSQLValueString($dataDescripcion_corta, "text"),
						GetSQLValueString($dataMostrar, "int"),
						GetSQLValueString($id ,"int")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
				}
				if ($rs_sql) {
					//Guardado
					$result["success"]["btn-editar-".$nombreCampos] = _informacionGuardada;

					if($id){
						//Guardamos Posicionamiento
						//../includes/configFunciones.php
						//No se encuentra en ../ajax_php/gestionFuncionesGlobales.php porque allá no se hace ajax
						guardarPosicionamiento($data, $variables, $id, $_conection);
						guardarAudios($data, $variables, $id, $_conection);
						guardarVideos($data, $variables, $id, $_conection);
						guardarTxtbanner($data, $variables, $id, $_conection);
						guardarTxtbanneren($data, $variables, $id, $_conection);
						guardarTxtbanner2campos($data, $variables, $id, $_conection);
						guardarTxtbannercampos($data, $variables, $id, $_conection);
					}
				}else{
					//Error sql
					$result["isOk"] = false;
					$result["error"]["btn-editar-".$nombreCampos] = _errorSql;
				}
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