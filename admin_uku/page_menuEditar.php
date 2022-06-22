<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	$id = $_GET["id"];
	$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'menu';
	$tituloPage = 'Editar Menu';
	$actualPage = 'page_menuEditar';

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
			<a href="inicio.php?page=page_menu">Menu</a>
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
						<li>
							<a href="#tab_posicionamiento" data-toggle="tab">
								Meta 
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
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

									<div class="form-group">
										<div class="height-14"></div>
										<label class="control-label">Link Externo</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-link" id="<?php echo $nombrePageUsado; ?>-link" placeholder="Link Externo" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_posicionamiento">
								<?php include 'includes/forms/form-seo.php'; ?>
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