/*
 * Control de la interfaz para la digitalizacion de documentos
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

/* Autocomplete */
$( '#registro_Digitalizacion_idRegistro' ).autocomplete({
    source: "../../Registro/razonSocialAutocomplete/",
    minLength: 2,
    select: function( event, ui ) {
        $( '#registro_Digitalizacion_idRegistroID' ).val( ui.item.id );
        descargaDigitalizadosRegistro( ui.item.id );
    }
});

/* BOTONES */
$( '#registro_Digitalizacion_solicitud' ).button();
$( '#registro_Digitalizacion_autorizacionDomiciliacion' ).button();
$( '#registro_Digitalizacion_contrato' ).button();
$( '#registro_Digitalizacion_cedula' ).button();
$( '#registro_Digitalizacion_edoCta' ).button();
$( '#registro_Digitalizacion_comprobanteDom' ).button();
$( '#registro_Digitalizacion_actaCons' ).button();
$( '#registro_Digitalizacion_poderNotarial' ).button();
$( '#registro_Digitalizacion_identificacion' ).button();

$( '#registro_Digitalizacion_descargaZip' ).button().click( function( e ) {
    e.preventDefault();
    idReg = $( '#registro_Digitalizacion_idRegistroID' ).val();
    location.replace( '../../Registro/descargaZip/idReg=' + idReg + '/' );
});

$( '#registro_Digitalizacion_descargaMegre' ).button().click( function( e ) {
    e.preventDefault();
    idReg = $( '#registro_Digitalizacion_idRegistroID' ).val();
    location.replace( '../../Registro/generaPDFMasivo/idReg=' + idReg + '/' );
});

$( '#registro_Digitalizacion_descargaMegre_ver2' ).button().click( function( e ) {
    e.preventDefault();
    idReg = $( '#registro_Digitalizacion_idRegistroID' ).val();
    location.replace( '../../Registro/generaPDFMasivo/idReg=' + idReg + '|sinActa=true/' );
});

$( '#registro_Digitalizacion_eliminaBusquedaBoton' ).button({icons: { primary: "ui-icon-close" }, text: false}).click( function( e ) {
    e.preventDefault();
    resetFormulario();
    ocultaDescargas();
});

