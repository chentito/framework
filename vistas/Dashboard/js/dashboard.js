/* 
 * Control de la interfaz grafica del dashboard
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Mayo 2018
 */

$(function () {
    // Make monochrome colors and set them as default for all pies
    Highcharts.getOptions().plotOptions.pie.colors = (function () {
    var colors = [],
    base = Highcharts.getOptions().colors[0],
    i;
    
    	for (i = 0; i < 10; i += 1) {
    		// Start out with a darkened base color (negative brighten), and end
        	// up with a much brighter color
        	colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    	}
    	return colors;
    }());
    
    //progressBar();
});

function progressBar() {
    valor = $( '#cargaDashboard_avance' ).val();
    $( "#progressbar" ).progressbar({
        value: parseInt( valor )
    });
}

