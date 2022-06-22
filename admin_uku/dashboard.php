<?php
	//Verificamos que se encuentre logueado
	include 'include/validacionSession.php';
?>
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat blue-madison">
				<div class="visual">
					<i class="fa fa-pie-chart"></i>
				</div>
				<div class="details">
					<div class="number js-espacio-total-disco">
						 
					</div>
					<div class="desc">
						 Espacio Total en Disco
					</div>
				</div>
				<a class="more" href="javascript:;">
					<!--View more <i class="m-icon-swapright m-icon-white"></i>-->
				</a>
			</div>
		</div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat red-intense">
				<div class="visual">
					<i class="fa fa-pie-chart"></i>
				</div>
				<div class="details">
					<div class="number js-espacio-libre-disco">
						 
					</div>
					<div class="desc">
						 Espacio Libre en Disco
					</div>
				</div>
				<a class="more" href="javascript:;">
					<!--View more <i class="m-icon-swapright m-icon-white"></i>-->
				</a>
			</div>
		</div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat green-haze">
				<div class="visual">
					<i class="fa fa-pie-chart"></i>
				</div>
				<div class="details">
					<div class="number js-espacio-pagina">
						 
					</div>
					<div class="desc">
						 Espacio Ocupado por Página
					</div>
				</div>
				<a class="more" href="javascript:;">
					<!--View more <i class="m-icon-swapright m-icon-white"></i>-->
				</a>
			</div>
		</div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat purple-plum">
				<div class="visual">
					<i class="fa fa-archive"></i>
				</div>
				<div class="details">
					<div class="number js-contador-archivos">
						 
					</div>
					<div class="desc">
						 Numero de Archivos
					</div>
				</div>
				<a class="more" href="javascript:;">
					<!--View more <i class="m-icon-swapright m-icon-white"></i>-->
				</a>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>

	<div>
		<div class="col-md-6 margin-top-10 sin-padding">
			<span class="label label-danger">NOTE! </span>
			<span> &nbsp; Tener máximo un archivo de backup, para evitar que se llene el disco.</span>
		</div>
		<div class="col-md-6 sin-padding">
			<a class="btn green-adele pull-right js-generar-backup" href="javascript:;"><i class="fa fa-lock"></i> Generar Backup</a>
		</div>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div>
				<div class="portlet box green-adele">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Tabla De Backups
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-hover">
						<thead>
						<tr>
							<th> Nombre </th>
							<th> Peso </th>
							<th class="hidden-480 text-center"> Descargar </th>
							<th class="text-center"> Eliminar </th>
						</tr>
						</thead>
						<tbody id="mostrar-backups">
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>