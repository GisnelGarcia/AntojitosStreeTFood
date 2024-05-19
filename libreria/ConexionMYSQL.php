<?php
include_once('Conexion.php');
class ConexionMYSQL{
	public $result,$url;
	//Metodo para la Conexion a la Base de Datos
	public function Conectar(){
		$this->url = new mysqli(DB_HOST,DB_USER,DB_PWD,DB_NAME);
		if ($this->url->connect_errno){
			return 0;
		}else{
			return 1;
		}
	}
	//funcion para destruir la conexion.
	public function Desconectar(){
		mysqli_close($this->url);
	}
}
	
?>