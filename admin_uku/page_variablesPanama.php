<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	$nombrePageUsado = 'vp';
	$tituloPage = 'Variables Panamá';
	$actualPage = 'page_variablesPanama';
	
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
							<a href="#tab_general" data-toggle="tab">
								General 
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					
					<!-- Semanas en el mes 4.33
					horas dia 8
					Dia Domingo o Descanso 1.5
					Dia Feriado 2.5
					
					Salario y Vacaciones
					Seguro Social 9.75 % 
					Seguro Educativo 1.25 %

					XIII
					Seguro Social 7.25 %  -->

					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_general">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Cantidad de semanas del mes</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-semanas" id="<?php echo $nombrePageUsado; ?>-semanas" placeholder="Semanas por mes" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Cantidad de horas de trabajo en un día</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-horas" id="<?php echo $nombrePageUsado; ?>-horas" placeholder="Horas por día" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6">
									<div class="form-group">
										<h3>Valor para cálculo de:</h3>
										<label class="control-label">Día Domingo o de Descanso</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-diadomingo" id="<?php echo $nombrePageUsado; ?>-diadomingo" placeholder="Día Domingo o de Descanso" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<h3>&nbsp;</h3>
										<label class="control-label">Día Feriado</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-diaferiado" id="<?php echo $nombrePageUsado; ?>-diaferiado" placeholder="Día Domingo o de Descanso" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6">
									<div class="form-group">
										<h3>Seguro Social sobre Salario y Vacaciones:</h3>
										<label class="control-label">Seguro Social (%)</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-vc_ss" id="<?php echo $nombrePageUsado; ?>-vc_ss" placeholder="Seguro Social" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<h3>&nbsp;</h3>
										<label class="control-label">Seguro Educativo (%)</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-vc_se" id="<?php echo $nombrePageUsado; ?>-vc_se" placeholder="Seguro Educativo" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6">
									<div class="form-group">
										<h3>Seguro Social sobre XIII:</h3>
										<label class="control-label">Seguro Social (%)</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-xiii_ss" id="<?php echo $nombrePageUsado; ?>-xiii_ss" placeholder="Seguro Social" class="form-control qtipmensaje"/>
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