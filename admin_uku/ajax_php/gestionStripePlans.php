<?php
session_start();

//Configuracion
// ini_set("display_errors", "1");
// error_reporting(E_ALL);
require '../includes/autoloader.php';
$conexion = $_conection->connect();

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if($_POST['tipo'] == 'formCrearStripePlans'){
		
		if(validarLogueado($_conection)){
			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);

			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataMin	= 	utf8_decode($data[$nombreCampos."-min"]);
			$dataMax	= 	utf8_decode($data[$nombreCampos."-max"]);
			$dataName	= 	utf8_decode($data[$nombreCampos."-name"]);
			$dataSlugName	= 	CamellizarConGuiones($data[$nombreCampos."-slug_name"]);
			$dataInterval	= 	utf8_decode($data[$nombreCampos."-interval"]);
			$dataDescription	= 	utf8_decode($data[$nombreCampos."-description"]);
			$dataAmount	= 	utf8_decode($data[$nombreCampos."-amount"]);
			$dataCurrency	= 	utf8_decode($data[$nombreCampos."-currency"]);
			$dataInterval_count	= 	utf8_decode($data[$nombreCampos."-interval_count"]);
			$dataTrial_period_days	= 	utf8_decode($data[$nombreCampos."-trial_period_days"]);

			//Definimos variables a devolver
			$result['id'] = '';

			$result["error"][$nombreCampos."-min"] 			= '';
			$result["error"][$nombreCampos."-max"] 			= '';
			$result["error"][$nombreCampos."-name"]= '';
			$result["error"][$nombreCampos."-slug_name"]	 	= '';
			$result["error"][$nombreCampos."-interval"]	 	= '';
			$result["error"][$nombreCampos."-description"]	 	= '';
			$result["error"][$nombreCampos."-amount"]	 	= '';
			$result["error"][$nombreCampos."-currency"]	 	= '';
			$result["error"][$nombreCampos."-interval_count"]	 	= '';
			$result["error"][$nombreCampos."-trial_period_days"]	 	= '';

			$result["success"]["btn-guardar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos
			if( !$dataSlugName ) {
				$result["error"][$nombreCampos."-slug_name"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			if( !$dataCurrency ) {
				$result["error"][$nombreCampos."-currency"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			$filtered = filter_var($dataMin, FILTER_VALIDATE_INT);
			if( $filtered === false || $dataMin <= 0 ) {
				$result["error"][$nombreCampos."-min"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			$filtered = filter_var($dataMax, FILTER_VALIDATE_INT);
			if( $filtered === false || $dataMax <= 0 ) {
				$result["error"][$nombreCampos."-max"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			$filtered = filter_var($dataAmount, FILTER_VALIDATE_INT);
			if( $filtered === false || $dataAmount <= 0 ) {
				$result["error"][$nombreCampos."-amount"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			$filtered = filter_var($dataInterval_count, FILTER_VALIDATE_INT);
			if ($dataInterval_count) {
				if( $filtered === false || $dataInterval_count <= 0 ) {
					$result["error"][$nombreCampos."-interval_count"] = _campoVacio;
					$result["isOk"] = false;
					$error=1;
				}
			}

			$filtered = filter_var($dataTrial_period_days, FILTER_VALIDATE_INT);
			if ($dataTrial_period_days) {
				if( $filtered === false || $dataTrial_period_days <= 0 ) {
					$result["error"][$nombreCampos."-trial_period_days"] = _campoVacio;
					$result["isOk"] = false;
					$error=1;
				}
			}

			//verificar que usuario no se encuentre en la base de  datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."slug_name=%s",
				GetSQLValueString($dataSlugName ,"text")
			);
			$rs_sql2 = mysqli_query($conexion, $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql2);
			if ($row_sql[$prefijo."id"]){
				$result["error"][$nombreCampos."-slug_name"] =  _cueUsernameRegistrado;
				$result["isOk"] = false;
				$error=1;
			}

			if ($error == 0) {
				// Buscar producto
				$sqlStripe = sprintf("SELECT * FROM 
											tbl_stripe_product 
										WHERE 
											sp_id=1");
				$rs_sqlStripe = mysqli_query($conexion, $sqlStripe);
				$row_sqlStripe = mysqli_fetch_assoc($rs_sqlStripe);

				$data[$nombreCampos."-slug_name"] = CamellizarConGuiones($data[$nombreCampos."-slug_name"]);
				if (!$dataInterval_count) {
					$dataInterval_count = 1;
					$data[$nombreCampos."-interval_count"] = 1;
				}

				if (!$dataTrial_period_days) {
					$dataTrial_period_days = 0;
					$data[$nombreCampos."-trial_period_days"] = 0;
				}

				$sql = sprintf("	INSERT INTO ".$tabla." 
										(
											".$prefijo."stripe_id,
											".$prefijo."sp_id,
											".$prefijo."sp_stripe_id,
											".$prefijo."min,
											".$prefijo."max,
											".$prefijo."name,
											".$prefijo."slug_name,
											".$prefijo."description,
											".$prefijo."amount,
											".$prefijo."interval,
											".$prefijo."currency,
											".$prefijo."interval_count,
											".$prefijo."trial_period_days
										)
										VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
					GetSQLValueString($dataSlugName,"text"),
					GetSQLValueString($row_sqlStripe['sp_id'],"text"),
					GetSQLValueString($row_sqlStripe['sp_stripe_id'],"text"),
					GetSQLValueString($dataMin, "text"),
					GetSQLValueString($dataMax, "text"),
					GetSQLValueString($dataName, "text"),
					GetSQLValueString($dataSlugName, "text"),
					GetSQLValueString($dataDescription, "text"),
					GetSQLValueString($dataAmount, "text"),
					GetSQLValueString($dataInterval, "text"),
					GetSQLValueString($dataCurrency, "text"),
					GetSQLValueString($dataInterval_count, "text"),
					GetSQLValueString($dataTrial_period_days, "text")
				);
				$rs_sql = mysqli_query($conexion, $sql);
				if ($rs_sql) {
					//Guardado
					$result["success"]["btn-guardar-".$nombreCampos] = _informacionGuardada;

					//Capturamos el último id ingresado
					$id = mysqli_insert_id($conexion);
					if($id){

						// STRIPE SAVE PLAN
						$stripe = new ClassIncStripe;
						if ( $row_sqlStripe['sp_stripe_id'] ) {

							$plan = $stripe->createPlan( $row_sqlStripe['sp_stripe_id'], $data, $nombreCampos );

							$plan_id = is_array( $plan ) ? $plan['id'] : $plan->id;
							if ( is_array( $plan ) ) {
								if ( $plan['error'] ) {
									if ($plan['error']['param']) {
										$result["error"][$nombreCampos."-".$plan['error']['param']] = $plan['error']['message'];
										$result["isOk"] = false;
										$error=1;
									}
								}
							}
							$result['plan_id'] = $plan_id;
						}

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
			$rs_sql = mysqli_query($conexion, $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);

			// Porcentaje por pestañas
			$progressPestanas = 1;
			$progressPestanasArray = array(
										'general' => 4
									);
			$progressCadaItem = 100/$progressPestanas;
			if(isset($progressPestanasArray['general'])){
				$totalGeneral = 0;
				if ($row_sql[$prefijo."minimo"])
						$totalGeneral++;
				if ($row_sql[$prefijo."maximo"])
						$totalGeneral++;
				if ($row_sql[$prefijo."mensual"])
						$totalGeneral++;
				if ($row_sql[$prefijo."anual"])
						$totalGeneral++;
				// $result['progress']['general'] = ($totalGeneral/$progressPestanasArray['general']) * 100;
			}

			// $result['progress']['otros'] = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);

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

			$result[$nombreCampos."-min"] = utf8_encode($row_sql[$prefijo.'min']);
			$result[$nombreCampos."-max"] = utf8_encode($row_sql[$prefijo.'max']);
			$result[$nombreCampos."-name"] = utf8_encode($row_sql[$prefijo.'name']);
			$result[$nombreCampos."-slug_name"] = utf8_encode($row_sql[$prefijo.'slug_name']);
			$result[$nombreCampos."-interval"] = utf8_encode($row_sql[$prefijo.'interval']);
			$result[$nombreCampos."-description"] = utf8_encode($row_sql[$prefijo.'description']);
			$result[$nombreCampos."-amount"] = utf8_encode($row_sql[$prefijo.'amount']);
			$result[$nombreCampos."-currency"] = utf8_encode($row_sql[$prefijo.'currency']);
			$result[$nombreCampos."-interval_count"] = utf8_encode($row_sql[$prefijo.'interval_count']);
			$result[$nombreCampos."-trial_period_days"] = utf8_encode($row_sql[$prefijo.'trial_period_days']);

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

	if($_POST['tipo'] == 'formEditarStripePlans'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataMin	= 	utf8_decode($data[$nombreCampos."-min"]);
			$dataMax	= 	utf8_decode($data[$nombreCampos."-max"]);
			$dataName	= 	utf8_decode($data[$nombreCampos."-name"]);
			$dataSlugName	= 	CamellizarConGuiones($data[$nombreCampos."-slug_name"]);
			$dataInterval	= 	utf8_decode($data[$nombreCampos."-interval"]);
			$dataDescription	= 	utf8_decode($data[$nombreCampos."-description"]);
			$dataAmount	= 	utf8_decode($data[$nombreCampos."-amount"]);
			$dataCurrency	= 	utf8_decode($data[$nombreCampos."-currency"]);
			$dataInterval_count	= 	utf8_decode($data[$nombreCampos."-interval_count"]);
			$dataTrial_period_days	= 	utf8_decode($data[$nombreCampos."-trial_period_days"]);

			//Definimos variables a devolver
			$result['id'] = '';

			$result["error"][$nombreCampos."-min"] 			= '';
			$result["error"][$nombreCampos."-max"] 			= '';
			$result["error"][$nombreCampos."-name"]= '';
			$result["error"][$nombreCampos."-slug_name"]	 	= '';
			$result["error"][$nombreCampos."-interval"]	 	= '';
			$result["error"][$nombreCampos."-description"]	 	= '';
			$result["error"][$nombreCampos."-amount"]	 	= '';
			$result["error"][$nombreCampos."-currency"]	 	= '';
			$result["error"][$nombreCampos."-interval_count"]	 	= '';
			$result["error"][$nombreCampos."-trial_period_days"]	 	= '';

			$result["success"]["btn-editar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos
			$filtered = filter_var($dataMin, FILTER_VALIDATE_INT);
			if( $filtered === false || $dataMin <= 0 ) {
				$result["error"][$nombreCampos."-min"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			$filtered = filter_var($dataMax, FILTER_VALIDATE_INT);
			if( $filtered === false || $dataMax <= 0 ) {
				$result["error"][$nombreCampos."-max"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			$filtered = filter_var($dataTrial_period_days, FILTER_VALIDATE_INT);
			if ($dataTrial_period_days) {
				if( $filtered === false || $dataTrial_period_days <= 0 ) {
					$result["error"][$nombreCampos."-trial_period_days"] = _campoVacio;
					$result["isOk"] = false;
					$error=1;
				}
			}

			//verificar que usuario no se encuentre en la base de  datos
			if ($error == 0) {
				if (!$dataInterval_count) {
					$dataInterval_count = 1;
					$data[$nombreCampos."-interval_count"] = 1;
				}

				if (!$dataTrial_period_days) {
					$dataTrial_period_days = 0;
					$data[$nombreCampos."-trial_period_days"] = 0;
				}

				$sqlStripe = sprintf("SELECT * FROM ".$tabla." INNER JOIN tbl_stripe_product ON spl_sp_id=sp_id 
										WHERE 
											".$prefijo."id=%s ",
								GetSQLValueString($id ,"int")
							);
				$rs_sqlStripe = mysqli_query($conexion, $sqlStripe);
				$row_sqlStripe = mysqli_fetch_assoc($rs_sqlStripe);

				$sql = sprintf("	UPDATE ".$tabla." 
										SET
											".$prefijo."min=%s,
											".$prefijo."max=%s,
											".$prefijo."sp_stripe_id=%s,
											".$prefijo."name=%s,
											".$prefijo."description=%s,
											".$prefijo."trial_period_days=%s
										WHERE 
											".$prefijo."id=%s",
					GetSQLValueString($dataMin, "text"),
					GetSQLValueString($dataMax, "text"),
					GetSQLValueString($row_sqlStripe['sp_stripe_id'], "text"),
					GetSQLValueString($dataName, "text"),
					GetSQLValueString($dataDescription, "text"),
					GetSQLValueString($dataTrial_period_days, "text"),
					GetSQLValueString($id ,"int")
				);
				$rs_sql = mysqli_query($conexion, $sql);
				if ($rs_sql) {
					//Guardado
					$result["success"]["btn-editar-".$nombreCampos] = _informacionGuardada;

					// Producto
					// $row_sqlStripe['spl_sp_stripe_id']
					// Plan 
					// $row_sqlStripe['spl_stripe_id']

					// STRIPE SAVE PLAN
					$stripe = new ClassIncStripe;
					$data[$nombreCampos."-slug_name"] = $row_sqlStripe['spl_stripe_id'];

					if ( !$stripe->existProduct($row_sqlStripe['sp_stripe_id']) ) {
						//Error sql
						$result["isOk"] = false;
						$result["error"]["btn-editar-".$nombreCampos] = 'No has creado el producto en Stripe';
					}else{
						// Revisar plan 
						if ( !$stripe->existPlan($row_sqlStripe['spl_stripe_id']) ) {
							// Crear Plan
							$data[$nombreCampos."-interval"] = $row_sqlStripe['spl_interval'];
							$data[$nombreCampos."-amount"] = $row_sqlStripe['spl_amount'];
							$data[$nombreCampos."-currency"] = $row_sqlStripe['spl_currency'];
							$data[$nombreCampos."-interval_count"] = $row_sqlStripe['spl_interval_count'];

							$plan = $stripe->createPlan( $row_sqlStripe['sp_stripe_id'], $data, $nombreCampos );

						}else{
							// Editar Plan
							// $plan = $stripe->deletePlan( $data[$nombreCampos."-slug_name"] );
							// $plan = $stripe->createPlan( $row_sqlStripe['sp_stripe_id'], $data, $nombreCampos );
							$plan = $stripe->updatePlan( $data, $nombreCampos );
						}

						$plan_id = is_array( $plan ) ? $plan['id'] : $plan->id;
						if ( is_array( $plan ) ) {
							if ( $plan['error'] ) {
								if ($plan['error']['param']) {
									$result["error"][$nombreCampos."-".$plan['error']['param']] = $plan['error']['message'];
									$result["isOk"] = false;
									$error=1;
								}
							}
						}
						$result['plan_id'] = $plan_id;
					}



					// if ( $row_sqlStripe['sp_stripe_id'] ) {
					// 	$plan = $stripe->createPlan( $row_sqlStripe['sp_stripe_id'], $data, $nombreCampos );

					// 	$plan_id = is_array( $plan ) ? $plan['id'] : $plan->id;
					// 	if ( is_array( $plan ) ) {
					// 		if ( $plan['error'] ) {
					// 			if ($plan['error']['param']) {
					// 				$result["error"][$nombreCampos."-".$plan['error']['param']] = $plan['error']['message'];
					// 				$result["isOk"] = false;
					// 				$error=1;
					// 			}
					// 		}
					// 	}
					// 	$result['plan_id'] = $plan_id;
					// }



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