/*
 * Control de la interfaz grafica de la alta de documentos de certificacion
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Junio 2018
 */
$( document ).ready( function() {
    $( '#capacitacion_Digitalizacion_ValidacionContenedor' ).hide();
    /* Autocomplete */
    $( '#capacitacion_Digitalizacion_idRegistro' ).autocomplete({
        source: "../../Registro/razonSocialAutocomplete/filtro=inpart/",
        minLength: 2,
        select: function( event, ui ) {
            $( '#capacitacion_Digitalizacion_idRegistroID' ).val( ui.item.id );
            descargaDigitalizadosCapacitacion( ui.item.id );
        }
    });
    /*
     * Botones
     */
    $( '#capacitacion_Digitalizacion_eliminaBusquedaBoton' ).button({icons: { primary: "ui-icon-close" }, text: false}).click( function( e ){
        e.preventDefault();
        resetFormularioCert();
        ocultaDescargasCertificacion();
    });
    $( '#capacitacion_Digitalizacion_certificado' ).button();
    $( '#capacitacion_Digitalizacion_comprobantePago' ).button();
    $( '#capacitacion_Digitalizacion_certificado_containerBoton' ).button({
        icons: { primary: "ui-icon-circle-arrow-s" }, text: false
    });
    $( '#capacitacion_Digitalizacion_comprobantePago_containerBoton' ).button({
        icons: { primary: "ui-icon-circle-arrow-s" }, text: false
    });
    $( '#capacitacion_Digitalizacion_guardaDocumentos' ).button().click(function( e ){
        e.preventDefault();
        validaFormularioDigitalizadosCapacitacion();
    });
    $( '.descargaDocumentoCert' ).click( function( e ) {
        e.preventDefault();
        idReg = $( '#capacitacion_Digitalizacion_idRegistroID' ).val();
        location.replace( '../../Capacitacion/DescargaDigitalizado/idReg=' + idReg + '|idDoc=' + this.value + '/' );
    });
    $( '#capacitacion_Digitalizacion_btnValidacion_Certificado' ).button().click( function( e ) {
        e.preventDefault();
        abreVentanaValidacion( "1" );
    });
    $( '#capacitacion_Digitalizacion_btnValidacion_Comprobante' ).button().click( function( e ){
        e.preventDefault();
        abreVentanaValidacion( "2" );
    });
});

function abreVentanaValidacion( pantalla ) {
    if( pantalla == '1' ){
            accion  = 'datosValidacionCapacitacion';
            accion2 = 'envioDatosCapacitacionValida';
            alto    = 270;
        } else if( pantalla == '2' ) {
            accion  = 'datosValidacionCapacitacionComprobante';
            accion2 = 'envioDatosCapacitacionValidaComprobante';
            alto    = 170;
    }
    idReg = $( '#capacitacion_Digitalizacion_idRegistroID' ).val();
    $( '#capacitacion_Digitalizacion_contenedorDatosValidacion' ).remove();
    $( 'body' ).append( '<div id="capacitacion_Digitalizacion_contenedorDatosValidacion" name="capacitacion_Digitalizacion_contenedorDatosValidacion" title="Validaci&oacute;n Documentos Capacitaci&oacute;n"></div>' );
    $( '#capacitacion_Digitalizacion_contenedorDatosValidacion' ).load( '../../Capacitacion/'+accion+'/idReg='+idReg+'/' ).dialog({
        modal: true, draggable: false, closeOnEscape: false, resizable: false, width: 550, height: alto,
        buttons:{
            'Validar': function() {
                abreModalSistema();
                datos = $( '#capacitacion_Digitalizacion_DatosPieza_form' ).serialize();
                $.post( '../../Capacitacion/'+accion2+'/' , datos , function( d ) {
                    if( d == 'OK' ) {
                            msj = 'Los documentos se han validado correctamente, se han enviado los datos de acceso.';
                        } else {
                            msj = 'Ocurrio un error en la validacion, intente mas tarde.';
                    }
                    cierraModalSistema();

                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#capacitacion_Digitalizacion_contenedorDatosValidacion' ).remove();

                    dialogoAviso( 'Validacion Documentos Digitalizados' , msj );
                });
            },
            'Cancelar': function() {
                $( this ).dialog( 'close' );
                $( this ).dialog( 'destroy' );
                $( '#capacitacion_Digitalizacion_contenedorDatosValidacion' ).remove();
            }
        }
    }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}

function datosValidacionCapacitacionDigitalizados() {
    
}

function descargaDigitalizadosCapacitacion( idReg ) {
    $.post( '../../Capacitacion/verificaDescargables/idreg='+idReg+'/' , function( res ) {
        if( res == "true" ) {
                $( '#capacitacion_Digitalizacion_tipoMovimiento' ).val( 'edita' );
                $( '#capacitacion_Digitalizacion_certificado_container' ).css( 'display' , 'inline' );
                $( '#capacitacion_Digitalizacion_comprobantePago_container' ).css( 'display' , 'inline' );
                $( '#capacitacion_Digitalizacion_ValidacionContenedor' ).show();
            } else {
                $( '#capacitacion_Digitalizacion_tipoMovimiento' ).val( 'alta' );
                $( '#capacitacion_Digitalizacion_certificado_container' ).css( 'display' , 'none' );
                $( '#capacitacion_Digitalizacion_comprobantePago_container' ).css( 'display' , 'none' );
                $( '#capacitacion_Digitalizacion_ValidacionContenedor' ).hide();
        }
    });
}

function validaFormularioDigitalizadosCapacitacion() {
    form = $( '#certificacion_digitalizacion_form' );
    mov  = $( '#capacitacion_Digitalizacion_tipoMovimiento' ).val();
    if( mov == 'alta' ) {
        form.validate({
            rules: {
                capacitacion_Digitalizacion_idRegistroID      : "required"
            },
            messages: {
                capacitacion_Digitalizacion_idRegistroID      : "<br />* Falta la razon social"
            }
        });
    } else if( mov == 'edita' ) {
        form.validate({
            rules: {
                capacitacion_Digitalizacion_idRegistroID : "required"
            },
            messages: {
                capacitacion_Digitalizacion_idRegistroID : "<br />* No ha seleccionado razon social a editar"
            }
        });
    }

    idRegistro = $( '#capacitacion_Digitalizacion_idRegistroID' ).val();

    if( idRegistro != "" ){
        $( '#certificacion_digitalizacion_form' ).submit();
        abreModalSistema();
        ocultaDescargasCertificacion();
    } else {
        dialogoAviso( 'Error' , 'No ha seleccionado la razon social' );
    }
}

function ocultaDescargasCertificacion() {
    $( '#capacitacion_Digitalizacion_certificado_container' ).css( 'display' , 'none' );
    $( '#capacitacion_Digitalizacion_comprobantePago_container' ).css( 'display' , 'none' );
    $( '#capacitacion_Digitalizacion_ValidacionContenedor' ).hide();
}

function resetFormularioCert() {
    cierraModalSistema();
    resetForm( 'certificacion_digitalizacion_form' );
}

function errorAltaDigitalizadosCert() {
    dialogoAviso( 'Documentos Digitalizados' , 'Se present&oacute; un error en el alta de los documentos, seleccione correctamente la Razon Social' );
}

function avisoAltaDigitalizadosCert() {
    dialogoAviso( 'Documentos Digitalizados' , 'Los archivos se han almacenado correctamente' );
}

