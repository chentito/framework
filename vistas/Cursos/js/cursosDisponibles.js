/* 
 * Control de la interfaz grafica de cursos disponibles
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Agosto 2017
 */

function formEdit ( d ) {    
    return '<form id="editarCursos_form" name="editarCursos_form">'+
            '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td >Nombre Curso:</td>'+
            '<td colspan="5"><input type="text" id="editarCursos_nomCurso" name="editarCursos_nomCurso" value="'+d.nombreCurso+'" /><input type="hidden" id="editarCursos_ID" name="editarCursos_ID" value="'+d.id+'" /></td>'+
        '</tr>'+
        '<tr>'+
            '<td >Descripci&oacute;n Curso:</td>'+
            '<td colspan="5"><textarea id="editarCursos_descCurso" name="editarCursos_descCurso" rows="4" cols="100" style="resize:none"  >'+d.descripcionCurso+'</textarea></td>'+
        '</tr>'+
        '<tr>'+
            '<td>Costo:</td>'+
            '<td><input type="text" id="editarCursos_cosCurso" name="editarCursos_cosCurso" value="'+d.costoCurso+'" /></td>'+
            '<td>Fecha Inicio Curso:</td>'+
            '<td><input type="text" id="editarCursos_fInicioCurso" name="editarCursos_fInicioCurso" value="'+d.fechaInicioCurso+'" /></td>'+
            '<td>Fecha Fin Curso:</td>'+
            '<td><input type="text" id="editarCursos_fFinCurso" name="editarCursos_fFinCurso" value="'+d.fechaFinCurso+'" /></td>'+
        '</tr>'+        
        '<tr>'+
            '<td>Banco:</td>'+
            '<td><input type="text" id="editarCursos_banco" name="editarCursos_banco" value="'+d.datosBancariosBanco+'" /></td>'+
            '<td>Titular:</td>'+
            '<td colspan="3"><input type="text" id="editarCursos_titular" name="editarCursos_titular" value="'+d.datosBancariosTitular+'" size="90" /></td>'+
        '</tr>'+        
        '<tr>'+
            '<td>Convenio CIE:</td>'+
            '<td><input type="text" id="editarCursos_convenioCIE" name="editarCursos_convenioCIE" value="'+d.datosBancariosConvenioCIE+'" /></td>'+
            '<td>Cuenta:</td>'+
            '<td><input type="text" id="editarCursos_cuenta" name="editarCursos_cuenta" value="'+d.datosBancariosCuenta+'" /></td>'+
            '<td>CLABE:</td>'+
            '<td><input type="text" id="editarCursos_CLABE" name="editarCursos_CLABE" value="'+d.datosBancariosCLABE+'" /></td>'+
        '</tr>'+
        '<tr>'+
            '<td align="center" colspan="6"><button id="editarCursos_btnGuardar" name="editarCursos_btnGuardar" onclick="javascript:editarCursos(); return false;" >Editar Curso</button></td>'+            
        '</tr>'+
    '</table>'+
    '</form>';
}

function editarCursos(){     
    //Validamos informacion del curso capturada
    validaDatosCurso();
}

function validaDatosCurso() {
    form = $("#editarCursos_form");
    form.validate({
        rules: {
            editarCursos_nomCurso: "required",
            editarCursos_descCurso: "required",
            editarCursos_cosCurso: "required",
            editarCursos_fInicioCurso: "required",
            editarCursos_fFinCurso: "required",
            editarCursos_banco: "required",
            editarCursos_titular: "required",
            editarCursos_convenioCIE: "required",
            editarCursos_cuenta: "required",
            editarCursos_CLABE: "required"
        },
        messages: {
            editarCursos_nomCurso: "<br />* No ha capturado el nombre del curso",
            editarCursos_descCurso: "<br />* No ha capturado la descripci&oacute;n del curso",
            editarCursos_cosCurso: "<br />* No ha capturado el costo del curso",
            editarCursos_fInicioCurso: "<br />* No ha capturado la fecha de inicio del curso",
            editarCursos_fFinCurso: "<br />* No ha capturado la fecha de fin del curso",
            editarCursos_banco: "<br />* No ha capturado el banco correspondiente a datos bancarios",
            editarCursos_titular: "<br />* No ha capturado el titular correspondiente a datos bancarios",
            editarCursos_convenioCIE: "<br />* No ha capturado el convenio CIE correspondiente a datos bancarios",
            editarCursos_cuenta: "<br />* No ha capturado la cuenta correspondiente a datos bancarios",
            editarCursos_CLABE: "<br />* No ha capturado la CLABE correspondiente a datos bancarios"
        }
    });

    if( form.valid() ){
        datos = $( '#editarCursos_form' ).serialize();
        guardaCurso( datos );
    }
}

function guardaCurso( datos ) {
    $.ajaxSetup({async:false});
    $.post( '../../Cursos/editaCurso/' , datos , function( d ) {        
        if(d == ""){
            dialogoAviso("Editar Cursos", "<p>Informaci&oacute;n editada exitosamente</p>");
            $('#tableCursosDisponibles').DataTable().ajax.reload();
        }else{
            dialogoAviso("Editar Cursos", "<p>Ocurrio un error al editar la informaci&oacute;n, por favor intente nuevamente:</p>");
        }
    });
}

