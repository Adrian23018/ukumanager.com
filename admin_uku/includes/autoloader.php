<?php
echo "entro 1";
error_reporting(0);
session_start();
// error_reporting(1);
// ini_set("display_errors", "1");
echo "entro 2";

set_time_limit(0);
ini_set('memory_limit','1.01G');
ini_set('max_file_uploads','200');
ini_set('max_input_time','14400');
ini_set('post_max_size','1G');
ini_set('upload_max_filesize','999M');

echo "entro 3"."</br>";

if ($_SERVER['HTTP_HOST'] == 'localhost') {

	echo "entro 4"."</br>";
	//Configuración para local
	define("_hostname", "localhost");
	define("_database", "bd_uku");
	define("_database_type", "mysqli");
	define("_charset", "utf8");
	define("_username", "root");
	define("_password", "");
}else{
	echo "entro 5"."</br>";
	define("_hostname", "localhost");
	define("_database", "ukulat_bd");
	define("_database_type", "mysqli");
	define("_charset", "utf8");
	define("_username", "ukulat_user");
	define("_password", "Ak32sj#s@");
}
echo "entro 6"."</br>";
//Conectarse a la Base de Datos
require 'clases/bd_conection.php';
//Variable de conección
$_conection  = new _conection;
$_connect  = new _conection;
$_conexion = $_conection->connect();

$puertoHttp = 'https://';
echo "entro 7"."</br>";
require 'configVariables.php';
echo "entro 8"."</br>";
//require 'configFunciones.php';
echo "entro 9"."</br>";
require 'configSEO.php';
echo "entro 10"."</br>";
require 'clases/medoo.php';

echo "entro 11"."</br>";


require 'stripe-pagos/stripe.php';
echo "entro Todo 2"."</br>";
require dirname( __FILE__ ).'/../../webservices/_functions/funciones_uku.php';
echo "entro Todo"."</br>";
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