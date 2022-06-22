<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	$nombrePageUsado = 'sp';
	$tituloPage = 'Stripe Producto';
	$actualPage = 'page_stripeProduct';

	$conexion = $_conection->connect();

	$sqlStripe = sprintf("SELECT * FROM 
								tbl_stripe_product 
							WHERE 
								sp_id=1");
	$rs_sqlStripe = mysqli_query($conexion, $sqlStripe);
	$row_sqlStripe = mysqli_fetch_assoc($rs_sqlStripe);
	$check = '';
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
								<div class="col-md-12">
									<label> ID STRIPE: <?php echo $row_sqlStripe["sp_stripe_id"]; ?></label>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Name</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-name" id="<?php echo $nombrePageUsado; ?>-name" placeholder="Name" class="form-control qtipmensaje"/>
										</div>
										<small></small>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Type</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											
											<select class="form-control select2" name="<?php echo $nombrePageUsado; ?>-type" id="<?php echo $nombrePageUsado; ?>-type" >
												<option value="service" 
													<?php echo ($row_sqlStripe['type'] == 'service') ? 'selected' : '';  ?>>
													Service (suscripciones y planes)
												</option>
												<option value="good" 
													<?php echo ($row_sqlStripe['type'] == 'good') ? 'selected' : '';  ?>>
													Good (Ordenes y SKU)
												</option>
											</select>
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