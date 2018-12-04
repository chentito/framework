/* 
 * Control de la interfaz grafica para la validacion de solicitudes
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Septiembre 2017
 */
idSolicitud = $( '#validacionSolicitud_idSolicitud' ).val();

$( '.descargaSolicitud' ).click( function( e ){
    location.replace( '/Registro/descargaFormatosPDF/id=1|idSol=' + idSolicitud + '/' );
});

$( '.descargaReporteCrediticio' ).click( function( e ){
    location.replace( '/Registro/descargaFormatosPDF/id=3|idSol=' + idSolicitud + '/' );
});

$( '.descargaReferenciasComerciales' ).click( function( e ){
    location.replace( '/Registro/descargaFormatosPDF/id=4|idSol=' + idSolicitud + '/' );
});

$( '.descargaDomiciliacion' ).click( function( e ){
    location.replace( '/Registro/descargaFormatosPDF/id=2|idSol=' + idSolicitud + '/' );
});

