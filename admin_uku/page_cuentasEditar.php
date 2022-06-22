<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	$id = $_GET["id"];
	$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'cuentas';
	$tituloPage = 'Editar Cuenta';
	$actualPage = 'page_cuentasEditar';

	//Función Traer Secciones
	$select_group_seccion = sprintf("SELECT * FROM a_tbl_gruposeccion");
	$rs_group_seccion = mysqli_query($_conection->connect(), $select_group_seccion);
	while ($row_group_seccion = mysqli_fetch_assoc($rs_group_seccion)) {
		$secGroupNombre = utf8_encode($row_group_seccion["gp_nombre"]);
		$secGroupId = utf8_encode($row_group_seccion["gp_id"]);
		//Secciones Existentes en Base de Datos
		$check_secciones .=  '<div class="checkbox">
											<label>
												<input type="checkbox" name="check-' . $secGroupId . '" id="check-' . $secGroupId . '" class="icheck-input uniform-checkbox" data-mincheck="2">
												' . $secGroupNombre . '
											</label>
										</div>';
	}
?>

<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="<?php echo $id; ?>"/>

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
							<a href="#tab_1" data-toggle="tab">
							Datos de la Cuenta </a>
						</li>
						<li>
							<a href="#tab_2" data-toggle="tab">
							Cambiar Clave </a>
						</li>
						<li>
							<a href="#tab_3" data-toggle="tab">
							Secciones </a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<div class="col-md-12">
									<h4 class="block">Datos de la Cuenta</h4>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Email<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-envelope"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-email" id="<?php echo $nombrePageUsado; ?>-email" placeholder="Email" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Usuario<span class="required"> * </span></label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-user"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-user" id="<?php echo $nombrePageUsado; ?>-user" placeholder="Usuario" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Nombres</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-user"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-nombres" id="<?php echo $nombrePageUsado; ?>-nombres" placeholder="Nombres" class="form-control qtipmensaje"/>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label">Apellidos</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-user"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-apellidos" id="<?php echo $nombrePageUsado; ?>-apellidos" placeholder="Apellidos" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Celular</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-mobile"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-celular" id="<?php echo $nombrePageUsado; ?>-celular" placeholder="Celular" class="form-control qtipmensaje"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label">Teléfono</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-phone"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-telefono" id="<?php echo $nombrePageUsado; ?>-telefono" placeholder="Teléfono" class="form-control qtipmensaje"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label">Ocupación</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-suitcase"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-ocupacion" id="<?php echo $nombrePageUsado; ?>-ocupacion" placeholder="Ocupación" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_2">
								<div class="col-md-12">
									<h4 class="block">Cambiar Clave</h4>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Clave</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-lock"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="password" class="form-control qtipmensaje" name="<?php echo $nombrePageUsado; ?>-password" id="<?php echo $nombrePageUsado; ?>-password" placeholder="Clave" />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Repetir Clave</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa-lock"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="password" class="form-control qtipmensaje" name="<?php echo $nombrePageUsado; ?>-passwordrepeat" id="<?php echo $nombrePageUsado; ?>-passwordrepeat" placeholder="Repetir Actual" />
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_3">
								<div class="col-md-12">
									<h4 class="block">Secciones</h4>
								</div>
								<div class="col-md-12 column-div-2">
									<?php echo $check_secciones; ?>
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