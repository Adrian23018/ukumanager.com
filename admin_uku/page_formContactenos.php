<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	//$id = $_GET["id"];
	//$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'fc';
	$tituloPage = 'Contáctenos';
	$actualPage = 'page_formContactenos';
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
				</div>
				<br><br>
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