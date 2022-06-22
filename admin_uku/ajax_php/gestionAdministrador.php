<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Para ejecutar las funciones en éste archivo, no necesita estar logueado.

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	//Generar Contraseña Con Crypt
	if ($_POST['tipo'] == 'generarContrasena') {
		sleep(2);
		$result['passwordCrypt'] = '';
		$result['error']['login-password'] = '';

		//Validamos que envie la variable @login-password
		if ($_POST["login-password"]) {
			$result['passwordCrypt'] = crypt($_POST["login-password"]);
		}else{
			//Devolvemos Error
			$result['error']['login-password'] = _campoVacio;
		}
	}//Termina generarContrasena

	//Loguearse al administrador
	if($_POST['tipo'] == "formLoguearse"){
		sleep(2);
		//Datos variables post
		$username = $_POST['login-username'];
		$password = $_POST['login-password'];

		//Definimos variables a devolver
		$result["error"]["login-username"] = '';
		$result["error"]["login-password"] = '';
		$result["error"]["login-btn"] = '';
		$result["url"] = '';

		$result["isOk"] = true;

		//Validamos que los campos estén llenos
		if($username!="" && $password!=""){
			$sql = 	sprintf("SELECT * FROM a_tbl_cuentas 
								WHERE cue_user=%s OR cue_email=%s AND cue_estado=1",
						GetSQLValueString(utf8_decode($username), "text"),
						GetSQLValueString(utf8_decode($username), "text")
					);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			if ($rs_sql) {
				$row_sql = mysqli_fetch_assoc($rs_sql);

				//Verificar que se encuentre el usuario
				if(!$row_sql["cue_user"]){
					//Error no se encuentra en la base de datos el usuario
					$result["isOk"] = false;
					$result["error"]["login-username"] = _cueUsernameNoRegistrado;
				}else{
					//Traemos la contraseña para verificación
					$password_hash = $row_sql["cue_password"];

					//Validamos la contraseña
					if(crypt($password, $password_hash) == $password_hash) {
						//Inicializamos variable de sessión
						$_SESSION[_sessionAdmin] = $row_sql['cue_id'];
						//Devolvemos url para redireccionar al usuario
						$result["url"] = 'inicio.php';
					}else{
						//Contraseña invalida
						$result["isOk"] = false;
						$result["error"]["login-password"] = _cuePasswordIncorrecto;
					}
				}
			}else{
				$result["error"]["login-btn"] = _errorSql;
			}			
		}else{
			$result["isOk"] = false;
			//Si no escribió el usuario
			if($username==""){
				$result["error"]["login-username"] = _campoVacio;
			}
			
			//Si no escribió la contraseña
			if($password==""){
				$result["error"]["login-password"] = _campoVacio;
			}	
		}
	}//Termina Loguearse administrador

	if ($_POST['tipo']=='formRecuperarClave') {
		sleep(2);
		//Datos variables post
		$username = $_POST['recuperar-email'];

		//Definimos variables a devolver
		$result["error"]["recuperar-email"] = '';
		$result["error"]["recuperar-btn"] = '';

		$result["success"]["recuperar-btn"] = '';
		$result["correo"] = '';

		$sql = 	sprintf("SELECT * FROM a_tbl_pagina WHERE pag_id=1");
		$rs_sql = mysqli_query($_conection->connect(), $sql);
		$row_pagina = mysqli_fetch_assoc($rs_sql);
		$nombreadministrador = explode("|",utf8_encode($row_pagina["pag_titulo"]));
		$nombreadministrador = $nombreadministrador[1];
		$logoadministador =  "http://" . $_SERVER["SERVER_NAME"] ."/"._carpetaAdministrador."/img/".utf8_encode($row_pagina["pag_logo"]);

		$result["isOk"] = true;
		if ($username) {
			$sql = 	sprintf("SELECT * FROM a_tbl_cuentas 
								WHERE cue_email=%s",
								GetSQLValueString(utf8_decode($username), "text")
					);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			if ($rs_sql) {
				$row_cuenta = mysqli_fetch_assoc($rs_sql);

				if ($row_cuenta["cue_email"])
					$encontroUser = true;

				//Generamos Nueva Contraseña y la enviamos al correo
				$correo = explode("@", $row_cuenta["cue_email"]);
				$p_correo = $correo[0];
				$primera_parte = $p_correo[0].$p_correo[1]."*****";
				$s_correo = $correo[1];
				$res = explode(".", $s_correo);
				$extension = $res[count($res)-1];
				$penultimo = $res[count($res)-2];
				$segunda_parte = $s_correo[0].$s_correo[1]."**".$penultimo[strlen($penultimo)-1].".".$extension;

				//Generamos nueva contraseña
				$nueva_clave = date('ihjk32');
				if (preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#", $row_cuenta["cue_email"]))
				{
					//Enviamos correo

					//Incluimos librería para enviar correos
					require_once("../phpMailer/class.phpmailer.php");

					$mail=new PHPMailer();

					$mail->CharSet='UTF-8';
					//Correo al que se envia el mensaje
					$mail->SetFrom('soporte@ukumanager.com');
					$mail->AddAddress($row_cuenta["cue_email"]);

					//Configuración Correo
					$mail->isSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'soporte@ukumanager.com';
					$mail->Password = 'nzfyvxmyyxzbdjkg';
					$mail->Port = '587';
					$mail->SMTPSecure = "tls";

					$mail->Subject = _subject_email;
					$mail->MsgHTML(include("../includes/template/recuperarClave.php"));

					if($mail->Send()){
						//Si se envió el correo correctamente
						$result["correo"] = $primera_parte."@".$segunda_parte;

						//Reseteamos la contraseña
						$sql = 	sprintf("UPDATE a_tbl_cuentas 
											SET cue_password=%s
											WHERE cue_email=%s",
									GetSQLValueString(crypt($nueva_clave), "text"),
									GetSQLValueString(utf8_decode($username), "text")
								);
						$rs_sql = mysqli_query($_conection->connect(), $sql);
						if ($rs_sql)
							$result["success"]['recuperar-btn'] = _msg_sendOkRecuperarClave;
						else
							$result["success"]['recuperar-btn'] = _errorSql;
					}else{
						$result["isOk"] = false;
						$result["error"]['recuperar-btn'] = _msg_sendErrorRecuperarClave;
					}
				}
			}

			if (!$encontroUser) {
				//Error no se encuentra en la base de datos el usuario
				$result["isOk"] = false;
				$result["error"]["recuperar-email"] = _cueUsernameNoRegistrado;
			}

		}else{
			$result["isOk"] = false;
			//Si no escribió el usuario
			if($username==""){
				$result["error"]["recuperar-email"] = _campoVacio;
			}
		}
	}//Termina Recuperar Contraseña

}

//Devolvemos un arreglo con los datos
$response->result = $result;
echo json_encode($response);
//Cerramos conección con la Base de Datos
$_conection->desconnect();
?>