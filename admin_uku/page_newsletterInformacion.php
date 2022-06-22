<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	$id = $_SESSION[_sessionIdioma];
	$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'nw';
	$tituloPage = 'Información Newsletter';
	$actualPage = 'page_newsletterInformacion';
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
								Formulario de Newsletter
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_formulario_contacto">
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
										<span class="help-block">Donde llegarán los mensajes de newsletter (Correos separados por comas)</span>
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