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
			$progressPestanas = 4;
			$progressPestanasArray = array(
										'formulario_contacto' => 2,
										'formulario_contacto_en' => 1
									);
			$TotalPorcentaje = $porcentajeGeneral = $porcentajeGeneral_en = $porcentajeFormulario = $porcentajeFormulario_en = 0;

			if(isset($progressPestanasArray['formulario_contacto'])){
				$totalFormulario = 0;
				if ($row_sql[$prefijo."formulario"])
					$totalFormulario++;		
				if ($row_sql[$prefijo."correos"])
					$totalFormulario++;
				$porcentajeFormulario = ($totalFormulario/$progressPestanasArray['formulario_contacto']) * 100;
				$TotalPorcentaje += ($porcentajeFormulario * $progressCadaItem) / 100;
				$result['progress']['formulario_contacto'] = $porcentajeFormulario;
			}

			if(isset($progressPestanasArray['formulario_contacto_en'])){
				$totalFormulario_en = 0;
				if ($row_sql[$prefijo."formulario_en"])
					$totalFormulario_en++;
				$porcentajeFormulario_en = ($totalFormulario_en/$progressPestanasArray['formulario_contacto_en']) * 100;
				$TotalPorcentaje += ($porcentajeFormulario_en * $progressCadaItem) / 100;
				$result['progress']['formulario_contacto_en'] = $porcentajeFormulario_en;
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

			$result[$nombreCampos."-correos"] = utf8_encode($row_sql[$prefijo.'correos']);
			$result[$nombreCampos."-formulario"] = utf8_encode($row_sql[$prefijo.'formulario']);
			$result[$nombreCampos."-formulario_en"] = utf8_encode($row_sql[$prefijo.'formulario_en']);
				
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

	if($_POST['tipo'] == 'formEditarContactenosInformacion'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataCorreos	= utf8_decode($data[$nombreCampos."-correos"]);
			$dataFormulario	= utf8_decode($data[$nombreCampos."-formulario"]);
			$dataFormulario_en	= utf8_decode($data[$nombreCampos."-formulario_en"]);

			$latitud = utf8_decode($data["latitud"]);
			$longitud = utf8_decode($data["longitud"]);
			$zoom = utf8_decode($data["zoom"]);
			$mapa =  $latitud . "," . $longitud . "(d)" . $latitud . "," . $longitud . "(d)" . $latitud . "," . $longitud . "(d)" . $zoom;

			//Definimos variables a devolver
			$result['id'] = '';

			$result["error"][$nombreCampos."-correos"] = '';
			$result["success"]["btn-editar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos
			if($dataCorreos == ""){
				$result["error"][$nombreCampos."-correos"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			//Correos separados por "," y validados
			$dataCorreos = correosPHPMAILER($dataCorreos);

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
								".$prefijo."correos,
								".$prefijo."formulario,
								".$prefijo."formulario_en,
								".$prefijo."mapa
							) VALUES (%s,%s,%s,%s,%s,%s)",
							GetSQLValueString($id,"int"),
							GetSQLValueString($_SESSION[_sessionIdioma],"int"),
							GetSQLValueString($dataCorreos,"text"),
							GetSQLValueString($dataFormulario,"text"),
							GetSQLValueString($dataFormulario_en,"text"),
							GetSQLValueString($mapa,"text")
						);
				}else{
					$sql = sprintf("	UPDATE ".$tabla." 
											SET
												".$prefijo."correos=%s,
												".$prefijo."formulario=%s,
												".$prefijo."formulario_en=%s,
												".$prefijo."mapa=%s
											WHERE 
												".$prefijo."id=%s",
							GetSQLValueString($dataCorreos,"text"),
							GetSQLValueString($dataFormulario,"text"),
							GetSQLValueString($dataFormulario_en,"text"),
							GetSQLValueString($mapa,"text"),
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