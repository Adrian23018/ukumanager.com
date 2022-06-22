<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';
	//prefijo categoria anterior
	$prefijoAnt = 'pcs_';
	$prefijoAntAnt = 'pcp_';

	//Si la seccion trae id
	$id_ant = $_GET[$prefijoAnt."id"];
	$id_ant = preg_replace('/[^0-9]/','',$id_ant);

	$id_antant = $_GET[$prefijoAntAnt."id"];
	$id_antant = preg_replace('/[^0-9]/','',$id_antant);

	$sql = sprintf("SELECT * FROM tbl_productos_categoriasecundaria WHERE ".$prefijoAnt."id=%s",
		GetSQLValueString($id_ant,"int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$row_sql = mysqli_fetch_assoc($rs_sql);

	$nombrePageUsado = 'pro';
	$tituloPage = 'Nuevo Producto de '. utf8_encode($row_sql[$prefijoAnt."nombre"]);
	$actualPage = 'page_productosNuevo';
	//$btnPageNuevoUrl = 'page_productosCategoriaSecundariaNuevo&'.$prefijoAnt.'id='.$id_ant;
?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="<?php echo $prefijoAnt; ?>id" value="<?php echo $id_ant; ?>"/>
<input class="hidden" id="<?php echo $prefijoAntAnt; ?>id" value="<?php echo $id_antant; ?>"/>

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="inicio.php">Inicio</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="inicio.php?page=page_productosCategoriaPrincipal">Categorias Principales</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="inicio.php?page=page_productosCategoriaSecundaria&<?php echo $prefijoAntAnt; ?>id=<?php echo $id_antant; ?>">Categorias Secundarias</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="inicio.php?page=page_productos&<?php echo $prefijoAntAnt; ?>id=<?php echo $id_antant; ?>&<?php echo $prefijoAnt; ?>id=<?php echo $id_ant; ?>">Productos</a>
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
							</a>
						</li>
						<li>
							<a href="#tab_posicionamiento" data-toggle="tab">
							Meta </a>
						</li>
						<li>
							<a href="#tab_imagenes" data-toggle="tab">
							Imágenes </a>
						</li>
						<li>
							<a href="#tab_audios" data-toggle="tab">
							Audios </a>
						</li>
						<li>
							<a href="#tab_videos" data-toggle="tab">
							Vídeos </a>
						</li>
						<li>
							<a href="#tab_archivos" data-toggle="tab">
							Descargas </a>
						</li>
						<li>
							<a href="#tab_txtbanner" data-toggle="tab">
							Textos Banner </a>
						</li>
						<li>
							<a href="#tab_txtbanner2campos" data-toggle="tab">
								Características
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="crear-<?php echo $nombrePageUsado; ?>" id="crear-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_general">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Nombre<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-nombre" id="<?php echo $nombrePageUsado; ?>-nombre" placeholder="Nombre" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Descripción Corta<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-descripcion_corta" id="<?php echo $nombrePageUsado; ?>-descripcion_corta" placeholder="Descripcion Corta" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Fecha<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-fecha" id="<?php echo $nombrePageUsado; ?>-fecha" placeholder="Fecha" class="form-control qtipmensaje date-picker"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Mostrar como ítem principal</span></label>
										<div class="">
											<div class="col-xs-4 text-center" style="padding-left:0px;">
												<label for="option1">Imagen</label>
												<input id="mostrar-imagen" type="radio" name="<?php echo $nombrePageUsado; ?>-mostrar" value="1" class="make-switch switch-radio1" data-size="mini" data-on-text="Imagen" data-off-text="Desactivado">
											</div>
											<div class="col-xs-4 text-center">
												<label for="option2">Audio</label>
												<input id="mostrar-audio" type="radio" name="<?php echo $nombrePageUsado; ?>-mostrar" value="2" class="make-switch switch-radio1" data-size="mini" data-on-text="Audio" data-off-text="Desactivado">
											</div>
											<div class="col-xs-4 text-center">
												<label for="option3">Vídeo</label>
												<input id="mostrar-video" type="radio" name="<?php echo $nombrePageUsado; ?>-mostrar" value="3" class="make-switch switch-radio1" data-size="mini" data-on-text="Vídeo" data-off-text="Desactivado">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<hr>
										<label class="control-label">Descripción<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-"></i>
											</span>
											<i class="fa faicono"></i>
											<textarea class="summernote qtipmensaje" id="<?php echo $nombrePageUsado; ?>-descripcion" name="<?php echo $nombrePageUsado; ?>-descripcion"></textarea>
										</div>
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
								<input id="fileinput-1" name="archivos[]" type="file" multiple class="file-loading subir-imagenes-1">
								<div class="clearfix"></div>
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
						<a href="javascript:;" class="btn btn-success" id="btn-guardar-<?php echo $nombrePageUsado; ?>">
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