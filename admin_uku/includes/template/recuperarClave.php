<?php
ob_start();
?>
<html>
  <head>
  </head>
  <body>
    <table width="100%" cellpadding="10" cellspacing="0" style="color: #000000; background-color: #f5f5f5;">
      <tr>
        <td align="center" style="height:70px; background-color:#dfdfdf; padding: 10px; font-size:13px; font-family:Arial, Helvetica, sans-serif;"><img src="<?php echo $logoadministador; ?>"></td>
      </tr>
      <tr >
        <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
          <br/>
          <b>Estos son los datos enviados 
          desde el administrador de <?php echo $nombreadministrador; ?></b>
          <br/>
          <br/>
            <div><b>Email</b>: <?php echo $username; ?></div>
          <br/>
			     <div><b>Contraseña</b>: <?php echo $nueva_clave; ?></div>
          <br/>
        </td>
      </tr>
      <tr>
         <td style="height:35px; background-color:#dfdfdf; text-align: right; padding: 10px;"><a href="" target="_blank"></a></td>
      </tr>
    </table>
  </body>
</html>
<?php
$content = ob_get_contents();
ob_end_clean();
return($content);
?>
