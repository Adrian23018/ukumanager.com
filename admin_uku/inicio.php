<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<?php
	require 'includes/autoloader.php';
	if (!$_SESSION[_sessionIdioma]) {
		$_SESSION[_sessionIdioma] = 1;
	}

	require 'includes/validacionSession.php';

	require 'includes/datosAdministrador.php';

	//Idioma
	$sql = sprintf("SELECT * FROM g_tbl_idiomas WHERE idi_estado_admin=1");
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	$iConteoIdioma = 0;
	while ($row_sql = mysqli_fetch_assoc($rs_sql)) {
		$idi_id = $row_sql["idi_id"];
		$idi_nombre = utf8_encode($row_sql["idi_nombre"]);

		$activeSelect = ($_SESSION[_sessionIdioma] == $idi_id) ? 'selected' : '';
		$optionIdioma .= '<option '. $activeSelect .' value="'. $idi_id .'">'. $idi_nombre .'</option>';

		$optionIdiomaOtros .= ($_SESSION[_sessionIdioma] != $idi_id) ? '<option '. $activeSelect .' value="'. $idi_id .'">'. $idi_nombre .'</option>' : '';
		$iConteoIdioma++;
	}

	//Titulo y logos
	$sql = sprintf("SELECT * FROM a_tbl_pagina WHERE pag_id=1");
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	//Si no existe error al hacer el sql
	if ($rs_sql) {
		$row_sql = mysqli_fetch_assoc($rs_sql);

		$pagTitulo = 'Administrador - ' . utf8_encode($row_sql['pag_titulo']);
		$pagLogo = utf8_encode($row_sql['pag_logo']);
		$pagLogo2 = utf8_encode($row_sql['pag_logo2']);
		$pagLink = utf8_encode($row_sql['pag_link']);
		$pagRealizado = utf8_encode($row_sql['pag_realizado']);

		if ($pagLogo2 && file_exists('img/'.$pagLogo2))
			$pagLogo2 = '<img src="img/'.$pagLogo2.'" alt="logo" height="30" class="logo-default"/>';
		else
			$pagLogo2 = '';
	}

	//Titulo y logos
	$sql = sprintf("SELECT * FROM g_tbl_pagina WHERE pag_idi_id=%s",
		GetSQLValueString($_SESSION[_sessionIdioma], "int")
	);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	if ($rs_sql) {
		$row_sql = mysqli_fetch_assoc($rs_sql);
		$pagTitulo = 'Administrador - ' . utf8_encode($row_sql['pag_titulo']);
	}
	

	//Cargar Datos del Usuario
	$sql = 	sprintf("SELECT * FROM a_tbl_cuentas WHERE cue_id=%s", 
						GetSQLValueString($_SESSION[_sessionAdmin], "int")
					);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	//Si no existe error al hacer el sql
	if ($rs_sql) {
		$row_sql = mysqli_fetch_assoc($rs_sql);
		$userCuenta = utf8_encode($row_sql['cue_user']);
		$nombreCuenta = $row_sql['cue_nombres'] . " " . $row_sql['cue_apellidos'];
	}

	//Cargar Avatar, persona logueada
	$sql = 	sprintf("SELECT * FROM g_tbl_imagenes WHERE img_tabla='cuentas' AND img_id_tabla=%s", 
						GetSQLValueString($_SESSION[_sessionAdmin], "int")
					);
	$rs_sql = mysqli_query($_conection->connect(), $sql);
	//Si no existe error al hacer el sql
	if ($rs_sql) {
		$row_sql = mysqli_fetch_assoc($rs_sql);
		$imagenCuenta = utf8_encode($row_sql['img_nombre']) . '.' . utf8_encode($row_sql['img_extension']);
		$pathImagen = "img/cuentas/".$_SESSION[_sessionAdmin]."/".$imagenCuenta;
		if ($row_sql['img_nombre'] && file_exists($pathImagen)){
			$imagenCuenta = '<img alt="" class="img-circle img-perfil" src="'.$pathImagen.'"/>';
		}else{
			$segundaletra = explode(" ", $nombreCuenta);
			$segundaletra = str_replace(" ", "", $segundaletra[1]);
			$segundaletra = strtolower($segundaletra[0]);

			$nombreUsuario = str_replace(" ", "", $nombreCuenta);
			$primeraletra = strtolower($nombreUsuario[0]);
			if($arrayLetras[$primeraletra]){
				$color = $arrayLetras[$primeraletra];
			}else{
				$color = $arrayColores[array_rand($arrayColores)];
			}
			$imagenCuenta = '<div class="img-circle letras-colores tamano-1" style="background: #'.$color.'">'.utf8_encode($primeraletra.$segundaletra).'</div>';
			//$imagenCuenta = '<img alt="" class="img-circle img-perfil" src="assets/admin/layout/img/avatar_small.jpg"/>';
		}
	}

	
