<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';
?>
<input class="hidden" id="pageActual" value="page_gruposeccion"/>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet box green-adele">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Grupo de Secciones
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
						<div class="col-md-6"></div>
						<div class="col-md-6">
							<div class="btn-group pull-right">
								<div class="btn btn-info js-btn-ordenar">Ordenar</div>
								<div class="btn btn-info js-btn-salir-ordenar hidden">Salir de Ordenar</div>
								
							</div>
						</div>
					</div>
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