<?php
/**
 * Controlador del modulo de home, pantalla principal del sistema
 *
 * @Framework
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/TemplateV2.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

/*
 * Funcionalidades del Modulo
 */
include_once _DIRPATH_ . '/modulos/Home/modelo/MHome.php';
#include_once _DIRPATH_ . '/modulos/Registro/modelo/MRegistro.php';

class Home{

    var $modelo   = null;
    var $menu     = null;
    var $registro = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        #parent::__construct();
        $this->modelo = new MHome();
        #$this->registro = new MRegistro();
    }

    /*
     * Accion que carga el template principal del sistema
     */
    public function index() {
        new Sesion();
        if( isset( $_SESSION['sesion'] ) && $_SESSION['sesion'] == true ){
            // Carga pagina principal de navegacion
            $parametros = array (
                'scripts'  => array( '' ),
                'estilos'  => array( '' ),
                'nombre'   => 'Carlos',
                'apellido' => 'Reyes',
                'cierraL'  => true
            );
            TemplateV2::generaVista( __CLASS__ . '/' . __FUNCTION__ . '.tpl' , $parametros );
        } else {
            // Redirecciona a pantalla de logeo
            header( 'Location:/Home/login/' );
        }
    }
 
    /*
     * Accion que carga el template de acceso al sistema administrativo
     */
    public function login() {
        $parametros = array (
            'scripts'  => array( 'vistas/Home/js/login.js' ),
            'estilos'  => array(),
            'cierraL'  => true
        );
        TemplateV2::generaVista( __CLASS__ . '/' . __FUNCTION__ . '.tpl' , $parametros );
    }

    /*
     * Accion que carga template para recuperar la contrasena
     */
    public function recupera() {
        $this->muestraDato( 'tituloacceso'      , _RECTEXTOTITULO_ );
        $this->muestraDato( 'tituloaccesotitle' , _TITULODEACCESOTITLE_ );
        $this->muestraDato( 'inputEmail'        , _RECTEXTOINPUT_ );
        $this->muestraDato( 'botonRecuperar'    , _RECBOTONTEXTO );
        $this->muestraDato( 'linkRegresarLogin' , _RECLINKLOGIN_ );
        $this->muestraDato( 'poweredBy'         , _TEXTOPOWEREDBY_ );
        $this->muestraDato( 'tema'              , 'ui-lightness' );
        $this->muestraDato( 'path'              , _URL_ );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    /*
     * Accion que carga template para recuperar la contrasena
     */
    public function solicita() {
        $this->muestraDato( 'tituloacceso'      , _SOLTEXTOTITULO_ );
        $this->muestraDato( 'tituloaccesotitle' , _TITULODEACCESOTITLE_ );
        $this->muestraDato( 'inputEmail'        , _RECTEXTOINPUT_ );
        $this->muestraDato( 'inputName'         , _SOLTEXTOINPUT_ );
        $this->muestraDato( 'botonRecuperar'    , _SOLBOTONTEXTO );
        $this->muestraDato( 'linkRegresarLogin' , _RECLINKLOGIN_ );
        $this->muestraDato( 'poweredBy'         , _TEXTOPOWEREDBY_ );
        $this->muestraDato( 'tema'              , 'ui-lightness' );
        $this->muestraDato( 'path'              , _URL_ );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    /*
     * Accion que verifica las credenciales de acceso
     */
    public function verificaAcceso( $param ) {
        $response = $this->modelo->verificaAcceso( $param['usr'] , $param['passwd'] , $param['remember'] , 'administradores' );
        echo $response;
    }

    /*
     * Accion que verifica las credenciales de acceso del panel de clientes
    
    public function verificaAccesoClientes( $param ) {
        $response = $this->modelo->verificaAcceso( $param['usr'] , $param['passwd'] , $param['remember'] , 'clientes' );
        echo $response;
    } */

    /*
     * Accion que verifica las credenciales de acceso del panel de empleados
     
    public function verificaAccesoEmpleados( $param ) {
        $response = $this->modelo->verificaAcceso( $param['usr'] , $param['passwd'] , $param['remember'] , 'empleados' );
        echo $response;
    }*/

    /*
     * Accion que verifica las credenciales de acceso al panel de candidatos
     
    public function verificaAccesoCandidatos( $param ) {
        $response = $this->modelo->verificaAcceso( $param['usr'] , $param['passwd'] , $param['remember'] , 'candidatos' );
        echo $response;
    }*/

    /*
     * Accion que recupera un acceso olvidado
     */
    public function recuperaAcceso( $param ) {
        $response = $this->modelo->recuperaAcceso( $param['email'] );
        echo $response;
    }

    /*
     * Accion que solicita un nuevo acceso
     
    public function solicitaAcceso( $param ) {
        $params = array (
            'nombre'     => $param[ 'nombre' ],
            'email'      => $param[ 'email' ],
            'usuario'    => $param[ 'usuario' ],
            'contrasena' => $param[ 'pass' ]
        );
        
        $response = $this->modelo->solicitaAcceso($params);
        echo $response;
    }*/
    
    /*
     * Accion que carga el menu en formato xml para la navegacion de los modulos
     */
    public function menu() {
        $this->menu = new MenuXML();
        echo $this->menu->xml();
    }

    /*
     * Accion que finaliza la sesion activa
     */
    public function logout() {
        $this->modelo->cierraSesion();
    }

    /*
     * Form de registro externo
     */
    public function registro() {
        $this->muestraDato( 'tituloaccesotitle'            , _TITULODEACCESOTITLE_ );
        $this->muestraDato( 'path'                         , _URL_ );
        $this->muestraDato( 'poweredBy'                    , _TEXTOPOWEREDBY_ );
        $this->muestraDato( 'scripts'                      , array( '../../vistas/Registro/js/altaRegistro.js' ) );
        $this->muestraDato( 'estilos'                      , array( '' ) );
        $this->muestraDato( 'tema'                         , 'ui-lightness' );        
        $this->muestraDato( 'breadcrumb'                   , true );        
        $this->muestraDato( 'breadcrumbElementos'          , array( 'Registro' ,  'Alta de Registro' ) );        
        $this->muestraDato( 'idRegistro'                   , "" );
        $this->muestraDato( 'accionRegistro'               , "" );
        $this->muestraDato( 'nombreComercial'              , "" );
        $this->muestraDato( 'calleComercial'               , "" );
        $this->muestraDato( 'coloniaComercial'             , "" );
        $this->muestraDato( 'delegacionComercial'          , "" );
        $this->muestraDato( 'ciudadComercial'              , "" );
        $this->muestraDato( 'entidadComercial'             , "" );
        $this->muestraDato( 'cpComercial'                  , "" );
        $this->muestraDato( 'telefonoComercial'            , "" );
        $this->muestraDato( 'faxComercial'                 , "" );
        $this->muestraDato( 'nombreFiscal'                 , "" );
        $this->muestraDato( 'rfcFiscal'                    , "" );
        $this->muestraDato( 'calleFiscal'                  , "" );
        $this->muestraDato( 'coloniaFiscal'                , "" );
        $this->muestraDato( 'delegacionFiscal'             , "" );
        $this->muestraDato( 'ciudadFiscal'                 , "" );
        $this->muestraDato( 'entidadFiscal'                , "" );
        $this->muestraDato( 'cpFiscal'                     , "" );
        $this->muestraDato( 'telefonoFiscal'               , "" );
        $this->muestraDato( 'faxFiscal'                    , "" );
        $this->muestraDato( 'localCatalogos'               , $this->registro->catalogoTipoLocal() );
        $this->muestraDato( 'local'                        , "" );
        $this->muestraDato( 'contactoComercial'            , "" );
        $this->muestraDato( 'contactoCuentasPagar'         , "" );
        $this->muestraDato( 'correoContactoComercial'      , "" );
        $this->muestraDato( 'correoContactoCuentasPagar'   , "" );
        $this->muestraDato( 'telefonoContactoComercial'    , "" );
        $this->muestraDato( 'telefonoContactoCuestasPagar' , "" );
        $this->muestraDato( 'antiguedadDomicilio'          , "" );
        $this->muestraDato( 'aseguradorasCatalogo'         , $this->registro->catalogoAseguradoras() );
        $this->muestraDato( 'aseguradoras'                 , array() );
        $this->muestraDato( 'cierraL'                      , false );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
}