?>
<title><?php echo $pagTitulo; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/pages/css/portfolio.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link href="assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link href="assets/global/plugins/nouislider/jquery.nouislider.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/nouislider/jquery.nouislider.pips.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet"/>
<link href="assets/admin/pages/css/image-crop.css" rel="stylesheet"/>
<link href="js/plugins/bootstrap-fileinput/fileinput.css" rel="stylesheet" type="text/css"/>
<link href="js/plugins/cropper/cropper.min.css" rel="stylesheet">
<link href="js/plugins/cropper/cropper-avatar.css" rel="stylesheet">
<link href="assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-summernote/summernote.css">
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-toastr/toastr.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/typeahead/typeahead.css">
<link rel="stylesheet" type="text/css" href="assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN THEME STYLES -->
<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
<link href="assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="js/plugins/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css"/>
<link href="css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="img/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content page-style-square">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="index.html">
			<?php echo $pagLogo2; ?>
			<!--<img src="assets/admin/layout/img/logo.png" alt="logo" class="logo-default"/>-->
			</a>
			<div class="menu-toggler sidebar-toggler hide">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<?php if ( $iConteoIdioma > 1 ){ ?>
			<span class="idioma">Idioma: </span>
			<select name="select-idioma" class="js-select-idioma">
				<?php echo $optionIdioma; ?>
			</select>
			<?php } ?>

			<a href="<?php echo $pagLink; ?>" target="_blank" class="display-inlineblock a-ver-pagina"> <?php echo _titulo_verpagina; ?> </a>
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<li class="dropdown dropdown-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<span id="avatar-id-modify">
						<?php echo $imagenCuenta; ?>
					</span>
					<span class="username username-hide-on-mobile js-nombre-usuario">
					<?php echo $userCuenta; ?> </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="inicio.php?page=page_editarPerfil">
							<i class="icon-user"></i> Mi Perfil </a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="javascript:;" class="js-cerrar-sesion">
							<i class="icon-key"></i> Salir </a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper hidden">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<!--<form class="sidebar-search " action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Buscar...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>-->
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<div class="margin-top-20"></div>
				<?php echo $menu; ?>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php 
				//Archivo pagina
				if( $secPage ){
					include $secPage . '.php'; 
				}
			?>

		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		<?php echo date("Y") . $pagRealizado; ?>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->

<div class="modal fade" id="modal-cropper" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Cortar Imagen</h4>
			</div>
			<div class="modal-body avatar-cargador">
				<div class="avatar-body">
					<!-- Crop and preview -->
					<div class="row">
						<div class="col-md-12 avatar-advertencias"></div>
						<div class="col-md-9">
							<div class="avatar-wrapper"></div>
						</div>
						<div class="col-md-3">
							<div class="avatar-preview preview-lg"></div>
							<!--<div class="avatar-preview preview-md"></div>
							<div class="avatar-preview preview-sm"></div>-->
							<div>
								<button type="button" id="eliminarimagenescrop" class="btn btn-danger margin-top-20 width-98">Eliminar Recorte</button>
								<form action="" method="post" class="hidden">
									<input type="hidden" id="crop_x" name="x"/>
									<input type="hidden" id="crop_y" name="y"/>
									<input type="hidden" id="crop_w" name="w"/>
									<input type="hidden" id="crop_h" name="h"/>
									<input type="hidden" id="crop_rotate" name="rotate"/>
									<input type="hidden" id="wimg" name="wimg"/>
									<input type="hidden" id="himg" name="himg"/>
									<input type="hidden" id="cropboxdata" name="cropboxdata"/>
									<input type="hidden" id="canvasdata" name="canvasdata"/>
								</form>
								<button type="button" id="manejoimagenescrop" class="btn btn-large btn-success margin-top-10 width-98">Guardar Cambios</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="margin-top-10"></div>
						<div class="col-md-9">
							<div class="sin-padding col-md-4">
								<div class="btn-group">
									<button class="btn green-adele" title="Mover" type="button" data-option="move" data-method="setDragMode"><span class="fa fa-arrows"></span></button>
									<button class="btn green-adele" title="Cortar" type="button" data-option="crop" data-method="setDragMode"><span class="fa fa-crop"></span></button>
									<button class="btn green-adele" data-method="zoom" data-option="0.1" type="button" title="Zoom In"><span class="fa fa-search-plus"></span></button>
									<button class="btn green-adele" data-method="zoom" data-option="-0.1" type="button" title="Zoom Out"><span class="fa fa-search-minus"></span></button>
								</div>
							</div>
							<div class="sin-padding col-md-4 text-right">
								<div class="btn-group">
									<button class="btn green-adele" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">Rotar Izquierda</button>
									<button class="btn green-adele" data-method="rotate" data-option="-15" type="button">-15deg</button>
								</div>
							</div>
							<div class="sin-padding col-md-4 text-right">
								<div class="btn-group">
									<button class="btn green-adele" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">Rotar Derecha</button>
									<button class="btn green-adele" data-method="rotate" data-option="15" type="button">15deg</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--termina avatar -->
			</div>
			<div class="clearfix"></div>
			<div class="margin-top-10"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-formContactenos" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Leer Mensaje</h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="clearfix"></div>
			<div class="margin-top-10"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

 <script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 

