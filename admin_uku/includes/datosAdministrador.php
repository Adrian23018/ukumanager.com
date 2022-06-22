<?php
	//si existe pagina validamos que el usuario tenga permiso sobre ella
	if (!isset($_GET['page'])) {
		//Buscamos si existe una sección por defecto y el usuario tiene permiso
		$select_default = "SELECT * FROM a_tbl_seccion AS sec INNER JOIN a_tbl_gruposeccion AS gp ON gp_id=sec_gp_id INNER JOIN a_tbl_cuentas_x_gruposeccion AS cgp ON gp_id=cgp_gp_id WHERE sec_defecto=1 AND cgp_cue_id=".$_SESSION[_sessionAdmin];
		$rs_default = mysqli_query($_conection->connect(), $select_default);
		$row_seccion = mysqli_fetch_assoc($rs_default);

		//Capturamos id de la sección por defecto
		if($row_seccion["sec_id"]){
			$secId = $row_seccion["sec_id"];
			
		}
	}else{
		//Traemos los datos de la sección
		$select_seccion = sprintf("SELECT * FROM a_tbl_seccion AS sec INNER JOIN a_tbl_gruposeccion AS gp ON gp_id=sec_gp_id WHERE sec_page=%s",
			GetSQLValueString($_GET["page"],"text")
		);
		$rs_seccion = mysqli_query($_conection->connect(), $select_seccion);
		$row_seccion = mysqli_fetch_assoc($rs_seccion);

		//Capturamos id de la sección
		if($row_seccion["sec_id"]){
			$secId = $row_seccion["sec_id"];
		}
	}


	//Si existe el id de la sección a mostrar
	if($secId){
		$secScript = $row_seccion["sec_script"];
		$secGrupo = $row_seccion["gp_id"];
		$secPage = $row_seccion["sec_page"];

		$_GET["page"] = $row_seccion["sec_page"];
	}

	//Armar Menú
	if (isset($_SESSION[_sessionAdmin])) {
		//Sacamos todos los grupos a los que los usuarios tienen permiso
		$select_group = sprintf("SELECT * FROM a_tbl_gruposeccion AS gp INNER JOIN a_tbl_cuentas_x_gruposeccion AS det ON gp_id=cgp_gp_id WHERE gp_estado=1 AND cgp_cue_id=%s ORDER BY gp_posicion",
			GetSQLValueString($_SESSION[_sessionAdmin], "text")
		);
		$rs_group = mysqli_query($_conection->connect(), $select_group);

		//Grupos de las secciones
		while ($row_group = mysqli_fetch_assoc($rs_group)){
			$grupoId = $row_group["gp_id"];
			$grupoNombre = utf8_encode($row_group["gp_nombre"]);

			//Subsecciones del grupo
			$select_seccion = "SELECT * FROM a_tbl_seccion WHERE sec_menu=1 AND sec_gp_id=".$grupoId." ORDER BY sec_posicion";
			$rs_seccion = mysqli_query($_conection->connect(), $select_seccion);
			//Recorremos las subsecciones
			$i_seccion = 0;	$menu_seccion = ""; $sbsecNombreInterno = ""; $sbsecUrlInterno = ""; $current = ""; $sec_icono = "";

			while($row_seccion = mysqli_fetch_assoc($rs_seccion)){
				$sec_icono = '';
				$sbsecUrlInterno = utf8_encode($row_seccion["sec_page"]);
				$sbsecNombreInterno = utf8_encode($row_seccion["sec_nombre"]);
				$sbsecIconoInterno = utf8_encode($row_seccion["sec_icono"]);
				if ($sbsecIconoInterno) {
					$sec_icono = '<i class="fa fa-'.$sbsecIconoInterno.'"></i>';
				}
				//Sub menu
				$menu_seccion .= 
					'<li>
						<a href="?page=' . $sbsecUrlInterno . '">
							' . $sec_icono . '
							' . $sbsecNombreInterno . '
						</a>
					</li>';
				$i_seccion++;
			}

			//Miramos si es el grupo activo
			if ($secGrupo == $grupoId){
				$current  = " active";
			}

			//Mas de una sección
			if ( ($grupoId == 17 && $_SESSION[_sessionIdioma] == 1) ) {

			}else{
				if($i_seccion>1){
					$menu .= '
						<li class=" ' . $current . '">
							<a href="javascript:;">
								<i class="fa fa-file-text"></i>
								' . $grupoNombre . '
								<span class="arrow "></span>
							</a>

							<ul class="sub-menu">
								' . $menu_seccion . '
							</ul>
						</li>';
				}elseif($i_seccion==1){
					//Una sola Seccion
					$menu .= '
						<li class="' . $current . '">				
							<a href="?page=' . $sbsecUrlInterno . '" >
								' . $sec_icono . '
								' . $sbsecNombreInterno . '
							</a>
						</li>';
				}
			}

		}
	}

	//Colocamos el campo para el Dashboard
	if ($menu) {
		if ($_SESSION[_sessionAdmin] == 1) {
			if ($_GET['page'] == 'dashboard') {
				$secPage = 'dashboard';
				$secScript = '<script type="text/javascript" src="js/dashboard.js"></script>';
				$activeDashboard = 'active';
			}

			$menu = '<li class="'.$activeDashboard.'">
							<a href="?page=dashboard" >
								<i class="fa fa-home"></i>
								Dashboard
							</a>
						</li>'.$menu;

		}
	}
	
?>