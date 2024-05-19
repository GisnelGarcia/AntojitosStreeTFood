<?php
/*session_start();*/
/*
Interaccion entre la base de datos y el usuario usando Json, JavaScript y Jquery para su lectura.
*/
	include ('InteraccionDB.php');
	$accion =  new InteraccionDB();
	
	sleep(2);
	switch($_REQUEST['mensaje']){
		case (1):{
			print_r($accion->OptionSelect($_REQUEST['valor']));
			
			break;
		}
		case (2):{
			print_r($accion->buscarReservacion($_REQUEST['valor']));
			
			break;
		}
		case (3):{
			print_r($accion->guardarReservacion($_REQUEST['mesa'], $_REQUEST['fecha'], $_REQUEST['hora'], $_REQUEST['referencia'], $_REQUEST['fecha_dep']));
			
			break;
		}
		default:
			print_r(call_user_func(array($accion, $_POST['valor'])));
		break;
	}
?>