<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<script src="assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="js/plugins/bootstrap-fileinput/fileinput.js" type="text/javascript"></script>
<script src="js/plugins/bootstrap-fileinput/fileinput_refreshExtraData.js" type="text/javascript"></script>
<script src="js/plugins/bootstrap-fileinput/fileinput_locale_es.js" type="text/javascript"></script>
<script src="js/plugins/cropper/cropper.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.rowReordering.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.columnFilter.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-summernote/lang/summernote-es-ES.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/jquery-mixitup/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/jcrop/js/jquery.color.js"></script>
<script type="text/javascript" src="assets/global/plugins/jcrop/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/nouislider/jquery.nouislider.all.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/profile.js" type="text/javascript"></script>
<script src="assets/global/scripts/datatable.js"></script>
<script src="js/plugins/qtip/jquery.qtip.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init(); // init quick sidebar
   Demo.init(); // init demo features 
   Index.init();   
   Index.initDashboardDaterange();
   //Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   Tasks.initDashboardWidget();
   Profile.init(); // init page demo

});
</script>
<script src="js/funcionesGlobales.js" type="text/javascript"></script>
<script src="js/fileinputLogs.js" type="text/javascript"></script>
<!-- Cargar Js De cada Sección -->
<?php 
	echo $secScript;
?>

<?php if ($latitud && $longitud) { ?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD7RHz5QAzOIWyqQFNOCYLkBSbzrLrW3Pg&sensor=true"></script>
<script type="text/javascript">
// VARIABLES GLOBALES JAVASCRIPT
var geocoder;
var marker;
var latLng;
var latLng2;
var map;

// INICiALIZACION DE MAPA
function initialize() {
  geocoder = new google.maps.Geocoder();
  latLng = new google.maps.LatLng(<?php echo $latitud;?> ,<?php echo $longitud;?>);
  map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom:<?php echo $zoom;?>,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.<?php echo $tipo_mapa;?>
  });

  /*var companyLogo = new google.maps.MarkerImage('template/images/marker-google-maps.png',
    new google.maps.Size(100,50),
    new google.maps.Point(0,0),
    new google.maps.Point(50,50)
  );*/

  // CREACION DEL MARCADOR  
  marker = new google.maps.Marker({
    position: latLng,
    title: 'Arrastra el marcador si quieres moverlo',
    map: map,
    draggable: true
    //,icon: companyLogo
  });
 

    //console.log(google.maps);
 
  // Escucho el CLICK sobre el mapa y si se produce actualizo la posicion del marcador 
  google.maps.event.addListener(map, 'click', function(event) {
     updateMarker(event.latLng);
   });
  
  // Inicializo los datos del marcador
  //    updateMarkerPosition(latLng);
     
      geocodePosition(latLng);
 
  // Permito los eventos drag/drop sobre el marcador
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Arrastrando...');
  });
 
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Arrastrando...');
    updateMarkerPosition(marker.getPosition());
  });
 
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Arrastre finalizado');
    geocodePosition(marker.getPosition());
  });
 
}

