<?php
session_start();

//Configuracion
require '../includes/autoloader.php';
//Validamos que sea envio por AJAX

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if(validarLogueado($_conection)){
		//Configuración dataTable Cuentas
		if($_POST['tipo'] == 'formCargarCuentas'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Usuario';
			$result['rows']['thead'][] = 'Email';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$user = utf8_encode($row_sql[$prefijo."user"]);
				$email = utf8_encode($row_sql[$prefijo."email"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnEliminar($id);

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $user;
				$result['rows']['tbody'][$i][] = $email;
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina Configuración dataTable Cuentas


		//Configuración dataTable Grupo Seccion
		if($_POST['tipo'] == 'formCargarGrupoSeccion'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Current';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$current = utf8_encode($row_sql[$prefijo."current"]);
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				//$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnEliminar($id);

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $current;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina Configuración dataTable Grupo Seccion

		//Configuración dataTable Blogs
		if($_POST['tipo'] == 'formCargarBlogs'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			$atributoDataTable = $variables["atributoDataTable"];

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			if ($atributoDataTable) { $result['rows']['thead'][] = ' <div class="select-all-table"> <input class="uniform-checkbox-items select_all" name="select_all" value="1" type="checkbox"> </div> '; }
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción Corta';
			$result['rows']['thead'][] = 'Fecha';
			// $result['rows']['thead'][] = 'Destacado';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			if ($atributoDataTable) { $result['columnFilter']['aoColumns'][] = null; }
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			// $result['columnFilter']['aoColumns'][] = array(	'type' => "select",
			// 			'bRegex' => true, 
			// 			'values' => array(
			// 				array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
			// 				array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
			// 			));
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 9;
			$progressPestanasArray = array(
										'general' => 4,
										'posicionamiento' => 3,
										'imagenes' => 1,
										'imagenes_secundarias' => 1,
										'audios' => 1,
										'videos' => 1,
										'archivos' => 1,
										'txtbanner' => 1,
										'txtbanner2campos' => 1,
									);
			$progressCadaItem = 100/$progressPestanas;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);

				//Destacado
				// $destacado = $row_sql[$prefijo."destacado"];
				// $varDestacado = ($destacado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				// $destacado = $varDestacado.btnDestacado($destacado, $id);

				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnVistaPrevia($LinkPreview."vistaprevia/true/".$id."/".CamellizarConGuiones($nombre));
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if (strip_tags($row_sql[$prefijo."descripcion"]))
						$totalGeneral++;
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					if ($row_sql[$prefijo."fecha"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				if ($atributoDataTable) { $result['rows']['tbody'][$i][] = '<input class="uniform-checkbox-items" type="checkbox" name="items-check" value="'.$id.'">'; }
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion_corta;
				$result['rows']['tbody'][$i][] = $fecha;
				// $result['rows']['tbody'][$i][] = $destacado;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Blogs

		//Configuración dataTable formCargarBlogsServer
		if($_POST['tipo'] == 'formCargarBlogsServer'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción Corta';
			$result['rows']['thead'][] = 'Fecha';
			//$result['rows']['thead'][] = 'Destacado';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			// $result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						// 'bRegex' => true, 
						// 'values' => array(
							// array('value' => '^'.$labelEstado['on'].'', 'label' => $labelEstado['on']),
							// array('value' => '^'.$labelEstado['off'].'', 'label' => $labelEstado['off']),
						// ));
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
		}
		//Termina de configurar tabla Blog Server

		//Configuración dataTable Banner Principal
		if($_POST['tipo'] == 'formCargarBannerPrincipal'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$atributoDataTable = $variables["atributoDataTable"];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];


			$result['rows']['thead'][] = '';
			if ($atributoDataTable) { $result['rows']['thead'][] = ' <div class="select-all-table"> <input class="uniform-checkbox-items select_all" name="select_all" value="1" type="checkbox"> </div> '; }
			$result['rows']['thead'][] = 'Imagen';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			if ($atributoDataTable) { $result['columnFilter']['aoColumns'][] = null; }
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 3;
			$progressPestanasArray = array(
										'general' => 2,
										'imagenes' => 1,
										'txtbanner' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				//$email = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if ($row_sql[$prefijo."posiciontexto"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="30" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				if ($atributoDataTable) { $result['rows']['tbody'][$i][] = '<input class="uniform-checkbox-items" type="checkbox" name="items-check" value="'.$id.'">'; }
				$result['rows']['tbody'][$i][] = $imagen;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Banner Principal

		//Configuración dataTable formContactenos
		if($_POST['tipo'] == 'formCargarformContactenos'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Leído';
			$labelEstado['off'] = 'Sin leer';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Correo';
			$result['rows']['thead'][] = 'Teléfono';
			$result['rows']['thead'][] = 'Mensaje';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Visto';
			//$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => $labelEstado['on'], 'label' => $labelEstado['on']),
							array('value' => $labelEstado['off'], 'label' => $labelEstado['off']),
						));
			//$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$correo = utf8_encode($row_sql[$prefijo."correo"]);
				$telefono = utf8_encode($row_sql[$prefijo."telefono"]);
				$mobile = utf8_encode($row_sql[$prefijo."mobile"]);
				$direccion = utf8_encode($row_sql[$prefijo."direccion"]);
				$asunto = utf8_encode($row_sql[$prefijo."asunto"]);
				$mensaje = utf8_encode($row_sql[$prefijo."mensaje"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$visto = utf8_encode($row_sql[$prefijo."visto"]);
				$acciones = '';

				$variablesVer = array(
									'nombre' => quitar_comillas($nombre), 
									'correo' => quitar_comillas($correo), 
									'telefono' => quitar_comillas($telefono), 
									'mobile' => quitar_comillas($mobile), 
									'direccion' => quitar_comillas($direccion), 
									'asunto' => quitar_comillas($asunto), 
									'mensaje' => quitar_comillas($mensaje),
									'visto' => quitar_comillas($visto),
									'table-normal' => $variables['dbNombre'],
									'table-prefijo' => $variables['dbPrefijo']
								);
				//
				//Estado
				$varEstado = ($visto) ? '<a href="javascript:;" class="btn btn-xs btn-success"> '.$labelEstado['on'].' </a>' : '<a href="javascript:;" class="btn btn-xs btn-danger"> '.$labelEstado['off'].' </a>';
				$varEstado .= ($visto) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$visto = $varEstado;
				//$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnVer($variablesVer, $id);
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $correo;
				$result['rows']['tbody'][$i][] = $telefono;
				//el hidden es para que salga al exportar
				$result['rows']['tbody'][$i][] = substr($mensaje, 0, 15).'... <div class="hidden">'.$mensaje.'</div>';
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $visto;
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla formContactenos

		//Configuración dataTable formNewsletter
		if($_POST['tipo'] == 'formCargarformNewsletter'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Leído';
			$labelEstado['off'] = 'Sin leer';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Correo';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Leído';
			//$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => $labelEstado['on'], 'label' => $labelEstado['on']),
							array('value' => $labelEstado['off'], 'label' => $labelEstado['off']),
						));
			//$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$correo = utf8_encode($row_sql[$prefijo."correo"]);
				$telefono = utf8_encode($row_sql[$prefijo."telefono"]);
				$mobile = utf8_encode($row_sql[$prefijo."mobile"]);
				$direccion = utf8_encode($row_sql[$prefijo."direccion"]);
				$asunto = utf8_encode($row_sql[$prefijo."asunto"]);
				$mensaje = utf8_encode($row_sql[$prefijo."mensaje"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$visto = utf8_encode($row_sql[$prefijo."visto"]);
				$acciones = '';

				$variablesVer = array(
									'nombre' => quitar_comillas($nombre), 
									'correo' => quitar_comillas($correo),
									'visto' => quitar_comillas($visto),
									'table-normal' => $variables['dbNombre'],
									'table-prefijo' => $variables['dbPrefijo']
								);
				//
				//Estado
				$varEstado = ($visto) ? '<a href="javascript:;" class="btn btn-xs btn-success"> '.$labelEstado['on'].' </a>' : '<a href="javascript:;" class="btn btn-xs btn-danger"> '.$labelEstado['off'].' </a>';
				$visto = $varEstado;
				//$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnVer($variablesVer, $id);
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $correo;
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $visto;
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla formNewsletter

		//Configuración dataTable Fotos
		if($_POST['tipo'] == 'formCargarFotos'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción Corta';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 4;
			$progressPestanasArray = array(
										'general' => 4,
										'general_en' => 3,
										'posicionamiento' => 3,
										'imagenes' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $porcentajeGeneral_en = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if (strip_tags($row_sql[$prefijo."descripcion"]))
						$totalGeneral++;
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					if ($row_sql[$prefijo."fecha"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				if(isset($progressPestanasArray['general_en'])){
					$totalGeneral_en = 0;
					if ($row_sql[$prefijo."nombre_en"])
						$totalGeneral_en++;
					if (strip_tags($row_sql[$prefijo."descripcion_en"]))
						$totalGeneral_en++;
					if ($row_sql[$prefijo."descripcion_corta_en"])
						$totalGeneral_en++;
					$porcentajeGeneral_en = ($totalGeneral_en/$progressPestanasArray['general_en']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral_en * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion_corta;
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Fotos

		//Configuración dataTable Vídeos
		if($_POST['tipo'] == 'formCargarVideos'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción Corta';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 4;
			$progressPestanasArray = array(
										'general' => 4,
										'general_en' => 3,
										'posicionamiento' => 3,
										'videos' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $porcentajeGeneral_en = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if (strip_tags($row_sql[$prefijo."descripcion"]))
						$totalGeneral++;
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					if ($row_sql[$prefijo."fecha"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				if(isset($progressPestanasArray['general_en'])){
					$totalGeneral_en = 0;
					if ($row_sql[$prefijo."nombre_en"])
						$totalGeneral_en++;
					if (strip_tags($row_sql[$prefijo."descripcion_en"]))
						$totalGeneral_en++;
					if ($row_sql[$prefijo."descripcion_corta_en"])
						$totalGeneral_en++;
					$porcentajeGeneral_en = ($totalGeneral_en/$progressPestanasArray['general_en']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral_en * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion_corta;
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Vídeos

		//Configuración dataTable Audios
		if($_POST['tipo'] == 'formCargarAudios'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción Corta';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 4;
			$progressPestanasArray = array(
										'general' => 4,
										'general_en' => 3,
										'posicionamiento' => 3,
										'audios' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $porcentajeGeneral_en = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if (strip_tags($row_sql[$prefijo."descripcion"]))
						$totalGeneral++;
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					if ($row_sql[$prefijo."fecha"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				if(isset($progressPestanasArray['general_en'])){
					$totalGeneral_en = 0;
					if ($row_sql[$prefijo."nombre_en"])
						$totalGeneral_en++;
					if (strip_tags($row_sql[$prefijo."descripcion_en"]))
						$totalGeneral_en++;
					if ($row_sql[$prefijo."descripcion_corta_en"])
						$totalGeneral_en++;
					$porcentajeGeneral_en = ($totalGeneral_en/$progressPestanasArray['general_en']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral_en * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion_corta;
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Audios

		//Configuración dataTable Menu
		if($_POST['tipo'] == 'formCargarMenu'){
			$variables = $_POST['variables'];
			//
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Principal';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Estado';
			//$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			//$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				if (utf8_encode($row_sql[$prefijo."principal"]) == 1) {
					$principal = "-";
				}else{
					$sql2 = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."id=".$row_sql[$prefijo."asociado"]);
					$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
					$row_sql2 = mysqli_fetch_assoc($rs_sql2);
					$principal = utf8_encode($row_sql2[$prefijo."nombre"]);
				}
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				//$acciones .= btnEliminar($id);

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $principal;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $estado;
				//$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Menu

		//Configuración dataTable formCargarProductosPrincipal
		if($_POST['tipo'] == 'formCargarProductosPrincipal'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			$atributoDataTable = $variables["atributoDataTable"];

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			if ($atributoDataTable) { $result['rows']['thead'][] = ' <div class="select-all-table"> <input class="uniform-checkbox-items select_all" name="select_all" value="1" type="checkbox"> </div> '; }
			$result['rows']['thead'][] = 'Imagen';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción <br>Corta';
			$result['rows']['thead'][] = 'Ver Categorias <br>Secundarias';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			if ($atributoDataTable) { $result['columnFilter']['aoColumns'][] = null; }
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 7;
			$progressPestanasArray = array(
										'general' => 4,
										'posicionamiento' => 3,
										'imagenes' => 1,
										'audios' => 1,
										'videos' => 1,
										'archivos' => 1,
										'txtbanner' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnVistaPrevia($LinkPreview."vistaprevia/true/".$id."/".CamellizarConGuiones($nombre));
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if (strip_tags($row_sql[$prefijo."descripcion"]))
						$totalGeneral++;
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					if ($row_sql[$prefijo."fecha"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="70" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}
				$result['rows']['tbody'][$i][] = $posicion;
				if ($atributoDataTable) { $result['rows']['tbody'][$i][] = '<input class="uniform-checkbox-items" type="checkbox" name="items-check" value="'.$id.'">'; }
				$result['rows']['tbody'][$i][] = $imagen;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion_corta;
				$result['rows']['tbody'][$i][] = '<a class="btn btn-xs green margin-bottom-5" href="inicio.php?page='.$variables["nombreSeccionSub"].'&'.$prefijo.'id='.$id.'"><i class="fa fa-folder"></i> Categorias <br> Secundarias</a>';
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla ProductosCatPrincipal

		//Configuración dataTable formCargarProductosSecundaria
		if($_POST['tipo'] == 'formCargarProductosSecundaria'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];
			$prefijoAnt = $variables['dbPrefijoAnt'];
			$id_ant = $variables[$variables['dbPrefijoAnt'].'id'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Imagen';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción Corta';
			$result['rows']['thead'][] = 'Ver Productos';
			$result['rows']['thead'][] = 'Fecha';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo.$prefijoAnt."id=".$id_ant." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo.$prefijoAnt."id=".$id_ant." AND ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo.$prefijoAnt."id=".$id_ant." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 7;
			$progressPestanasArray = array(
										'general' => 4,
										'posicionamiento' => 3,
										'imagenes' => 1,
										'audios' => 1,
										'videos' => 1,
										'archivos' => 1,
										'txtbanner' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id."&".$prefijoAnt."id=".$id_ant);
				$acciones .= btnVistaPrevia($LinkPreview."vistaprevia/true/".$id."/".CamellizarConGuiones($nombre));
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if (strip_tags($row_sql[$prefijo."descripcion"]))
						$totalGeneral++;
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					if ($row_sql[$prefijo."fecha"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="70" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}
				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $imagen;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion_corta;
				$result['rows']['tbody'][$i][] = '<a class="btn btn-xs green margin-bottom-5" href="inicio.php?page='.$variables["nombreSeccionSub"].'&'.$prefijoAnt.'id='.$id_ant.'&'.$prefijo.'id='.$id.'"><i class="fa fa-folder"></i> Productos</a>';
				$result['rows']['tbody'][$i][] = $fecha;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla ProductosCatSecundaria

		//Configuración dataTable formCargarProductos
		if($_POST['tipo'] == 'formCargarProductos'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];
			$prefijoAnt = $variables['dbPrefijoAnt'];
			$prefijoAntAnt = $variables['dbPrefijoAntAnt'];
			$id_antant = $variables[$variables['dbPrefijoAntAnt'].'id'];
			$id_ant = $variables[$variables['dbPrefijoAnt'].'id'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Imagen';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Descripción Corta';
			$result['rows']['thead'][] = 'Fecha';
			//$result['rows']['thead'][] = 'Destacado';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			// $result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						// 'bRegex' => true, 
						// 'values' => array(
							// array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							// array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						// ));
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo.$prefijoAnt."id=".$id_ant." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo.$prefijoAnt."id=".$id_ant." AND ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo.$prefijoAnt."id=".$id_ant." ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 7;
			$progressPestanasArray = array(
										'general' => 4,
										'posicionamiento' => 3,
										'imagenes' => 1,
										'audios' => 1,
										'videos' => 1,
										'archivos' => 1,
										'txtbanner' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);
				
				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);

				//Destacados
				// $destacado = $row_sql[$prefijo."destacado"];
				// $varDestacado = ($destacado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				// $destacado = $varDestacado.btnDestacado($destacado, $id);

				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id."&".$prefijoAnt."id=".$id_ant."&".$prefijoAntAnt."id=".$id_antant);
				$acciones .= btnVistaPrevia($LinkPreview."vistaprevia/true/".$id."/".CamellizarConGuiones($nombre));
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if (strip_tags($row_sql[$prefijo."descripcion"]))
						$totalGeneral++;
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					if ($row_sql[$prefijo."fecha"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="70" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}
				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $imagen;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $descripcion_corta;
				$result['rows']['tbody'][$i][] = $fecha;
				//$result['rows']['tbody'][$i][] = $destacado;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Productos

		//Configuración dataTable Idioma
		if($_POST['tipo'] == 'formCargarIdioma'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Sigla';
			$result['rows']['thead'][] = 'Estado';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."estado_admin=1 ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."estado_admin=1 ORDER BY ".$prefijo."posicion ASC");
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$abreviacion = utf8_encode($row_sql[$prefijo."abreviacion"]);
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);

				//Destacado
				// $destacado = $row_sql[$prefijo."destacado"];
				// $varDestacado = ($destacado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				// $destacado = $varDestacado.btnDestacado($destacado, $id);

				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnVistaPrevia($LinkPreview);
				$acciones .= btnEliminar($id);

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="40" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $abreviacion;
				$result['rows']['tbody'][$i][] = $estado;

				$i++;
			}

		}
		//Termina de configurar tabla Idioma

		//Configuración dataTable Clientes
		if($_POST['tipo'] == 'formCargarClientes'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			$atributoDataTable = $variables["atributoDataTable"];

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			if ($atributoDataTable) { $result['rows']['thead'][] = ' <div class="select-all-table"> <input class="uniform-checkbox-items select_all" name="select_all" value="1" type="checkbox"> </div> '; }
			$result['rows']['thead'][] = 'Imagen';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Link';
			$result['rows']['thead'][] = 'Fecha';
			// $result['rows']['thead'][] = 'Destacado';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			if ($atributoDataTable) { $result['columnFilter']['aoColumns'][] = null; }
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			// $result['columnFilter']['aoColumns'][] = array(	'type' => "select",
			// 			'bRegex' => true, 
			// 			'values' => array(
			// 				array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
			// 				array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
			// 			));
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 2;
			$progressPestanasArray = array(
										'general' => 2,
										'imagenes' => 1
									);
			$progressCadaItem = 100/$progressPestanas;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$link = utf8_encode($row_sql[$prefijo."link"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha_update"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);

				//Destacado
				// $destacado = $row_sql[$prefijo."destacado"];
				// $varDestacado = ($destacado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				// $destacado = $varDestacado.btnDestacado($destacado, $id);

				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				$acciones .= btnVistaPrevia($LinkPreview);
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;
					if ($row_sql[$prefijo."link"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="40" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				if ($atributoDataTable) { $result['rows']['tbody'][$i][] = '<input class="uniform-checkbox-items" type="checkbox" name="items-check" value="'.$id.'">'; }
				$result['rows']['tbody'][$i][] = $imagen;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = $link;
				$result['rows']['tbody'][$i][] = $fecha;
				// $result['rows']['tbody'][$i][] = $destacado;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Clientes

		//Configuración dataTable Glosario
		if($_POST['tipo'] == 'formCargarGlosario'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Término';
			$result['rows']['thead'][] = 'Definición';
			$result['rows']['thead'][] = 'Actualización';
			// $result['rows']['thead'][] = 'Destacado';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "date-range");
			// $result['columnFilter']['aoColumns'][] = array(	'type' => "select",
			// 			'bRegex' => true, 
			// 			'values' => array(
			// 				array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
			// 				array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
			// 			));
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 1;
			$progressPestanasArray = array(
										'general' => 2
									);
			$progressCadaItem = 100/$progressPestanas;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$nombre = utf8_encode($row_sql[$prefijo."nombre"]);
				$descripcion_corta = utf8_encode($row_sql[$prefijo."descripcion_corta"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha_update"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);

				//Destacado
				// $destacado = $row_sql[$prefijo."destacado"];
				// $varDestacado = ($destacado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				// $destacado = $varDestacado.btnDestacado($destacado, $id);

				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				//$acciones .= btnVistaPrevia($LinkPreview."vistaprevia/true/".$id."/".CamellizarConGuiones($nombre));
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."nombre"])
						$totalGeneral++;		
					if ($row_sql[$prefijo."descripcion_corta"])
						$totalGeneral++;
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;

				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $nombre;
				$result['rows']['tbody'][$i][] = cortarTexto($descripcion_corta, 120);
				$result['rows']['tbody'][$i][] = $fecha;
				// $result['rows']['tbody'][$i][] = $destacado;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla Glosario

		//Configuración dataTable formCargarTablaTarifas
		if($_POST['tipo'] == 'formCargarTablaTarifas'){
			$variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Mínimo';
			$result['rows']['thead'][] = 'Máximo';
			$result['rows']['thead'][] = 'Mensual';
			$result['rows']['thead'][] = 'Anual';
			$result['rows']['thead'][] = 'Estado';
			$result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." WHERE ".$prefijo."idi_id=%s ORDER BY ".$prefijo."posicion ASC", 
				GetSQLValueString($_SESSION[_sessionIdioma],"int")
			);
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 1;
			$progressPestanasArray = array(
										'general' => 4
									);
			$progressCadaItem = 100/$progressPestanas;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;

			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$minimo = utf8_encode($row_sql[$prefijo."minimo"]);
				$maximo = utf8_encode($row_sql[$prefijo."maximo"]);
				$mensual = utf8_encode($row_sql[$prefijo."mensual"]);
				$anual = utf8_encode($row_sql[$prefijo."anual"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha_update"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';

				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);

				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				//$acciones .= btnVistaPrevia($LinkPreview."vistaprevia/true/".$id."/".CamellizarConGuiones($nombre));
				$acciones .= btnEliminar($id);

				//Revisamos Items General
				$TotalPorcentaje = $porcentajeGeneral = $returnPosicionamiento = $porcentajePosicionamiento = $returnImagenes = $porcentajeImagenes = $returnAudios = $porcentajeAudios = $returnVideos = $porcentajeVideos = $returnArchivos = $porcentajeArchivos = $returnTxtbanner = $porcentajeTxtbanner = 0;
				if(isset($progressPestanasArray['general'])){
					$totalGeneral = 0;
					if ($row_sql[$prefijo."minimo"])
						$totalGeneral++;
					if ($row_sql[$prefijo."maximo"])
						$totalGeneral++;		
					if ($row_sql[$prefijo."mensual"])
						$totalGeneral++;		
					if ($row_sql[$prefijo."anual"])
						$totalGeneral++;		
					$porcentajeGeneral = ($totalGeneral/$progressPestanasArray['general']) * 100;
					$TotalPorcentaje += ($porcentajeGeneral * $progressCadaItem) / 100;
				}

				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];

				$result['rows']['id'][$i][] = $id;
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="70" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}
				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $minimo;
				$result['rows']['tbody'][$i][] = $maximo;
				$result['rows']['tbody'][$i][] = $mensual;
				$result['rows']['tbody'][$i][] = $anual;
				$result['rows']['tbody'][$i][] = $estado;
				$result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;

				$i++;
			}

		}
		//Termina de configurar tabla formCargarTablaTarifas

		//Configuración dataTable formCargarStripePlans
		if($_POST['tipo'] == 'formCargarStripePlans'){
		    $variables = $_POST['variables'];
			//
			$LinkPreview = $variables['LinkPreview'];
			$tabla = $variables['dbTipo'] . 'tbl_' . $variables['dbNombre'];
			$prefijo = $variables['dbPrefijo'];

			$labelEstado['on'] = 'Activado';
			$labelEstado['off'] = 'Desactivado';

			//Columnas y Evitar Errores
			//$result['rows'] = [];
			$result['rows']['tbody'] = [];

			$result['rows']['thead'][] = '';
			$result['rows']['thead'][] = 'Id';
			$result['rows']['thead'][] = 'Nombre';
			$result['rows']['thead'][] = 'Min Empleados';
			$result['rows']['thead'][] = 'Max Empleados';
			$result['rows']['thead'][] = 'Intervalo';
			$result['rows']['thead'][] = 'Precio';
			$result['rows']['thead'][] = 'Estado';
			// $result['rows']['thead'][] = 'Progreso';
			$result['rows']['thead'][] = 'Acciones';

			//Configuración DataTable
			$result['columnFilter']['sRangeFormat'] = "Desde {from} Hasta {to}";
			$result['columnFilter']['sPlaceHolder'] = "head:after";
			//Columnas
			$result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array('type' => "text");
			$result['columnFilter']['aoColumns'][] = array(	'type' => "select",
						'bRegex' => true, 
						'values' => array(
							array('value' => '^'.$labelEstado['on'].'$', 'label' => $labelEstado['on']),
							array('value' => '^'.$labelEstado['off'].'$', 'label' => $labelEstado['off']),
						));
			// $result['columnFilter']['aoColumns'][] = null;
			$result['columnFilter']['aoColumns'][] = null;
			

			//Dejamos Base De Datos Ordenada
			$cont_ord=1;
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC" );
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
				$sql2 = sprintf("UPDATE ".$tabla." SET ".$prefijo."posicion=%s WHERE ".$prefijo."id=%s",
					GetSQLValueString($cont_ord, "int"),
					GetSQLValueString($row_sql[$prefijo."id"], "int")
				);
				$rs_sql2 = mysqli_query($_conection->connect(), $sql2);
				$cont_ord++;
			}

			//Sacamos datos
			$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC" );
			$rs_sql = mysqli_query($_conection->connect(), $sql);
			$i = 0;

			//Calculamos el progreso de cada Item
			$progressPestanas = 1;
			$progressPestanasArray = array(
										'general' => 4
									);
			$progressCadaItem = 100/$progressPestanas;

			$tabNombre = $tabIdRegistro = $tabTipo = '';
			$tabNombre = $variables['dbNombre'];
			$tabTipo = '';
			$img_principal = 'ambas';
			$variablesExtras['datatable'] = true;
            
            
			while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
    			$id = utf8_encode($row_sql[$prefijo."id"]);
				$posicion = utf8_encode($row_sql[$prefijo."posicion"]);
				$minimo = utf8_encode($row_sql[$prefijo."min"]);
				$maximo = utf8_encode($row_sql[$prefijo."max"]);
				$interval = utf8_encode($row_sql[$prefijo."interval"]);
				$stripe_id = utf8_encode($row_sql[$prefijo."stripe_id"]);
				$amount = utf8_encode($row_sql[$prefijo."amount"]);
				$name = utf8_encode($row_sql[$prefijo."name"]);
				$fecha = utf8_encode($row_sql[$prefijo."fecha_update"]);
				if ($fecha > 0) {
					$fecha = date_create($fecha);
					$fecha = date_format($fecha, 'd/m/Y');
				}else{
					$fecha = '';
				}
				$estado = utf8_encode($row_sql[$prefijo."estado"]);
				$acciones = '';
                
				$arrayImagenes = extraerImagenes($_conection, $tabNombre, $tabTipo, $id, $img_principal, $linktrue, $variablesExtras);
				
				//Estado
				$varEstado = ($estado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
				$estado = $varEstado.btnEstado($estado, $id);
				//Acciones
				$acciones .= btnEditar($variables['nombreSeccion3'], $id);
				//$acciones .= btnVistaPrevia($LinkPreview."vistaprevia/true/".$id."/".CamellizarConGuiones($nombre));
				// $acciones .= btnEliminar($id);
                
				$returncalcularPorcentaje = calcularPorcentaje($progressPestanas, $progressPestanasArray, $variables, $id, $_conection);
				$TotalPorcentaje += $returncalcularPorcentaje[0];
                
				$result['rows']['id'][$i][] = $id;
				if ($arrayImagenes[0]) {
					$imagen = '<div class="text-center"><img width="100" height="70" src="'.substr($arrayImagenes[0],3).'"/></div>';
				}else{
					$imagen = '';
				}
				
				//print $i;
				$result['rows']['tbody'][$i][] = $posicion;
				$result['rows']['tbody'][$i][] = $stripe_id;
				$result['rows']['tbody'][$i][] = $name;
				$result['rows']['tbody'][$i][] = $minimo;
				$result['rows']['tbody'][$i][] = $maximo;
				$result['rows']['tbody'][$i][] = $interval;
				$result['rows']['tbody'][$i][] = number_format($amount/100, 2) ;
				$result['rows']['tbody'][$i][] = $estado;
				// $result['rows']['tbody'][$i][] = progressTabla($TotalPorcentaje);
				$result['rows']['tbody'][$i][] = $acciones;
				
				$i++;
			}

		}
		//Termina de configurar tabla formCargarStripePlans
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