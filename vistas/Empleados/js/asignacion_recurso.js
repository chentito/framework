/* 
 * Controlador de interfaz de usuario de la asignacion de recursos
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */

$( '#asignaRecurso_seleccionaEmpleado' ).autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "../../Empleados/nombreEmpleadoAutocomplete/",
            dataType: "json",
            data: {
                term : request.term,
                cli : $( '#asignaRecurso_cliente' ).val()
            },
            success: function(data) {
                response(data);
            }
        });
    },
    minLength: 2,
    select   : function( event, ui ) {
        $( '#asignaRecurso_seleccionaEmpleadoHidden' ).val( ui.item.id );
    }
});

$( '#asignaRecurso_seleccionaItem' ).autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "../../Empleados/identificadorItemAutocomplete/",
            dataType: "json",
            data: {
                term : request.term,
                cli : $( '#asignaRecurso_cliente' ).val()
            },
            success: function(data) {
                response(data);
            }
        });
    },
    minLength: 2,
    select   : function( event, ui ) {
        $( '#asignaRecurso_seleccionaItemHidden' ).val( ui.item.id );
    }
});

$( '#asignaRecurso_guardaAsignacion' ).button().click( function( e ){
    e.preventDefault();
    guardaAsignacionRecurso();
});

$( '#asignaRecurso_generaDocumento' ).button().click( function( e ){
    e.preventDefault();
    generaDocumentoResguardo();
});

$( '#asignaRecurso_fechaInicioAsigna' ).datepicker({ dateFormat: 'yy-mm-dd' });
$( '#asignaRecurso_fechaFinAsigna' ).datepicker({ dateFormat: 'yy-mm-dd' });


function guardaAsignacionRecurso() {
    var ban        = 0;
    var error      = '';
    var cliente    = $( '#asignaRecurso_cliente' ).val();
    var fInicial   = $( '#asignaRecurso_fechaInicioAsigna' ).val();
    var fFinal     = $( '#asignaRecurso_fechaFinAsigna' ).val();
    var idEmpleado = $( '#asignaRecurso_seleccionaEmpleadoHidden' ).val();
    var idItem     = $( '#asignaRecurso_seleccionaItemHidden' ).val();
    var indef      = $( '#asignaRecurso_tiempoIndefinido' ).prop( 'checked' ) ? 1 : 0;

    if( cliente == '' ) {
        ban ++;
        error += 'No ha seleccionado un cliente<br />';
    }

    if( idEmpleado == '' ) {
        ban ++;
        error += 'No ha seleccionado un empleado<br />';
    }

    if( idItem == '' ) {
        ban ++;
        error += 'No ha seleccionado un recurso a asignar<br />';
    }

    if( fInicial == '' ) {
        ban ++;
        error += 'No ha proporcionado una fecha de inicio de asignaci&oacute;n<br />';
    }

    if( indef == 0 ){
        if( fFinal == '' ) {
            ban ++;
            error += 'No ha proporcionado una fecha de finalizacion de asignaci&oacute;n<br />';
        }
        if( ( new Date( fFinal ).getTime() < new Date( fInicial ).getTime() ) || fFinal == fInicial ) {
            ban ++;
            error += 'La fecha de finalizacion no debe ser mayor a la fecha de inicio<br />';
        }
    }

    if( ban > 0 ){
            dialogoAviso( 'Error al asignar recurso' , error );
        }else{
            $.post( '../../Empleados/guardaAsignacion/' , { fInicial:fInicial , fFinal:fFinal , idEmpleado:idEmpleado , idItem:idItem , indef:indef } , function( datos ){
                if( datos == '' ){
                        dialogoAviso( 'Alta de Asignacion' ,  'La asignaci&oacute;n se ha ejecutado exitosamente.' );
                        $("#asignaRecurso_item option[value='"+idItem+"']").remove();
                    }else{
                        dialogoAviso( 'Error al asignar recurso' , 'Se present&oacute; un error al asignar recurso, intente m&aacute;s tarde' );
                }
                $( '#asignaRecurso_tiempoIndefinido' ).attr('checked',false);
                $( '#asignaRecurso_fechaInicioAsigna' ).val('');
                $( '#asignaRecurso_fechaFinAsigna' ).val('');
                $( '#asignaRecurso_seleccionaEmpleadoHidden' ).val('');
                $( '#asignaRecurso_seleccionaEmpleado' ).val('');
                $( '#asignaRecurso_seleccionaItemHidden' ).val('');
                $( '#asignaRecurso_seleccionaItem' ).val('');
                $( '#asignaRecurso_cliente' ).val('-');
                $( '#GridAsigacionesActuales' ).trigger( 'reloadGrid' );
            });
    }
}

function select_row( id ) {
    //alert("generando documento resguardo");
    location.replace( '../../Empleados/docResguardoRecursos/id='+id+'/' );
}
    
    
