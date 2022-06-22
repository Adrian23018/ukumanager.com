<?php
error_reporting(0);
session_start();
// error_reporting(1);
// ini_set("display_errors", "1");

set_time_limit(0);
ini_set('memory_limit','1.01G');
ini_set('max_file_uploads','200');
ini_set('max_input_time','14400');
ini_set('post_max_size','1G');
ini_set('upload_max_filesize','999M');

if ($_SERVER['HTTP_HOST'] == 'localhost') {
	//Configuración para local
	define("_hostname", "localhost");
	define("_database", "bd_uku");
	define("_database_type", "mysqli");
	define("_charset", "utf8");
	define("_username", "root");
	define("_password", "");
}else{
	define("_hostname", "localhost");
	define("_database", "ukulat_bd");
	define("_database_type", "mysqli");
	define("_charset", "utf8");
	define("_username", "ukulat_user");
	define("_password", "Ak32sj#s@");
}

//Conectarse a la Base de Datos
require 'clases/bd_conection.php';
//Variable de conección
$_conection  = new _conection;
$_connect  = new _conection;
$_conexion = $_conection->connect();

$puertoHttp = 'https://';

require 'configVariables.php';
require 'configFunciones.php';
require 'configSEO.php';
require 'clases/medoo.php';

require 'stripe-pagos/stripe.php';
require dirname( __FILE__ ).'/../../webservices/_functions/funciones_uku.php';

//header('Content-Type: application/json');

/*$database = new medoo([
	// required
	'database_type' => _database_type,
	'database_name' => _database,
	'server' => _hostname,
	'username' => _username,
	'password' => _password,
	'charset' => _charset
]);*/

?>