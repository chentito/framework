/*
 * Control de la interfaz grafica de la alta de registro
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */
$( document ).ready(function() {
    /*$( '#registro_altaRegistro_Fiscal_telefonoContactoComercial' ).mask( '(99) 999-9999999' );
    $( '#registro_altaRegistro_Fiscal_telefonoContactoCuentasPagar' ).mask( '(99) 999-9999999' );
    $( '#registro_altaRegistro_Comercial_telefono' ).mask( '(99) 999-9999999' );
    $( '#registro_altaRegistro_Fiscal_telefono' ).mask( '(99) 999-9999999' );*/
    $( '#registro_altaRegistro_Comercial_CP' ).mask( '99999' );
    $( '#registro_altaRegistro_Fiscal_CP' ).mask( '99999' );

    /******** EVENTOS *******/
    $( '#registro_altaRegistro_giroNegocio' ).change(function( e ){
        if(this.value == '2' ) {
            $( '#contenedorFabricante' ).css( 'visibility' , 'visible' );
        }else {
            $( '#contenedorFabricante' ).css( 'visibility' , 'hidden' );
        }
    });
    
    $( '#registro_altaRegistro_giroNegocio_fabricante' ).change( function( e ){
        if( this.value == '1' || this.value == '4' ) {
            $( '#contenedorIDAgencia' ).css( 'visibility' , 'visible' );
        } else {
            $( '#contenedorIDAgencia' ).css( 'visibility' , 'hidden' );
        }
    });
    
    /******** BOTONES *******/
    $( '#registro_altaRegistro_btnGuardar' ).button().click(function( e ) {
        e.preventDefault();    
        validaDatosRegistro();
    });
});


