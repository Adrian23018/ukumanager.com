<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	//$id = $_GET["id"];
	//$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'blogs';
	$tituloPage = 'Blogs';
	$actualPage = 'page_blogs';
	$btnPageNuevoUrl = 'page_blogsNuevo';

	//DATATABLE SERVER
	$labelEstado['on'] = 'Activado';
	$labelEstado['off'] = 'Desactivado';

	$tabla = "tbl_blog";
	$prefijo = "bl_";
	$variables['dbNombre'] = "blog";

	$sql = sprintf("SELECT * FROM ".$tabla." ORDER BY ".$prefijo."posicion ASC");
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
		//$destacado = $row_sql[$prefijo."destacado"];
		//$varDestacado = ($destacado) ? '<span class="hidden">'.$labelEstado['on'].'</span>' : '<span class="hidden">'.$labelEstado['off'].'</span>';
		//$destacado = $varDestacado.btnDestacado($destacado, $id);

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

		$resultDatos = '';
		$resultDatos .= '<td>'.$posicion.'</td>';
		$resultDatos .= '<td>'.$nombre.'</td>';
		$resultDatos .= '<td>'.$descripcion_corta.'</td>';
		$resultDatos .= '<td>'.$fecha.'</td>';
		//$resultDatos .= '<td>'.$destacado.'</td>';
		//$resultDatos .= '<td>'.$estado.'</td>';
		//$resultDatos .= '<td>'.progressTabla($TotalPorcentaje).'</td>';
		//$resultDatos .= '<td>'.$acciones.'</td>';

		$resultDatos .= '<td>'.$estado.'</td>';
		$resultDatos .= '<td>'.progressTabla($TotalPorcentaje).'</td>';
		$resultDatos .= '<td>'.$acciones.'</td>';

		$resultDatosTotal .= '<tr id="'.$id.'" data-position="'.$id.'">' . $resultDatos . '</tr>';

		$i++;
	}

	//TERMINA DATATABLE SERVER



?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet box green-adele">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo $tituloPage; ?>
				</div>
				<div class="tools">
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse">
					</a>
					<a href="javascript:;" class="reload reload-table">
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<a href="inicio.php?page=<?php echo $btnPageNuevoUrl; ?>" class="btn green-adele">
								Crear <i class="fa fa-plus"></i>
								</a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="btn-group pull-right">
								<div class="btn btn-info js-btn-ordenar">Ordenar</div>
								<div class="btn btn-info js-btn-salir-ordenar hidden">Salir de Ordenar</div>
								
							</div>
						</div>
					</div>
				</div>
				<br><br>
				<!--BEGIN DATATABLE -->
				<table class="table table-striped table-hover table-bordered" id="dataTable2">
					<thead>
						<tr class="filter">
							<th></th>
							<th>Nombre</th>
							<th>Descripción Corta</th>
							<th>Fecha</th>
							<!--<th>Destacado</th>-->
							<th>Estado</th>
							<th>Progreso</th>
							<th>Acciones</th>
						</tr>
						<tr class="heading">
							<td></td>
							<td>Nombre</td>
							<td>Descripción Corta</td>
							<td>Fecha</td>
							<!--<td>Destacado</td>-->
							<td>Estado</td>
							<td>Progreso</td>
							<td>Acciones</td>
						</tr>
					</thead>
					<tbody>
						<?php echo $resultDatosTotal; ?>
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th>Nombre</th>
							<th>Descripción Corta</th>
							<th>Fecha</th>
							<!--<th>Destacado</th>-->
							<th>Estado</th>
							<th>Progreso</th>
							<th>Acciones</th>
						</tr>
					</tfoot>
				</table>
				<!--END DATATABLE -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->