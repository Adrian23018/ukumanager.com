<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	//$id = $_GET["id"];
	//$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'banp';
	$tituloPage = 'Banner Principal';
	$actualPage = 'page_bannerPrincipal';
	$btnPageNuevoUrl = 'page_bannerPrincipalNuevo';
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
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<a href="inicio.php?page=<?php echo $btnPageNuevoUrl; ?>" class="btn green-adele">
								Crear <i class="fa fa-plus"></i>
								</a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="btn-group pull-right">
								<div class="btn btn-info js-btn-ordenar">Ordenar</div>
								<div class="btn btn-info js-btn-salir-ordenar hidden">Salir de Ordenar</div>
								
							</div>
						</div>
					</div>
				</div>
				<br><br>
				<?php if ( $iConteoIdioma > 1 ){ ?>
				<div class="table-toolbar" style="margin-top: 0px;">
					<div class="row">
						<div class="col-md-6 text-left">
							<!-- Duplicar Idioma -->
								<span class="idioma">Duplicar a: </span>
								<select name="duplicar-idioma" id="duplicar-idioma" class="js-select2">
									<?php echo $optionIdiomaOtros; ?>
								</select>
								<a href="javascript:;" class="btn green-adele js-duplicar-grupal">Aplicar</a>
						</div>
						<div class="col-md-6">
							
						</div>
					</div>
				</div>
				<?php } ?>
				<!--BEGIN DATATABLE -->
				<table class="table table-striped table-hover table-bordered" id="dataTable">
					<thead>
						<tr>
							<th>Cargando...</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
				<!--END DATATABLE -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->