/******* FUNCIONES ********/
function validaDatosRegistro() {
    var urlValidaRFC = "";
    if( $("#registro_altaRegistro_accion").val() == "" ){
        urlValidaRFC = "../../Registro/verificaRFC/";
    }else if( $("#registro_altaRegistro_accion").val() == "editar" ){
        urlValidaRFC = "";
    }
    
    form = $("#registro_altaRegistro_form");
    form.validate({
        rules: {
            registro_altaRegistro_Comercial_nombreComercial : "required",
            registro_altaRegistro_Fiscal_nombreFiscal : "required",
            registro_altaRegistro_Comercial_calle : "required",
            registro_altaRegistro_Comercial_colonia : "required",
            registro_altaRegistro_Comercial_delegacion : "required",
            registro_altaRegistro_Comercial_pais : "required",
            registro_altaRegistro_Comercial_ciudad : "required",
            registro_altaRegistro_Comercial_telefono : "required",
            registro_altaRegistro_Comercial_CP : "required",
            registro_altaRegistro_Fiscal_rfc :{
                "required" : true,
                "minlength": 12,
                "maxlength": 13,
                "remote"   : {
                    url     : urlValidaRFC,
                    type    : "POST"
                }
            }, 
            registro_altaRegistro_Fiscal_calle : "required",
            registro_altaRegistro_Fiscal_colonia : "required",
            registro_altaRegistro_Fiscal_delegacion : "required",
            registro_altaRegistro_Fiscal_ciudad : "required",
            registro_altaRegistro_Fiscal_pais : "required",
            registro_altaRegistro_Fiscal_CP : "required",
            registro_altaRegistro_Fiscal_telefono : "required",
            registro_altaRegistro_Fiscal_lugarOcupa : "required",
            registro_altaRegistro_Fiscal_contactoComercial : "required",
            registro_altaRegistro_Fiscal_contactoCuentasPagar : "required",
            registro_altaRegistro_Fiscal_antiguedadDomicilio : "required",
            registro_altaRegistro_Fiscal_correoContactoComercial : {
                "required" : true,
                "email"    : true
            },
            registro_altaRegistro_Fiscal_correoContactoCuentasPagar : {
                "required" : true,
                "email"    : true
            },
            registro_altaRegistro_Fiscal_telefonoContactoComercial : "required",
            registro_altaRegistro_Fiscal_telefonoContactoCuentasPagar : "required"
        },
        messages: {
            registro_altaRegistro_Comercial_nombreComercial           : "<br />* No ha capturado el Nombre Comercial",
            registro_altaRegistro_Fiscal_nombreFiscal                 : "<br />* No ha capturado el Nombre Fiscal",
            registro_altaRegistro_Comercial_calle                     : "<br />* No ha capturado la calle en el registro comercial",
            registro_altaRegistro_Comercial_colonia                   : "<br />* No ha capturado la colonia en el registro comercial",
            registro_altaRegistro_Comercial_delegacion                : "<br />* No ha capturado la delegacion en el registro comercial",
            registro_altaRegistro_Comercial_pais                      : "<br />* No ha capturado el pais en el registro comercial",
            registro_altaRegistro_Comercial_ciudad                    : "<br />* No ha capturado la ciudad en el registro comercial",
            registro_altaRegistro_Comercial_telefono                  : "<br />* No ha capturado el telefono en el registro comercial",
            registro_altaRegistro_Comercial_CP                        : "<br />* No ha capturado el codigo postal en el registro comercial",
            registro_altaRegistro_Fiscal_rfc                          : {
                                                                            "required" : "<br />* No ha capturado el RFC, 12 posiciones persona fisica, 13 persona moral",
                                                                            "remote" : "<br />* El RFC capturado ya se encuentra en uso" 
                                                                        },
            registro_altaRegistro_Fiscal_calle                        : "<br />* No ha capturado la calle",
            registro_altaRegistro_Fiscal_colonia                      : "<br />* No ha capturado la colonia",
            registro_altaRegistro_Fiscal_delegacion                   : "<br />* No ha capturado la delegacion",
            registro_altaRegistro_Fiscal_ciudad                       : "<br />* No ha capturado la ciudad",
            registro_altaRegistro_Fiscal_pais                         : "<br />* No ha capturado el pais",
            registro_altaRegistro_Fiscal_CP                           : "<br />* No ha capturado el codigo postal",
            registro_altaRegistro_Fiscal_telefono                     : "<br />* No ha capturado el telefono",
            registro_altaRegistro_Fiscal_lugarOcupa                   : "<br />* No ha capturado el local que ocupa",
            registro_altaRegistro_Fiscal_contactoComercial            : "<br />* No ha capturado el contacto comercial",
            registro_altaRegistro_Fiscal_contactoCuentasPagar         : "<br />* No ha capturado el contacto de cuentas por pagar",
            registro_altaRegistro_Fiscal_antiguedadDomicilio          : "<br />* No ha capturado la antiguedad en domicilio",
            registro_altaRegistro_Fiscal_correoContactoComercial      : "<br />* No ha capturado el correo del contacto comercial",
            registro_altaRegistro_Fiscal_correoContactoCuentasPagar   : "<br />* No ha capturado el el correo del contacto de cuentas por pagar",
            registro_altaRegistro_Fiscal_telefonoContactoComercial    : "<br />* No ha capturado el telefono del contacto comercial",
            registro_altaRegistro_Fiscal_telefonoContactoCuentasPagar : "<br />* No ha capturado el telefono del contacto de cuentas por pagar"
        }
    });

    if( form.valid() ){
        datos = $( '#registro_altaRegistro_form' ).serialize();
        guardaRegistro( datos );
    }    
}

function guardaRegistro( datos ) {
    var accionEjecutada = "";
    if( $("#registro_altaRegistro_accion").val() == "" ){
        accionEjecutada = "agregado";
    }else if( $("#registro_altaRegistro_accion").val() == "editar" ){
        accionEjecutada = "editado";
    }
    
    $.ajaxSetup({async:false});
    $.post( '../../Registro/guardaDetalleRegistro/' , datos , function( d ) {
        if( d == 1 ) {
            dialogoAviso( 'Alta de Registro' , '<center>Registro '+accionEjecutada+' exitosamente.</center>' );
            if( $("#registro_altaRegistro_accion").val() == "" ){ $( '#registro_altaRegistro_form' ).trigger( 'reset' ); }
        } else {
            dialogoAviso( 'Alta de Registro' , '<center>Error al realizar operaci&oacute;n en el registro [' + d + '], inente m&aacute;s tarde.</center>' );
        }
    }); 
}

function isNumberKey(evt) {
    var key = evt.keyCode ?evt.keyCode : evt.which;
    return(key <= 40 || (key >= 48 && key <= 57 ));
}