<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';
	//prefijo categoria anterior
	$prefijoAnt = 'pcp_';

	//Si la seccion trae id
	$id_ant = $_GET[$prefijoAnt."id"];
	$id_ant = preg_replace('/[^0-9]/','',$id_ant);

	$sql = sprintf("SELECT * FROM tbl_productos_categoriaprincipal WHERE ".$prefijoAnt."id=%s",
		GetSQLValueString($id_ant,"int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$row_sql = mysqli_fetch_assoc($rs_sql);

	$nombrePageUsado = 'pcs';
	$tituloPage = 'Productos, Categorías Secundarias de '. utf8_encode($row_sql[$prefijoAnt."nombre"]);
	$actualPage = 'page_productosCategoriaSecundaria';
	$btnPageNuevoUrl = 'page_productosCategoriaSecundariaNuevo&'.$prefijoAnt.'id='.$id_ant;
?>
<input class="hidden" id="pageActual" value="<?php echo $actualPage; ?>"/>
<input class="hidden" id="<?php echo $prefijoAnt; ?>id" value="<?php echo $id_ant; ?>"/>

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="inicio.php">Inicio</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="inicio.php?page=page_productosCategoriaPrincipal">Categorias Principales</a>
		</li>
	</ul>
</div>

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