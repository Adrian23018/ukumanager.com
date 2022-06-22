<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	$nombrePageUsado = 'rs';
	$tituloPage = 'Redes Sociales';
	$actualPage = 'page_redessociales';

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
							<a href="#tab_general" data-toggle="tab">
								General
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_general">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Facebook</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-facebook"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-facebook" id="<?php echo $nombrePageUsado; ?>-facebook" placeholder="Facebook" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Twitter</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-twitter"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-twitter" id="<?php echo $nombrePageUsado; ?>-twitter" placeholder="Twitter" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Google +</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-google-plus"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-google-plus" id="<?php echo $nombrePageUsado; ?>-google-plus" placeholder="Google +" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Instagram</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-instagram"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-instagram" id="<?php echo $nombrePageUsado; ?>-instagram" placeholder="Instagram" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Youtube</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-youtube"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-youtube" id="<?php echo $nombrePageUsado; ?>-youtube" placeholder="Youtube" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Linkedin</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-linkedin"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-linkedin" id="<?php echo $nombrePageUsado; ?>-linkedin" placeholder="Linkedin" class="form-control qtipmensaje"/>
										</div>
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