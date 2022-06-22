<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if($_POST['tipo'] == 'formCrearIdioma'){
		
		if(validarLogueado($_conection)){
			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);

			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataNombre				= 	utf8_decode($data[$nombreCampos."-nombre"]);
			$dataLink	= 	utf8_decode($data[$nombreCampos."-link"]);

			//Definimos variables a devolver
			$result['id'] = '';

			$result["error"][$nombreCampos."-nombre"] 			= '';
			$result["error"][$nombreCampos."-fecha"] 			= '';
			$result["error"][$nombreCampos."-descripcion_corta"]= '';
			$result["error"][$nombreCampos."-descripcion"]	 	= '';

			$result["success"]["btn-guardar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos
			if($dataNombre == ""){
				$result["error"][$nombreCampos."-nombre"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			//verificar que usuario no se encuentre en la base de  datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."nombre=%s AND ".$prefijo."idi_id=%s",
				GetSQLValueString($dataNombre ,"text"),
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if ($row_sql[$prefijo."id"]){
				$result["error"][$nombreCampos."-nombre"] =  _cueUsernameRegistrado;
				$result["isOk"] = false;
				$error=1;
			}

			if ($error == 0) {
				$sql = sprintf("	INSERT INTO ".$tabla." 
										(
											".$prefijo."idi_id,
											".$prefijo."nombre,
											".$prefijo."link
										)
										VALUES (%s,%s,%s)",
					GetSQLValueString($_SESSION[_sessionIdioma],"int"),
					GetSQLValueString($dataNombre,"text"),
					GetSQLValueString($dataLink, "text")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				if ($rs_sql) {
					//Guardado
					$result["success"]["btn-guardar-".$nombreCampos] = _informacionGuardada;

					//Capturamos el último id ingresado
					$id = mysql_insert_id();

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

					//Devolvemos Id
					$result['id'] = $id;
					$result['link'] = 'inicio.php?page='.$variables['nombreSeccion3'].'&id='.$id;
				}else{
					//Error sql
					$result["isOk"] = false;
					$result["error"]["btn-guardar-".$nombreCampos] = _errorSql;
				}
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

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
			$progressPestanas = 2;
			$progressPestanasArray = array(
										'general' => 2,
										'imagenes' => 1
									);
			$progressCadaItem = 100/$progressPestanas;
			if(isset($progressPestanasArray['general'])){
				$totalGeneral = 0;
				if ($row_sql[$prefijo."nombre"])
					$totalGeneral++;
				if ($row_sql[$prefijo."link"])
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
			$result[$nombreCampos."-link"] = utf8_encode($row_sql[$prefijo.'link']);

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

		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}//

	if($_POST['tipo'] == 'formEditarIdioma'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataNombre				= 	utf8_decode($data[$nombreCampos."-nombre"]);
			$dataLink				= 	utf8_decode($data[$nombreCampos."-link"]);

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
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."nombre=%s AND ".$prefijo."idi_id=%s AND ".$prefijo."id!=%s",
				GetSQLValueString($dataNombre ,"text"),
				GetSQLValueString($_SESSION[_sessionIdioma],"int"),
				GetSQLValueString($id ,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if ($row_sql[$prefijo."id"]){
				$result["error"][$nombreCampos."-nombre"] =  _cueUsernameRegistrado;
				$result["isOk"] = false;
				$error=1;
			}

			if ($error == 0) {
				$sql = sprintf("	UPDATE ".$tabla." 
										SET
											".$prefijo."nombre=%s,
											".$prefijo."link=%s
										WHERE 
											".$prefijo."id=%s",
					GetSQLValueString($dataNombre,"text"),
					GetSQLValueString($dataLink, "text"),
					GetSQLValueString($id ,"int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
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