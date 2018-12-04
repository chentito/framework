/* 
 * Control de la interfaz grafica de la alta de cursos
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Agosto 2017
 */

/* Date picker */
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();

$("#registro_altaCursos_fechaInicioCurso").datepicker({minDate: new Date(),dateFormat:'yy-mm-dd',monthNames: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct", "Nov","Dic"],dayNamesMin: ["D","L","M","M","J","V","S"]});
$("#registro_altaCursos_fechaFinCurso").datepicker({minDate: new Date(),dateFormat:'yy-mm-dd',monthNames: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct", "Nov","Dic"],dayNamesMin: ["D","L","M","M","J","V","S"]});
$("#registro_altaCursos_fechaPublicacionCurso").val(yyyy+"-"+(mm.length>1?mm:"0"+mm)+"-"+(dd.length>1?dd:"0"+dd));
$("#registro_altaCursos_fechaPublicacionCurso").attr('disabled', true );

/* Botones */
$( '#registro_altaCursos_btnGuardar' ).button().click(function( e ){
    e.preventDefault();
    validaDatosCurso();    
});

function validaDatosCurso() {
    form = $("#registro_altaCursos_form");
    form.validate({
        rules: {
            registro_altaCursos_nombreCurso: "required",
            registro_altaCursos_descripcionCurso: "required",
            registro_altaCursos_costoCurso: "required",
            registro_altaCursos_fechaInicioCurso: "required",
            registro_altaCursos_fechaFinCurso: "required",
            registro_altaCursos_datosBancarios_banco: "required",
            registro_altaCursos_datosBancarios_titular: "required",
            registro_altaCursos_datosBancarios_convenioCIE: "required",
            registro_altaCursos_datosBancarios_Cuenta: "required",
            registro_altaCursos_datosBancarios_CLABE: "required"
        },
        messages: {
            registro_altaCursos_nombreCurso: "<br />* No ha capturado el nombre del curso",
            registro_altaCursos_descripcionCurso: "<br />* No ha capturado la descripci&oacute;n del curso",
            registro_altaCursos_costoCurso: "<br />* No ha capturado el costo del curso",
            registro_altaCursos_fechaInicioCurso: "<br />* No ha capturado la fecha de inicio del curso",
            registro_altaCursos_fechaFinCurso: "<br />* No ha capturado la fecha de fin del curso",
            registro_altaCursos_datosBancarios_banco: "<br />* No ha capturado el banco correspondiente a datos bancarios",
            registro_altaCursos_datosBancarios_titular: "<br />* No ha capturado el titular correspondiente a datos bancarios",
            registro_altaCursos_datosBancarios_convenioCIE: "<br />* No ha capturado el convenio CIE correspondiente a datos bancarios",
            registro_altaCursos_datosBancarios_Cuenta: "<br />* No ha capturado la cuenta correspondiente a datos bancarios",
            registro_altaCursos_datosBancarios_CLABE: "<br />* No ha capturado la CLABE correspondiente a datos bancarios"
        }
    });

    if( form.valid() ){
        datos = $( '#registro_altaCursos_form' ).serialize();
        guardaCurso( datos );
    }
}

function guardaCurso( datos ) {
    openDialogLoading();
    $.post( '../../Cursos/guardaCurso/' , datos , function( d ) {
        if(d == ""){
            //Informacion guardada exitosamente, mostramos mensaje y limpiamos formulario de captura
            $("#registro_altaCursos_nombreCurso").val("");
            $("#registro_altaCursos_descripcionCurso").val("");
            $("#registro_altaCursos_costoCurso").val("");
            $("#registro_altaCursos_fechaInicioCurso").val("");
            $("#registro_altaCursos_fechaFinCurso").val("");
            $("#registro_altaCursos_datosBancarios_banco").val("");
            $("#registro_altaCursos_datosBancarios_titular").val("");
            $("#registro_altaCursos_datosBancarios_convenioCIE").val("");
            $("#registro_altaCursos_datosBancarios_Cuenta").val("");
            $("#registro_altaCursos_datosBancarios_CLABE").val("");
            closeDialogLoading();
            dialogoAviso("Alta Cursos", "<p>Informaci&oacute;n guardada exitosamente</p>");
        }else{
            //Mostramos mensaje de error
            closeDialogLoading();
            dialogoAviso("Alta Cursos", "<p>Ocurrio un error al guardar la informaci&oacute;n, por favor intente nuevamente:</p>");
        }
    });
}

function openDialogLoading(){
    $( 'body' ).append( '<div title="Procesando Informacion..." id="loading"><center><p><strong>Procesando...</strong></p><br /><img src ="../../assets/imgs/ajax-loader.gif" width="31" height="31"></center></div>' );
    $("#loading").dialog({
        modal: true,resizable: false,width:'auto',height:'auto',closeOnEscape: false,draggable:false,bgiframe:true
    }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}

function closeDialogLoading(){
    $( "#loading" ).dialog( 'close' );
    $( "#loading" ).dialog( 'destroy' );
    $( "#loading" ).remove();
}

function numeros(evt){   
    var key = evt.keyCode ?evt.keyCode : evt.which;        
    return(key <= 40 || (key >= 48 && key <= 57 ) || key == 46 || key == 45);
}