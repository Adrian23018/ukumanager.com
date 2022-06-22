<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	//$id = $_GET["id"];
	//$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'googleanalytics';
	$tituloPage = 'Google Analytics';
	$actualPage = 'page_googleAnalytics';
?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="1"/>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet box green-adele">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo $tituloPage; ?>
				</div>
				<div class="tools">
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse">
					</a>
					<a href="javascript:;" class="reload">
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<p>Google Analytics es una herramienta de Analítica Web de la empresa Google. Ofrece información agrupada del tráfico que llega a los sitios web según la audiencia, la adquisición, el comportamiento y las conversiones que se llevan a cabo en el sitio web.</p>
				<form class="form-horizontal form-bordered" name="form-analytics" id="form-analytics" method="POST">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-1">Google Analitycs</label>
							<div class="col-md-11">
								<textarea class="form-control" name="googleanalytics" id="googleanalytics" rows="6" style="resize:none;"></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-6 text-right padding-right-5">
						<div class="margiv-top-10">
							<a href="javascript:;" class="btn btn-success" id="btn-guardar-googleanalytics">
								<i class="fa fa-save"></i>
							Guardar Cambios </a>
						</div>
					</div>
					<div class="col-md-6 text-left padding-left-5">
						<div class="margiv-top-10">
							<a href="javascript:;" class="btn btn-danger" id="btn-cancelar-googleanalytics">
								<i class="fa fa-close"></i>
							Cancelar </a>
						</div>
					</div>

					<hr><br><br>
				</form>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->