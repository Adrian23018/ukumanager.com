<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	$nombrePageUsado = 'gl';
	$tituloPage = 'Galería';
	$actualPage = 'page_galeria';
	
?>

<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="<?php echo $_SESSION[_sessionIdioma]; ?>"/>

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
				
				<div class="tabbable">
					<ul class="nav nav-tabs nav-tabs-lg">
						<li class="active">
							<a href="#tab_imagenes" data-toggle="tab">
								Imágenes 
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_imagenes">
								<br>
								<div class="clearfix margin-top-10">
									<span class="label label-danger">NOTE! </span>
									<span> &nbsp; Peso Máximo: <span class="js-maxfilesize-1"></span>MB; Tipo de archivos: jpg, png, gif; <span class="js-recomendacion-tamano-1"></span> Resolución 72;</span>
								</div>
								<br>
								<input id="fileinput-1" name="archivos[]" type="file" multiple class="file-loading subir-imagenes-1">
								<div class="clearfix"></div>
									<br><br>
									<div class="col-md-6 dp-ib v-m sin-padding">
										<label><input class="uniform-checkbox-items select_all_image" name="select_all_image" value="1" type="checkbox"> Seleccionar Todas</label>
									</div><div class="col-md-6 dp-ib v-m sin-padding">
										<!-- Duplicar Idioma -->
										<?php if ( $iConteoIdioma > 1 ){ ?>
										<div class="text-right">
											<span class="idioma">Duplicar a: </span>
											<select name="duplicar-idioma" id="duplicar-idioma" class="js-select2">
												<?php echo $optionIdiomaOtros; ?>
											</select>
											<a href="javascript:;" class="btn green-adele js-duplicar-individual-image">Aplicar</a>
										</div>
										<?php } ?>
									</div>
										<br><br>

									<div class="row mix-grid" id="mostrar-imagenes"></div>
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