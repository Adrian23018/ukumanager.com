<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

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
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			// Porcentaje por pestañas
			$progressPestanas = 1;
			$progressPestanasArray = array(
										'general' => 7
									);
			$progressCadaItem = 100/$progressPestanas;
			if(isset($progressPestanasArray['general'])){
				$totalGeneral = 0;
				if ($row_sql[$prefijo."semanas"])
					$totalGeneral++;
				if ($row_sql[$prefijo."horas"])
					$totalGeneral++;
				if ($row_sql[$prefijo."diadomingo"])
					$totalGeneral++;
				if ($row_sql[$prefijo."diaferiado"])
					$totalGeneral++;
				if ($row_sql[$prefijo."vc_ss"])
					$totalGeneral++;
				if ($row_sql[$prefijo."vc_se"])
					$totalGeneral++;
				if ($row_sql[$prefijo."xiii_ss"])
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

			$result[$nombreCampos."-semanas"] = utf8_encode($row_sql[$prefijo.'semanas']);
			$result[$nombreCampos."-horas"] = utf8_encode($row_sql[$prefijo.'horas']);
			$result[$nombreCampos."-diadomingo"] = utf8_encode($row_sql[$prefijo.'diadomingo']);
			$result[$nombreCampos."-diaferiado"] = utf8_encode($row_sql[$prefijo.'diaferiado']);
			$result[$nombreCampos."-vc_ss"] = utf8_encode($row_sql[$prefijo.'vc_ss']);
			$result[$nombreCampos."-vc_se"] = utf8_encode($row_sql[$prefijo.'vc_se']);
			$result[$nombreCampos."-xiii_ss"] = utf8_encode($row_sql[$prefijo.'xiii_ss']);
			
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

	if($_POST['tipo'] == 'formEditarVariablesPanama'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataSemanas = utf8_decode($data[$nombreCampos."-semanas"]);
			$dataHoras = utf8_decode($data[$nombreCampos."-horas"]);
			$dataDiadomingo = utf8_decode($data[$nombreCampos."-diadomingo"]);
			$dataDiaferiado = utf8_decode($data[$nombreCampos."-diaferiado"]);
			$dataVc_ss = utf8_decode($data[$nombreCampos."-vc_ss"]);
			$dataVc_se = utf8_decode($data[$nombreCampos."-vc_se"]);
			$dataXiii_ss = utf8_decode($data[$nombreCampos."-xiii_ss"]);

			//Definimos variables a devolver
			$result['id'] = '';

			$result["success"]["btn-editar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos

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
								".$prefijo."semanas,
								".$prefijo."horas,
								".$prefijo."diadomingo,
								".$prefijo."diaferiado,
								".$prefijo."vc_ss,
								".$prefijo."vc_se,
								".$prefijo."xiii_ss
							) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)",
							GetSQLValueString($id,"int"),
							GetSQLValueString($_SESSION[_sessionIdioma],"int"),
							GetSQLValueString($dataSemanas,"text"),
							GetSQLValueString($dataHoras,"text"),
							GetSQLValueString($dataDiadomingo,"text"),
							GetSQLValueString($dataDiaferiado,"text"),
							GetSQLValueString($dataVc_ss,"text"),
							GetSQLValueString($dataVc_se,"text"),
							GetSQLValueString($dataXiii_ss,"text")
						);
				}else{
					$sql = sprintf("	UPDATE ".$tabla." 
											SET
												".$prefijo."semanas=%s,
												".$prefijo."horas=%s,
												".$prefijo."diadomingo=%s,
												".$prefijo."diaferiado=%s,
												".$prefijo."vc_ss=%s,
												".$prefijo."vc_se=%s,
												".$prefijo."xiii_ss=%s
											WHERE 
												".$prefijo."id=%s",
							GetSQLValueString($dataSemanas,"text"),
							GetSQLValueString($dataHoras,"text"),
							GetSQLValueString($dataDiadomingo,"text"),
							GetSQLValueString($dataDiaferiado,"text"),
							GetSQLValueString($dataVc_ss,"text"),
							GetSQLValueString($dataVc_se,"text"),
							GetSQLValueString($dataXiii_ss,"text"),
							GetSQLValueString($id,"int")
					);
				}
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