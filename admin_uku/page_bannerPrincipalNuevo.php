<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	$id = $_GET["id"];
	$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'banp';
	$tituloPage = 'Nuevo Banner';
	$actualPage = 'page_bannerPrincipalNuevo';

?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="inicio.php">Inicio</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="inicio.php?page=page_bannerPrincipal">Banners</a>
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
							<a href="#tab_imagenes" data-toggle="tab">
							Imágenes </a>
						</li>
						<li>
							<a href="#tab_txtbanner" data-toggle="tab">
							Textos Banner </a>
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
									<div class="form-group col-xs-12">
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
										<label class="control-label col-xs-12">Posición Imagen</span></label>
										<div class="">
											<div class="col-xs-4 text-center">
												<label for="option1">Izquierda</label>
												<input type="radio" name="<?php echo $nombrePageUsado; ?>-posicionimagen" value="1" class="make-switch switch-radio1 js-class-posicionimagen qtipmensaje" data-size="mini" data-on-text="Izquierda" data-off-text="Desactivado">
											</div>
											<div class="col-xs-4 text-center">
												<label for="option3">Derecha</label>
												<input type="radio" name="<?php echo $nombrePageUsado; ?>-posicionimagen" value="2" class="make-switch switch-radio1 js-class-posicionimagen qtipmensaje" data-size="mini" data-on-text="Derecha" data-off-text="Desactivado">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-xs-12">Posición Texto<span class="required"> * </span></span></label>
										<div class="">
											<div class="col-xs-4 text-center">
												<label for="option1">Izquierda</label>
												<input type="radio" name="<?php echo $nombrePageUsado; ?>-posiciontexto" value="1" class="make-switch switch-radio1 js-class-posiciontexto qtipmensaje" data-size="mini" data-on-text="Izquierda" data-off-text="Desactivado">
											</div>
											<div class="col-xs-4 text-center">
												<label for="option2">Centrado</label>
												<input type="radio" name="<?php echo $nombrePageUsado; ?>-posiciontexto" value="2" class="make-switch switch-radio1 js-class-posiciontexto qtipmensaje" data-size="mini" data-on-text="Centrado" data-off-text="Desactivado">
											</div>
											<div class="col-xs-4 text-center">
												<label for="option3">Derecha</label>
												<input type="radio" name="<?php echo $nombrePageUsado; ?>-posiciontexto" value="3" class="make-switch switch-radio1 js-class-posiciontexto qtipmensaje" data-size="mini" data-on-text="Derecha" data-off-text="Desactivado">
											</div>
										</div>
									</div>
								</div>

								<div class="cleafix clear margin-top-20 col-md-12"></div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Filtro Fondo RGBA</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" class="colorpicker-rgba form-control" value="rgba(0,0,0,0)" data-color-format="rgba" name="<?php echo $nombrePageUsado; ?>-colorrgba" id="<?php echo $nombrePageUsado; ?>-colorrgba"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Link</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-link" id="<?php echo $nombrePageUsado; ?>-link" placeholder="Link" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_imagenes">
								<br>
								<div class="clearfix margin-top-10">
									<span class="label label-danger">NOTE! </span>
									<span> &nbsp; Peso Máximo: <span class="js-maxfilesize-1"></span>MB; Tipo de archivos: jpg, png, gif; <span class="js-recomendacion-tamano-1"></span> Resolución 72;</span>
								</div>
								<div class="clearfix margin-top-10">
									<span class="label label-danger">NOTE! </span>
									<span> &nbsp; Peso Máximo: <span class="js-maxfilesize-1"></span>MB; Tipo de archivos: jpg, png, gif; <span class="js-recomendacion-tamano-2"></span> Resolución 72;</span>
								</div>
								<br>
								<input id="fileinput-1" name="archivos[]" type="file" multiple class="file-loading subir-imagenes-1">
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