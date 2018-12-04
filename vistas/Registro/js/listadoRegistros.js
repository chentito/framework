/*
 * Control de la interfaz grafica de la alta de registro
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

function AutorizarSolicitud( e, dt, node, config ) {
    $( '#contenedorValidacionSolicitudes' ).remove();
    var row_selected = dt.row(".selected").data();
    if( row_selected === undefined) {
            //Mostramos mensaje de error
            dialogoAviso( "Descarga Solicitud" , "<p>Para continuar debe seleccionar un registro</p>" );
        } else {
            var idSelected = row_selected.id;            
            $.post( '../../Registro/verificaValidacionPrevia/idSol='+idSelected+'/' , function( d ){
                datos = JSON.parse( d );
                if( datos.verificado == 'v' ){
                        $( 'body' ).append( '<div title="Validaci&oacute;n de Solicitud" id="contenedorValidacionSolicitudes" name="contenedorValidacionSolicitudes"><center>Solicitud ' + ( ( datos.validacion == '1' ) ? 'autorizada' : 'rechazada' ) + ' previamente</center></div>' );
                        $( '#contenedorValidacionSolicitudes' ).dialog({
                            modal: true, draggable:false, resizable:false, closeOnEscape:false, width: 270, height:100,
                            buttons:{
                                'Aceptar': function() {
                                    $( '#contenedorValidacionSolicitudes' ).dialog( 'close' );
                                    $( '#contenedorValidacionSolicitudes' ).dialog( 'destroy' );
                                    $( '#contenedorValidacionSolicitudes' ).remove();
                                }
                            }
                        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
                    } else {
                        $( 'body' ).append( '<div title="Validaci&oacute;n de Solicitud" id="contenedorValidacionSolicitudes" name="contenedorValidacionSolicitudes"></div>' );
                        $( '#contenedorValidacionSolicitudes' ).load( '../../Registro/pantallaValidacionSolicitud/idRegistro=' + idSelected + '/' ).dialog({
                            modal: true, draggable:false, resizable:false, closeOnEscape:false, width: 310, height:240,
                            buttons:{
                                'Recordatorio': function() {
                                    abreModalSistema();
                                    $.post( '../../Registro/enviaRecordatorioComprobante/idSolicitud='+idSelected+'/' , function(d){
                                        cierraModalSistema();
                                        dialogoAviso( 'Env&iacute;o de Recordatorio' , '<center>Correo enviado correctamente</center>' );
                                    });
                                },
                                'Autorizar': function() {
                                    abreModalSistema();
                                    var noClienteAudatex = $( '#validaSolicitud_noClienteAudatex' ).val();
                                    $.post( '../../Registro/guardaValidacionSolicitud/noClienteAudatex='+noClienteAudatex+'|idSolicitud='+idSelected+'|val=1|motivoRechazo=/' , {} , function( d ){
                                        cierraModalSistema();
                                        dialogoAviso( 'Validaci&oacute;n Solicitud' , '<center>La solicitud se ha validado correctamente</center>' );
                                    });
                                    $( '#contenedorValidacionSolicitudes' ).dialog( 'close' );
                                    $( '#contenedorValidacionSolicitudes' ).dialog( 'destroy' );
                                    $( '#contenedorValidacionSolicitudes' ).remove();
                                },
                                'Rechazar': function() {
                                    $( '#capturaMotivoRechazoSolicitud' ).remove();
                                    $( 'body' ).append( '<div id="capturaMotivoRechazoSolicitud" name="capturaMotivoRechazoSolicitud" title"Rechazo Solicitud"></div>' );
                                    $( '#capturaMotivoRechazoSolicitud' ).load( '../../Registro/pantallaMotivoRechazo/idSolicitud='+idSelected+'/' ).dialog({
                                       modal: true, draggable: false, closeOnEscape: false, resizable: false, width: 370, height:180,
                                       buttons: {
                                            'Cancelar':function() {
                                                $( this ).dialog( 'close' );
                                                $( this ).dialog( 'destroy' );
                                                $( '#contenedorValidacionSolicitudes' ).remove();
                                                $( '#capturaMotivoRechazoSolicitud' ).dialog( 'close' );
                                                $( '#capturaMotivoRechazoSolicitud' ).dialog( 'destroy' );
                                                $( '#capturaMotivoRechazoSolicitud' ).remove();
                                            },
                                            'Aplicar Rechazo': function() {
                                                $( '#cancelaSolicitud_form' ).submit();
                                                abreModalSistema();
                                           }
                                       }
                                    }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
                                },
                                'Cerrar': function() {
                                    $( '#contenedorValidacionSolicitudes' ).dialog( 'close' );
                                    $( '#contenedorValidacionSolicitudes' ).dialog( 'destroy' );
                                    $( '#contenedorValidacionSolicitudes' ).remove();
                                }
                            }
                        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
                }
            });
        }
}

function despuesRechazoProceso() {
    $( '#capturaMotivoRechazoSolicitud' ).dialog( 'close' );
    $( '#capturaMotivoRechazoSolicitud' ).dialog( 'destroy' );
    $( '#capturaMotivoRechazoSolicitud' ).remove();
    $( '#contenedorValidacionSolicitudes' ).dialog( 'close' );
    $( '#contenedorValidacionSolicitudes' ).dialog( 'destroy' );
    $( '#contenedorValidacionSolicitudes' ).remove();
    cierraModalSistema();
}

function DescargaSolicitud( e, dt, node, config ) {
    var row_selected = dt.row(".selected").data();
    if( row_selected === undefined) {
            //Mostramos mensaje de error
            dialogoAviso( "Descarga Solicitud" , "<p>Para continuar debe seleccionar un registro</p>" );
        } else {
            var idSelected = row_selected.id;
            location.replace( '/Registro/descargaFormatosPDF/id=1|idSelected=' + idSelected + '/' );
    }
}

function Comentarios( e, dt, node, config ) {
    var row_selected = dt.row(".selected").data();
    if( row_selected === undefined) {
            //Mostramos mensaje de error
            dialogoAviso( "Agregar Comentario" , "<p>Para continuar debe seleccionar un registro</p>" );
        } else {
            var idSelected = row_selected.id;
            $.post( '/Registro/consultaComentarioRegistro/id='+idSelected+'/' , function( d ){
                $( 'body' ).append( '<div id="contenedorComentarioRegSolicitud" name="contenedorComentarioRegSolicitud" title="Comentarios/Observaciones"></div>' );
                $( '#contenedorComentarioRegSolicitud' ).load( '/Registro/altaComentarioRegistro/id=1|idSelected=' + idSelected + '|contenido=' + escape( d ) + '/' ).dialog({
                    modal: true, draggable: false, closeOnEscape: false, resizable:false, width:'500px', heigth:'300px',
                    buttons: {
                        'Guardar': function() {
                            id        = $( '#comentariosGeneralesRegistroSolicitudID' ).val();
                            contenido = $( '#comentariosGeneralesRegistroSolicitud' ).val();
                            $.post( '/Registro/guardaComentarioRegistro/id='+id+'|contenido='+contenido+'/' , function( d ) {
                                dialogoAviso( 'Comentarios Registro Solicitud' , d );
                                $( this ).dialog( 'close' );
                                $( this ).dialog( 'destroy' );
                                $( '#contenedorComentarioRegSolicitud' ).remove();
                            });
                        },
                        'Cerrar': function() {
                            $( this ).dialog( 'close' );
                            $( this ).dialog( 'destroy' );
                            $( '#contenedorComentarioRegSolicitud' ).remove();
                        }
                    }
                }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
            });
    }
}

function EditarDatos( e, dt, node, config ){
    var row_selected = dt.row(".selected").data();
    if( row_selected === undefined){
        //Mostramos mensaje de error
        dialogoAviso("Editar Registro", "<p>Para continuar debe seleccionar un registro</p>");
    }else{
        //Continuamos ya que si fue seleccionado un registro
        var idSelected = row_selected.id;
        //Ejecutamos ajax para obtener datos registro para id seleccionado
        $.ajaxSetup({async:false});
        $.post( '../../Registro/obtieneRegistroID/' , {idSelected:idSelected} , function( d ) {
            if(d == ""){
                //Mostramos mensaje de error
                dialogoAviso("Editar Registro", "<p>Ocurrio un error al obtener la informaci&oacute;n, por favor intente nuevamente:</p>");
            }else{
                detalle = $.parseJSON( d );
                var nombreComercial = detalle.nombreComercial;
                var calleComercial = detalle.calleComercial;
                var coloniaComercial = detalle.coloniaComercial;
                var delegacionComercial = detalle.delegacionComercial;
                var ciudadComercial = detalle.ciudadComercial;
                var entidadComercial = detalle.entidadComercial;
                var cpComercial = ( detalle.cpComercial.length == 4 ) ? '0'+detalle.cpComercial : detalle.cpComercial ;
                var paisComercial = detalle.paisComercial;
                var telefonoComercial = detalle.telefonoComercial;
                var faxComercial = detalle.faxComercial;
                var nombreFiscal = detalle.nombreFiscal;
                var rfcFiscal = detalle.rfcFiscal;
                var calleFiscal = detalle.calleFiscal;
                var coloniaFiscal = detalle.coloniaFiscal;
                var delegacionFiscal = detalle.delegacionFiscal;
                var ciudadFiscal = detalle.ciudadFiscal;
                var entidadFiscal = detalle.entidadFiscal;
                var cpFiscal = ( detalle.cpFiscal.length == 4 ) ? '0'+detalle.cpFiscal : detalle.cpFiscal ;
                var paisFiscal = detalle.paisFiscal;
                var telefonoFiscal = detalle.telefonoFiscal;
                var faxFiscal = detalle.faxFiscal;
                var local = detalle.local;
                var contactoComercial = detalle.contactoComercial;
                var contactoCuentasPagar = detalle.contactoCuentasPagar;
                var correoContactoComercial = detalle.correoContactoComercial;
                var correoContactoCuentasPagar = detalle.correoContactoCuentasPagar;
                var telefonoContactoComercial = detalle.telefonoContactoComercial;
                var telefonoContactoCuestasPagar = detalle.telefonoContactoCuestasPagar;
                var antiguedadDomicilio = detalle.antiguedadDomicilio;
                var aseguradoras = detalle.aseguradoras;
                var representanteLegal = detalle.representanteLegal;
                var regimenFiscal = detalle.regimenFiscal;
                var giroNegocio = detalle.giroNegocio;
                var giroTexto = detalle.giroTexto;
                var noClienteAudatex = detalle.noClienteAudatex;

                //Abrimos TAB Alta de registro
                var tabNameExists = false;
                var tabindex = $("#tabs").tabs('option', 'selected');
                var url2 = $( "#tabs li:contains('Alta de registro')" ).children('a');
                var url = (url2).attr( "href" );

                $('#tabs ul li a').each(function(i) {
                    if ( !url ) {
                        tabNameExists = true;
                    }
                });

                var tabindex = $("#tabs").tabs('option', 'selected');

                if (!tabNameExists){
                    $("#tabs").tabs('remove', tabindex);
                    //$("#tabs").tabs('select', url);
                    $("#tabs").tabs('remove', url);
                    $("#tabs").tabs('add',"../../Registro/altaRegistro/accion=editar|noClienteAudatex="+noClienteAudatex+"|giroNegocio="+giroNegocio+"|giroTexto="+giroTexto+"|regimenFiscal="+regimenFiscal+"|representanteLegal="+representanteLegal+"|paisFiscal="+paisFiscal+"|paisComercial="+paisComercial+"|aseguradoras="+aseguradoras+"|idRegistro="+idSelected+"|nombreComercial="+nombreComercial+"|calleComercial="+calleComercial+"|coloniaComercial="+coloniaComercial+"|delegacionComercial="+delegacionComercial+"|ciudadComercial="+ciudadComercial+"|entidadComercial="+entidadComercial+"|cpComercial="+cpComercial+"|telefonoComercial="+telefonoComercial+"|faxComercial="+faxComercial+"|nombreFiscal="+nombreFiscal+"|rfcFiscal="+rfcFiscal+"|calleFiscal="+calleFiscal+"|coloniaFiscal="+coloniaFiscal+"|delegacionFiscal="+delegacionFiscal+"|ciudadFiscal="+ciudadFiscal+"|entidadFiscal="+entidadFiscal+"|cpFiscal="+cpFiscal+"|telefonoFiscal="+telefonoFiscal+"|faxFiscal="+faxFiscal+"|local="+local+"|contactoComercial="+contactoComercial+"|contactoCuentasPagar="+contactoCuentasPagar+"|correoContactoComercial="+correoContactoComercial+"|correoContactoCuentasPagar="+correoContactoCuentasPagar+"|telefonoContactoComercial="+telefonoContactoComercial+"|telefonoContactoCuestasPagar="+telefonoContactoCuestasPagar+"|antiguedadDomicilio="+antiguedadDomicilio+"/","&nbsp;&nbsp;Alta de Registro");
                }else{
                    $("#tabs").tabs('remove', tabindex);
                    $("#tabs").tabs('add',"../../Registro/altaRegistro/accion=editar|noClienteAudatex="+noClienteAudatex+"|giroNegocio="+giroNegocio+"|giroTexto="+giroTexto+"|regimenFiscal="+regimenFiscal+"|representanteLegal="+representanteLegal+"|paisFiscal="+paisFiscal+"|paisComercial="+paisComercial+"|aseguradoras="+aseguradoras+"|idRegistro="+idSelected+"|nombreComercial="+nombreComercial+"|calleComercial="+calleComercial+"|coloniaComercial="+coloniaComercial+"|delegacionComercial="+delegacionComercial+"|ciudadComercial="+ciudadComercial+"|entidadComercial="+entidadComercial+"|cpComercial="+cpComercial+"|telefonoComercial="+telefonoComercial+"|faxComercial="+faxComercial+"|nombreFiscal="+nombreFiscal+"|rfcFiscal="+rfcFiscal+"|calleFiscal="+calleFiscal+"|coloniaFiscal="+coloniaFiscal+"|delegacionFiscal="+delegacionFiscal+"|ciudadFiscal="+ciudadFiscal+"|entidadFiscal="+entidadFiscal+"|cpFiscal="+cpFiscal+"|telefonoFiscal="+telefonoFiscal+"|faxFiscal="+faxFiscal+"|local="+local+"|contactoComercial="+contactoComercial+"|contactoCuentasPagar="+contactoCuentasPagar+"|correoContactoComercial="+correoContactoComercial+"|correoContactoCuentasPagar="+correoContactoCuentasPagar+"|telefonoContactoComercial="+telefonoContactoComercial+"|telefonoContactoCuestasPagar="+telefonoContactoCuestasPagar+"|antiguedadDomicilio="+antiguedadDomicilio+"/","&nbsp;&nbsp;Alta de Registro");
                }
            }        
        });
    }
}

function DatosACG( e, dt, node, config ) {
    var row_selected = dt.row(".selected").data();
    if( row_selected === undefined) {
            //Mostramos mensaje de error
            dialogoAviso( "Capturar datos ACG" , "<p>Para continuar debe seleccionar un registro</p>" );
        } else {
            var idSelected = row_selected.id;
            $( '#contenedorDatosACG' ).remove();
            $( 'body' ).append( '<div id="contenedorDatosACG" name="contenedorDatosACG" title="Datos ACG" ></div>' );
            $( '#contenedorDatosACG' ).load( '../../Registro/datosACG/idSol='+idSelected+'/' ).dialog({
                modal: true, draggable: false, resizable: false, closeOnEscape: false, width: '280' , height:'180',
                buttons:{
                    'Guardar': function() {
                        usuario = $( '#datosListadoRegistro_ACG_usuario' ).val();
                        passwrd = $( '#datosListadoRegistro_ACG_password' ).val();
                        $.post( '../../Registro/guardaDatosACG/usuario='+usuario+'|passwd='+passwrd+'|id='+idSelected+'/', function( e ){
                            dialogoAviso( 'Datos ACG' , "<center>Informaci&oacute;n guardada!</center>" );
                            $( this ).dialog( 'close' );
                            $( this ).dialog( 'destroy' );
                            $( '#contenedorDatosACG' ).remove();
                        });
                    },
                    'Cancelar': function() {
                        $( this ).dialog( 'close' );
                        $( this ).dialog( 'destroy' );
                        $( '#contenedorDatosACG' ).remove();
                    }
                }
            }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}

