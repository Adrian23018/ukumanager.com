<?php
session_start();

//Configuracion
require '../includes/autoloader.php';

//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if(validarLogueado($_conection)){
		
		$path = _pathBackups;

		if ($_POST['tipo'] == 'mostrar-backups') {
			$arrayZips = revisarZip($path, $arrayZips);
			foreach ($arrayZips as $key => $value) {
				$nombreCarpeta = explode(".zip", $value);
				$peso = formatBytes(filesize($path.$nombreCarpeta[0].'/'.$value));
				$archivosZip .= '<tr class="">
									<td>
										 '.$value.'
									</td>
									<td>
										 '.$peso.'
									</td>
									<td class="hidden-480 text-center">
										 <a href="javascript:;" class="js-descargar-backup" data-archivo="'.$value.'"><i class="fa fa-download font-blue"></i></a>
									</td>
									<td class="text-center">
										<a href="javascript:;" class="js-eliminar-backup" data-archivo="'.$value.'"><i class="fa fa-trash font-red"></i></a>
									</td>
								</tr>';
			}

			$result['backups'] = $archivosZip;
		}// Termina mostrar-backups
		
		if ($_POST['tipo'] == 'eliminar-backup') {
			$result['isOk'] = '';
			$value = $_POST['archivo'];
			$nombreCarpeta = explode(".zip", $value);
			eli_archivos($path.$nombreCarpeta[0]);
			$result['isOk'] = true;
		}

		if ($_POST['tipo'] == 'mostrar-datos') {
			$urlpagina = getcwd();
			$urlpagina = str_replace(_carpetaAdministrador.'/ajax_php', '', $urlpagina);

			$result['espacio-total-disco'] = formatBytes(disk_total_space("/"));
			$result['espacio-libre-disco'] = formatBytes(disk_free_space("/"));
			$result['espacio-pagina'] = formatBytes( dirSize ($urlpagina, 0) );
			$result['contador-archivos'] = contar_archivos ( $urlpagina , 0);
		}

		if ($_POST['tipo'] == 'generar-backup') {
			require_once('../includes/backup_restore.class.php');
			set_time_limit(0);
			ini_set('memory_limit','1.01G');
			ini_set('max_file_uploads','200');
			ini_set('max_input_time','14400');
			ini_set('post_max_size','1G');
			ini_set('upload_max_filesize','999M');

			$db_host = _hostname;
			$db_user = _username;
			$db_pass = _password;
			$db_name = _database;

			$path = _pathBackups;

			if (file_exists($path)) {
				$hora = date("Y-m-d_H-i-s");
				$nombreProyecto = "backup--";
				$nombreCarpeta = $nombreProyecto.$hora.'/';
				$pathCarpeta = $path.$nombreCarpeta;
				mkdir($pathCarpeta, 0777);

				$urlpagina = getcwd();
				$urlpagina = str_replace(_carpetaAdministrador.'/ajax_php', '', $urlpagina);

				$archive_name = $pathCarpeta.$nombreProyecto.$hora.".zip"; // name of zip file
				$archive_folder = $urlpagina; // the folder which you archivate

				$zip = new ZipArchive; 
				if ($zip -> open($archive_name, ZipArchive::CREATE) === TRUE){
					$dir = preg_replace('/[\/]{2,}/', '/', $archive_folder."/");

					//Añadimos Base De Datos
					$newImport = new backup_restore($db_host,$db_name,$db_user,$db_pass,$pathCarpeta);
					$newImport -> backup();
					$zip -> addFile($pathCarpeta."/".'database_' . _database . '.sql', 'database_' . _database . '.sql');
					
					//Añadimos Carpeta Página			
					crearZip($archive_folder, $zip);

					$zip -> close(); 
					$result['success'] = _successZip;
				}else{ 
					$result['error'] = _errorZip;
				}
			}
		}
	}else{
		//Si no se encuentra logueado, no sabemos como llegó acá
		exit();
	}
}

//Devolvemos un arreglo con los datos
$response->result = $result;
echo json_encode($response);
//Cerramos conección con la Base de Datos
$_conection->desconnect();
?>