<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	$id = $_SESSION[_sessionIdioma];
	$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'continf';
	$tituloPage = 'Información Contáctenos';
	$actualPage = 'page_contactenosInformacion';

	$select_datos = "SELECT * FROM tbl_contactenos_informacion WHERE continf_id=".$id;
	$rs_datos = mysqli_query($select_datos, $_connect->connect());
	$row_datos_contacto = mysqli_fetch_assoc($rs_datos);
	$CodigoMapa = explode("(d)",$row_datos_contacto['continf_mapa']);
	$NombrePoniter = strtr('Squash', "áéíóúÁÉÍÓÚñÑ", "aeiouAEIOUnN");
	if($CodigoMapa[0]){
		$datos = explode(",",$CodigoMapa[0]);
		$latitud= $datos[0];
		$longitud= $datos[1];
		$zoom= $CodigoMapa[3];
	}else{
		///mapa
		$latitud= "4.598055599999999";
		$longitud="-74.0758333";
		$zoom= "17";
	}
	$tipo_mapa = "ROADMAP";
	$direccion = "";
?>

<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="<?php echo $id; ?>"/>

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="inicio.php">Inicio</a>
		</li>
	</ul>
</div>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet box green-adele form">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo $tituloPage; ?>
				</div>
				<div class="tools">
				</div>
				<div class="tools">
					<a href="javascript:;" class="reload">
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<!-- Duplicar Idioma -->
				<?php if ( $iConteoIdioma > 1 ){ ?>
				<div class="text-right">
					<span class="idioma">Duplicar a: </span>
					<select name="duplicar-idioma" id="duplicar-idioma" class="js-select2">
						<?php echo $optionIdiomaOtros; ?>
					</select>
					<a href="javascript:;" class="btn green-adele js-duplicar-individual">Aplicar</a>
				</div>
				<?php } ?>
				
				<div class="tabbable">
					<ul class="nav nav-tabs nav-tabs-lg">
						<li class="active">
							<a href="#tab_formulario_contacto" data-toggle="tab">
								General 
								<span class="badge"></span>
							</a>
						</li>
						<li class="continf-ubicacion">
							<a href="#tab_ubicacion" data-toggle="tab">
								Ubicación
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_formulario_contacto">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Descripción Formulario</label>
										<div class="input-icon right">
											<i class="fa faicono"></i>
											<textarea class="form-control maxlength-handler qtipmensaje" rows="3" name="<?php echo $nombrePageUsado; ?>-formulario" id="<?php echo $nombrePageUsado; ?>-formulario" maxlength="300"></textarea>
											<span class="help-block">max 300 caracteres</span>
										</div>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Correos<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-correos" id="<?php echo $nombrePageUsado; ?>-correos" placeholder="Correos" class="form-control qtipmensaje"/>
										</div>
										<span class="help-block">Donde llegarán los mensajes de contáctenos (Correos separados por comas)</span>
									</div>
								</div>

								<div class="clearfix"></div>
							</div>
							<div class="tab-pane" id="tab_ubicacion">
								<input type="text" name="id-directorio-mapa" id="id-directorio-mapa" style="display:none;"/>
								<div id="formulario">
									<p>
										<div class="col-md-12">
											<label>Búsqueda</label>
										</div>
										<div class="col-md-6">
											<input type="text" name="direccion-mapa" id="direccion-mapa" value="<?php echo $direccion;?>" class="form-control" />
										</div>
										<div class="col-md-6 text-left padding-left-5">
											<div class="margiv-top-10">
												<a href="javascript:;" class="btn btn-danger" id="codeAddress">
													<i class="fa fa-search"></i>
													Buscar
												 </a>
											</div>
										</div>
										<div class="clearfix"></div>
									</p>
	
									<div class="map-direccion" style="width:60%; float:left; margin-bottom: 10px; display:none;">
										<label>Latitud:</label><input type="text" name="latitud" id="latitud" value="<?php echo $latitud;?>"/>
										<label>Longitud:</label> <input type="text" name="longitud" id="longitud" value="<?php echo $longitud;?>"/>
										<button id="codeLatLon" class="radius2">Ubicar</button>
									</div>
								</div>
								<div id="mapCanvas" style="margin:0px auto; height:400px; width:600px;"></div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="form-actions">
				<div class="col-md-6 text-right padding-right-5">
					<div class="margiv-top-10">
						<a href="javascript:;" class="btn btn-success" id="btn-editar-<?php echo $nombrePageUsado; ?>">
							<i class="fa fa-save"></i>
						Guardar </a>
					</div>
				</div>
				<div class="col-md-6 text-left padding-left-5">
					<div class="margiv-top-10">
						<a href="javascript:;" class="btn btn-danger" id="btn-cancelar-<?php echo $nombrePageUsado; ?>">
							<i class="fa fa-close"></i>
						Cancelar </a>
					</div>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->