// Permito la gestion de los eventos DOM
google.maps.event.addDomListener(window, 'load', initialize());

// ESTA FUNCION OBTIENE LA DIRECCION A PARTIR DE LAS COORDENADAS POS
function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('No puedo encontrar esta direccion.');
    }
  });
}

// OBTIENE LA DIRECCION A PARTIR DEL LAT y LON DEL FORMULARIO
function codeLatLon() {
      str= $("#longitud").val() + " , " + $("#latitud").val();
      latLng2 = new google.maps.LatLng($("#latitud").val() ,$("#longitud").val());
      marker.setPosition(latLng2);
      map.setCenter(latLng2);
      geocodePosition (latLng2);
      // document.form_mapa.direccion.value = str+" OK";
}

// OBTIENE LAS COORDENADAS DESDE lA DIRECCION EN LA CAJA DEL FORMULARIO
function codeAddress() {
        var address = $("#direccion-mapa").val();
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
             updateMarkerPosition(results[0].geometry.location);
             marker.setPosition(results[0].geometry.location);
             map.setCenter(results[0].geometry.location);
           } else {
            alert('ERROR : ' + status);
          }
        });
      }

// OBTIENE LAS COORDENADAS DESDE lA DIRECCION EN LA CAJA DEL FORMULARIO
function codeAddress2 (address) {
          
          geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
             updateMarkerPosition(results[0].geometry.location);
             marker.setPosition(results[0].geometry.location);
             map.setCenter(results[0].geometry.location);
             $("#direccion-mapa").val(address);
           } else {
            alert('ERROR : ' + status);
          }
        });
      }

function updateMarkerStatus(str) {
    $("#direccion-mapa").val(str);
}

// RECUPERO LOS DATOS LON LAT Y DIRECCION Y LOS PONGO EN EL FORMULARIO
function updateMarkerPosition (latLng) {
  $("#longitud").val(latLng.lng());
  $("#latitud").val(latLng.lat());
}

function updateMarkerAddress(str) {
    $("#direccion-mapa").val(str)
}

// ACTUALIZO LA POSICION DEL MARCADOR
function updateMarker(location) {
  marker.setPosition(location);
  updateMarkerPosition(location);
  geocodePosition(location);
}

$(document).ready(function(){
    $("#li_contacto").bind("click", function(event){
      $("#li_datos_generales").removeAttr("class", "current");
      $("#li_mapa_contacto").removeAttr("class", "current");
      $("#datos_generales").hide();
      $("#mapa_contacto").hide();

      $("#li_contacto").attr("class", "current");
      $("#contacto").show();
    });

    $("#li_datos_generales").bind("click", function(event){
      $("#li_mapa_contacto").removeAttr("class", "current");
      $("#li_contacto").removeAttr("class", "current");
      $("#mapa_contacto").hide();
      $("#contacto").hide();

      $("#li_datos_generales").attr("class", "current");
      $("#datos_generales").show();
    });

    $("#li_mapa_contacto").bind("click", function(event){
      $("#li_datos_generales").removeAttr("class", "current");
      $("#li_contacto").removeAttr("class", "current");
      $("#datos_generales").hide();
      $("#contacto").hide();

      $("#li_mapa_contacto").attr("class", "current");
      $("#mapa_contacto").show();
    });

    $("#codeAddress").bind("click", function(event){
        event.preventDefault();
        codeAddress();
    });

    $("#guardarmapa").bind("click", function(event){
        event.preventDefault();
        var latitud = $('#latitud').val();
        var longitud = $('#longitud').val();
        $.ajax({
            url: "ajax_php/gestionContactenosInformacion.php",
            data: {
                tipo: "guardar_ubicacion_mapa",
                latitud:latitud,
                longitud:longitud,
                zoom: map.getZoom()
            },
            type: "post",
            dataType: "json",
            success: function(json){
            	if (json.result['isOk']) {
					//Mensaje de 
					initToastr('success', json.result["success"]["mensaje"], mensajesJS['successTitle']);
				}else{
					initToastr('success', json.result["error"]["mensaje"], mensajesJS['errorTitle']);
				}
            }
        });
    });

    $("#codeLatLon").bind("click", function(event){
        event.preventDefault();
        codeLatLon();
    });
    
});
</script>
<?php } ?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>