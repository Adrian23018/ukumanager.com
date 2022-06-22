<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
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

			$result[$nombreCampos."-nombre"] = utf8_encode($row_sql[$prefijo.'nombre']);
			$result[$nombreCampos."-nombre_en"] = utf8_encode($row_sql[$prefijo.'nombre_en']);
			$result[$nombreCampos."-link"] = utf8_encode($row_sql[$prefijo.'link']);

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

	if($_POST['tipo'] == 'formEditarMenu'){
		
		if(validarLogueado($_conection)){
			$id = (int)$_POST["idSeccion"];

			//Convertir serialize en arreglo.
			parse_str($_POST['data'], $data);
			$variables 		= $_POST['variables'];
			$tabla 			= $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo 		= $variables['dbPrefijo'];
			$nombreCampos 	= $variables['nombreCampos'];

			$dataNombre			= 	utf8_decode($data[$nombreCampos."-nombre"]);
			$dataNombre_en		= 	utf8_decode($data[$nombreCampos."-nombre_en"]);
			$dataLink			= 	utf8_decode($data[$nombreCampos."-link"]);

			//Definimos variables a devolver
			$result['id'] = '';

			$result["error"][$nombreCampos."-nombre"] 			= '';
			$result["error"][$nombreCampos."-nombre_en"] 			= '';
			$result["error"][$nombreCampos."-link"] 			= '';

			$result["success"]["btn-editar-".$nombreCampos] 	= '';

			$result["isOk"] = true;

			//Verificamos que no se encuentre vacio algunos campos
			if($dataNombre == ""){
				$result["error"][$nombreCampos."-nombre"] = _campoVacio;
				$result["isOk"] = false;
				$error=1;
			}

			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s AND ".$prefijo."id!=%s ",
				GetSQLValueString($_SESSION[_sessionIdioma],"int"),
				GetSQLValueString($id ,"int")
			);
			//verificar que nombre no se encuentre en la base de  datos
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while($row_sql = mysqli_fetch_assoc($rs_sql)){
				if (CamellizarConGuiones($row_sql[$prefijo."nombre"]) == CamellizarConGuiones($dataNombre)) {
					$result["error"][$nombreCampos."-nombre"] =  _cueUsernameRegistrado;
					$result["isOk"] = false;
					$error=1;
					break;
				}
			}

			if ($error == 0) {
				$sql = sprintf("	UPDATE ".$tabla." 
										SET
											".$prefijo."nombre=%s,
											".$prefijo."link=%s
										WHERE 
											".$prefijo."id=%s",
					GetSQLValueString($dataNombre,"text"),
					GetSQLValueString($dataLink,"text"),
					GetSQLValueString($id ,"int")
				);
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