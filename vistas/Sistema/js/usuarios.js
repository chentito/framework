/* 
 *  * Interaccion de interfaz grafica con controlador en la administracion de
 *   * usuarios
 *    * @Autor Mexagon.net / Jose Gutierrez
 *     * @Fecha Enero 2016
 *      */

function validaEmail(value,colname){
    var exp = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
    if(exp.test(value)){
            return[true,""];
        }else{
            return[false,"No ha proporcionado una cuenta de correo correcta."];
    }
}

function asignarMarcasPorUsuario() {
    id = $( '#ListadoUsuariosSistema' ).jqGrid ( 'getGridParam' , 'selrow' );
    if( id == undefined ){
        dialogoAviso( 'Error cargar marcas' , 'No ha seleccionado un usuario' );
    }else{
        $('body').append( '<div id="muestraMarcasPorUsuario" title=".:: Detalle Usuario | Marcas Asignadas ::."></div>' );
        $('#muestraMarcasPorUsuario').load('/Sistema/muestraMarcas/id='+id+'/').dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:250,height:400,
            buttons:{
                'Cancelar':function() {
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#muestraMarcasPorUsuario' ).remove();
                },
                'Guardar Marcas':function() {
                    datos = $( '#formularioUsoMarcasPorUsuario' ).serialize();
                    $.post( '/Sistema/guardaMarcaPorUsuario/a=b&'+datos+'/' , function(d){
                        if( d == true ){
                            dialogoAviso( 'Configuracion Marcas' , '<center>Marcas asignadas correctamente</center>' );
                        }else{
                            dialogoAviso( 'Configuracion Marcas' , '<center>Error al asignar marcas, intente nuevamente</center>' );
                        }
                    });
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#muestraMarcasPorUsuario' ).remove();
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}