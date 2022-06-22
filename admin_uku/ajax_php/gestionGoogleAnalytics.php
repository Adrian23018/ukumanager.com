<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	//formTraerDatos
	if($_POST['tipo'] == 'formTraerDatos') {
		if(validarLogueado($_conection)){
			
			//Obtener Id del Usuario
			$id = (int)$_POST["idSeccion"];

			$variables = $_POST['variables'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
				GetSQLValueString($id,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			$result["googleanalytics"]= utf8_encode($row_sql[$prefijo."texto"]);
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina formTraerDatos

	//formEditarGoogleAnalytics
	if($_POST['tipo'] == 'formEditarGoogleAnalytics') {
		if(validarLogueado($_conection)){
			
			//Obtener Id del Usuario
			$id 				= (int)$_POST["idSeccion"];
			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$googleanalytics 	= $data["googleanalytics"];

			$variables = $_POST['variables'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=%s",
				GetSQLValueString($id,"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$row_sql = mysqli_fetch_assoc($rs_sql);
			if ($row_sql[$prefijo."id"]) {
				$sql = sprintf("UPDATE ".$tabla." SET ".$prefijo."texto=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString(utf8_decode($googleanalytics),"text"),
					GetSQLValueString(utf8_decode($id), "int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
			}else{
				$sql = sprintf("INSERT INTO ".$tabla." (".$prefijo."texto, ".$prefijo."id) VALUES (%s, %s)",
					GetSQLValueString(utf8_decode($googleanalytics),"text"),
					GetSQLValueString(utf8_decode($id), "int")
				);
				$rs_sql = mysqli_query($_conection->connect(), $sql);
			}

			$result['googleanalytics'] = '';
			if ($rs_sql) {
				$result['googleanalytics'] = $googleanalytics;
			}
		}else{
			//Si no se encuentra logueado, no sabemos como llegó acá
			exit();
		}
	}
	//Termina formEditarGoogleAnalytics
	
}

//Devolvemos un arreglo con los datos
$response->result = $result;
echo json_encode($response);
//Cerramos conección con la Base de Datos
$_conection->desconnect();
?>