<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

if(validarLogueado($_conection) && ($_SESSION[_sessionAdmin] == 1)) {
	$path = _pathBackups;

	set_time_limit(0);
	ini_set('memory_limit','3000M');
	ini_set('max_file_uploads','200');

	$value = $_GET['archivo'];
	$nombreCarpeta = explode(".zip", $value);
	$archive_name = $path.$nombreCarpeta[0].'/'.$value;
	download_file($archive_name, $value);
}else{
	//Si no se encuentra logueado, no sabemos como llegó acá
	exit();
}
?>