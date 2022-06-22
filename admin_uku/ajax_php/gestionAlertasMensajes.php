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
			$progressPestanas = 5;
			$progressPestanasArray = array(
										'general' => 5,
										'respuestas' => 6,
										'botones' => 3,
										'errores' => 19,
										'mensajes_template' => 6
									);
			$TotalPorcentaje = $porcentajeGeneral = $porcentajeGeneral_en = $porcentajeFormulario = $porcentajeFormulario_en = 0;
			if(isset($progressPestanasArray['general'])){
				$totalGeneral = 0;
				if ($row_sql[$prefijo."correo_as_registrarse"])
					$totalGeneral++;
				if ($row_sql[$prefijo."correo_as_recuperar_contrasena"])
					$totalGeneral++;
				if ($row_sql[$prefijo."correo_as_bienvenido"])
					$totalGeneral++;
				if ($row_sql[$prefijo."correo_as_contacto"])
					$totalGeneral++;
				if ($row_sql[$prefijo."correo_as_suscribirse"])
					$totalGeneral++;
				$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
				$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;

				$result['progress']['general'] = $porcentajeGeneral;
			}

			if(isset($progressPestanasArray['respuestas'])){
				$totalrespuestas = 0;
				if ($row_sql[$prefijo."respuesta_form_registrarse"])
					$totalrespuestas++;
				if ($row_sql[$prefijo."respuesta_form_no_registrarse"])
					$totalrespuestas++;
				if ($row_sql[$prefijo."respuesta_form_contacto"])
					$totalrespuestas++;
				if ($row_sql[$prefijo."respuesta_form_no_contacto"])
					$totalrespuestas++;
				if ($row_sql[$prefijo."respuesta_form_suscribirse"])
					$totalrespuestas++;
				if ($row_sql[$prefijo."respuesta_form_no_suscribirse"])
					$totalrespuestas++;
				$porcentajerespuestas = ($totalrespuestas/$progressPestanasArray['respuestas']) * 100;
				$TotalPorcentaje += ($porcentajerespuestas * $progressCadaItem) / 100;

				$result['progress']['respuestas'] = $porcentajerespuestas;
			}

			if(isset($progressPestanasArray['botones'])){
				$totalbotones = 0;
				if ($row_sql[$prefijo."btn_enviar"])
					$totalbotones++;
				if ($row_sql[$prefijo."btn_enviando"])
					$totalbotones++;
				if ($row_sql[$prefijo."btn_enviado"])
					$totalbotones++;
				$porcentajebotones = ($totalbotones/$progressPestanasArray['botones']) * 100;
				$TotalPorcentaje += ($porcentajebotones * $progressCadaItem) / 100;

				$result['progress']['botones'] = $porcentajebotones;
			}

			if(isset($progressPestanasArray['errores'])){
				$totalerrores = 0;
				if ($row_sql[$prefijo."error_requerido_general"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_requerido_campo"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_nombre"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_telefono"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_direccion"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_asunto"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_email"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_mensaje"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_cedula"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_empresa"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_pais"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_ciudad"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_departamento"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_sexo"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_estado_civil"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_fecha"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_contrasena"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_contrasena_confirmar"])
					$totalerrores++;
				if ($row_sql[$prefijo."error_coincidencia"])
					$totalerrores++;
				$porcentajeerrores = ($totalerrores/$progressPestanasArray['errores']) * 100;
				$TotalPorcentaje += ($porcentajeerrores * $progressCadaItem) / 100;

				$result['progress']['errores'] = $porcentajeerrores;
			}

			if(isset($progressPestanasArray['mensajes_template'])){
				$totalmensajes_template = 0;
				if ($row_sql[$prefijo."mensaje_correo_hola"])
					$totalmensajes_template++;
				if ($row_sql[$prefijo."mensaje_correo_header"])
					$totalmensajes_template++;
				if ($row_sql[$prefijo."mensaje_correo_header_newsletter"])
					$totalmensajes_template++;
				if ($row_sql[$prefijo."mensaje_correo_enviado_a"])
					$totalmensajes_template++;
				if ($row_sql[$prefijo."mensaje_correo_enviado_a_resto"])
					$totalmensajes_template++;
				if ($row_sql[$prefijo."mensaje_correo_footer"])
					$totalmensajes_template++;
				$porcentajemensajes_template = ($totalmensajes_template/$progressPestanasArray['mensajes_template']) * 100;
				$TotalPorcentaje += ($porcentajemensajes_template * $progressCadaItem) / 100;

				$result['progress']['mensajes_template'] = $porcentajemensajes_template;
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

			$result[$nombreCampos."-correo_as_registrarse"] = utf8_encode($row_sql[$prefijo.'correo_as_registrarse']);
			$result[$nombreCampos."-correo_as_recuperar_contrasena"] = utf8_encode($row_sql[$prefijo.'correo_as_recuperar_contrasena']);
			$result[$nombreCampos."-correo_as_bienvenido"] = utf8_encode($row_sql[$prefijo.'correo_as_bienvenido']);
			$result[$nombreCampos."-correo_as_contacto"] = utf8_encode($row_sql[$prefijo.'correo_as_contacto']);
			$result[$nombreCampos."-correo_as_suscribirse"] = utf8_encode($row_sql[$prefijo.'correo_as_suscribirse']);
			$result[$nombreCampos."-respuesta_form_registrarse"] = utf8_encode($row_sql[$prefijo.'respuesta_form_registrarse']);
			$result[$nombreCampos."-respuesta_form_no_registrarse"] = utf8_encode($row_sql[$prefijo.'respuesta_form_no_registrarse']);
			$result[$nombreCampos."-respuesta_form_contacto"] = utf8_encode($row_sql[$prefijo.'respuesta_form_contacto']);
			$result[$nombreCampos."-respuesta_form_no_contacto"] = utf8_encode($row_sql[$prefijo.'respuesta_form_no_contacto']);
			$result[$nombreCampos."-respuesta_form_suscribirse"] = utf8_encode($row_sql[$prefijo.'respuesta_form_suscribirse']);
			$result[$nombreCampos."-respuesta_form_no_suscribirse"] = utf8_encode($row_sql[$prefijo.'respuesta_form_no_suscribirse']);
			$result[$nombreCampos."-btn_enviar"] = utf8_encode($row_sql[$prefijo.'btn_enviar']);
			$result[$nombreCampos."-btn_enviando"] = utf8_encode($row_sql[$prefijo.'btn_enviando']);
			$result[$nombreCampos."-btn_enviado"] = utf8_encode($row_sql[$prefijo.'btn_enviado']);
			$result[$nombreCampos."-error_requerido_general"] = utf8_encode($row_sql[$prefijo.'error_requerido_general']);
			$result[$nombreCampos."-error_requerido_campo"] = utf8_encode($row_sql[$prefijo.'error_requerido_campo']);
			$result[$nombreCampos."-error_nombre"] = utf8_encode($row_sql[$prefijo.'error_nombre']);
			$result[$nombreCampos."-error_telefono"] = utf8_encode($row_sql[$prefijo.'error_telefono']);
			$result[$nombreCampos."-error_direccion"] = utf8_encode($row_sql[$prefijo.'error_direccion']);
			$result[$nombreCampos."-error_asunto"] = utf8_encode($row_sql[$prefijo.'error_asunto']);
			$result[$nombreCampos."-error_email"] = utf8_encode($row_sql[$prefijo.'error_email']);
			$result[$nombreCampos."-error_mensaje"] = utf8_encode($row_sql[$prefijo.'error_mensaje']);
			$result[$nombreCampos."-error_cedula"] = utf8_encode($row_sql[$prefijo.'error_cedula']);
			$result[$nombreCampos."-error_empresa"] = utf8_encode($row_sql[$prefijo.'error_empresa']);
			$result[$nombreCampos."-error_pais"] = utf8_encode($row_sql[$prefijo.'error_pais']);
			$result[$nombreCampos."-error_ciudad"] = utf8_encode($row_sql[$prefijo.'error_ciudad']);
			$result[$nombreCampos."-error_departamento"] = utf8_encode($row_sql[$prefijo.'error_departamento']);
			$result[$nombreCampos."-error_sexo"] = utf8_encode($row_sql[$prefijo.'error_sexo']);
			$result[$nombreCampos."-error_estado_civil"] = utf8_encode($row_sql[$prefijo.'error_estado_civil']);
			$result[$nombreCampos."-error_fecha"] = utf8_encode($row_sql[$prefijo.'error_fecha']);
			$result[$nombreCampos."-error_contrasena"] = utf8_encode($row_sql[$prefijo.'error_contrasena']);
			$result[$nombreCampos."-error_contrasena_confirmar"] = utf8_encode($row_sql[$prefijo.'error_contrasena_confirmar']);
			$result[$nombreCampos."-error_coincidencia"] = utf8_encode($row_sql[$prefijo.'error_coincidencia']);
			$result[$nombreCampos."-mensaje_correo_hola"] = utf8_encode($row_sql[$prefijo.'mensaje_correo_hola']);
			$result[$nombreCampos."-mensaje_correo_header"] = utf8_encode($row_sql[$prefijo.'mensaje_correo_header']);
			$result[$nombreCampos."-mensaje_correo_header_newsletter"] = utf8_encode($row_sql[$prefijo.'mensaje_correo_header_newsletter']);
			$result[$nombreCampos."-mensaje_correo_enviado_a"] = utf8_encode($row_sql[$prefijo.'mensaje_correo_enviado_a']);
			$result[$nombreCampos."-mensaje_correo_enviado_a_resto"] = utf8_encode($row_sql[$prefijo.'mensaje_correo_enviado_a_resto']);
			$result[$nombreCampos."-mensaje_correo_footer"] = utf8_encode($row_sql[$prefijo.'mensaje_correo_footer']);
			
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

	if($_POST['tipo'] == 'formEditarAlertasMensajes'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataCorreo_as_registrarse	= utf8_decode($data[$nombreCampos."-correo_as_registrarse"]);
			$dataCorreo_as_recuperar_contrasena	= utf8_decode($data[$nombreCampos."-correo_as_recuperar_contrasena"]);
			$dataCorreo_as_bienvenido	= utf8_decode($data[$nombreCampos."-correo_as_bienvenido"]);
			$dataCorreo_as_contacto	= utf8_decode($data[$nombreCampos."-correo_as_contacto"]);
			$dataCorreo_as_suscribirse	= utf8_decode($data[$nombreCampos."-correo_as_suscribirse"]);
			$dataRespuesta_form_registrarse	= utf8_decode($data[$nombreCampos."-respuesta_form_registrarse"]);
			$dataRespuesta_form_no_registrarse	= utf8_decode($data[$nombreCampos."-respuesta_form_no_registrarse"]);
			$dataRespuesta_form_contacto	= utf8_decode($data[$nombreCampos."-respuesta_form_contacto"]);
			$dataRespuesta_form_no_contacto	= utf8_decode($data[$nombreCampos."-respuesta_form_no_contacto"]);
			$dataRespuesta_form_suscribirse	= utf8_decode($data[$nombreCampos."-respuesta_form_suscribirse"]);
			$dataRespuesta_form_no_suscribirse	= utf8_decode($data[$nombreCampos."-respuesta_form_no_suscribirse"]);
			$dataBtn_enviar	= utf8_decode($data[$nombreCampos."-btn_enviar"]);
			$dataBtn_enviando	= utf8_decode($data[$nombreCampos."-btn_enviando"]);
			$dataBtn_enviado	= utf8_decode($data[$nombreCampos."-btn_enviado"]);
			$dataError_requerido_general	= utf8_decode($data[$nombreCampos."-error_requerido_general"]);
			$dataError_requerido_campo	= utf8_decode($data[$nombreCampos."-error_requerido_campo"]);
			$dataError_nombre	= utf8_decode($data[$nombreCampos."-error_nombre"]);
			$dataError_telefono	= utf8_decode($data[$nombreCampos."-error_telefono"]);
			$dataError_direccion	= utf8_decode($data[$nombreCampos."-error_direccion"]);
			$dataError_asunto	= utf8_decode($data[$nombreCampos."-error_asunto"]);
			$dataError_email	= utf8_decode($data[$nombreCampos."-error_email"]);
			$dataError_mensaje	= utf8_decode($data[$nombreCampos."-error_mensaje"]);
			$dataError_cedula	= utf8_decode($data[$nombreCampos."-error_cedula"]);
			$dataError_empresa	= utf8_decode($data[$nombreCampos."-error_empresa"]);
			$dataError_pais	= utf8_decode($data[$nombreCampos."-error_pais"]);
			$dataError_ciudad	= utf8_decode($data[$nombreCampos."-error_ciudad"]);
			$dataError_departamento	= utf8_decode($data[$nombreCampos."-error_departamento"]);
			$dataError_sexo	= utf8_decode($data[$nombreCampos."-error_sexo"]);
			$dataError_estado_civil	= utf8_decode($data[$nombreCampos."-error_estado_civil"]);
			$dataError_fecha	= utf8_decode($data[$nombreCampos."-error_fecha"]);
			$dataError_contrasena	= utf8_decode($data[$nombreCampos."-error_contrasena"]);
			$dataError_contrasena_confirmar	= utf8_decode($data[$nombreCampos."-error_contrasena_confirmar"]);
			$dataError_coincidencia	= utf8_decode($data[$nombreCampos."-error_coincidencia"]);
			$dataMensaje_correo_hola	= utf8_decode($data[$nombreCampos."-mensaje_correo_hola"]);
			$dataMensaje_correo_header	= utf8_decode($data[$nombreCampos."-mensaje_correo_header"]);
			$dataMensaje_correo_header_newsletter	= utf8_decode($data[$nombreCampos."-mensaje_correo_header_newsletter"]);
			$dataMensaje_correo_enviado_a	= utf8_decode($data[$nombreCampos."-mensaje_correo_enviado_a"]);
			$dataMensaje_correo_enviado_a_resto	= utf8_decode($data[$nombreCampos."-mensaje_correo_enviado_a_resto"]);
			$dataMensaje_correo_footer	= utf8_decode($data[$nombreCampos."-mensaje_correo_footer"]);

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
								".$prefijo."correo_as_registrarse,
								".$prefijo."correo_as_recuperar_contrasena,
								".$prefijo."correo_as_bienvenido,
								".$prefijo."correo_as_contacto,
								".$prefijo."correo_as_suscribirse,
								".$prefijo."respuesta_form_registrarse,
								".$prefijo."respuesta_form_no_registrarse,
								".$prefijo."respuesta_form_contacto,
								".$prefijo."respuesta_form_no_contacto,
								".$prefijo."respuesta_form_suscribirse,
								".$prefijo."respuesta_form_no_suscribirse,
								".$prefijo."btn_enviar,
								".$prefijo."btn_enviando,
								".$prefijo."btn_enviado,
								".$prefijo."error_requerido_general,
								".$prefijo."error_requerido_campo,
								".$prefijo."error_nombre,
								".$prefijo."error_telefono,
								".$prefijo."error_direccion,
								".$prefijo."error_asunto,
								".$prefijo."error_email,
								".$prefijo."error_mensaje,
								".$prefijo."error_cedula,
								".$prefijo."error_empresa,
								".$prefijo."error_pais,
								".$prefijo."error_ciudad,
								".$prefijo."error_departamento,
								".$prefijo."error_sexo,
								".$prefijo."error_estado_civil,
								".$prefijo."error_fecha,
								".$prefijo."error_contrasena,
								".$prefijo."error_contrasena_confirmar,
								".$prefijo."error_coincidencia,
								".$prefijo."mensaje_correo_hola,
								".$prefijo."mensaje_correo_header,
								".$prefijo."mensaje_correo_header_newsletter,
								".$prefijo."mensaje_correo_enviado_a,
								".$prefijo."mensaje_correo_enviado_a_resto,
								".$prefijo."mensaje_correo_footer
							) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
							GetSQLValueString($id,"int"),
							GetSQLValueString($_SESSION[_sessionIdioma],"int"),
							GetSQLValueString($dataCorreo_as_registrarse,"text"),
							GetSQLValueString($dataCorreo_as_recuperar_contrasena,"text"),
							GetSQLValueString($dataCorreo_as_bienvenido,"text"),
							GetSQLValueString($dataCorreo_as_contacto,"text"),
							GetSQLValueString($dataCorreo_as_suscribirse,"text"),
							GetSQLValueString($dataRespuesta_form_registrarse,"text"),
							GetSQLValueString($dataRespuesta_form_no_registrarse,"text"),
							GetSQLValueString($dataRespuesta_form_contacto,"text"),
							GetSQLValueString($dataRespuesta_form_no_contacto,"text"),
							GetSQLValueString($dataRespuesta_form_suscribirse,"text"),
							GetSQLValueString($dataRespuesta_form_no_suscribirse,"text"),
							GetSQLValueString($dataBtn_enviar,"text"),
							GetSQLValueString($dataBtn_enviando,"text"),
							GetSQLValueString($dataBtn_enviado,"text"),
							GetSQLValueString($dataError_requerido_general,"text"),
							GetSQLValueString($dataError_requerido_campo,"text"),
							GetSQLValueString($dataError_nombre,"text"),
							GetSQLValueString($dataError_telefono,"text"),
							GetSQLValueString($dataError_direccion,"text"),
							GetSQLValueString($dataError_asunto,"text"),
							GetSQLValueString($dataError_email,"text"),
							GetSQLValueString($dataError_mensaje,"text"),
							GetSQLValueString($dataError_cedula,"text"),
							GetSQLValueString($dataError_empresa,"text"),
							GetSQLValueString($dataError_pais,"text"),
							GetSQLValueString($dataError_ciudad,"text"),
							GetSQLValueString($dataError_departamento,"text"),
							GetSQLValueString($dataError_sexo,"text"),
							GetSQLValueString($dataError_estado_civil,"text"),
							GetSQLValueString($dataError_fecha,"text"),
							GetSQLValueString($dataError_contrasena,"text"),
							GetSQLValueString($dataError_contrasena_confirmar,"text"),
							GetSQLValueString($dataError_coincidencia,"text"),
							GetSQLValueString($dataMensaje_correo_hola,"text"),
							GetSQLValueString($dataMensaje_correo_header,"text"),
							GetSQLValueString($dataMensaje_correo_header_newsletter,"text"),
							GetSQLValueString($dataMensaje_correo_enviado_a,"text"),
							GetSQLValueString($dataMensaje_correo_enviado_a_resto,"text"),
							GetSQLValueString($dataMensaje_correo_footer,"text")
						);
				}else{
					$sql = sprintf("	UPDATE ".$tabla." 
											SET
												".$prefijo."correo_as_registrarse=%s,
												".$prefijo."correo_as_recuperar_contrasena=%s,
												".$prefijo."correo_as_bienvenido=%s,
												".$prefijo."correo_as_contacto=%s,
												".$prefijo."correo_as_suscribirse=%s,
												".$prefijo."respuesta_form_registrarse=%s,
												".$prefijo."respuesta_form_no_registrarse=%s,
												".$prefijo."respuesta_form_contacto=%s,
												".$prefijo."respuesta_form_no_contacto=%s,
												".$prefijo."respuesta_form_suscribirse=%s,
												".$prefijo."respuesta_form_no_suscribirse=%s,
												".$prefijo."btn_enviar=%s,
												".$prefijo."btn_enviando=%s,
												".$prefijo."btn_enviado=%s,
												".$prefijo."error_requerido_general=%s,
												".$prefijo."error_requerido_campo=%s,
												".$prefijo."error_nombre=%s,
												".$prefijo."error_telefono=%s,
												".$prefijo."error_direccion=%s,
												".$prefijo."error_asunto=%s,
												".$prefijo."error_email=%s,
												".$prefijo."error_mensaje=%s,
												".$prefijo."error_cedula=%s,
												".$prefijo."error_empresa=%s,
												".$prefijo."error_pais=%s,
												".$prefijo."error_ciudad=%s,
												".$prefijo."error_departamento=%s,
												".$prefijo."error_sexo=%s,
												".$prefijo."error_estado_civil=%s,
												".$prefijo."error_fecha=%s,
												".$prefijo."error_contrasena=%s,
												".$prefijo."error_contrasena_confirmar=%s,
												".$prefijo."error_coincidencia=%s,
												".$prefijo."mensaje_correo_hola=%s,
												".$prefijo."mensaje_correo_header=%s,
												".$prefijo."mensaje_correo_header_newsletter=%s,
												".$prefijo."mensaje_correo_enviado_a=%s,
												".$prefijo."mensaje_correo_enviado_a_resto=%s,
												".$prefijo."mensaje_correo_footer=%s
											WHERE 
												".$prefijo."id=%s",
							GetSQLValueString($dataCorreo_as_registrarse,"text"),
							GetSQLValueString($dataCorreo_as_recuperar_contrasena,"text"),
							GetSQLValueString($dataCorreo_as_bienvenido,"text"),
							GetSQLValueString($dataCorreo_as_contacto,"text"),
							GetSQLValueString($dataCorreo_as_suscribirse,"text"),
							GetSQLValueString($dataRespuesta_form_registrarse,"text"),
							GetSQLValueString($dataRespuesta_form_no_registrarse,"text"),
							GetSQLValueString($dataRespuesta_form_contacto,"text"),
							GetSQLValueString($dataRespuesta_form_no_contacto,"text"),
							GetSQLValueString($dataRespuesta_form_suscribirse,"text"),
							GetSQLValueString($dataRespuesta_form_no_suscribirse,"text"),
							GetSQLValueString($dataBtn_enviar,"text"),
							GetSQLValueString($dataBtn_enviando,"text"),
							GetSQLValueString($dataBtn_enviado,"text"),
							GetSQLValueString($dataError_requerido_general,"text"),
							GetSQLValueString($dataError_requerido_campo,"text"),
							GetSQLValueString($dataError_nombre,"text"),
							GetSQLValueString($dataError_telefono,"text"),
							GetSQLValueString($dataError_direccion,"text"),
							GetSQLValueString($dataError_asunto,"text"),
							GetSQLValueString($dataError_email,"text"),
							GetSQLValueString($dataError_mensaje,"text"),
							GetSQLValueString($dataError_cedula,"text"),
							GetSQLValueString($dataError_empresa,"text"),
							GetSQLValueString($dataError_pais,"text"),
							GetSQLValueString($dataError_ciudad,"text"),
							GetSQLValueString($dataError_departamento,"text"),
							GetSQLValueString($dataError_sexo,"text"),
							GetSQLValueString($dataError_estado_civil,"text"),
							GetSQLValueString($dataError_fecha,"text"),
							GetSQLValueString($dataError_contrasena,"text"),
							GetSQLValueString($dataError_contrasena_confirmar,"text"),
							GetSQLValueString($dataError_coincidencia,"text"),
							GetSQLValueString($dataMensaje_correo_hola,"text"),
							GetSQLValueString($dataMensaje_correo_header,"text"),
							GetSQLValueString($dataMensaje_correo_header_newsletter,"text"),
							GetSQLValueString($dataMensaje_correo_enviado_a,"text"),
							GetSQLValueString($dataMensaje_correo_enviado_a_resto,"text"),
							GetSQLValueString($dataMensaje_correo_footer,"text"),
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