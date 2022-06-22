<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	$nombrePageUsado = 'sc';
	$tituloPage = 'Configuración Stripe';
	$actualPage = 'page_stripeConfg';

	$conexion = $_conection->connect();
	
	$sqlStripe = sprintf("SELECT * FROM 
								tbl_stripe_confg 
							WHERE 
								sc_id=1");
	$rs_sqlStripe = mysqli_query($conexion, $sqlStripe);
	$row_sqlStripe = mysqli_fetch_assoc($rs_sqlStripe);
	$check = '';
	if ($row_sqlStripe["sc_test"] == 1) {
		$check = 'checked';
	}

?>

<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="1"/>

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
							<a href="#tab_general" data-toggle="tab">
								General 
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_general">
								<div class="col-md-12 text-center">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="check-test" id="check-test" class="icheck-input uniform-checkbox" data-mincheck="2" <?php echo $check; ?> >
											<b>Habilitar modo de pruebas</b>
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<h3>Configuración Pruebas</h3>
									<div class="form-group">
										<label class="control-label">Api Key Test</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-apikey_test" id="<?php echo $nombrePageUsado; ?>-apikey_test" placeholder="Api Key" class="form-control qtipmensaje"/>
										</div>
										<small></small>
									</div>
								</div>
								<div class="col-md-6">
									<h3>Configuración Producción</h3>
									<div class="form-group">
										<label class="control-label">Api Key Live</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-apikey_live" id="<?php echo $nombrePageUsado; ?>-apikey_live" placeholder="Api Key" class="form-control qtipmensaje"/>
										</div>
										<small></small>
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