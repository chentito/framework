<?php
/**
 * Controlador del modulo de registro, pantalla principal del sistema
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Junio 2018
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/Template.php';
include_once _DIRPATH_ . '/sistema/Interfaz/JQDataTable.php';
include_once _DIRPATH_ . '/sistema/Interfaz/MenuXML.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

/*
 * Funcionalidades del Modulo
 */
include_once _DIRPATH_ . '/modulos/Capacitacion/modelo/MCapacitacion.php';

class Capacitacion extends Template {

    var $modelo = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        new Sesion();
        parent::__construct();
        $this->modelo = new MCapacitacion();
    }

    /*
     * Carga pantalla para adjuntar documentos de certificacion
     */
    public function altaDocCertificados() {
        $this->muestraDato( 'scripts'             , array( '/vistas/Capacitacion/js/altaDocCertificados.js' ) );
        $this->muestraDato( 'estilos'             , array( '/vistas/Capacitacion/css/altaDocCertificados.css' ) );
        $this->muestraDato( 'breadcrumb'          , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Capacitaci&oacute;n' ,  'Alta de Certificados' ) );
        $this->muestraDato( 'contenidoSeccion'    , "bla bla bla" );
        $this->muestraDato( 'esAdmin'             , ( $_SESSION[ 'perfil' ] == '1' ) ? true : false );
        $this->muestraDato( 'cierraL'             , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Verifica la disponibilidad de archivos descargables
     */
    public function verificaDescargables( $params ) {
        $idRegistro = $params[ 'idreg' ];
        echo $this->modelo->verificaRegistroDigitalizados( $idRegistro );
    }

    /*
     * Funcio que realiza la carga de archivos a través de la plataforma y los almacena en formato pdf
     */
    public function uploadFiles() {
        $alta = $this->modelo->actualizaRegistroDigitalizados();

        if( $alta ) {
                echo '<script>parent.avisoAltaDigitalizadosCert();</script>';
                echo '<script>parent.resetFormularioCert();</script>';
            } else {
                echo '<script>parent.errorAltaDigitalizadosCert();</script>';
                echo '<script>parent.resetFormularioCert();</script>';
        }
    }

    /*
     * Metodo para descargar digitalizados
     */
    public function DescargaDigitalizado( $params ) {
        $this->modelo->descargaDigitalizadoIndividual( $params[ 'idReg' ] , $params[ 'idDoc' ] );
    }

    /*
     * Carga la pantalla para la validacion de documentos (certificado) asi como para la capura de datos adicionales
     */
    public function datosValidacionCapacitacion( $param ) {
        $datos = $this->modelo->obtieneDatosPiezasCapacitacion( $param[ 'idReg' ] );
        $this->muestraDato( 'scripts'       , array( '' ) );
        $this->muestraDato( 'estilos'       , array( '' ) );
        $this->muestraDato( 'idReg'         , $param[ 'idReg' ] );
        $this->muestraDato( 'usuario'       , $datos[ 'usuario' ] );
        $this->muestraDato( 'password'      , $datos[ 'password' ] );
        $this->muestraDato( 'usuarioInpart' , $datos[ 'usuarioInpart' ] );
        $this->muestraDato( 'passwordInpart', $datos[ 'passwordInpart' ] );
        $this->muestraDato( 'terminalID'    , $datos[ 'terminalID' ] );
        $this->muestraDato( 'companyCode'   , $datos[ 'companyCode' ] );
        $this->muestraDato( 'cierraL' , false );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    /*
     * Carga la pantalla para la validacion de documentos (comprobante) asi como para la capura de datos adicionales
     */
    public function datosValidacionCapacitacionComprobante( $param ) {
        $datos = $this->modelo->obtieneDatosPiezasCapacitacion( $param[ 'idReg' ] );
        $this->muestraDato( 'scripts'       , array( '' ) );
        $this->muestraDato( 'estilos'       , array( '' ) );
        $this->muestraDato( 'idReg'         , $param[ 'idReg' ] );
        $this->muestraDato( 'usuarioCurso'  , $datos[ 'usuarioCurso' ] );
        $this->muestraDato( 'passwordCurso' , $datos[ 'passwordCurso' ] );
        $this->muestraDato( 'cierraL'       , false );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Valida documentos digitalizados y abre la pantalla de captura para las piezas de correo
     */
    public function envioDatosCapacitacionValida() {
        $param = $_POST;
        echo $this->modelo->validacionDatosDocumentosCapacitacion( $param );
    }
    
    /*
     * Valida documentos digitalizados y abre la pantalla de captura para las piezas de correo
     */
    public function envioDatosCapacitacionValidaComprobante() {
        $param = $_POST;
        echo $this->modelo->validacionDatosDocumentosCapacitacionComprobante( $param );
    }
    
}


