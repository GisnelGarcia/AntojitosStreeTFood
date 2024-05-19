<?php
session_start();
require_once 'ConexionMYSQL.php';
require_once 'Codigos.php';


class InteraccionDB{
	private $busqueda, $sql, $sql_codigo, $conexion, $titulos;
	/*Falta la verificacion de clave por la fecha del ultimo cambio de clave*/
	public function __construct(){
		$this->result = '';
		$this->busqueda = array();
		$this->titulos = array();
	}

	private function BuscarCampos($tabla){
		$this->sql = "DESCRIBE ".$tabla;
		$result_titulo = $this->conexion->url->query($this->sql);
		$i = 1;
		while($row = mysqli_fetch_assoc($result_titulo)){
			$this->titulos[$i] = $row['Field'];
			$i++;
		}
	}
	public function OptionSelect($tabla){
		//Llenar los option select dinamicamente
		$this->conexion = new ConexionMYSQL();
		$this->conexion->conectar();
		$this->BuscarCampos($tabla);
		$this->sql = "Select * from ".$tabla;
		$result = $this->conexion->url->query($this->sql);
		$filas = array();
		//echo $this->sql;
		while($row = mysqli_fetch_assoc($result)){
			$filas[$row[$this->titulos[1]]] = $row[$this->titulos[2]];
		}
		$this->conexion->Desconectar();
		return json_encode($filas);
	}
	
	public function guardarReservacion($mesa, $fecha, $hora, $ref, $fecha_dep){
		$conexion = new ConexionMYSQL();
		$conexion->conectar();
		$reservacion = new Codigos();
		$codigo = $reservacion->CodigoAnio("reservaciones","codigo",5);
		$this->sql = "INSERT INTO reservaciones VALUE ('".$codigo."',".$mesa.",'".$fecha."','".$hora."','".date("Y-m-d H:i:s")."',".$_SESSION['usuario'].",'".$ref."','".$fecha_dep."')";
		$usuario = 1;
		if($conexion->url->query($this->sql) === TRUE){
			$resultado = "1;".$codigo;
		}else{
			$resultado = "0";
		}
		$conexion->Desconectar();
		return $resultado;
	}
	
	public function buscarReservacion($fechaHora)
	{
		$valores = explode(";",$fechaHora);
		$fecha = $valores[0];
		$hora = $valores[1]; 
		$this->conexion = new ConexionMYSQL();
		$this->conexion->conectar();
		$this->BuscarCampos("reservaciones");
		$this->sql = "SELECT * FROM reservaciones WHERE fecha_reservacion = '".$fecha."' AND hora = '".$hora."'";
		$this->result = $this->conexion->url->query($this->sql);
		$filas = array();
		while($row = mysqli_fetch_assoc($this->result)){
			$filas[$row[$this->titulos[1]]] = $row[$this->titulos[2]];
		}
		$this->conexion->Desconectar();
		$this->result = "";
		return json_encode($filas);
	}
}

?>