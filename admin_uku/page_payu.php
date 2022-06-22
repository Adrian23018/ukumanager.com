<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	$nombrePageUsado = 'py';
	$tituloPage = 'Configuración Payu';
	$actualPage = 'page_payu';

	$conexion = $_conection->connect();
	
	$sqlPayu = sprintf("SELECT * FROM 
								tbl_payu 
							WHERE 
								py_id=1");
	$rs_sqlPayu = mysqli_query($conexion, $sqlPayu);
	$row_sqlPayu = mysqli_fetch_assoc($rs_sqlPayu);
	if ($row_sqlPayu["py_test"] == 1) {
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
										<label class="control-label">Api Key</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-test_apikey" id="<?php echo $nombrePageUsado; ?>-test_apikey" placeholder="Api Key" class="form-control qtipmensaje"/>
										</div>
										<small>Llave que sirve para encriptar la comunicación con PayU Latam.</small>
									</div>

									<div class="form-group">
										<label class="control-label">Api Login</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-test_apilogin" id="<?php echo $nombrePageUsado; ?>-test_apilogin" placeholder="Api Login" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Account ID</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-test_accountid" id="<?php echo $nombrePageUsado; ?>-test_accountid" placeholder="Account ID" class="form-control qtipmensaje"/>
										</div>
										<small>ID de la cuenta en PayU Latam.</small>
									</div>

									<div class="form-group">
										<label class="control-label">Merchant ID</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-test_idcomercio" id="<?php echo $nombrePageUsado; ?>-test_idcomercio" placeholder="Merchant ID" class="form-control qtipmensaje"/>
										</div>
										<small>ID único de usuario en PayU Latam (Id de comercio)</small>
									</div>

									<!-- <div class="form-group">
										<label class="control-label">Currency</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-test_currency" id="<?php echo $nombrePageUsado; ?>-test_currency" placeholder="Currency e.g. COP" class="form-control qtipmensaje"/>
										</div>
									</div> -->

									<div class="form-group">
										<label class="control-label">Gateway URL API</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-test_url" id="<?php echo $nombrePageUsado; ?>-test_url" placeholder="Gateway URL API" class="form-control qtipmensaje"/>
										</div>
										<small>URL de la pasarela de pago PayU Latam.</small>
									</div>
								</div>
								<div class="col-md-6">
									<h3>Configuración Ventas</h3>
									<div class="form-group">
										<label class="control-label">Api Key</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-apikey" id="<?php echo $nombrePageUsado; ?>-apikey" placeholder="Api Key" class="form-control qtipmensaje"/>
										</div>
										<small>Llave que sirve para encriptar la comunicación con PayU Latam.</small>
									</div>

									<div class="form-group">
										<label class="control-label">Api Login</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-apilogin" id="<?php echo $nombrePageUsado; ?>-apilogin" placeholder="Api Login" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Account ID</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-accountid" id="<?php echo $nombrePageUsado; ?>-accountid" placeholder="Account ID" class="form-control qtipmensaje"/>
										</div>
										<small>ID de la cuenta en PayU Latam.</small>
									</div>

									<div class="form-group">
										<label class="control-label">Merchant ID</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-idcomercio" id="<?php echo $nombrePageUsado; ?>-idcomercio" placeholder="Merchant ID" class="form-control qtipmensaje"/>
										</div>
										<small>ID único de usuario en PayU Latam (Id de comercio)</small>
									</div>

									<!-- <div class="form-group">
										<label class="control-label">Currency</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-currency" id="<?php echo $nombrePageUsado; ?>-currency" placeholder="Currency e.g. COP" class="form-control qtipmensaje"/>
										</div>
									</div> -->

									<div class="form-group">
										<label class="control-label">Gateway URL API</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-url" id="<?php echo $nombrePageUsado; ?>-url" placeholder="Gateway URL API" class="form-control qtipmensaje"/>
										</div>
										<small>URL de la pasarela de pago PayU Latam.</small>
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