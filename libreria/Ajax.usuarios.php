<?php
/*session_start();
$_SESSION['idusuario']=2082;*/
	//include_once 'Usuarios_Access.php';
	include_once 'Usuarios.php';
	$usuario =  new Usuario();
	//$usuario_access = new Usuarios();
			//echo $usuario->CargarPersonal(2301);
	switch ($_REQUEST['num']){
		case 1:
			echo json_encode($usuario->BuscarPersonal($_GET['term']));
		break;
		case 2:
			echo $usuario->CargarPersonal($_REQUEST['persona']);
		break;
		case 3:
			echo json_encode($usuario->buscarAccess($_GET['term']));
		break;
		case 4:
			echo $usuario->ListaUsuarios($_REQUEST['buscado']);
		break;
		case 5:
			echo $usuario->datosSesion();
		break;
		case 6:
			echo $usuario->CerrarSession();
		break;
	}
	//echo json_encode($usuario->buscarAccess(1));
?>