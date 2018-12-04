<?php
/*
 * Clase que contiene la estructura de las graficas a mostrar en los dashboards
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

class Grafica {
    /*
     * Atributo que contiene el identificador del contenedor donde se mostrara la grafica
     */
    protected $container = '';

    /*
     * Titulo de la grafica
     */
    protected $titulo = '';
    
    /*
     * Tipo de grafica a armar
     */
    protected $tipoGrafica = '';

    /*
     * Elemento de medicion
     */
    protected $elemento = '';
    
    /*
     * Atributo que contiene las series a graficar
     */
    public $series = array();
    
    /*
     * Atributo que contiene la estructura final js para desplegar el contenido
     */
    public $js = '';

    /*
     * Constructor de la clase
     */
    public function __construct( $container , $titulo , $elemento , $tipoGrafica , $series ) {
        $this->container   = $container;
        $this->titulo      = $titulo;
        $this->tipoGrafica = $tipoGrafica;
        $this->series      = $series;
        $this->elemento    = $elemento;
        
        $this->generaGrafica();        
    }

    /*
     * Metodo que une todas las partes para generar la grafica del dashboard
     */
    public function generaGrafica() {
        if( $this->tipoGrafica == 'pie' ){
            $grafica = $this->estructuraGraficaPastel();
        }
        
        return $grafica;
    }
    
    /*
     * Metodo que contiene una estructura de grafica de pastel
     */
    private function estructuraGraficaPastel() {
        $js = "$('#" . $this->container . "').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: '". $this->titulo ."'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                exporting: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: '" . $this->elemento . "',
                    data: [
                       " . $this->series . "
                    ]
                }]
             });";
        
        $this->js = $js;
    }

}

