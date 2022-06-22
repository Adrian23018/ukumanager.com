<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	//$id = $_GET["id"];
	//$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'perfil';
	$tituloPage = 'Editar Perfil';
	$actualPage = 'page_editarPerfil';
?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="<?php echo $_SESSION[_sessionAdmin]; ?>"/>

			<h3 class="page-title">
				Mi Perfil <small>configuración</small>
			</h3>

			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="inicio.php">Inicio</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="javascript:;">Mi Perfil</a>
					</li>
				</ul>
			</div>

			<!-- BEGIN PAGE CONTENT-->
			<div class="row margin-top-20">
				<div class="col-md-12">
					<!-- BEGIN PROFILE SIDEBAR -->
					<div class="profile-sidebar">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic text-center">
								
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
									 <!--Marcus Doe-->
								</div>
								<div class="profile-usertitle-job">
									 <!--Developer-->
								</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
						</div>
						<!-- END PORTLET MAIN -->
					</div>
					<!-- END BEGIN PROFILE SIDEBAR -->

					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Mi Perfil</span>
										</div>
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_1" data-toggle="tab">Información Personal</a>
											</li>
											<li>
												<a href="#tab_1_2" data-toggle="tab">Cambiar Imagen</a>
											</li>
											<li>
												<a href="#tab_1_3" data-toggle="tab">Cambiar Clave</a>
											</li>
										</ul>
									</div>
									<div class="portlet-body">
										<div class="tab-content">
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane active" id="tab_1_1">
												<form role="form" action="" method="POST" name="editar-perfil" id="editar-perfil">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Email</label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-envelope"></i>
																</span>
																<input type="text" name="email" placeholder="Email" class="form-control qtipmensaje" disabled/>
															</div>
														</div>

														<div class="form-group">
															<label class="control-label">Nombres</label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-user"></i>
																</span>
																<input type="text" name="nombres" placeholder="Nombres" class="form-control qtipmensaje"/>
															</div>
														</div>

														<div class="form-group">
															<label class="control-label">Apellidos</label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-user"></i>
																</span>
																<input type="text" name="apellidos" placeholder="Apellidos" class="form-control qtipmensaje"/>
															</div>
														</div>
													</div>
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Celular</label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-mobile"></i>
																</span>
																<input type="text" name="celular" placeholder="Celular" class="form-control qtipmensaje"/>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label">Teléfono</label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-phone"></i>
																</span>
																<input type="text" name="telefono" placeholder="Teléfono" class="form-control qtipmensaje"/>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label">Ocupación</label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-suitcase"></i>
																</span>
																<input type="text" name="ocupacion" placeholder="Ocupación" class="form-control qtipmensaje"/>
															</div>
														</div>
													</div>

													<div class="col-md-6 text-right padding-right-5">
														<div class="margiv-top-10">
															<a href="javascript:;" class="btn green-haze" id="btn-guardar-cambios-perfil">
																<i class="fa fa-save"></i>
															Guardar Cambios </a>
														</div>
													</div>
													<div class="col-md-6 text-left padding-left-5">
														<div class="margiv-top-10">
															<a href="javascript:;" class="btn btn-danger" id="btn-cancelar-cambios-perfil">
																<i class="fa fa-close"></i>
															Cancelar </a>
														</div>
													</div>
												</form>
											</div>
											<!-- END PERSONAL INFO TAB -->
											<!-- CHANGE AVATAR TAB -->
											<div class="tab-pane" id="tab_1_2">
												<br>
												<div class="clearfix margin-top-10">
													<span class="label label-danger">NOTE! </span>
													<span> &nbsp; Peso Máximo: <span class="js-maxfilesize-1"></span>MB; Tipo de archivos: jpg, png, gif; <span class="js-recomendacion-tamano-1"></span> Resolución 72;</span>
												</div>
												<br>
												<input id="input-subir-avatar" name="archivos[]" type="file" multiple class="file-loading ">
												<div class="clearfix"></div>
													<br><br>
													<div class="row mix-grid" id="mostrar-imagenes"></div>
											</div>
											<!-- END CHANGE AVATAR TAB -->
											<!-- CHANGE PASSWORD TAB -->
											<div class="tab-pane" id="tab_1_3">
												<form action="" method="POST" name="editar-clave" id="editar-clave">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Clave Actual</label>
															<div class="input-group input-icon right">
																<span class="input-group-addon">
																	<i class="fa fa-lock"></i>
																</span>
																<i class="fa faicono"></i>
																<input type="password" class="form-control qtipmensaje" name="password" id="password" />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Nueva Clave</label>
															<div class="input-group input-icon right">
																<span class="input-group-addon">
																	<i class="fa fa-lock"></i>
																</span>
																<i class="fa faicono"></i>
																<input type="password" class="form-control qtipmensaje" name="passwordnueva" id="passwordnueva" />
															</div>
														</div>
														<div class="form-group">
															<label class="control-label">Repetir Nueva Clave</label>
															<div class="input-group input-icon right">
																<span class="input-group-addon">
																	<i class="fa fa-lock"></i>
																</span>
																<i class="fa faicono"></i>
																<input type="password" class="form-control qtipmensaje" name="passwordnuevarepetir" id="passwordnuevarepetir"/>
															</div>
														</div>
													</div>

													<div class="col-md-6 text-right padding-right-5">
														<div class="margiv-top-10">
															<a href="javascript:;" class="btn green-haze" id="btn-guardar-clave">
																<i class="fa fa-save"></i>
															Cambiar Clave </a>
														</div>
													</div>
													<div class="col-md-6 text-left padding-left-5">
														<div class="margiv-top-10">
															<a href="javascript:;" class="btn default" id="btn-cancelar-clave">
																<i class="fa fa-close"></i>
															Cancelar </a>
														</div>
													</div>

												</form>
											</div>
											<!-- END CHANGE PASSWORD TAB -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>