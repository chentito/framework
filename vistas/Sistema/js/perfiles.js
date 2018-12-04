/* 
 *  * Interaccion de interfaz grafica con controlador en la administracion de
 *   * perfiles
 *    * @Autor Mexagon.net / Jose Gutierrez
 *     * @Fecha Enero 2016
 *      */

$("#sistema_agregarPerfil").button();
$("#sistema_guardarPerfil").button();

$("input:checkbox").prop('disabled', true);
//$("#sistema_agregarPerfil").prop('disabled', true);

/*$("input:checkbox").each( function () {
      alert( $(this).val() );
});*/

$('#sistema_agregarPerfil').button().click( function(){
    $("#nuevoPerfil").show();
    return false;
});

$('#sistema_guardarPerfil').button().click( function(){
   //Validamos que el nombre del nuevo perfil no sea vacio
   var nombrePerfil = $("#nombrePerfil").val();
   if(nombrePerfil == ""){
      //Mostramos mensaje de error
      dialogoAviso( 'Perfiles' , 'Porfavor capture un nombre de perfil valido.' );
   }else{
      //Ejecutamos ajax para guardar nuevo perfil en BD
      $.post( '../Sistema/guardarNuevoPerfil/nombrePerfil='+nombrePerfil+'/' , function( mensaje ){
          if(mensaje != "0"){
             //Indica que se inserto correctamente el nuevo perfil
             var nombrePerfil = $("#nombrePerfil").val();
	     //Agregar a combobox nuevo elemento
             $('#comboPerfil').append('<option val="'+mensaje+'">'+nombrePerfil+'</option>');
             $("#nombrePerfil").val("");
             $("#nuevoPerfil").hide();
	     $('#comboPerfil').val(nombrePerfil);
	     $("#idPerfil").val(mensaje);
             $("input:checkbox").prop('disabled', false);
	     dialogoAviso( 'Perfiles' , 'Perfil agregado exitosamente.' );
          }else{
             //Ocurrio un error al insertar perfil
             dialogoAviso( 'Perfiles' , 'Ocurrio un error al insertar nuevo perfil, por favor intente mas tarde.' );
          }
      });                                            
   } 
   return false;
});

function buscaInformacionPerfil(){
    var comboPerfil = $("#comboPerfil").val();
    if(comboPerfil == ""){
        //Mostramos dialog con aviso
        $("#sistema_agregarPerfil").prop('disabled', true);
	$("input:checkbox").prop( "checked", false );
        $("input:checkbox").prop('disabled', true);
	$("#idPerfil").val("");
	$("#nombrePerfil").val("");
        $("#nuevoPerfil").hide();
        dialogoAviso( 'Perfiles' , 'Porfavor seleccione un perfil v&aacute;lido.' );
    }else if(comboPerfil == "sistema_agregarPerfil"){
	//Mostramos form para agregar nuevo perfil
	$("input:checkbox").prop( "checked", false );
	$("input:checkbox").prop('disabled', true);
        $("#nuevoPerfil").show();
    }else{
	$("#nombrePerfil").val("");
        $("#nuevoPerfil").hide();
	$("input:checkbox").prop( "checked", false );
	$("#idPerfil").val(comboPerfil);
	//Ejecutamos ajax para buscar en BD informacion guardada para el perfil selecionado
	$.post( '../Sistema/buscaPerfil/perfil='+comboPerfil+'/' , function( mensaje ){
	      var perfilesSeleccionados = mensaje.split(",");
	      $("input:checkbox").prop('disabled', false);
	      for(i=0; i<perfilesSeleccionados.length; i++){
                  $("#option"+perfilesSeleccionados[i]).prop( "checked", true );
              }
              
	      $("#sistema_agregarPerfil").prop('disabled', false);
	});
    }
}

function actualizaPermisos(valor){    
    var statusChkBox = $("#option"+valor).is(':checked');
    var valChkbox = ((statusChkBox==true)?"1":"0");
    var idPerfil = $("#idPerfil").val();
    //Ejecutamos ajax para actualizar BD ocn informacion del permiso asignado en el perfil seleccionado
    $.post( '../Sistema/actualizarPermisos/statusChkBox='+valChkbox+'|idPerfil='+idPerfil+'|modulo='+valor+'/' , function( mensaje ){
         if(mensaje == "1"){
            //Los permisos fueron actualizados correctamente
	    dialogoAviso( 'Perfiles' , 'El permiso seleccionado para el perfil '+$('select[name=comboPerfil] option:selected').text()+' fue actualizado correctamente.' );
         }else if(mensaje == "0"){
            //No se pudo realizar actualizacion de permisos
            $("#comboPerfil").val("");
            dialogoAviso( 'Perfiles' , 'Ocurrio un error al actualizar los permisos por favor intente mas tarde.' );
         }
    });
}