$( '#registro_Digitalizacion_solicitud_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_autorizacionDomiciliacion_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_contrato_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_cedula_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_edoCta_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_comprobanteDom_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});
$( '#registro_Digitalizacion_actaCons_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_poderNotarial_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_identificacion_containerBoton' ).button({
    icons: { primary: "ui-icon-circle-arrow-s" }, text: false
});

$( '#registro_Digitalizacion_btnGuarda' ).button().click(function( e ) {
    e.preventDefault();
    validaFormularioDigitalizados();
});

$( '.descargaDocumento' ).click( function( e ) {
    e.preventDefault();
    idReg = $( '#registro_Digitalizacion_idRegistroID' ).val();
    location.replace( '../../Registro/DescargaDigitalizado/idReg=' + idReg + '|idDoc=' + this.value + '/' );
});

function descargaDigitalizadosRegistro( idReg ) {
    $.post( '../../Registro/verificaDescargables/idreg='+idReg+'/' , function( res ){
        if( res == "true" ) {
                $( '#registro_Digitalizacion_tipoMovimiento' ).val( 'edita' );
                $( '#registro_Digitalizacion_descargaMasiva_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_solicitud_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_autorizacionDomiciliacion_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_contrato_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_cedula_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_edoCta_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_comprobanteDom_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_actaCons_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_poderNotarial_container' ).css( 'display' , 'inline' );
                $( '#registro_Digitalizacion_identificacion_container' ).css( 'display' , 'inline' );
            } else {
                $( '#registro_Digitalizacion_tipoMovimiento' ).val( 'alta' );
                $( '#registro_Digitalizacion_descargaMasiva_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_solicitud_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_autorizacionDomiciliacion_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_contrato_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_cedula_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_edoCta_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_comprobanteDom_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_actaCons_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_poderNotarial_container' ).css( 'display' , 'none' );
                $( '#registro_Digitalizacion_identificacion_container' ).css( 'display' , 'none' );
        }
    } );
}

function ocultaDescargas() {
    $( '#registro_Digitalizacion_descargaMasiva_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_solicitud_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_autorizacionDomiciliacion_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_contrato_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_cedula_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_edoCta_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_comprobanteDom_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_actaCons_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_poderNotarial_container' ).css( 'display' , 'none' );
    $( '#registro_Digitalizacion_identificacion_container' ).css( 'display' , 'none' );
}

function validaFormularioDigitalizados() {
    form = $( '#registro_Digitalizacion_form' );
    mov  = $( '#registro_Digitalizacion_tipoMovimiento' ).val();

    $.validator.addMethod('filesize', function(value, element, param) {
        // param = size (en bytes) 
        // element = element to validate (<input>)
        // value = value of the element (file name)
        return this.optional(element) || (element.files[0].size <= param) 
    });

    if( mov == 'alta' ) {
        form.validate({
            rules: {
                registro_Digitalizacion_solicitud                 : {required: true , accept: "pdf", filesize: 1048576},
                registro_Digitalizacion_autorizacionDomiciliacion : {required: true , accept: "pdf", filesize: 1048576},
                registro_Digitalizacion_contrato                  : {required: true , accept: "pdf", filesize: 4048576},
                registro_Digitalizacion_cedula                    : {required: true , accept: "pdf", filesize: 500000 },
                registro_Digitalizacion_edoCta                    : {required: true , accept: "pdf", filesize: 500000 },
                registro_Digitalizacion_comprobanteDom            : {required: true , accept: "pdf", filesize: 500000 },
                registro_Digitalizacion_actaCons                  : {required: false, accept: "pdf", filesize: 4048576},
                registro_Digitalizacion_poderNotarial             : {required: false, accept: "pdf", filesize: 4048576},
                registro_Digitalizacion_identificacion            : {required: true , accept: "pdf", filesize: 500000 },
                registro_Digitalizacion_idRegistro                : "required",
                registro_Digitalizacion_idRegistroID              : "required"
            },
            messages: {
                registro_Digitalizacion_solicitud                 : "<br />* La solicitud debe tener formato pdf y no exceder 1 MB de peso",
                registro_Digitalizacion_autorizacionDomiciliacion : "<br />* La autorizacion debe tener formato pdf y no exceder 1 MB de peso",
                registro_Digitalizacion_contrato                  : "<br />* El contrato debe tener formato pdf y no exceder 4 MB de peso",
                registro_Digitalizacion_cedula                    : "<br />* La cedula debe tener formato pdf y no exceder 500 KB de peso",
                registro_Digitalizacion_edoCta                    : "<br />* El estado de cuenta debe tener formato pdf y no exceder 500 KB de peso",
                registro_Digitalizacion_comprobanteDom            : "<br />* El comprobante de domicilio debe tener formato pdf y no exceder 500 KB de peso",
                registro_Digitalizacion_actaCons                  : "<br />* El acta constitutiva debe tener formato pdf y no exceder 4 MB de peso",
                registro_Digitalizacion_poderNotarial             : "<br />* El poder notarial debe tener formato pdf y no exceder 4 MB de peso",
                registro_Digitalizacion_identificacion            : "<br />* La identificacion debe tener formato pdf y no exceder 500 KB de peso",
                registro_Digitalizacion_idRegistro                : "<br />* Falta razon social para asignar documentos",
                registro_Digitalizacion_idRegistroID              : "<br />* Falta razon social para asignar documentos"
            }
        });
    } else if( mov == 'edita' ) {
        form.validate({
            rules: {
                registro_Digitalizacion_idRegistro                : "required",
                registro_Digitalizacion_idRegistroID              : "required"
            },
            messages: {
                registro_Digitalizacion_idRegistro                : "<br />* No ha seleccionado razon social a editar",
                registro_Digitalizacion_idRegistroID              : "<br />* No ha seleccionado razon social a editar"
            }
        });
    }

    if( form.valid() ){
        $( '#registro_Digitalizacion_form' ).submit();
        abreModalSistema();
        ocultaDescargas();
    }
}

function avisoAltaDigitalizados() {
    dialogoAviso( 'Documentos Digitalizados' , 'Los archivos se han almacenado correctamente' );
}

function errorAltaDigitalizados() {
    dialogoAviso( 'Documentos Digitalizados' , 'Se present&oacute; un error en el alta de los documentos, seleccione correctamente la Razon Social' );
}

function resetFormulario() {
    cierraModalSistema();
    resetForm( 'registro_Digitalizacion_form' );
}
