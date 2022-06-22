<?php
	// session_start();
	require("../../admin_uku/includes/autoloader.php");
	$pathFile = '../../imagenes-contenidos/';
	date_default_timezone_set('America/Bogota');
	$conexion = $_conection->connect();

	// error_reporting(1);
	require_once '../../admin_uku/dompdf/autoload.inc.php';
	$stripe = new ClassIncStripe;

	echo 'Pruebas Log<br>';
	
    $data = array("password" => _Password_Apple_Pay, "receipt-data" => "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");                               
    $data_string = json_encode($data);                                                                                   
                                                                                                                         
    $ch = curl_init('https://sandbox.itunes.apple.com/verifyReceipt');         
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                   
                                                                                                                         
    $result = curl_exec($ch);
    
    $resultApple = json_decode($result);
    if( $resultApple->receipt ){
        foreach( $resultApple->receipt->in_app as $nameApple => $valorItem ){
            if( $valorItem->transaction_id == '1000000562312920' ){
                // Remplazamos _ por -
                // Quitar las 2 primeras letras del string
                $planID = substr(str_replace("_","-",$valorItem->product_id),2);

                $sqlPlans = sprintf("SELECT * FROM tbl_stripe_plans WHERE spl_stripe_id=%s",
                                GetSQLValueString($planID, "text"));
                $rs_sqlPlans = mysqli_query($_conection->connect(), $sqlPlans);
                while( $row_sqlPlans = mysqli_fetch_assoc($rs_sqlPlans) ){
                    print 'spl_min: ' . $row_sqlPlans['spl_min'] . '<br>';
                    print 'spl_max: ' . $row_sqlPlans['spl_max'] . '<br>';
                }

                $nameApple.' ';
                $fechaExpira = explode(" ", $valorItem->expires_date)[0];
                
                print $fechaExpira . '<br>';
                print 'date ' . date("Y-m-d", strtotime($fechaExpira . " +1 Day")) . '<br>';
                if( time() > strtotime($fechaExpira . " +1 Day") ){
                    print 'vencido';
                }else{
                    print 'activo';
                }
                print '<br><br><br>';
            }
        }
    }

?>