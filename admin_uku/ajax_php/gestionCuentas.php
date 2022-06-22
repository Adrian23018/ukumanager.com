<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	//Empieza cerrarSesion
	if($_POST['tipo'] == 'cerrarSesion'){
		unset($_SESSION[_sessionAdmin]);
	}

	//Nombre Usuario Logueado
	if($_POST['tipo'] == 'datosUsuario'){
		//Función en ../includes/configFunciones.php
		if(validarLogueado($_conection)){
			
			//Buscamos Usuario
			$sql = 	sprintf("SELECT * FROM a_tbl_cuentas WHERE cue_id=%s AND cue_estado=1",
						GetSQLValueString($_SESSION[_sessionAdmin], "int")
					);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			if ($rs_sql) {
				$row_sql = mysqli_fetch_assoc($rs_sql);
				$nombreCuenta = $row_sql['cue_nombres'] . " " . $row_sql['cue_apellidos'];
				$result["userUsuario"] = utf8_encode($row_sql['cue_user']);
				$result["emailUsuario"] = utf8_encode($row_sql['cue_email']);
				$result["nombresUsuario"] = utf8_encode($row_sql['cue_nombres']);
				$result["apellidosUsuario"] = utf8_encode($row_sql['cue_apellidos']);
				$result["telefonoUsuario"] = utf8_encode($row_sql['cue_telefono']);
				$result["celularUsuario"] = utf8_encode($row_sql['cue_celular']);
				$result["ocupacionUsuario"] = utf8_encode($row_sql['cue_ocupacion']);
				$result["imagenUsuario"] = utf8_encode($row_sql['cue_imagen']);

				$result["imagenUsuario"] = false;
				$result["imagenUsuarioImg"] = false;

				$tabNombre = $tabIdRegistro = $tabTipo = '';
				$tabNombre = 'cuentas';
				$tabTipo = 'a_';
				$img_principal = 'ambas';
				$variablesExtras['datatable'] = true;
				$variablesExtras['carpeta_admin'] = true;
				$variablesExtras['thumbnail'] = "si";
				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $_SESSION[_sessionAdmin], $img_principal, $linktrue, $variablesExtras);
				$segundaletra = explode(" ", $nombreCuenta);
				$segundaletra = str_replace(" ", "", $segundaletra[1]);
				$segundaletra = strtolower($segundaletra[0]);

				$nombreUsuario = str_replace(" ", "", $nombreCuenta);
				$primeraletra = strtolower($nombreUsuario[0]);
				if($arrayLetras[$primeraletra]){
					$color = $arrayLetras[$primeraletra];
				}else{
					$color = $arrayColores[array_rand($arrayColores)];
				}
				
				if ($arrayImagenes[0]) {
					if ($arrayImagenes[0][1]) {
						$imagen_principal = substr($arrayImagenes[0][1],3);
					}else{
						$imagen_principal = substr($arrayImagenes[0][0],3);
					}

					$pathImagen = "../".$imagen_principal;
					$pathImagenLink = $imagen_principal;
					if (file_exists($pathImagen)){
						$result["imagenUsuario"] = '<img src="'.$pathImagenLink.'" class="img-responsive" alt="">';
						$result["imagenUsuarioImg"] = '<img alt="" class="img-circle img-perfil" src="'.$pathImagenLink.'"/>';
					}else{						
						$result["imagenUsuario"] = '<div class="img-circle letras-colores tamano-2" style="background: #'.$color.'">'.utf8_encode($primeraletra.$segundaletra).'</div>';
						$result["imagenUsuarioImg"] = '<div class="img-circle img-responsive letras-colores tamano-1" style="background: #'.$color.'">'.utf8_encode($primeraletra.$segundaletra).'</div>';
					}
				}else{
					$result["imagenUsuario"] = '<div class="img-circle letras-colores tamano-2" style="background: #'.$color.'">'.utf8_encode($primeraletra.$segundaletra).'</div>';
					$result["imagenUsuarioImg"] = '<div class="img-circle img-responsive letras-colores tamano-1" style="background: #'.$color.'">'.utf8_encode($primeraletra.$segundaletra).'</div>';
				}
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}

	//Guardar Cambios Perfil
	if($_POST['tipo'] == 'formEditarPerfil'){
		//Función en ../includes/configFunciones.php
		if(validarLogueado($_conection)){
			

			//Datos Post Formulario
			$nombres = $_POST["nombres"];
			$apellidos = $_POST["apellidos"];
			$celular = $_POST["celular"];
			$telefono = $_POST["telefono"];
			$ocupacion = $_POST["ocupacion"];

			//Definimos variables a devolver
			$result["error"]["nombres"] = '';
			$result["error"]["apellidos"] = '';
			$result["error"]["celular"] = '';
			$result["error"]["telefono"] = '';
			$result["error"]["ocupacion"] = '';
			$result["error"]["btn-guardar-cambios-perfil"] = '';

			$result["success"]["btn-guardar-cambios-perfil"] = '';

			$result["isOk"] = true;

			//Hemos validado los datos
			if ($error != 1) {
				$sql = 	sprintf("	UPDATE a_tbl_cuentas 
									SET 
										cue_nombres=%s,
										cue_apellidos=%s,
										cue_celular=%s,
										cue_telefono=%s,
										cue_ocupacion=%s
									WHERE cue_id=%s",
							GetSQLValueString(utf8_decode($nombres), "text"),
							GetSQLValueString(utf8_decode($apellidos), "text"),
							GetSQLValueString(utf8_decode($celular), "text"),
							GetSQLValueString(utf8_decode($telefono), "text"),
							GetSQLValueString(utf8_decode($ocupacion), "text"),
							GetSQLValueString($_SESSION[_sessionAdmin], "int")
						);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				if (!$rs_sql) {
					$result["isOk"] = false;
					$result["error"]["btn-guardar-cambios-perfil"] = _errorSql;
				}
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}//

	if($_POST['tipo'] == 'formCambiarContrasena'){
		//Función en ../includes/configFunciones.php
		if(validarLogueado($_conection)){
			
			//Campos Enviados por Post
			$password = $_POST["password"];
			$passwordnueva = $_POST["passwordnueva"];
			$passwordnuevarepetir = $_POST["passwordnuevarepetir"];

			//Definimos variables a devolver
			$result["error"]["password"] = '';
			$result["error"]["passwordnueva"] = '';
			$result["error"]["passwordnuevarepetir"] = '';

			$result["success"]["btn-guardar-clave"] = '';

			$result["isOk"] = true;
		
			//Revisamos si los campos no están vacios
			if($password == ""){
				$result["error"]["password"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			if($passwordnueva == ""){
				$result["error"]["passwordnueva"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			if($passwordnuevarepetir == ""){
				$result["error"]["passwordnuevarepetir"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			//Buscamos Usuario
			$sql = 	sprintf("	SELECT * FROM a_tbl_cuentas 
								WHERE cue_id=%s AND cue_estado=1",
						GetSQLValueString($_SESSION[_sessionAdmin], "int")
					);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			if ($rs_sql) {
				$row_sql = mysqli_fetch_assoc($rs_sql);

				$password_hash = $row_sql['cue_password'];

				if ($error != 1) {
					if(crypt($password, $password_hash) == $password_hash) {
						$sql = 	sprintf("	UPDATE a_tbl_cuentas 
											SET cue_password=%s 
											WHERE cue_id=%s",
									GetSQLValueString(crypt($passwordnueva), "text"),
									GetSQLValueString($_SESSION[_sessionAdmin], "int")
								);
						
						$rs_sql = mysqli_query($_conection->connect(), $sql);
						if (!$rs_sql) {
							$result["isOk"] = false;
							$result["error"]["btn-guardar-clave"] = _errorSql;
						}else{
							$result["success"]["btn-guardar-clave"] = _informacionEditada;
						}
					}else{
						//Contraseña invalida
						$result["isOk"] = false;
						$result["error"]["password"] = _cuePasswordIncorrecto;
					}
				}
			}else{
				$result["isOk"] = false;
				$result["error"]["btn-guardar-clave"] = _errorSql;
			}

		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}//

	if($_POST['tipo'] == 'formCrearCuentas'){
		
		if(validarLogueado($_conection)){
			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataEmail			= 	utf8_decode($data[$nombreCampos."-email"]);
			$dataUser			= 	utf8_decode(CamellizarConGuiones($data[$nombreCampos."-user"]));
			$dataPassword		= 	utf8_decode($data[$nombreCampos."-password"]);
			$dataPasswordrepeat	= 	utf8_decode($data[$nombreCampos."-passwordrepeat"]);
			$dataNombres		= 	utf8_decode($data[$nombreCampos."-nombres"]);
			$dataApellidos		= 	utf8_decode($data[$nombreCampos."-apellidos"]);
			$dataCelular		= 	utf8_decode($data[$nombreCampos."-celular"]);
			$dataTelefono		= 	utf8_decode($data[$nombreCampos."-telefono"]);
			$dataOcupacion		= 	utf8_decode($data[$nombreCampos."-ocupacion"]);

			//Definimos variables a devolver
			$result['id'] = '';
			
			$result["error"][$nombreCampos."-email"] 			= '';
			$result["error"][$nombreCampos."-user"] 			= '';
			$result["error"][$nombreCampos."-password"] 		= '';
			$result["error"][$nombreCampos."-passwordrepeat"] 	= '';
			$result["error"][$nombreCampos."-nombres"] 			= '';
			$result["error"][$nombreCampos."-apellidos"] 		= '';
			$result["error"][$nombreCampos."-celular"] 			= '';
			$result["error"][$nombreCampos."-telefono"] 		= '';
			$result["error"][$nombreCampos."-ocupacion"] 		= '';

			$result["success"]["btn-guardar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//verificar que el email sea valido
			if(!preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#", $dataEmail)){
				$result["error"][$nombreCampos."-email"] = _errorCampoEmail;
				$result["isOk"] = false;
				$error=1;
			}

			//Verificamos que no se encuentre vacio algunos campos
			if($dataUser == ""){
				$result["error"][$nombreCampos."-user"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			if($dataPassword == ""){
				$result["error"][$nombreCampos."-password"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			if($dataPasswordrepeat == ""){
				$result["error"][$nombreCampos."-passwordrepeat"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			//verificar que usuario no se encuentre en la base de  datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."user=%s",
				GetSQLValueString($dataUser ,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if ($row_sql[$prefijo."id"]){
				$result["error"][$nombreCampos."-user"] =  _cueUsernameRegistrado;
				$result["isOk"] = false;
				$error=1;
			}

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."email=%s",
				GetSQLValueString($dataEmail ,"text")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if ($row_sql[$prefijo."id"]){
				$result["error"][$nombreCampos."-email"] =  _cueUsernameRegistrado;
				$result["isOk"] = false;
				$error=1;
			}

			//Revisamos que las contraseñas coincidan
			if($dataPassword != $dataPasswordrepeat){
				$result["error"][$nombreCampos."-password"] = _cuePasswordNoCoinciden;
				$result["isOk"] = false;
				$error=1;
			}

			if ($error == 0) {
				$sql = sprintf("	INSERT INTO ".$tabla." 
										(
											".$prefijo."user,
											".$prefijo."password,
											".$prefijo."email,
											".$prefijo."nombres,
											".$prefijo."apellidos,
											".$prefijo."telefono,
											".$prefijo."celular,
											".$prefijo."ocupacion
										)
										VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
					GetSQLValueString($dataUser,"text"),
					GetSQLValueString(crypt($dataPassword),"text"),
					GetSQLValueString($dataEmail, "text"),
					GetSQLValueString($dataNombres, "text"),
					GetSQLValueString($dataApellidos, "text"),
					GetSQLValueString($dataTelefono, "text"),
					GetSQLValueString($dataCelular, "text"),
					GetSQLValueString($dataOcupacion, "text")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
				if ($rs_sql) {
					//Guardado
					$result["success"]["btn-guardar-".$nombreCampos] = _informacionGuardada;

					//Capturamos el último id ingresado
					$id = mysql_insert_id();
					//Devolvemos Id
					$result['id'] = $id;
					$result['link'] = 'inicio.php?page='.$variables['nombreSeccion3'].'&id='.$id;
					$select_group_seccion = "SELECT * FROM a_tbl_gruposeccion";
					$rs_group_seccion = mysqli_query($_conection->connect(), $select_group_seccion);
					//Recorremos todos las secciones que existen en la base de datos
					while ($row_group_seccion = mysqli_fetch_assoc($rs_group_seccion)) {
						$valor = 'check-'.$row_group_seccion["gp_id"];
						//Si el check fue marcado se guarda en la base de datos
						if($data[$valor]) {
							$insert_sql_detalle = sprintf("INSERT INTO a_tbl_cuentas_x_gruposeccion (cgp_cue_id, cgp_gp_id) VALUES (%s,%s)",
								GetSQLValueString($id,"int"),
								GetSQLValueString($row_group_seccion["gp_id"],"int")
							);
							$rs_insert_detalle = mysqli_query($_conection->connect(), $insert_sql_detalle);
						}
					}//
				}else{
					//Error sql
					$result["error"]["btn-guardar-".$nombreCampos] = _errorSql;
				}
			}
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

			$result[$nombreCampos."-user"] = utf8_encode($row_sql[$prefijo.'user']);
			$result[$nombreCampos."-email"] = utf8_encode($row_sql[$prefijo.'email']);
			$result[$nombreCampos."-nombres"] = utf8_encode($row_sql[$prefijo.'nombres']);
			$result[$nombreCampos."-apellidos"] = utf8_encode($row_sql[$prefijo.'apellidos']);
			$result[$nombreCampos."-telefono"] = utf8_encode($row_sql[$prefijo.'telefono']);
			$result[$nombreCampos."-celular"] = utf8_encode($row_sql[$prefijo.'celular']);
			$result[$nombreCampos."-ocupacion"] = utf8_encode($row_sql[$prefijo.'ocupacion']);

			//gruposeccion
			$sql = sprintf("SELECT * FROM a_tbl_cuentas_x_gruposeccion WHERE cgp_cue_id=%s",
				GetSQLValueString($id,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;
			while ($row_sql = mysqli_fetch_assoc($rs_sql)){
				$array_secciones[$i] = $row_sql["cgp_gp_id"];
				$i++;
			}
			$result["secciones"] = $array_secciones;
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina traer datos

	if($_POST['tipo'] == 'formEditarCuentas'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataEmail			= 	utf8_decode($data[$nombreCampos."-email"]);
			$dataUser			= 	utf8_decode(CamellizarConGuiones($data[$nombreCampos."-user"]));
			$dataPassword		= 	utf8_decode($data[$nombreCampos."-password"]);
			$dataPasswordrepeat	= 	utf8_decode($data[$nombreCampos."-passwordrepeat"]);
			$dataNombres			= 	utf8_decode($data[$nombreCampos."-nombres"]);
			$dataApellidos		= 	utf8_decode($data[$nombreCampos."-apellidos"]);
			$dataCelular			= 	utf8_decode($data[$nombreCampos."-celular"]);
			$dataTelefono		= 	utf8_decode($data[$nombreCampos."-telefono"]);
			$dataOcupacion		= 	utf8_decode($data[$nombreCampos."-ocupacion"]);

			//Definimos variables a devolver
			$result["error"][$nombreCampos."-email"] 			= '';
			$result["error"][$nombreCampos."-user"] 			= '';
			$result["error"][$nombreCampos."-password"] 		= '';
			$result["error"][$nombreCampos."-passwordrepeat"] 	= '';
			$result["error"][$nombreCampos."-nombres"] 			= '';
			$result["error"][$nombreCampos."-apellidos"] 		= '';
			$result["error"][$nombreCampos."-celular"] 			= '';
			$result["error"][$nombreCampos."-telefono"] 		= '';
			$result["error"][$nombreCampos."-ocupacion"] 		= '';

			$result["success"]["btn-guardar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//verificar que el email sea valido
			if(!preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#", $dataEmail)){
				$result["error"][$nombreCampos."-email"] = _errorCampoEmail;
				$result["isOk"] = false;
				$error=1;
			}

			//Verificamos que no se encuentre vacio algunos campos
			if($dataUser == ""){
				$result["error"][$nombreCampos."-user"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			//verificar que usuario no se encuentre en la base de  datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."user=%s AND ".$prefijo."id!=%s",
				GetSQLValueString($dataUser ,"text"),
				GetSQLValueString($id ,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if ($row_sql[$prefijo."id"]){
				$result["error"][$nombreCampos."-user"] =  _cueUsernameRegistrado;
				$result["isOk"] = false;
				$error=1;
			}

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."email=%s AND ".$prefijo."id!=%s",
				GetSQLValueString($dataEmail ,"text"),
				GetSQLValueString($id ,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if ($row_sql[$prefijo."id"]){
				$result["error"][$nombreCampos."-email"] =  _cueUsernameRegistrado;
				$result["isOk"] = false;
				$error=1;
			}

			//Revisamos que las contraseñas coincidan
			if(($dataPassword != $dataPasswordrepeat) && ($dataPassword || $dataPasswordrepeat)){
				$result["error"][$nombreCampos."-password"] = _cuePasswordNoCoinciden;
				$result["isOk"] = false;
				$error=1;
			}

			if ($error == 0) {
				$sql = sprintf("UPDATE ".$tabla." 
										SET 
											".$prefijo."user=%s,
											".$prefijo."email=%s,
											".$prefijo."nombres=%s,
											".$prefijo."apellidos=%s,
											".$prefijo."telefono=%s,
											".$prefijo."celular=%s,
											".$prefijo."ocupacion=%s
										WHERE ".$prefijo."id=%s",
					GetSQLValueString($dataUser,"text"),
					GetSQLValueString($dataEmail, "text"),
					GetSQLValueString($dataNombres, "text"),
					GetSQLValueString($dataApellidos, "text"),
					GetSQLValueString($dataTelefono, "text"),
					GetSQLValueString($dataCelular, "text"),
					GetSQLValueString($dataOcupacion, "text"),
					GetSQLValueString($id, "int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);

				if ($dataPassword && $dataPasswordrepeat) {
					$sqlP = sprintf("UPDATE ".$tabla." 
											SET 
												".$prefijo."password=%s
											WHERE ".$prefijo."id=%s",
						GetSQLValueString(crypt($dataPassword),"text"),
						GetSQLValueString($id, "int")
					);
					$rs_sqlP = mysqli_query($_conection->connect(), $sqlP);
				}

				if ($rs_sql) {
					//Guardado
					$result["success"]["btn-editar-".$nombreCampos] = _informacionGuardada;

					//Eliminamos los anteriores registros de detalle cuenta
					$sql = sprintf("DELETE FROM a_tbl_cuentas_x_gruposeccion WHERE cgp_cue_id=%s",
						GetSQLValueString($id,"int")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);

					$select_group_seccion = "SELECT * FROM a_tbl_gruposeccion";
					$rs_group_seccion = mysqli_query($_conection->connect(), $select_group_seccion);
					//Recorremos todos las secciones que existen en la base de datos
					while ($row_group_seccion = mysqli_fetch_assoc($rs_group_seccion)) {
						$valor = 'check-'.$row_group_seccion["gp_id"];
						//Si el check fue marcado se guarda en la base de datos
						if($data[$valor]) {
							$insert_sql_detalle = sprintf("INSERT INTO a_tbl_cuentas_x_gruposeccion (cgp_cue_id, cgp_gp_id) VALUES (%s,%s)",
								GetSQLValueString($id,"int"),
								GetSQLValueString($row_group_seccion["gp_id"],"int")
							);
							$rs_insert_detalle = mysqli_query($_conection->connect(), $insert_sql_detalle);
						}
					}//
				}else{
					//Error sql
					$result["error"]["btn-editar-".$nombreCampos] = _errorSql;
				}
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina Editar Cuenta
}

//Devolvemos un arreglo con los datos
$response->result = $result;
echo json_encode($response);
//Cerramos conección con la Base de Datos
$_conection->desconnect();
?>