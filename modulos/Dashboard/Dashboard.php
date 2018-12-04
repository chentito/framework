<?php
/*
 * Controlador que genera las graficas del dashboard del sistema
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/Template.php';
include_once _DIRPATH_ . '/sistema/Interfaz/Grafica.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

/*
 * Funcionalidades de los modulos
 */
include_once _DIRPATH_ . '/modulos/Dashboard/modelo/MDashboard.php';

class Dashboard extends Template {
    
    /*
     * Atributo que contiene la instancia del modelo
     */
    protected $modelo = null;
    
    /*
     * Constructor de la clase
     */
    public function __construct() {
        new Sesion();
        parent::__construct();
        $this->modelo = new MDashboard();
    }

    /*
     * Metodo que carga el dashboard correspondiente de acuerdo al usuario logeado
     */
    public function cargaDashboard() {
        $datos         = $this->modelo->clientesPorMes();
        $g1            = 'graficaDashboard_1';
        $graficaSupIzq = new Grafica( $g1 , 'Usuarios por mes' , 'Items' , 'pie' , $datos );

        $this->muestraDato( 'scripts'    , array('/vistas/Dashboard/js/dashboard.js') );
        $this->muestraDato( 'grafica1'   , $g1 );
        $this->muestraDato( 'jsGrafica1' , $graficaSupIzq->js );
        $this->muestraDato( 'esAdmin'    , ( $_SESSION[ 'perfil' ] == '1' ) ? 'admin' : 'user' );
        $this->muestraDato( 'avance'     , $this->proceso() );

        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Metodo que obtiene los pasos del proceso
     */
    public function proceso() {
        return $this->modelo->proceso();
    }

    /*
     * Muestra el dashboard administrativo
     */
    public function administrativo() {
        $series  = $this->modelo->seriesGraficaPieAdmin();
        $series2 = $this->modelo->seriesGraficaPieAdmin2();
        $g1      = 'graficaContainer_si';
        $g2      = 'graficaContainer_sc';
        $graficaSupIzq = new Grafica( $g1 , 'Existencias por Clientes' , 'Items' , 'pie' , $series );
        $graficaSupCen = new Grafica( $g2 , 'Existencias por Almacenes' , 'Items' , 'pie' , $series2 );
        $this->muestraDato( 'grafica1' , $g1 );
        $this->muestraDato( 'grafica2' , $g2 );
        $this->muestraDato( 'titulo1' , _DASHBOARDADMINTITGRAF1_ );
        $this->muestraDato( 'titulo2' , _DASHBOARDADMINTITGRAF2_ );
        $this->muestraDato( 'jsGrafica1' , $graficaSupIzq->js );
        $this->muestraDato( 'jsGrafica2' , $graficaSupCen->js );
        $this->muestraDato( 'scripts' , array('/vistas/Dashboard/js/administrativo.js') );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

}

