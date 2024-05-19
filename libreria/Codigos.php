<?php


//session_start();

require_once 'ConexionMYSQL.php';
class Codigos{
	private $busqueda, $sql, $sql_codigo, $result;
	public function __construct(){
		$this->result = '';
		$this->busqueda = array();
	}
	
	public function llenacero($valor, $longitud){//Funcion para llenar con ceros a la izquierda con str_pad
		$res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
		return $res;
	}
	public function ceros($valor, $longitud){//Funcion con for para llenar con ceros a la izqierda
		$cero = '';
		for($i=1;$i<=$longitud;$i++){
			$cero .= '0';
		}
		return $cero.$valor;
	}
	public function ValorExistente($tabla, $Key, $valor){
		$conexion = new ConexionMYSQL();
		$conexion->Conectar();
		$this->sql = "SELECT ".$Key." FROM ".$tabla." WHERE ".$Key."='".$valor."'";
		//echo $this->sql;
		if(mysqli_num_rows($conexion->url->query($this->sql))>0){
			return 0;
		}else{
			return 1;
		}
		$conexion->Desconectar();
	}
	
	public function ExtraerCodigo($tabla, $PriKey, $Key, $valor){
		$conexion = new ConexionMYSQL();
		$conexion->Conectar();
		$this->sql = "SELECT ".$PriKey." FROM ".$tabla." WHERE ".$Key."='".$valor."'";
		//echo $this->sql;
		$this->result = $conexion->url->query($this->sql);
		if(mysqli_num_rows($this->result)>0){
			$row = mysqli_fetch_assoc($this->result);
			return $row[$PriKey];
		}else{
			return false;
		}
		$conexion->Desconectar();
	}
	
	public function Correlativo($tabla, $PryKey){//Es un correlativo
		$conexion = new ConexionMYSQL();
		$conexion->conectar();
		$this->sql_codigo = "SELECT MAX(".$PryKey.") FROM ".$tabla;
		$result = $conexion->url->query($this->sql_codigo);
		
		if(mysqli_num_rows($result)){
			$row_codigo = $result->fetch_array(MYSQLI_NUM);
			$codigo = $row_codigo[0] + 1;
		}
		$conexion->Desconectar();
		return $codigo;
	}
	
	public function BuscaCodigo($tabla, $PryKey){//Busca si falta algun valor en los codigos y los crea
		$conexion = new ConexionMYSQL();
		$conexion->conectar();
		$this->sql = "SELECT ".$PryKey." FROM ".$tabla." ORDER BY ".$PryKey." ASC";
		//echo $this->sql;
		$result = $conexion->url->query($this->sql);
		$indice = 1;
		
		while($row = mysqli_fetch_assoc($result)){
			if ($indice == $row[$PryKey]){
				$indice ++;
			}else{
				break;
			}
		}
		$conexion->Desconectar();
		return $indice;
	}
	
	public function CodigosDetalles($tabla, $CodEnca, $CodDet, $codigo){//busca el valor faltante entre los codigos de los detalles
		$conexion = new ConexionMYSQL();
		$conexion->conectar();
		$this->sql_codigo = "SELECT ".$CodDet." FROM ".$tabla." WHERE ".$CodEnca." = '".$codigo."'";
		$result = $conexion->url->query($this->sql_codigo);
		$indice = 1;
		//echo $this->sql_codigo;
		while($row = mysqli_fetch_assoc($result)){
			if ($indice == $row[$CodDet]){
				$indice ++;
			}else{
				break;
			}
		}
		$conexion->Desconectar();
		return $indice;
	}
	/*Busca los valores que no se encuentran en la lista servira en un principio para las compras y las ventas*/
	public function CodigoAnio($tabla, $PryKey, $longitud){
		$conexion = new ConexionMYSQL();
		$conexion->conectar();
		$this->sql = "SELECT SUBSTRING(".$PryKey.",1,".$longitud.") as ".$PryKey." FROM ".$tabla." WHERE SUBSTRING(".$PryKey.",".($longitud + 2).")='".date("Y")."'  ORDER BY ".$PryKey." ASC";
		$result = $conexion->url->query($this->sql);
		$indice = 1;
		//echo $this->sql;
		while($row = mysqli_fetch_assoc($result)){
			if ($indice == $row[$PryKey]){
				$indice ++;
			}else{
				break;
			}
		}
		$indice = $this->llenacero($indice, $longitud)."-".date("Y");
		$conexion->Desconectar();
		return $indice;
	}
	
	public function ExistDetalle($tabla, $PriKey, $encabezado, $ForKey, $detalle){
		$conexion = new ConexionMYSQL();
		$conexion->Conectar();
		$this->sql = "SELECT * FROM ".$tabla." WHERE ".$PriKey."='".$encabezado."' and ".$ForKey."='".$detalle;
		//echo $this->sql;
		$this->result = $conexion->url->query($this->sql);
		if(mysqli_num_rows($this->result)>0){
			return 1;
		}else{
			return 0;
		}
		$conexion->Desconectar();
	}
}


?>