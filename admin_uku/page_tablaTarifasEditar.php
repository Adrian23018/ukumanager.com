<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	$id = $_GET["id"];
	$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'pcp';
	$tituloPage = 'Editar Fila en Tabla';
	$actualPage = 'page_tablaTarifasEditar';

?>

<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="<?php echo $id; ?>"/>

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="inicio.php">Inicio</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="inicio.php?page=page_tablaTarifas">Tabla Tarifas</a>
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
				<div class="tabbable">
					<ul class="nav nav-tabs nav-tabs-lg">
						<li class="active">
							<a href="#tab_general" data-toggle="tab">
								General 
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_general">
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Mínimo (Empleados)<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-minimo" id="<?php echo $nombrePageUsado; ?>-minimo" placeholder="Valor" class="form-control qtipmensaje"/>
										</div>
										<small>Solo Número</small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Máximo (Empleados)<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-maximo" id="<?php echo $nombrePageUsado; ?>-maximo" placeholder="Valor" class="form-control qtipmensaje"/>
										</div>
										<small>Solo Número</small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Mensual<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-mensual" id="<?php echo $nombrePageUsado; ?>-mensual" placeholder="Valor" class="form-control qtipmensaje"/>
										</div>
										<small>Solo Número</small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Anual<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-anual" id="<?php echo $nombrePageUsado; ?>-anual" placeholder="Valor" class="form-control qtipmensaje"/>
										</div>
										<small>Solo Número</small>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_posicionamiento">
								<?php include 'includes/forms/form-seo.php'; ?>
							</div>
							<div class="tab-pane" id="tab_imagenes">
								<br>
								<div class="clearfix margin-top-10">
									<span class="label label-danger">NOTE! </span>
									<span> &nbsp; Peso Máximo: <span class="js-maxfilesize-1"></span>MB; Tipo de archivos: jpg, png, gif; <span class="js-recomendacion-tamano-1"></span> Resolución 72;</span>
								</div>
								<br>
								<input id="fileinput-1" name="archivos[]" type="file" class="file-loading subir-imagenes-1">
								<div class="clearfix"></div>
									<br><br>
									<div class="row mix-grid" id="mostrar-imagenes"></div>
							</div>
							<div class="tab-pane" id="tab_audios">
								<div class="btn-group">
									<a href="javascript:;" class="btn green-adele js-add-audio">
										Añadir <i class="fa fa-plus"></i>
									</a>
								</div>

								<div class="clearfix margin-bottom-20"></div>
								<div class="portlet box blue-hoki">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Audio - Sound Cloud
										</div>
									</div>
									<div class="portlet-body form">
										<div class="clearfix margin-bottom-10"></div>
										<div class="soundcloud" id="sortable_soundcloud"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="tab-pane" id="tab_videos">
								<div class="btn-group">
									<a href="javascript:;" class="btn green-adele js-add-videos">
										Añadir <i class="fa fa-plus"></i>
									</a>
								</div>
								<div class="clearfix margin-bottom-20"></div>
								<div class="portlet box blue-hoki">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Video - Youtube - Vimeo
										</div>
									</div>
									<div class="portlet-body form">
										<div class="clearfix margin-bottom-10"></div>
										<div class="videos" id="sortable_videos"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="tab-pane" id="tab_archivos">
								<input id="fileinput-2" name="archivos_descargas[]" type="file" multiple class="file-loading subir-archivos-1">
								<div class="clearfix"></div>
									<br><br>
									<div class="row mix-grid" id="mostrar-archivos"></div>
							</div>
							<div class="tab-pane" id="tab_txtbanner">
								<div class="btn-group">
									<a href="javascript:;" class="btn green-adele js-add-txtbanner">
										Añadir <i class="fa fa-plus"></i>
									</a>
								</div>
								<div class="clearfix margin-bottom-20"></div>
								<div class="portlet box blue-hoki">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Textos Del Banner
										</div>
									</div>
									<div class="portlet-body form">
										<div class="clearfix margin-bottom-10"></div>
										<div class="txtbanner" id="sortable_txtbanner"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="tab-pane" id="tab_txtbanner2campos">
								<div class="btn-group">
									<a href="javascript:;" class="btn green-adele js-add-txtbanner2campos">
										Añadir <i class="fa fa-plus"></i>
									</a>
								</div>
								<div class="clearfix margin-bottom-20"></div>
								<div class="portlet box blue-hoki">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Información Adicional
										</div>
									</div>
									<div class="portlet-body form">
										<div class="clearfix margin-bottom-10"></div>
										<div class="txtbanner2campos" id="sortable_txtbanner2campos"></div>
									</div>
								</div>
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