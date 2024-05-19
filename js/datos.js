/* 
Obten el id del select
busca los datos predeterminados del select(id) en la base de datos
carga los datos extraidos de la base de datos en el select
 */
function CargarSelects(idInput){
    $.getJSON('./libreria/AjaxDB.php',{'valor':idInput, 'mensaje':'1'},function(data){
        $.each(data, function(id,value){
            const almacena = "valores= " + id + " Dato = " + value;
            $("#"+idInput).append('<option value="'+id+'">'+value+'</option>');
        });
    });  
}
function BuscaMesa(fecha, hora) {
    $("#loading").show();
    $("body").find(".mesaocupada").each(function(){
        $me = $(this);
        $me.attr("src","./img/icons/vector-mesa "+ $me.attr("id") + ".svg").removeClass().addClass("mesas")
    });
    $.getJSON('./libreria/AjaxDB.php',{'valor':fecha+";"+hora, 'mensaje':'2'},function(data){
        $.each(data, function(id,value){
            //console.log(id+":"+value)
            $("#"+value).attr("src","./img/icons/vector-mesa "+value+"-rojo.svg").removeClass("mesas").addClass("mesaocupada");
        });
    }).done(function(){
        $("#loading").hide();
    });  
}
function tablaUsuarios() {
    $.getJSON('./libreria/Ajax.usuarios.php',{'buscado': $("#buscado").val(), 'num':'4'},function(data){
        $.each(data, function(id,value){
            console.log(id+":"+value)
            const resultado = value.split(";");
            $(".contenedor-table").append(
                "<div class='contenedor-item' id='"+id+"'>"+
                    "<div class='table-item'>"+id+"</div>"+
                    "<div class='table-item'>"+resultado[0]+"</div>"+
                    "<div class='table-item'>"+resultado[1]+"</div>"+
                    "<div class='table-item'>"+resultado[2]+"</div>"+
                "</div>"
            );
        });
    }).done(function(){
        $("#loading").hide();
    }); 
}
function abreModalCarta(idClass){
    $(".modal-img").attr("src","");
    $.getJSON('./json/carta.json',function(data){
        $.each(data, function(id,value){
            console.log(idClass+ "-> " +id+": "+value);
            if(idClass == id){
                $(".modal-img").attr("src","./img/carta/"+value);
            } 
        });
    }).done(function(){
        $(".modal").addClass("modal--show");
    });
}
function cierraModalCarta() {
    $(".modal").removeClass("modal--show");
}

function ValidaMenu(){
    
    $.ajax({
        url: './libreria/Ajax.usuarios.php?num=5',
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loading").show();
        },
        success: function(data){
            //alert(data);
            if(data == "no"){
                window.open("inicio-sesion.html", "_self");
            }else{
                window.open("reservacion.html", "_self");
            }
        },
        error: function(){
        }
    });
}
function OcultaValor(){
    $.ajax({
        url: './libreria/Ajax.usuarios.php?num=5',
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loading").show();
        },
        success: function(data){
            //alert(data);
            if(data == "no"){
                $("#iniciar").show();
                $("#cerrar").hide();
            }else{
                $("#iniciar").hide();
                $("#cerrar").show();
            }
        },
        error: function(){
        }
    });

}