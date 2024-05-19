<?php
    require_once 'ConexionMYSQL.php';
    require_once 'Codigos.php';
    function GuardarReservacion(){
        $usuario = 1;
        $conexion = new ConexionMYSQL();
        $conexion->conectar();
        $reservaciones = new Codigos();
        $codigo = $reservaciones->CodigoAnio("reservaciones","codigo",5);
        //Para el calendario de DatePiker
        //$sql = "INSERT INTO compras_enc VALUES('".$codigo."','".$_REQUEST['proveedor']."','".fentrada($_REQUEST['fecha'])."',CURRENT_TIMESTAMP,".$_SESSION["usuario"].")";
        //Para la Fecha del calendario de HTMl 5
        $sql = "INSERT INTO reservaciones VALUES('".$codigo."','".$_REQUEST['proveedor']."','".$_REQUEST['fecha']."',CURRENT_TIMESTAMP,".$_SESSION["usuario"].")";
        $result = $conexion->url->query($sql);
    //	echo $codigo."<br>".$_REQUEST['fecha']."<br>".$sql."<br>";
        if($result){
            echo "1;".$codigo;
        }else{
            echo "0";
        }
        
    }
?>