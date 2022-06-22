<?php
/*****************************************************************/
/****************  CONEXION BASE DE DATOS  ******************/
/*****************************************************************/

class _conection {
  
  //variables de conexion
    private $host = _hostname;
    private $user = _username;
    private $pass = _password;
    public $type = _database_type;
    private $db = _database;
    public $lid = 0;

    //funcion de conexion
    public function connect(){
        $connect = $this->type.'_connect';

        return $connect($this->host, $this->user, $this->pass, $this->db);
  //       if (!$this->lid = $connect($this->host, $this->user, $this->pass)) {

  //       }else {
		// 	$sql = $this->type.'_select_db';			 
		// 	if (!$baseconections = $sql($this->db,$this->lid)) {
		// 		mysqli_query("SET NAMES 'utf8'");
		// 	}
		// }
		// return ($this->lid);
 	}//termina conexion

	//funcion de desconexion
	public function desconnect(){
	 	$desconnect = $this->type.'_close';
		$desconnect($this->lid);
	}//termina funcion de desconexion

}


?>