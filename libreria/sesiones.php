<?php
	include_once 'Usuarios.php';
	$usuario = new Usuario();
	if ($usuario->VerificarLogin($_POST['usuario'], $_POST['clave'])==1){
		//session_start();
		list(
			$_SESSION['usuario'],
			$_SESSION['nombre'],
			$_SESSION['apellido'],
			$_SESSION['telefono'],
			$_SESSION['tipo_usuario']
		) = explode(";",$usuario->BuscarId($_POST['usuario'], $_POST['clave']));
		
		echo 'si;'.$_SESSION["tipo_usuario"];//.$cambio_clave;
	}else{
		echo 'no';
	}
?>
