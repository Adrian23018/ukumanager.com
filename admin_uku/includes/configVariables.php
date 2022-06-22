<?php
	//Variables de Configuración PHPMAILER
	define('_smtp_host', 'ssl://smtp.gmail.com');
	define('_smtp_username', 'form1@myinc.me');
	define('_smtp_password', 'marketeam');
	define('_smtp_port', '465');
	define('_smtp_secure', 'ssl'); //ssl or tls

	//define('_smtp_host', 'smtp.gmail.com');
	//define('_smtp_username', 'correophpmailerdesarrollador@gmail.com');
	//define('_smtp_password', 'correophpmailerdesarrollador123');
	//define('_smtp_port', '465');
	//define('_smtp_secure', 'ssl'); //ssl or tls

	//Variables para el PHPMAILER
	define('_from_name', '');
	define('_from_email', 'correophpmailerdesarrollador@gmail.com');
	define('_subject_email', 'Recuperar Contraseña');

	//path backups
	// /home/etc/backups/
	define('_pathBackups', ''); 
	define('_carpetaAdministrador', 'admin_uku');
	// define('_carpetaAdministrador_global', 'uku/uku_web/');
	define('_carpetaAdministrador_global', '');
	
	$arrayMesesGlobal = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' );
	$arrayMesesGlobalAb = array('', 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC' );

	// $fechaReferencia = "2018-05-13 07:48:00 PM";
	$fechaReferencia = "2021-09-14 04:23:00 PM";
	$fechaActual = "Y-m-d  h:i:s A";

	$array_dias['Sunday'] = 7;
	$array_dias['Monday'] = 1;
	$array_dias['Tuesday'] = 2;
	$array_dias['Wednesday'] = 3;
	$array_dias['Thursday'] = 4;
	$array_dias['Friday'] = 5;
	$array_dias['Saturday'] = 6;

	//Define Payu.
	$sqlPayu = sprintf("SELECT * FROM 
								tbl_payu 
							WHERE 
								py_id=1");
	$rs_sqlPayu = mysqli_query($_conection->connect(), $sqlPayu);
	$row_sqlPayu = mysqli_fetch_assoc($rs_sqlPayu);
	// define('ApiKey', '4Vj8eK4rloUd272L48hsrarnUA');
	// define('merchantId', '508029');
	// define('currency', 'COP');
	// define('apiLogin', 'pRRXKOl8ikMmt9u');
	// define('accountId', '512321');
	// define('payuUrl', 'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi');
	if ($row_sqlPayu["py_test"] == 1) {
		$check = 'checked';

		define('ApiKey', $row_sqlPayu["py_test_apikey"]);
		define('merchantId', $row_sqlPayu["py_test_idcomercio"]);
		define('currency', $row_sqlPayu["py_test_currency"]);
		define('apiLogin', $row_sqlPayu["py_test_apilogin"]);
		define('accountId', $row_sqlPayu["py_test_accountid"]);
		define('payuUrl', $row_sqlPayu["py_test_url"]);
		define('test', true);
	}else{
		define('ApiKey', $row_sqlPayu["py_apikey"]);
		define('merchantId', $row_sqlPayu["py_idcomercio"]);
		define('currency', $row_sqlPayu["py_currency"]);
		define('apiLogin', $row_sqlPayu["py_apilogin"]);
		define('accountId', $row_sqlPayu["py_accountid"]);
		define('payuUrl', $row_sqlPayu["py_url"]);
		define('test', false);
	}

	$erroresStripe = array(
	      'incorrect_number' => "El número de tarjeta es incorrecto.",
	      'invalid_number' => "El número de tarjeta no es un número de tarjeta válido.",
	      'invalid_expiry_month' => "El mes de caducidad de la tarjeta no es válido.",
	      'invalid_expiry_year' => "El año de caducidad de la tarjeta no es válido.",
	      'invalid_cvc' => "El código de seguridad de la tarjeta no es válido.",
	      'expired_card' => "La tarjeta ha caducado.",
	      'incorrect_cvc' => "El código de seguridad de la tarjeta es incorrecto.",
	      'incorrect_zip' => "Falló la validación del código postal de la tarjeta.",
	      'card_declined' => "La tarjeta ha sido rechazada.",
	      'missing' => "El cliente al que se está cobrando no tiene tarjeta",
	      'processing_error' => "Ocurrió un error procesando la tarjeta.",
	      'rate_limit' =>  "Ocurrió un error debido a consultar la API demasiado rápido. Por favor, avísanos si recibes este error contínuamente."
	);

	//Api key de Firebase
	define( 'API_ACCESS_KEY', 'AIzaSyBkRPt66TMEHVH9XeEdauXgap8Zm7mTg9Q' );
	
    //Password Compras Apple Pay
    define( '_Password_Apple_Pay', 'a75cb78a2f744254a429e7a9f14512a2' );

	define('_SECRET_TOKEN', 'ukuapp');

	//RecuperarClave
	define('_msg_sendOkRecuperarClave', 'Se ha enviado la contraseña al correo.');
	define('_msg_sendErrorRecuperarClave', 'Lo siento, no se ha podido enviar el mensaje.');

	//Variable ir al sitio
	define('_titulo_verpagina', 'Ir al Sitio');

	//Variables Globales
	define('_campoVacio', 'Este campo es requerido');
	define('_informacionEditada', 'Se han guardado los cambios satisfactoriamente');
	define('_informacionGuardada', 'Se han guardado los datos satisfactoriamente');
	define('_errorCampoEmail', 'Por favor ingrese y valide su Email.');
	define('_errorCampoPrecio', 'Por favor ingrese y valide el Precio.');
	define('_errorCampoCuota', 'Por favor ingrese y valide la Cuota.');
	define('_errorCampoGeneral', 'Todos los campos con * son obligatorios.');
	define('_errorMaximoEspeciales', 'Solo se permiten 3 productos especiales por distribuidor');
	define('_errorMaximoDestacados', 'Solo se permiten 5 productos destacados por distribuidor');

	define('_errorSql', 'Error, al momento de hacer la consulta');
	define('_errorArchivo', 'Error, el archivo ya existe');
	define('_errorCampoInvalido', 'Error, Campo Inválido');
	define('_errorExtension', 'Error, La extension es invalida');

	define('_successZip', '¡Bien hecho!, se ha creado el archivo con extensión .zip');
	define('_errorZip', '¡Error!, No se ha podido crear el archivo con extensión .zip');

	//Variables para la Cuenta
	define('_cueUsernameRegistrado', 'Error, ya se encuentrado registrado en nuestra base de datos.');
	define('_cuePasswordNoCoinciden', 'Error, las contraseñas no coinciden.');
	define('_cueUsernameNoRegistrado', 'Error, el usuario no se encuentra registrado en nuestra base de datos.');
	define('_cuePasswordIncorrecto', 'Error, por favor vuelve a introducir su contraseña.');
	
	//Variable de sessión 	
	define('_sessionAdmin', 'INC_admin_prueba');
	define('_sessionIdioma', '4d3l3_adele_idioma');
	define('_sessionNoExiste', 'Error, No existe usuario logueado');

	define('_carpetaImagenesGlobal', 'imagenes-contenidos');
	//Carpetas
	define('_carpetaA', '../img/');
	define('_carpetaG', '');
	define('_carpetaN', '../../imagenes-contenidos/');

	define('_carpetaMostrarA', 'img/');
	define('_carpetaMostrarG', '');
	define('_carpetaMostrarN', '../imagenes-contenidos/');

	$arrayParentesco = array('Padre', 'Madre', 'Hermanos', 'Hijos', 'Abuelos');
	
	$arrayColores = array("F44336", "9C27B0", "673AB7", "3F51B5", "2196F3", "03A9F4", "00BCD4", "009688", "4CAF50", "8BC34A", "CDDC39", "FFEB3B", "FFC107", "FF9800", "FF5722", "795548", "607D8B", "9CCC65", "26C6DA", "E53935", "AB47BC", "FFCA28", "8D6E63", "BDBDBD", "D4E157", "D4E157", "4DB6AC", "9FA8DA", "2196F3", "03A9F4", "00BCD4", "009688", "4CAF50");
	$arrayLetras = array('a' => $arrayColores[0],'b' => $arrayColores[1],'c' => $arrayColores[2],'d' => $arrayColores[3],'e' => $arrayColores[4],'f' => $arrayColores[5],'g' => $arrayColores[6],'h' => $arrayColores[7],'i' => $arrayColores[8],'j' => $arrayColores[9],'k' => $arrayColores[10],'l' => $arrayColores[11],'m' => $arrayColores[12],'n' => $arrayColores[13],'ñ' => $arrayColores[14],'o' => $arrayColores[15],'p' => $arrayColores[16],'q' => $arrayColores[17],'r' => $arrayColores[18],'s' => $arrayColores[19],'t' => $arrayColores[21],'u' => $arrayColores[22],'v' => $arrayColores[23],'w' => $arrayColores[24],'x' => $arrayColores[25],'y' => $arrayColores[26],'z' => $arrayColores[27] );
?>