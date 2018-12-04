/*
 * Control de la interfaz grafica para la exportacion de layout de un determinado rango de fechas
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Septiembre 2017
 */

$( document ).ready(function() {

    /* Botones */
    $( '#exportaLayout_btnExportar' ).button().click( function( e ){
        e.preventDefault();
        validaDescargaLayout();
    });

    /* Calendarios */
    $( '#exportaLayout_fechaInicial' ).datepicker({
        dateFormat:'yy-mm-dd',timeFormat: 'hh:mm:ss',showSecond: true,monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre", "Noviembre","Diciembre"],dayNamesMin: ["Dom","Lun","Mar","Mie","Jue","Vie","Sab"]
    });
    
    $( '#exportaLayout_fechaFinal' ).datepicker({
        dateFormat:'yy-mm-dd',timeFormat: 'hh:mm:ss',showSecond: true,monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre", "Noviembre","Diciembre"],dayNamesMin: ["Dom","Lun","Mar","Mie","Jue","Vie","Sab"]
    });

});

function validaDescargaLayout() {
    form = $("#exportaLayout_form");
    form.validate({
        rules: {
            exportaLayout_fechaInicial : "required",
            exportaLayout_fechaFinal   : "required"
        },
        messages: {
            exportaLayout_fechaInicial : "<br />* No ha capturado una fecha inicial",
            exportaLayout_fechaFinal   : "<br />* No ha capturado una fecha final"
        }
    });

    if( form.valid() ){
        fi = $( '#exportaLayout_fechaInicial' ).val();
        ff = $( '#exportaLayout_fechaFinal' ).val();
        generaDescargaLayout( fi , ff );
    }
}

function generaDescargaLayout( fi , ff) {
    $.post( '../../Sistema/verificaLayoutCant/fi='+fi+'|ff='+ff+'/' , function( d ){
        if( d == true ) {
            location.replace( '../../Sistema/verificaLayout/fi='+fi+'|ff='+ff+'/' );
        } else {
            dialogoAviso( 'Descarga Layout' , '<center>No hay informaci&oacute;n a descargar con el rango de fechas seleccionado</center>' )
        }
    });
}

