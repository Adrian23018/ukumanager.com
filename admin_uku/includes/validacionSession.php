<?php
//require session_start

//Función en ../includes/configFunciones.php
if(!validarLogueado($_conection)){
    echo '<script type="text/javascript"> window.location = "index.php"; </script>';
}
?>