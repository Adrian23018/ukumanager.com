<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';

	//Si la seccion trae id
	$id = $_GET["id"];
	$id = preg_replace('/[^0-9]/','',$id);

	$sql = sprintf("SELECT * FROM tbl_usuarios WHERE usu_id=%s",
		GetSQLValueString($id,"int")
	);
	$rs_sql = mysql_query($sql, $_conection->connect());
	$row_sql = mysql_fetch_assoc($rs_sql);

	$nombrePageUsado = 'usu';
	$tituloPage = 'Usuarios de '. utf8_encode($row_sql['usu_nombres'].' '.$row_sql['usu_apellidos']);
	$actualPage = 'page_usuariosEmpleados';
	$btnPageNuevoUrl = 'page_usuariosEmpleadosNuevo';


?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="idSeccion" value="<?php echo $id; ?>"/>

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
							<th>Tipo</th>
							<th>Perfil</th>
							<th>Tipo Contrato</th>
							<th>Nombre</th>
							<th>Contrato</th>
			            </tr>
			        </thead>
			        <tfoot>
			            <tr>
			            	<th>Id</th>
							<th>Tipo</th>
							<th>Perfil</th>
							<th>Tipo Contrato</th>
							<th>Nombre</th>
							<th>Contrato</th>
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