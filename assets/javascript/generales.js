/* 
 * Funciones generales utilizadas en todo el sistema
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */

function dialogoAviso( titulo , mensaje ){
    $('body').append('<div id="dialogoGralSistema" title="'+titulo+'" >'+mensaje+'</div>');
    $('#dialogoGralSistema').dialog({
        modal:true, draggable:false, closeOnEscape:false, resizable:false, width:'450', height:'120',
        buttons:{
            'Aceptar':function(){
                $('#dialogoGralSistema').remove();
                $('#dialogoGralSistema').dialog('close');
                $('#dialogoGralSistema').dialog('destroy');
            }
        }
    }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}

function vacio( value ){
    if( value.length == 0 || value == "" ){
        return true;
    }else{
        return false;
    }
}

function abreModalSistema() {
    $('#loading-gral-sitio').dialog({zIndex:10500,width:300,height:120,modal:true,resizable:false,closeOnEscape:false,draggable:false,title:false,bgiframe:true}).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}

function cierraModalSistema() {
    $("#loading-gral-sitio").dialog("close");
}

$(document).ready(function(){
    $("#breadCrumbContainer").jBreadCrumb();
});
    
function isEnter(e){
    var keynum;
    if( window.event ) {
        keynum = e.keyCode; // IE
    } else if( e.which ) {
        keynum = e.which; // Netscape/Firefox/Opera
    } if( keynum == 13 ){
        return true;
    }
    return false;
}

function resetForm( id ) {
    $( '#' + id ).find( 'input:text, input:password, input:file, select, textarea' ).val( '' );
    $( '#' + id ).find( 'input:radio, input:checkbox' ).removeAttr( 'checked' ).removeAttr( 'selected' );
}