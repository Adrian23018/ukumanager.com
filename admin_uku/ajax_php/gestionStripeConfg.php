<?php
session_start();

//Configuracion
require '../includes/autoloader.php';
$conexion = $_conection->connect();

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if($_POST['tipo'] == 'formTraerProgress') {
		
		if(validarLogueado($_conection)){
			$result['progress'] = '';
			$id = (int)$_POST["idSeccion"];

			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
				GetSQLValueString($id,"int")
			);
			$rs_sql = mysqli_query($conexion, $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			// Porcentaje por pestañas
			$progressPestanas = 1;
			$progressPestanasArray = array(
										'general' => 2
									);
			$progressCadaItem = 100/$progressPestanas;
			if(isset($progressPestanasArray['general'])){
				$totalGeneral = 0;
				if ($row_sql[$prefijo."apikey_test"])
					$totalGeneral++;
				if ($row_sql[$prefijo."apikey_live"])
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
			$rs_sql = mysqli_query($conexion, $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			$result[$nombreCampos."-apikey_test"] = utf8_encode($row_sql[$prefijo.'apikey_test']);
			$result[$nombreCampos."-apikey_live"] = utf8_encode($row_sql[$prefijo.'apikey_live']);
			
			$psc = mostrarPosicionamiento('', $variables, $id, $_conection);
			$result['psc_titulo'] = $psc['psc_titulo'];
			$result['psc_tags'] = $psc['psc_tags'];
			$result['psc_descripcion'] = $psc['psc_descripcion'];

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

	if($_POST['tipo'] == 'formEditarStripeConfg'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$data_sc_apikey_test = utf8_decode($data[$nombreCampos."-apikey_test"]);
			$data_sc_apikey_live = utf8_decode($data[$nombreCampos."-apikey_live"]);

			$check = 0;
			if ($data["check-test"] == "on") {
				$check = 1;
			}

			//Definimos variables a devolver
			$result['id'] = '';

			$result["success"]["btn-editar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
				GetSQLValueString($id, "int")
			);
			$rs_sql = mysqli_query($conexion, $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			if ($error == 0) {
				if (!$row_sql[$prefijo."id"]) {
					$sql = sprintf("	INSERT INTO ".$tabla." 
							(
								".$prefijo."id, 
								".$prefijo."test,
								".$prefijo."apikey_test,
								".$prefijo."apikey_live
							) VALUES (%s,%s,%s,%s)",
							GetSQLValueString(1,"int"),
							GetSQLValueString($check,"int"),
							GetSQLValueString($data_sc_apikey_test,"text"),
							GetSQLValueString($data_sc_apikey_live,"text")
						);
				}else{
					$sql = sprintf("	UPDATE ".$tabla." 
											SET
												".$prefijo."test=%s,
												".$prefijo."apikey_test=%s,
												".$prefijo."apikey_live=%s
											WHERE 
												".$prefijo."id=%s",
							GetSQLValueString($check,"int"),
							GetSQLValueString($data_sc_apikey_test,"text"),
							GetSQLValueString($data_sc_apikey_live,"text"),
							GetSQLValueString(1,"int")
					);
				}

				//echo $sql;
				$rs_sql = mysqli_query($conexion, $sql);
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