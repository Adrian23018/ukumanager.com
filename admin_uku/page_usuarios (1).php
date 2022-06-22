<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	//$id = $_GET["id"];
	//$id = preg_replace('/[^0-9]/','',$id);

	$nombrePageUsado = 'usu';
	$tituloPage = 'Usuarios';
	$actualPage = 'page_usuarios';
	$btnPageNuevoUrl = 'page_usuariosNuevo';
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
				<br>
				<!--BEGIN DATATABLE -->
				<table id="dataTableServer" class="table table-striped table-hover table-bordered display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
							<th>Id</th>
							<th>Tipo de inscripción</th>
							<th>Nombre</th>
							<th>Email</th>
							<th>App en:</th>
							<th>Nacionalidad</th>
							<th>Empleados</th>
			            </tr>
			        </thead>
			        <tfoot>
			            <tr>
			            	<th>Id</th>
							<th>Tipo de inscripción</th>
							<th>Nombre</th>
							<th>Email</th>
							<th>App en:</th>
							<th>Nacionalidad</th>
							<th>Empleados</th>
			            </tr>
			        </tfoot>
			    </table>
				<!--END DATATABLE -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->