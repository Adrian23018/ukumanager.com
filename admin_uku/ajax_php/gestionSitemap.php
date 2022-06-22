<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if($_POST['tipo'] == 'generarSitemap'){
		
		if(validarLogueado($_conection)){
			$result['isOk'] = true;
			/*Ejemplo sección noticias*/
			
			/*$select_nts = "SELECT * FROM tbl_noticias WHERE nts_estado=1 ORDER BY nts_posicion ASC";
			$rs_nts = mysqli_query($select_nts, $_connect->connect());
			while($row_nts = mysqli_fetch_assoc($rs_nts)){
				$nts_id = utf8_encode($row_nts["nts_id"]);
				$nts_nombre = utf8_encode($row_nts["nts_nombre"]);
				$urls_sitemap .= '<url><loc>http://pagina.com.co/noticias-detalle/'.$nts_id.'/'.CamellizarConGuiones($nts_nombre).'</loc><changefreq>daily</changefreq></url>
	';
			}*/

			$contenidoXML = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

	<url><loc>http://pagina.com.co/inicio</loc><changefreq>daily</changefreq></url>

	'.$urls_sitemap.'
</urlset>
			';

			$archivoXML = "../../sitemap.xml";
			$f = fopen($archivoXML,"w");
			if($f){
				fwrite($f,utf8_decode($contenidoXML));
				fclose($f);
			}else{
				$result['isOk'] = false;
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