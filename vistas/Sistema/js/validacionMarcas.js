/* 
 * Control de la interfaz de configuracion para la validacion de campos por marcas
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2016
 */
$( '#guardaConfValidacionMarcas' ).button().click(function(e){
    e.preventDefault();
    datos = $( '#formConfValidacionMarcas' ).serialize();    
    
    $.post( '/Sistema/guardaReglasValidacion/a=b&'+datos+'/' , function( d ){
        dialogoAviso( 'Actualizacion de Reglas' , '<center>Reglas actualizadas correctamente</center>' );
    });    
});


