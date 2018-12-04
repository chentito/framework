/*
 * Control de la interfaz grafica de la descarga de formatos
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

/* Eventos iniciados */
$( '#descargaFormatos_edicionDatos_contenedor' ).hide();
$( "#descargaFormatos_edicionDatos_contenedor button" )
      .eq( 0 ).button({
        icons: { primary: "ui-icon-pencil" }, text: false
      }).click(function(){
          cargaFormularioFormatos( 1 );
      })
      /*.end().eq( 1 ).button({
        icons: { primary: "ui-icon-pencil" }, text: false
      }).click(function(){
          cargaFormularioFormatos( 3 );
      })*/
      .end().eq( 1 ).button({
        icons: { primary: "ui-icon-pencil" }, text: false
      }).click(function(){
          cargaFormularioFormatos( 2 );
      })
      .end().eq( 2 ).button({
        icons: { primary: "ui-icon-pencil" }, text: false
      }).click(function(){
          cargaFormularioFormatos( 4 );
      }).end().eq( 3 ).button({
        icons: { primary: "ui-icon-pencil" }, text: false
      }).click(function(){
          cargaFormularioFormatos( 5 );
      });

/* Autocomplete */
$( '#descargaFormatos_idRegistro' ).autocomplete({
    source: "../../Registro/razonSocialAutocomplete/",
    minLength: 2,
    select: function( event, ui ) {
        $( '#descargaFormatos_idRegistroID' ).val( ui.item.id );
        $( '#descargaFormatos_idSistema' ).val( ui.item.sistema );
        if( ui.item.sistema == '2') {
            $( '#btn_DescargaRefComerciales' ).unbind();
        }
        $( '#descargaFormatos_idGiro' ).val( ui.item.giro );
        $( '#descargaFormatos_idGiroTexto' ).val( ui.item.giroTxt );
        edicionDeDescargables();
    }
});

/* Eventos */
$( '#btn_DescargaSolicitud' ).click(function( e ) {
    e.preventDefault();
    idSolicitud = $( '#descargaFormatos_idRegistroID' ).val();
    if( idSolicitud == "" )return false;
    location.replace( '/Registro/descargaFormatosPDF/id=1|idSol='+idSolicitud+'/' );
});

$( '#btn_DescargaAutDomiciliacion' ).click(function( e ){
    e.preventDefault();
    idSolicitud = $( '#descargaFormatos_idRegistroID' ).val();
    if( idSolicitud == "" )return false;
    location.replace( '/Registro/descargaFormatosPDF/id=2|idSol='+idSolicitud+'/' );
});

$( '#btn_DescargaAutRepCredito' ).click(function( e ){
    e.preventDefault();
    idSolicitud = $( '#descargaFormatos_idRegistroID' ).val();
    if( idSolicitud == "" )return false;
    location.replace( '/Registro/descargaFormatosPDF/id=3|idSol='+idSolicitud+'/' );
});

$( '#btn_DescargaRefComerciales' ).click(function( e ){
    e.preventDefault();
    idSolicitud = $( '#descargaFormatos_idRegistroID' ).val();
    if( idSolicitud == "" )return false;
    location.replace( '/Registro/descargaFormatosPDF/id=4|idSol='+idSolicitud+'/' );
});

$( '#btn_DescargaContrato' ).click(function( e ){
    e.preventDefault();
    idSolicitud = $( '#descargaFormatos_idRegistroID' ).val();
    sistema     = $( '#descargaFormatos_idSistema' ).val();
    giro        = $( '#descargaFormatos_idGiro' ).val();
    giroTxt     = $( '#descargaFormatos_idGiroTexto' ).val();
    if( idSolicitud == "" )return false;
    location.replace( '/Registro/descargaFormatosPDF/sistema='+sistema+'|giro='+giro+'|texto='+giroTxt+'|id=5|idSol='+idSolicitud+'/' );
});

$( '#btn_DescargaContratoImpart' ).click(function( e ){
    e.preventDefault();
    idSolicitud = $( '#descargaFormatos_idRegistroID' ).val();
    location.replace( '/Registro/descargaFormatosPDF/id=6|idSol='+idSolicitud+'/' );
});

/* Botones */
$( '#descargaFormatos_eliminaBusquedaBoton' ).button({icons: { primary: "ui-icon-close" }, text: false}).click( function( e ) {
    e.preventDefault();
    ocultaDecargables();
});

/* Funciones */
function edicionDeDescargables() {
    $( '#descargaFormatos_edicionDatos_contenedor' ).show();
}

function ocultaDecargables() {
    $( '#descargaFormatos_edicionDatos_contenedor' ).hide();
    $( '#descargaFormatos_idRegistroID' ).val( '' );
    $( '#descargaFormatos_idRegistro' ).val( '' );
}

function cargaFormularioFormatos( id ) {
    var medidas = [];
    if( id == 1 ) { // Domiciiacion
        medidas[ 0 ] = 450; medidas[ 1 ] = 350;
        nForm = "formDatosFormatoDomiciliacion";
    } else if( id == 2 ) { // Solo acg
        if( $( '#descargaFormatos_idSistema' ).val() == '2' ) {return false;
        }else{
            medidas[ 0 ] = 450; medidas[ 1 ] = 370;
            nForm = "formDatosFormatoReferenciasComerciales";
        }
    } else if( id == 3 ) { // Reporte credito
        medidas[ 0 ] = 450; medidas[ 1 ] = 250;
        nForm = "formDatosFormatoReporteCrediticio";
    } else if( id == 4 ) { // Contratos
        medidas[ 0 ] = 450; medidas[ 1 ] = 200;
        nForm = "formDatosFormatoContrato";
    } else if( id == 5 ) { // Contratos
        medidas[ 0 ] = 450; medidas[ 1 ] = 200;
        nForm = "formDatosFormatoContrato";
    }

    $( '#ventanaCargaFormularioFormatoDescarga' ).remove();
    $( 'body' ).append( '<div id="ventanaCargaFormularioFormatoDescarga" name="ventanaCargaFormularioFormatoDescarga" title="Datos Formatos Descarga" ></div>' );
    $( '#ventanaCargaFormularioFormatoDescarga' ).load( '../../Registro/cargaFormularioFormatos/idFormato=' + id + '|idSolicitud=' + $( '#descargaFormatos_idRegistroID' ).val() + '/' ).dialog({
        modal: true, draggable: false, closeOnEscape:false, resizable:false, width: medidas[ 0 ], height: medidas[ 1 ],
        buttons:{
            'Guardar': function() {
                datos = $( '#' + nForm ).serialize();
                $.post( '../../Registro/guardaDatosFormularioFormatos/?' + datos  , function( d ) {
                    if( d == '1' ) {
                        dialogoAviso( 'Alta formato' , 'Datos agregados correctamente.' );
                        $( this ).dialog( 'close' );
                        $( this ).dialog( 'destroy' );
                        $( '#ventanaCargaFormularioFormatoDescarga' ).remove();
                    } else {
                        dialogoAviso( 'Alta formato' , 'Error al agregar datos, intente nuevamente.' );
                        $( this ).dialog( 'close' );
                        $( this ).dialog( 'destroy' );
                        $( '#ventanaCargaFormularioFormatoDescarga' ).remove();
                    }
                });
            },
            'Cancelar': function() {
                $( this ).dialog( 'close' );
                $( this ).dialog( 'destroy' );
                $( '#ventanaCargaFormularioFormatoDescarga' ).remove();
            }
        }
    }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}


