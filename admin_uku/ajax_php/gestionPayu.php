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
										'general' => 10
									);
			$progressCadaItem = 100/$progressPestanas;
			if(isset($progressPestanasArray['general'])){
				$totalGeneral = 0;
				if ($row_sql[$prefijo."test_apikey"])
					$totalGeneral++;
				if ($row_sql[$prefijo."test_apilogin"])
					$totalGeneral++;
				if ($row_sql[$prefijo."test_accountid"])
					$totalGeneral++;
				if ($row_sql[$prefijo."test_idcomercio"])
					$totalGeneral++;
				// if ($row_sql[$prefijo."test_currency"])
				// 	$totalGeneral++;
				if ($row_sql[$prefijo."test_url"])
					$totalGeneral++;
				if ($row_sql[$prefijo."apikey"])
					$totalGeneral++;
				if ($row_sql[$prefijo."apilogin"])
					$totalGeneral++;
				if ($row_sql[$prefijo."accountid"])
					$totalGeneral++;
				if ($row_sql[$prefijo."idcomercio"])
					$totalGeneral++;
				// if ($row_sql[$prefijo."currency"])
				// 	$totalGeneral++;
				if ($row_sql[$prefijo."url"])
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

			$result[$nombreCampos."-test_apikey"] = utf8_encode($row_sql[$prefijo.'test_apikey']);
			$result[$nombreCampos."-test_apilogin"] = utf8_encode($row_sql[$prefijo.'test_apilogin']);
			$result[$nombreCampos."-test_accountid"] = utf8_encode($row_sql[$prefijo.'test_accountid']);
			$result[$nombreCampos."-test_idcomercio"] = utf8_encode($row_sql[$prefijo.'test_idcomercio']);
			$result[$nombreCampos."-test_currency"] = utf8_encode($row_sql[$prefijo.'test_currency']);
			$result[$nombreCampos."-test_url"] = utf8_encode($row_sql[$prefijo.'test_url']);
			$result[$nombreCampos."-apikey"] = utf8_encode($row_sql[$prefijo.'apikey']);
			$result[$nombreCampos."-apilogin"] = utf8_encode($row_sql[$prefijo.'apilogin']);
			$result[$nombreCampos."-accountid"] = utf8_encode($row_sql[$prefijo.'accountid']);
			$result[$nombreCampos."-idcomercio"] = utf8_encode($row_sql[$prefijo.'idcomercio']);
			$result[$nombreCampos."-currency"] = utf8_encode($row_sql[$prefijo.'currency']);
			$result[$nombreCampos."-url"] = utf8_encode($row_sql[$prefijo.'url']);
			
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

	if($_POST['tipo'] == 'formEditarPayu'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$data_py_test_apikey = utf8_decode($data[$nombreCampos."-test_apikey"]);
			$data_py_test_apilogin = utf8_decode($data[$nombreCampos."-test_apilogin"]);
			$data_py_test_accountid = utf8_decode($data[$nombreCampos."-test_accountid"]);
			$data_py_test_idcomercio = utf8_decode($data[$nombreCampos."-test_idcomercio"]);
			$data_py_test_currency = utf8_decode($data[$nombreCampos."-test_currency"]);
			$data_py_test_url = utf8_decode($data[$nombreCampos."-test_url"]);
			$data_py_apikey = utf8_decode($data[$nombreCampos."-apikey"]);
			$data_py_apilogin = utf8_decode($data[$nombreCampos."-apilogin"]);
			$data_py_accountid = utf8_decode($data[$nombreCampos."-accountid"]);
			$data_py_idcomercio = utf8_decode($data[$nombreCampos."-idcomercio"]);
			$data_py_currency = utf8_decode($data[$nombreCampos."-currency"]);
			$data_py_url = utf8_decode($data[$nombreCampos."-url"]);

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
								".$prefijo."test_apikey,
								".$prefijo."test_apilogin,
								".$prefijo."test_accountid,
								".$prefijo."test_idcomercio,
								".$prefijo."test_currency,
								".$prefijo."test_url,
								".$prefijo."apikey,
								".$prefijo."apilogin,
								".$prefijo."accountid,
								".$prefijo."idcomercio,
								".$prefijo."currency,
								".$prefijo."url
							) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
							GetSQLValueString(1,"int"),
							GetSQLValueString($check,"int"),
							GetSQLValueString($data_py_test_apikey,"text"),
							GetSQLValueString($data_py_test_apilogin,"text"),
							GetSQLValueString($data_py_test_accountid,"text"),
							GetSQLValueString($data_py_test_idcomercio,"text"),
							GetSQLValueString($data_py_test_currency,"text"),
							GetSQLValueString($data_py_test_url,"text"),
							GetSQLValueString($data_py_apikey,"text"),
							GetSQLValueString($data_py_apilogin,"text"),
							GetSQLValueString($data_py_accountid,"text"),
							GetSQLValueString($data_py_idcomercio,"text"),
							GetSQLValueString($data_py_currency,"text"),
							GetSQLValueString($data_py_url,"text")
						);
				}else{
					$sql = sprintf("	UPDATE ".$tabla." 
											SET
												".$prefijo."test=%s,
												".$prefijo."test_apikey=%s,
												".$prefijo."test_apilogin=%s,
												".$prefijo."test_accountid=%s,
												".$prefijo."test_idcomercio=%s,
												".$prefijo."test_currency=%s,
												".$prefijo."test_url=%s,
												".$prefijo."apikey=%s,
												".$prefijo."apilogin=%s,
												".$prefijo."accountid=%s,
												".$prefijo."idcomercio=%s,
												".$prefijo."currency=%s,
												".$prefijo."url=%s
											WHERE 
												".$prefijo."id=%s",
							GetSQLValueString($check,"int"),
							GetSQLValueString($data_py_test_apikey,"text"),
							GetSQLValueString($data_py_test_apilogin,"text"),
							GetSQLValueString($data_py_test_accountid,"text"),
							GetSQLValueString($data_py_test_idcomercio,"text"),
							GetSQLValueString($data_py_test_currency,"text"),
							GetSQLValueString($data_py_test_url,"text"),
							GetSQLValueString($data_py_apikey,"text"),
							GetSQLValueString($data_py_apilogin,"text"),
							GetSQLValueString($data_py_accountid,"text"),
							GetSQLValueString($data_py_idcomercio,"text"),
							GetSQLValueString($data_py_currency,"text"),
							GetSQLValueString($data_py_url,"text"),
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