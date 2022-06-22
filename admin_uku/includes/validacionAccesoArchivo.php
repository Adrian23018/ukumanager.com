<?php
	//si existe pagina validamos que el usuario tenga permiso sobre ella
	if (isset($_GET['page'])) {
		//$_SESSION[_sessionAdmin];
		//Por defecto no tiene acceso al contenido del archivo
    	$acceso_archivo = false;

    	//Traemos datos del usuario logueado
		if (isset($_SESSION[_sessionAdmin])) {
			
			$sql = 	sprintf("SELECT * FROM a_tbl_cuentas_x_gruposeccion AS cgp 
								INNER JOIN a_tbl_seccion AS sec ON cgp_gp_id=sec_gp_id
								WHERE cgp_cue_id=%s",
						GetSQLValueString($_SESSION[_sessionAdmin], "int")
					);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			//Si no existe error al hacer el sql
			if ($rs_sql) {
				while ( $row_sql = mysqli_fetch_assoc($rs_sql) ) {
					//Revisamos que el usuario tenga acceso al archivo o sección
					if (strtolower(utf8_encode($row_sql["sec_page"])) == strtolower($_GET["page"])){
						$acceso = true;
						break;
					}
				}
			}
			
			if (!$acceso) {
				//Error 404
				echo '<script type="text/javascript"> window.location = "inicio.php?error=404"; </script>';
			}
		}else{
			//Redireccionar por que no está logueado
			echo '<script type="text/javascript"> window.location = "index.php"; </script>';
		}
	}
?>