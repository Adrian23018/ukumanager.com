<?php
session_start();

//Configuracion
require '../includes/autoloader.php';
// ini_set("display_errors", "1");
// error_reporting(E_ALL);

$pathFile = '../../imagenes-contenidos/';
$conexion = $_conection->connect();
$arrayPaises = array('', 'Colombia', 'Panamá', 'Argentina', 'Perú', 'Ecuador', 'Venezuela', 'Brasil', 'Uruguay', 'Paraguay', 'Bolivia', 'Chile');


//Validamos que sea envio por AJAX
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if(validarLogueado($_conection)){
		$aColumns = array( 'usu_id', 'usu_tipo', 'usu_nombres', 'usu_email', 'usu_nacionalidad', 'usu_pais', 'usu_sexo');
		$sIndexColumn = "usu_id";

		/* DB table to use */
		$sTable = "tbl_usuarios";
		
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string( $conexion,  $_GET['iDisplayStart'] ).", ".
				mysqli_real_escape_string( $conexion,  $_GET['iDisplayLength'] );
		}
		
		
		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
					 	".mysqli_real_escape_string( $conexion,  $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}

		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "";
		if ( $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string( $conexion,  $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string( $conexion, $_GET['sSearch_'.$i])."%' ";
			}
		}

		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sWhere
			$sOrder
			$sLimit
		";

		//echo $sQuery; 
		$rResult = mysqli_query( $conexion, $sQuery ) or die(mysqli_error($conexion));
		
		/* Data set length after filtering */
		$sQuery = "
			SELECT FOUND_ROWS()
		";
		$rResultFilterTotal = mysqli_query( $conexion, $sQuery ) or die(mysqli_error($conexion));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.")
			FROM   $sTable
		";
		$rResultTotal = mysqli_query( $conexion, $sQuery ) or die(mysqli_error($conexion));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		while ( $aRow = mysqli_fetch_array( $rResult ) )
		{
			$varEstado = '';
			$row = array();
			for ( $i=0 ; $i<=count($aColumns)-1; $i++ )
			{
				$id = $aRow[ $aColumns[0] ];
				if ( $aColumns[$i] == "usu_pais" ){
					$row[] = $arrayPaises[$aRow[$aColumns[$i]]];
				}elseif ( $aColumns[$i] == "usu_sexo" ){
					$btnProductos = '<a href="inicio.php?page=page_usuariosEmpleados&id='.$aRow[ "usu_id" ].'" class="btn btn-xs green margin-bottom-5"><i class="fa fa-edit"></i> Empleados</a>';
					$row[] = $btnProductos;
				}else{
			 		$row[] = utf8_encode($aRow[ $aColumns[$i] ]);
				}
			}
			$output['aaData'][] = $row;
		}
	}else{
		//Si no se encuentra logueado, no sabemos como llegó acá
		exit();
	}
}

echo json_encode( $output );
//Devolvemos un arreglo con los datos
//$response->result = $result;
//echo json_encode($response);
//$_conection->desconnect();
?>