$(document).ready(function(){

	$("#iniciar").on("click", function(e){
		e.preventDefault();
		const correo = $("#correo").val();
		const clave = $("#clave").val();
		if(!correo || !clave){
			alert("Revise los datos");
			return false;
		}
		
		$("#resultado").load("libreria/sesiones.php", {usuario:correo, clave:clave},function(datos){
			//alert(datos);
			var resultado = datos.split(";");
			if(resultado[0]=='si'){
				//alert(resultado[1]);
				if(resultado[1]=="Administrador"){
					window.open("index-admin.html", "_self");
				}else{
					window.open("reservacion.html", "_self");
				}
			}else{
				alert("Usuario y clave no coinciden");
				$("#contrasenia").val('');
			}
		});
	});
});
