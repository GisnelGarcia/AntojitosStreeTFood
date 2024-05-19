<?php
/*Clase de usuarios: en esta se hacenn todos los metodos que
tengan que ver con los usuarios del sistema directamente*/
// Conexion a base de datos MySqli
session_start();
require_once 'ConexionMYSQL.php';
//include ('funciones.php');
// Clase Usuario
class Usuario{
	private $busqueda, $sql;
	/*Falta la verificacion de clave por la fecha del ultimo cambio de clave*/
	public function __construct(){
		$this->busqueda = array();
	}

	//Metodo para Agregar un Usuario
	public function AgregarUsuario($idusuario,$correo,$grupo_acceso,$usuario){
		$conexion= new ConexionPGSQL();
		if ($conexion->conectar() == 1){
			$clave = randomText(8);
			//echo $clave;
			$clave_encrip = md5($clave);
			list($nombre, $dominio) = explode("@",$correo);
			$sql ="INSERT INTO usuarios (idusuario,nombre,clave,correo,grupo_acceso,clave_cambiada,fecha_clave,fecha,usuario) VALUES($idusuario,'$nombre','$clave_encrip','$correo',$grupo_acceso,'f',current_timestamp,current_timestamp,17408731)";
			$res = pg_query($sql);
		}
		return $res;
	}
	//Metodo para cambiar la  clave
	public function ModificarUsuario($idusuario){
		$conexion= new ConexionPGSQL();
		if ($conexion->conectar()==1){
			$clave = randomText(8);
			$clave_encrip = md5($clave);
			$sql="UPDATE usuarios SET clave = $clave_encrip, clave_cambiada = 't',fecha_clave = current_timestamp  WHERE idusuario=$idusuario";
			$res=pg_query($sql);
		}
		return $res;
	}

	//M�todo para verificar si el nick y  la clave son correctos.
	public function VerificarLogin($nombre, $clave){
		$conexion= new ConexionMYSQL();
		$this->busqueda = 0;
		if ($conexion->conectar()==1){
			//$clave_encrip = md5($clave);
			$this->sql = "SELECT * FROM usuarios WHERE correo='$nombre' AND clave='$clave'";//_encrip'";
			//echo $this->sql;
			$result = $conexion->url->query($this->sql);
			if(mysqli_num_rows($result)){
				$this->busqueda = 1;
			}
			$conexion->Desconectar();
		}
		return $this->busqueda;
	}
	//Metodo para buscar el id de los usuarios
	public function BuscarId($nombre, $clave){
		$conexion= new ConexionMYSQL();
		$this->busqueda = 'no';
		if ($conexion->conectar()==1){
			//$clave_encrip = md5($clave);
			$this->sql = "SELECT * FROM usuarios WHERE correo='$nombre' AND clave='$clave'";//_encrip'";
			$result = $conexion->url->query($this->sql);
			 if(mysqli_num_rows($result)){
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$this->busqueda = $row["cedula"].';'.$row["nombre"].";".$row["apellido"].";".$row["telefono"].";".$row["tipo_usuario"];
				$result->free();
			}
		}
		return $this->busqueda;
	}
	public function datosSesion(){
		if (!isset($_SESSION['usuario'])) {
			return "no";
		}else{
			return $_SESSION['usuario'].";".$_SESSION['nombre'].";".$_SESSION['apellido'].";".$_SESSION['telefono'].";".$_SESSION['tipo_usuario'];
		}
	}
	
	
	public function ListaUsuarios($buscado=""){
		$datos = array();
		$this->conexion = new ConexionMYSQL();
		$this->conexion->conectar();
			$this->sql = "Select * from usuarios ";
			if($buscado!=""){
				"where cedula like '%".$buscado."%' or nombre like %'".$buscado."'% or apellido like %'".$buscado."'% or correo like %'".$buscado."'%";
			}
		//echo $this->sql;
		$this->result = $this->conexion->url->query($this->sql);
		$filas = array();
		$fila = 0;
		while($row = mysqli_fetch_assoc($this->result)){
			$datos = $row["nombre"].";".$row["apellido"].";".$row["correo"];
			$filas[$row["cedula"]] = $datos;
			$fila++;
		}
		$this->conexion->Desconectar();
		$this->result = "";
		return json_encode($filas);
	}
	public function CerrarSession(){
		session_destroy();
		header("Location: ../");
		exit;	
	}
}
/* $valor = new Usuario();
echo $valor->BuscarId("demo@antojitos.com", "1234"); */
//echo $valor->BuscarId('cesar.vina','qwerty');
//echo $valor->VerificarLogin('cesar.vina','qwerty');
?>