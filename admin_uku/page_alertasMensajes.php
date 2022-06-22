<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	$nombrePageUsado = 'msj';
	$tituloPage = 'Alertas y/o Mensajes';
	$actualPage = 'page_alertasMensajes';

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
								Asuntos Correos
								<span class="badge"></span>
							</a>
						</li>
						<li>
							<a href="#tab_respuestas" data-toggle="tab">
								Respuesta Acciones Formulario
								<span class="badge"></span>
							</a>
						</li>
						<li>
							<a href="#tab_botones" data-toggle="tab">
								Botones
								<span class="badge"></span>
							</a>
						</li>
						<li>
							<a href="#tab_errores" data-toggle="tab">
								Errores
								<span class="badge"></span>
							</a>
						</li>
						<li>
							<a href="#tab_mensajes_template" data-toggle="tab">
								Mensajes Template
								<span class="badge"></span>
							</a>
						</li>
					</ul>
					<form role="form" action="" method="POST" name="editar-<?php echo $nombrePageUsado; ?>" id="editar-<?php echo $nombrePageUsado; ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_general">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Contacto</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-correo_as_contacto" id="<?php echo $nombrePageUsado; ?>-correo_as_contacto" placeholder="msj_correo_as_contacto" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Suscribirse</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-correo_as_suscribirse" id="<?php echo $nombrePageUsado; ?>-correo_as_suscribirse" placeholder="msj_correo_as_suscribirse" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Registro</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-correo_as_registrarse" id="<?php echo $nombrePageUsado; ?>-correo_as_registrarse" placeholder="msj_correo_as_registrarse" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Recuperar Contraseña</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-correo_as_recuperar_contrasena" id="<?php echo $nombrePageUsado; ?>-correo_as_recuperar_contrasena" placeholder="msj_correo_as_recuperar_contrasena" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Bienvenido</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-correo_as_bienvenido" id="<?php echo $nombrePageUsado; ?>-correo_as_bienvenido" placeholder="msj_correo_as_bienvenido" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

							</div>
							<div class="tab-pane" id="tab_respuestas">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Respuesta Registrarse</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-respuesta_form_registrarse" id="<?php echo $nombrePageUsado; ?>-respuesta_form_registrarse" placeholder="msj_respuesta_form_registrarse" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Respuesta Error Registrarse</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-respuesta_form_no_registrarse" id="<?php echo $nombrePageUsado; ?>-respuesta_form_no_registrarse" placeholder="msj_respuesta_form_no_registrarse" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Respuesta Contactar</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-respuesta_form_contacto" id="<?php echo $nombrePageUsado; ?>-respuesta_form_contacto" placeholder="msj_respuesta_form_contacto" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Respuesta Error Contactar</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-respuesta_form_no_contacto" id="<?php echo $nombrePageUsado; ?>-respuesta_form_no_contacto" placeholder="msj_respuesta_form_no_contacto" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Respuesta Suscribirse</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-respuesta_form_suscribirse" id="<?php echo $nombrePageUsado; ?>-respuesta_form_suscribirse" placeholder="msj_respuesta_form_suscribirse" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Respuesta Error Suscribirse</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-respuesta_form_no_suscribirse" id="<?php echo $nombrePageUsado; ?>-respuesta_form_no_suscribirse" placeholder="msj_respuesta_form_no_suscribirse" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_botones">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Botón Enviar</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-btn_enviar" id="<?php echo $nombrePageUsado; ?>-btn_enviar" placeholder="msj_btn_enviar" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Botón Enviando</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-btn_enviando" id="<?php echo $nombrePageUsado; ?>-btn_enviando" placeholder="msj_btn_enviando" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Botón Enviado</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-btn_enviado" id="<?php echo $nombrePageUsado; ?>-btn_enviado" placeholder="msj_btn_enviado" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_errores">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Requerido General</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_requerido_general" id="<?php echo $nombrePageUsado; ?>-error_requerido_general" placeholder="msj_error_requerido_general" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Requerido Individual</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_requerido_campo" id="<?php echo $nombrePageUsado; ?>-error_requerido_campo" placeholder="msj_error_requerido_campo" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Nombre</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_nombre" id="<?php echo $nombrePageUsado; ?>-error_nombre" placeholder="msj_error_nombre" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Teléfono</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_telefono" id="<?php echo $nombrePageUsado; ?>-error_telefono" placeholder="msj_error_telefono" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Dirección</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_direccion" id="<?php echo $nombrePageUsado; ?>-error_direccion" placeholder="msj_error_direccion" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Asunto</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_asunto" id="<?php echo $nombrePageUsado; ?>-error_asunto" placeholder="msj_error_asunto" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Email</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_email" id="<?php echo $nombrePageUsado; ?>-error_email" placeholder="msj_error_email" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Mensaje</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_mensaje" id="<?php echo $nombrePageUsado; ?>-error_mensaje" placeholder="msj_error_mensaje" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Cédula</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_cedula" id="<?php echo $nombrePageUsado; ?>-error_cedula" placeholder="msj_error_cedula" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Empresa</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_empresa" id="<?php echo $nombrePageUsado; ?>-error_empresa" placeholder="msj_error_empresa" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error País</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_pais" id="<?php echo $nombrePageUsado; ?>-error_pais" placeholder="msj_error_pais" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Ciudad</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_ciudad" id="<?php echo $nombrePageUsado; ?>-error_ciudad" placeholder="msj_error_ciudad" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Departamento</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_departamento" id="<?php echo $nombrePageUsado; ?>-error_departamento" placeholder="msj_error_departamento" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Sexo</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_sexo" id="<?php echo $nombrePageUsado; ?>-error_sexo" placeholder="msj_error_sexo" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Estado Civil</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_estado_civil" id="<?php echo $nombrePageUsado; ?>-error_estado_civil" placeholder="msj_error_estado_civil" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Fecha</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_fecha" id="<?php echo $nombrePageUsado; ?>-error_fecha" placeholder="msj_error_fecha" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Contraseña</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_contrasena" id="<?php echo $nombrePageUsado; ?>-error_contrasena" placeholder="msj_error_contrasena" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Confirmar Contraseña</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_contrasena_confirmar" id="<?php echo $nombrePageUsado; ?>-error_contrasena_confirmar" placeholder="msj_error_contrasena_confirmar" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Error Coincidencia Contraseña</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-error_coincidencia" id="<?php echo $nombrePageUsado; ?>-error_coincidencia" placeholder="msj_error_coincidencia" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_mensajes_template">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Hola,</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-mensaje_correo_hola" id="<?php echo $nombrePageUsado; ?>-mensaje_correo_hola" placeholder="msj_mensaje_correo_hola" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">Header Mensaje (Contáctenos)</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<textarea type="text" name="<?php echo $nombrePageUsado; ?>-mensaje_correo_header" id="<?php echo $nombrePageUsado; ?>-mensaje_correo_header" placeholder="msj_mensaje_correo_header" class="form-control qtipmensaje"></textarea>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">Header Mensaje (Newsletter)</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<textarea type="text" name="<?php echo $nombrePageUsado; ?>-mensaje_correo_header_newsletter" id="<?php echo $nombrePageUsado; ?>-mensaje_correo_header_newsletter" placeholder="msj_mensaje_correo_header_newsletter" class="form-control qtipmensaje"></textarea>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Enviado a:</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-mensaje_correo_enviado_a" id="<?php echo $nombrePageUsado; ?>-mensaje_correo_enviado_a" placeholder="msj_mensaje_correo_enviado_a" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Enviado a: (Continuación)</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<input type="text" name="<?php echo $nombrePageUsado; ?>-mensaje_correo_enviado_a_resto" id="<?php echo $nombrePageUsado; ?>-mensaje_correo_enviado_a_resto" placeholder="msj_mensaje_correo_enviado_a_resto" class="form-control qtipmensaje"/>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">Footer</label>
										<div class="input-group input-icon right">
											<span class="input-group-addon">
												<i class="fa fa"></i>
											</span>
											<i class="fa faicono"></i>
											<textarea type="text" name="<?php echo $nombrePageUsado; ?>-mensaje_correo_footer" id="<?php echo $nombrePageUsado; ?>-mensaje_correo_footer" placeholder="msj_mensaje_correo_footer" class="form-control qtipmensaje"></textarea>
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