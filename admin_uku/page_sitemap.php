<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	//$id = $_GET["id"];
	//$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'sitemap';
	$tituloPage = 'Sitemap';
	$actualPage = 'page_sitemap';
	//$btnPageNuevoUrl = 'page_Nuevo';
?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>

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
					<a href="javascript:;" class="reload reload-table">
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="btn-group">
					<div class="clearfix margin-top-10">
						<span class="label label-danger">NOTE! </span>
						<span> &nbsp; Recuerda generar el sitemap cada vez que cree, edite o elimine una noticia, un producto o un proyecto.</span>
					</div>
					<br>
					<a href="javascript:;" class="btn green-adele btn-sitemap">
						Generar Sitemap <i class="fa fa-code"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->