<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

	// ...
	// SERVER CODE that processes ajax upload and returns a JSON response. Your server action 
	// must return a json object containing initialPreview, initialPreviewConfig, & append.
	// An example for PHP Server code is mentioned below.
	// ...

	//Valores Extras
	/*
		@tipoArchivo:
			{ 1: ['jpg', 'png', 'gif']}
		@tipoTable
			{ 'a_' , '', 'g_' }
		@table string con el resto de la tabla
		@prefijoTable string con el prefijo de la tabla
		@idTable int de la tabla
		@archivosPermitidos int o vacio 
			//Revisamos si ya existe un archivo lo reemplazamos
	*/
	$tipoArchivo = $_POST['tipoArchivo'];
	$tipoTable = $_POST['tipoTable'];
	$table = $_POST['table'];
	$prefijoTable = $_POST['prefijoTable'];
	$idTable = $_POST['idTable'];
	$archivosPermitidos = $_POST['archivosPermitidos'];
	$idNombre = $_POST['idNombre'];

	//Valores Devueltos
	$error = '';
	$errorkeys = '';
	//$p1 = $p2 = $errorExtension = [];

	if (!$table) {
		$error .= 'No se ha configurado la tabla en la base de datos<br>';
	}else{
		$carpeta = $table;
		//Revisamos carpeta donde se guardará el archivo
		if ($tipoTable == 'a_') {
			$pathFile = _carpetaA;
		}elseif ($tipoTable == 'g_') {
			$pathFile = _carpetaG;
		}else{
			$pathFile = _carpetaN;
		}

		//Creamos Carpeta Global
		if(!file_exists($pathFile.$carpeta) && $carpeta){
			mkdir($pathFile.$carpeta,0777);
		}

		$pathFile = $pathFile.$carpeta.'/'.$idTable;

		//Creamos Carpeta Archivo
		if(!file_exists($pathFile) && $idTable){
			mkdir($pathFile,0777);
		}

		if(!file_exists($pathFile)){
			$error .= 'No se ha configurado la carpeta donde se guardará el archivo <br>';	
		}
	}

	if ( $tipoArchivo == 1 ) {
		$fileExtension = array("jpg", "png", "gif");
		$prefijoTable = 'img_';
		$tablebd = 'g_tbl_imagenes';
		$value = 'archivos';
	}elseif ( $tipoArchivo == 2 ) {
		$fileExtension = array('pdf','xls','xlsx','doc','docx','ppt','pptx');
		$prefijoTable = 'arc_';
		$tablebd = 'g_tbl_archivos';
		$value = 'archivos_descargas';
	}else{
		$error .= 'No se ha configurado el tipo de archivo a subir <br>';
	}

	if ($idNombre == 'name') {
		$value .= $idTable;
	}

	if (!$idTable) {
		$error .= 'No se ha configurado el id de la tabla';
	}

	if (empty($_FILES[$value]['name'])) {
		echo '{}';
		return;
	}

	for ($i = 0; $i < count($_FILES[$value]['name']); $i++) {
		$uniqid = '';
		
		$nombreOriginal = $_FILES[$value]['name'][$i];
		$extensionOriginal = strtolower(end(explode('.', $nombreOriginal)));
		$uniqid = uniqid();
		$fileName = $uniqid . '.' . $extensionOriginal;

		if ( in_array($extensionOriginal, $fileExtension) ) {
			//Guardamos el archivo
			if (move_uploaded_file($_FILES[$value]['tmp_name'][$i], $pathFile.DIRECTORY_SEPARATOR.$fileName)) {
				//Eliminamos el archivo que se encuentra en la base de datos, si solo se permite un archivo por carpeta
				if($archivosPermitidos == 1 ){
					//Buscamos el archivo anterior
					$sql = sprintf("SELECT * FROM ".$tablebd." 
										WHERE 
											".$prefijoTable."tabla=%s AND 
											".$prefijoTable."id_tabla=%s AND 
											(".$prefijoTable."tipo_tabla=%s OR ".$prefijoTable."tipo_tabla IS NULL)",
							GetSQLValueString($table,"text"),
							GetSQLValueString($idTable,"int"),
							GetSQLValueString($tipoTable,"text")
					);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
					$row_sql = mysqli_fetch_assoc($rs_sql);

					if (!$row_sql[$prefijoTable.'nombre']) {
						$insert = true;
					}else{
						$nombre = $row_sql[$prefijoTable.'nombre'];
						$ext = $row_sql[$prefijoTable.'extension'];
						unlink($pathFile.'/'.$nombre.'.'.$ext);

						if ( $tipoArchivo == 1 ){
							unlink($pathFile.'/thumbnail/'.$nombre.'.'.$ext);
							//Update
							$sql = sprintf("UPDATE ".$tablebd." 
										SET 
											".$prefijoTable."thumb=0, 
											".$prefijoTable."x='',
											".$prefijoTable."y='',
											".$prefijoTable."width='',
											".$prefijoTable."height='',
											".$prefijoTable."rotate='',
											".$prefijoTable."cropboxdata='',
											".$prefijoTable."canvasdata=''
										WHERE  
											".$prefijoTable."tabla=%s AND 
											".$prefijoTable."id_tabla=%s AND 
											(".$prefijoTable."tipo_tabla=%s OR ".$prefijoTable."tipo_tabla IS NULL)",
								GetSQLValueString($table,"text"),
								GetSQLValueString($idTable,"int"),
								GetSQLValueString($tipoTable,"text")
							);
							$rs_sql = mysqli_query($_conection->connect(), $sql);
						}
						
						//Update
						$sql = sprintf("UPDATE ".$tablebd." 
											SET 
												".$prefijoTable."nombre=%s, 
												".$prefijoTable."extension=%s
											WHERE  
												".$prefijoTable."tabla=%s AND 
												".$prefijoTable."id_tabla=%s AND 
												(".$prefijoTable."tipo_tabla=%s OR ".$prefijoTable."tipo_tabla IS NULL)",
									GetSQLValueString($uniqid,"text"),
									GetSQLValueString($extensionOriginal,"text"),
									GetSQLValueString($table,"text"),
									GetSQLValueString($idTable,"int"),
									GetSQLValueString($tipoTable,"text")
								);
						$rs_sql = mysqli_query($_conection->connect(), $sql);
					}
				}else{
					$insert = true;
				}

				if ($insert) {
					$sql = 	sprintf("INSERT INTO ".$tablebd." 
									(
										".$prefijoTable."tabla,
										".$prefijoTable."id_tabla,
										".$prefijoTable."tipo_tabla,
										".$prefijoTable."nombre,
										".$prefijoTable."extension
									) 
									VALUES (%s,%s,%s,%s,%s)",
								GetSQLValueString($table,"text"),
								GetSQLValueString($idTable,"int"),
								GetSQLValueString($tipoTable,"text"),
								GetSQLValueString($uniqid,"text"),
								GetSQLValueString($extensionOriginal,"text")
							);
					$rs_sql = mysqli_query($_conection->connect(), $sql);
				}

			} else {
				$error .= '';
			}

			@unlink($_FILES['file']['tmp_name'][$i]);
		}else{
			$errorExtension[] = $i;
		}

		//$j = $i + 1;
		//$key = $j;
		//$errorkeys[$i] = $i;
		//$url = '<your server action to delete the file>';
		//
		//	$p1[$i] = "<img src='http://path.to.uploaded.file/{$key}.jpg' class='file-preview-image'>";
		//	$p2[$i] = ['caption' => "Animal-{$j}.jpg", 'width' => '120px', 'url' => $url, 'key' => $key];
	}

	if ($error)
		$array_response['error'] = $error;
	
	if ($errorkeys) 
		$array_response['errorkeys'] = $errorkeys;

	if ($initialPreviewConfig) 
		$array_response['p2'] = $p2;

	if ($p1) 
		$array_response['initialPreview'] = $p1;

	if (true) 
		$array_response['append'] = true;
	// whether to append these configurations to initialPreview.
	// if set to false it will overwrite initial preview
	// if set to true it will append to initial preview
	// if this propery not set or passed, it will default to true.

	echo json_encode($array_response);
?>