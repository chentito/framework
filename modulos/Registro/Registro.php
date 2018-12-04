<?php
/**
 * Controlador del modulo de registro, pantalla principal del sistema
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
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
include_once _DIRPATH_ . '/modulos/Registro/modelo/MRegistro.php';

class Registro extends Template {

    var $modelo = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        new Sesion();
        parent::__construct();
        $this->modelo = new MRegistro();
    }

    /*
     * Alta de un nuevo registro
     */
    public function altaRegistro( $params ) {
        $this->muestraDato( 'scripts'                      , array( '/vistas/Registro/js/altaRegistro.js?1' ) );
        $this->muestraDato( 'estilos'                      , array( '/vistas/Registro/css/altaRegistro.css' ) );
        $this->muestraDato( 'breadcrumb'                   , true );
        $this->muestraDato( 'breadcrumbElementos'          , array( 'Registro' ,  'Alta de Registro' ) );
        $this->muestraDato( 'idRegistro'                   , $params["idRegistro"] );
        $this->muestraDato( 'accionRegistro'               , $params["accion"] );
        $this->muestraDato( 'nombreComercial'              , $params["nombreComercial"] );
        $this->muestraDato( 'calleComercial'               , $params["calleComercial"] );
        $this->muestraDato( 'coloniaComercial'             , $params["coloniaComercial"] );
        $this->muestraDato( 'delegacionComercial'          , $params["delegacionComercial"] );
        $this->muestraDato( 'ciudadComercial'              , $params["ciudadComercial"] );
        $this->muestraDato( 'entidadComercial'             , $params["entidadComercial"] );
        $this->muestraDato( 'cpComercial'                  , $params["cpComercial"] );
        $this->muestraDato( 'paisComercial'                , $params["paisComercial"] );
        $this->muestraDato( 'telefonoComercial'            , $params["telefonoComercial"] );
        $this->muestraDato( 'faxComercial'                 , $params["faxComercial"] );
        $this->muestraDato( 'nombreFiscal'                 , $params["nombreFiscal"] );
        $this->muestraDato( 'rfcFiscal'                    , $params["rfcFiscal"] );
        $this->muestraDato( 'calleFiscal'                  , $params["calleFiscal"] );
        $this->muestraDato( 'coloniaFiscal'                , $params["coloniaFiscal"] );
        $this->muestraDato( 'delegacionFiscal'             , $params["delegacionFiscal"] );
        $this->muestraDato( 'ciudadFiscal'                 , $params["ciudadFiscal"] );
        $this->muestraDato( 'entidadFiscal'                , $params["entidadFiscal"] );
        $this->muestraDato( 'cpFiscal'                     , $params["cpFiscal"] );
        $this->muestraDato( 'paisFiscal'                   , $params["paisFiscal"] );
        $this->muestraDato( 'telefonoFiscal'               , $params["telefonoFiscal"] );
        $this->muestraDato( 'faxFiscal'                    , $params["faxFiscal"] );
        $this->muestraDato( 'localCatalogos'               , $this->modelo->catalogoTipoLocal() );
        $this->muestraDato( 'local'                        , $params["local"] );
        $this->muestraDato( 'contactoComercial'            , $params["contactoComercial"] );
        $this->muestraDato( 'contactoCuentasPagar'         , $params["contactoCuentasPagar"] );
        $this->muestraDato( 'correoContactoComercial'      , $params["correoContactoComercial"] );
        $this->muestraDato( 'correoContactoCuentasPagar'   , $params["correoContactoCuentasPagar"] );
        $this->muestraDato( 'telefonoContactoComercial'    , $params["telefonoContactoComercial"] );
        $this->muestraDato( 'telefonoContactoCuestasPagar' , $params["telefonoContactoCuestasPagar"] );
        $this->muestraDato( 'antiguedadDomicilio'          , $params["antiguedadDomicilio"] );
        $this->muestraDato( 'aseguradorasCatalogo'         , $this->modelo->catalogoAseguradoras() );
        $this->muestraDato( 'aseguradoras'                 , explode( ";" , $params["aseguradoras"] ) );
        $this->muestraDato( 'paisesCatalogo'               , $this->modelo->catalogoPaises() );
        $this->muestraDato( 'paisesCatalogoFis'            , $this->modelo->catalogoPaises() );
        $this->muestraDato( 'estadosCatalogo'              , $this->modelo->catalogoEstados() );
        $this->muestraDato( 'estado'                       , $params["entidadComercial"] );
        $this->muestraDato( 'estadosCatalogoFis'           , $this->modelo->catalogoEstados() );
        $this->muestraDato( 'regimenesFiscales'            , $this->modelo->catalogoRegimenesFiscales() );
        $this->muestraDato( 'regimenFiscal'                , $params["regimenFiscal"] );
        $this->muestraDato( 'metodosPago'                  , $this->modelo->catalogoMetodosPago() );
        $this->muestraDato( 'metodoPago'                   , $params["metodoPago"] );
        $this->muestraDato( 'girosNegocio'                 , $this->modelo->catalogoGirosNegocio() );
        $this->muestraDato( 'giroNegocio'                  , $params["giroNegocio"] );
        $this->muestraDato( 'fabricantes'                  , $this->modelo->catalogoFabricantes() );
        $this->muestraDato( 'fabricante'                   , $params["giroTexto"] );
        $this->muestraDato( 'representanteLegal'           , $params["representanteLegal"] );
        $this->muestraDato( 'noClienteAudatex'             , $params["noClienteAudatex"] );
        $this->muestraDato( 'cierraL'                      , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Metodo que genera resultado del autocomplete de razones sociales.
     */
    public function razonSocialAutocomplete( $param='' ) {
        $filtro = '';
        if( !empty( $param ) ){
            $filtro = $param[ 'filtro' ];
        }
        $valor = $_GET[ 'term' ];
        echo $this->modelo->autocompleteRazonSocial( $valor , $filtro );
    }

    /*
     * Metodo que guarda el detalle del registro
     */
    public function guardaDetalleRegistro() {
        echo $this->modelo->guardaRegistro( $_POST );
    }

    /*
     * Listado de registros dados de alta
     */
    public function listadoRegistros() {
        $columnasID      = $this->modelo->registrosDisponibles_columnasID();
        $columnasHTML    = $this->modelo->registrosDisponibles_columnasHTML();
        $columnasHidden  = $this->modelo->registrosDisponibles_columnasHidden();
        $paths           = array( 'ajax' => '/Registro/getInformacionRegistro/' );
        $selectRow       = true;
        $detailControl   = false;
        $editForm        = false;
        $viewForm        = false;
        $botones         = array("copiar" => true, "csv" => true, "excel" => true, "pdf" => false, "imprimir" => true, "eliminar" => false);
        $botonesPers     = array("EditarDatos" => true,"DescargaSolicitud"=>true,"AutorizarSolicitud"=>true,"Comentarios"=>true,"DatosACG"=>true);
        $jsAfterEditForm = '';
        $dataTable = new JQDataTable( "tableListadoRegistros", "listadoRegistros_form", "Registros", $columnasID, $columnasHTML, $columnasHidden, $paths, $selectRow, $detailControl, $editForm, $viewForm, $jsAfterEditForm, $botones, $botonesPers );
        $this->muestraDato( 'scripts' , array("/vistas/Registro/js/listadoRegistros.js?1") );
        $this->muestraDato( 'estilos' , array( '/vistas/Registro/css/listadoRegistros.css' ) );
        $this->muestraDato( 'contenidoSeccion' , $dataTable->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Registros' ,  'Listado de Registros' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    /*
     * Digitalizacion de documentos
     */
    public function digitalizacionDocumentos() {
        $this->muestraDato( 'scripts'             , array( '/vistas/Registro/js/digitalizacionDocumentos.js?1' ) );
        $this->muestraDato( 'estilos'             , array( '/vistas/Registro/css/digitalizacionDocumentos.css' ) );
        $this->muestraDato( 'breadcrumb'          , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Registro' ,  'Digitalizaci&oacute;n de Documentos' ) );
        $this->muestraDato( 'contenidoSeccion'    , "bla bla bla" );
        $this->muestraDato( 'cierraL'             , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Funcio que realiza la carga de archivos a través de la plataforma y los almacena en formato pdf
     */
    public function uploadFiles() {
        $alta = $this->modelo->actualizaRegistroDigitalizados();

        if( $alta ) {
                echo '<script>parent.avisoAltaDigitalizados();</script>';
                echo '<script>parent.resetFormulario();</script>';
            } else {
                echo '<script>parent.errorAltaDigitalizados();</script>';
                echo '<script>parent.resetFormulario();</script>';
        }
    }

    /*
     * Metodo que verifica la existencia de un rfc
     */
    public function verificaRFC() {
        $rfc = $_POST[ 'registro_altaRegistro_Fiscal_rfc' ];
        echo $this->modelo->verificaRFC( $rfc );
    }

    /*
     * Metodo que verifica si se han dado de alta o no, documentos digitalizados de un registro en particular
     */
    public function verificaDescargables( $params ) {
        $idRegistro = $params[ 'idreg' ];
        echo $this->modelo->verificaRegistroDigitalizados( $idRegistro );
    }

    /*
     * Metodo para descargar digitalizados
     */
    public function DescargaDigitalizado( $params ) {
        $this->modelo->descargaDigitalizadoIndividual( $params[ 'idReg' ] , $params[ 'idDoc' ] );
    }

    /*
     * Metodo que descarga el compendio de digitalizados en archivo zip
     */
    public function descargaZip( $params ) {
        $idReg = $params[ 'idReg' ];
        $this->modelo->generaZIP( $idReg );
    }

    /*
     * Metodo que genera un solo pdf
     */
    public function generaPDFMasivo( $params ) {
        $idReg = $params[ 'idReg' ];
        $acta  = ( isset( $params[ 'sinActa' ] ) ? true : false );
        $this->modelo->pdfMerge( $idReg , $acta );
    }

    /*
     * Descarga solicitud
     */
    public function descargaSolicitud() {
        //include_once _SITEPATH_ . '/modulos/Registro/SolicitudRegistro.php';
        include_once '/var/www/html/modulos/Registro/SolicitudRegistro.php';
        $solicitud = new SolicitudRegistro( "p","pt","letter" );
        $solicitud->generaSolicitudRegistro();
    }

    /* Obtiene los datos de audatex */
    public function informacionAudatex() {
        return $this->modelo->datosAudatex();
    }

    /*
     * Descarga de formatos
     */
    public function descargaFormatosPDF( $params ) {
        $id   = $params[ 'id' ];
        $sol  = $params[ 'idSol' ];

        switch( $id ) {
            case '1':
                    include_once _DIRPATH_ . '/modulos/Registro/SolicitudRegistro.php';
                    $datosSolicitud = $this->modelo->getDatosRegistroID( array( "idSelected" => $sol ) , true );
                    $solicitud      = new SolicitudRegistro( "p" , "pt" , "letter" );
                    $solicitud->generaSolicitudRegistro( $datosSolicitud );
                ;break;
            case '2':
                    include_once _DIRPATH_ . '/modulos/Registro/AutorizacionDomiciliacion.php';
                    $p = $this->modelo->obtieneDatosDomiciliacion( $sol );
                    $p[ 'audatex' ] = $this->informacionAudatex();
                    $autorizacion = new AutorizacionDomiciliacion( "p" , "pt" , "letter" );
                    $autorizacion->generaAutorizacionDomiciliacion( $p );
                ;break;
            case '3':
                    include_once _DIRPATH_ . '/modulos/Registro/AutorizacionReporteCredito.php';
                    $p = $this->modelo->obtieneDatosReporteCrediticio( $sol );
                    $p[ 'audatex' ] = $this->informacionAudatex();
                    $autorizacion = new AutorizacionReporteCredito( "p" , "pt" , "letter" );
                    $autorizacion->generaAutorizacionReporteCredito( $p );
                ;break;
            case '4':
                    include_once _DIRPATH_ . '/modulos/Registro/ReferenciasComerciales.php';
                    $p = $this->modelo->obtieneDatosReferenciasComerciales( $sol );
                    $p[ 'audatex' ] = $this->informacionAudatex();
                    $referencias = new ReferenciasComerciales( "p" , "pt" , "letter" );
                    $referencias->generaRegerenciasComerciales( $p );
                ;break;
            case '5':
                    $giro = $params[ 'giro' ];
                    $sistema = $params[ 'sistema' ];
                    $script = 'Contratos';

                    if( $sistema == '2' ) { // Sistema Inpart
                        $script = 'ContratosInpart';
                    } else {
                        if( $giro == '3' ) { // TOT (especializado)
                            $script = 'ContratosInpart';
                        } elseif( $giro == '1' ) { // Multimarca
                            $script = 'Contratos';
                        } elseif( $giro == '2' ) { // Agencia
                            $giroTxt = $params[ 'texto' ];
                            if( $giroTxt == '2' ) $script = 'ContratosRenault'; // Renault
                            elseif( $giroTxt == '10' ) $script = 'ContratosNissan'; // Nissan
                            else $script = 'Contratos';
                        }
                    }

                    include_once _DIRPATH_ . '/modulos/Registro/'.$script.'.php';
                    $p = $this->modelo->obtieneDatosContratos( $sol );
                    $p[ 'audatex' ] = $this->informacionAudatex();
                    $referencias = new Contratos( "p" , "pt" , "letter" );
                    $referencias->generaContrato( $p );
                ;break;
            case '6':
                    include_once _DIRPATH_ . '/modulos/Registro/ContratosImpart.php';
                    $p = $this->modelo->obtieneDatosContratos( $sol );
                    $p[ 'audatex' ] = $this->informacionAudatex();
                    $referencias = new ContratosImpart( "p" , "pt" , "letter" );
                    $referencias->generaContrato( $p );
                ;break;
        }
    }

    /*
     * Obtiene listado de registros
     */
    public function getInformacionRegistro(){
        $this->modelo->getRegistrosDisponibles();
    }

    /*
     * Obtiene Datos Registro para Id seleccionado
     */
    public function obtieneRegistroID(){
        echo $this->modelo->getDatosRegistroID(array( "idSelected" => $_POST[ "idSelected" ] ) , false );
    }

    /*
     * Descarga de formatos
     */
    public function descargaFormatos() {
        $this->muestraDato( 'scripts'             , array( '/vistas/Registro/js/descargaFormatos.js?1' ) );
        $this->muestraDato( 'estilos'             , array() );
        $this->muestraDato( 'breadcrumb'          , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Registro' ,  'Descarga Formatos' ) );
        $this->muestraDato( 'contenidoSeccion'    , '' );
        $this->muestraDato( 'cierraL'             , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Carga Formulario de formatos
     */
    public function cargaFormularioFormatos( $params ) {
        $this->muestraDato( 'scripts'             , array() );
        $this->muestraDato( 'estilos'             , array() );
        $this->muestraDato( 'breadcrumb'          , false );
        $this->muestraDato( 'idSolicitud'         , $params[ 'idSolicitud' ] );
        $this->muestraDato( 'contenidoSeccion'    , '' );
        $this->muestraDato( 'cierraL'             , true );
        $tpl = "";
        switch ( $params[ 'idFormato' ] ) {
            case "1":
                $datos = $this->modelo->obtieneDatosDomiciliacion( $params[ 'idSolicitud' ] );
                $tpl   = "formDomiciliacion";
                $this->muestraDato( 'bancos'                 , $this->modelo->catalogoBancos() );
                $this->muestraDato( 'banco'                  , $datos[ 'banco' ] );
                $this->muestraDato( 'clienteNombreFiscal'    , $datos[ 'cliente_nombreFiscal' ] );
                $this->muestraDato( 'clienteNombreComercial' , $datos[ 'nombreComercial' ] );
                $this->muestraDato( 'rfc'                    , $datos[ 'rfc' ] );
                $this->muestraDato( 'titularCuenta'          , $datos[ 'titularCuenta' ] );
                $this->muestraDato( 'terminacionCuenta'      , $datos[ 'terminacion' ] );
                $this->muestraDato( 'sucursal'               , $datos[ 'sucursal' ] );
                $this->muestraDato( 'clabe'                  , $datos[ 'clabe' ] );
                $this->muestraDato( 'representanteLegal'     , $datos[ 'representanteLegal' ] );
                break;
            case "2":
                $datos = $this->modelo->obtieneDatosReferenciasComerciales( $params[ 'idSolicitud' ] );
                $this->muestraDato( 'nombreParticipante'   , $datos[ 'nombreParticipante' ] );
                $this->muestraDato( 'aPaternoParticipante' , $datos[ 'aPaternoParticipante' ] );
                $this->muestraDato( 'aMaternoParticipante' , $datos[ 'aMaternoParticipante' ] );
                $this->muestraDato( 'correoParticipante'   , $datos[ 'correoParticipante' ] );
                $this->muestraDato( 'usuario'              , $datos[ 'usuario' ] );
                $this->muestraDato( 'password'             , $datos[ 'password' ] );
                $this->muestraDato( 'terminalID'           , $datos[ 'terminalID' ] );
                $this->muestraDato( 'companyCode'          , $datos[ 'companyCode' ] );
                $this->muestraDato( 'usuarioInpart'        , $datos[ 'usuarioInpart' ] );
                $this->muestraDato( 'passwordInpart'       , $datos[ 'passwordInpart' ] );
                $this->muestraDato( 'esAdmin'              , ( $_SESSION[ 'perfil' ] == '1' )? '' : 'readonly=readonly' );
                $tpl="formReferenciasComerciales";
                break;
            case "3":
                $datos = $this->modelo->obtieneDatosReporteCrediticio( $params[ 'idSolicitud' ] );
                $tpl   = "formReporteCrediticio";
                $this->muestraDato( 'cliente'           , $datos[ 'cliente' ] );
                $this->muestraDato( 'domicilioTelefono' , $datos[ 'domicilioTelefono' ] );
                $this->muestraDato( 'solicitante'       , $datos[ 'solicitante' ] );
                $this->muestraDato( 'fechaConsulta'     , $datos[ 'fechaConsulta' ] );
                $this->muestraDato( 'folioConsulta'     , $datos[ 'folioConsulta' ] );
                $this->muestraDato( 'rfc'               , $datos[ 'rfc' ] );
                break;
            case "4":
                $datos = $this->modelo->obtieneDatosContratos( $params[ 'idSolicitud' ] );
                $tpl   = "formContrato";
                $this->muestraDato( 'scripts'                   , array( '/vistas/Registro/js/datosContrato.js?1' ) );
                $this->muestraDato( 'clienteRepresentanteLegal' , $datos[ 'representanteLegal' ] );
                $this->muestraDato( 'clienteNombreComercial'    , $datos[ 'nombreComercial' ] );
                $this->muestraDato( 'dia'                       , $datos[ 'dia' ] );
                $this->muestraDato( 'mes'                       , $datos[ 'mes' ] );
                $this->muestraDato( 'anio'                      , $datos[ 'anio' ] );
                break;
            case "5":
                $datos = $this->modelo->obtieneDatosContratos( $params[ 'idSolicitud' ] );
                $tpl   = "formContrato";
                $this->muestraDato( 'scripts'                   , array( '/vistas/Registro/js/datosContrato.js?1' ) );
                $this->muestraDato( 'clienteRepresentanteLegal' , $datos[ 'representanteLegal' ] );
                $this->muestraDato( 'clienteNombreComercial'    , $datos[ 'nombreComercial' ] );
                $this->muestraDato( 'dia'                       , $datos[ 'dia' ] );
                $this->muestraDato( 'mes'                       , $datos[ 'mes' ] );
                $this->muestraDato( 'anio'                      , $datos[ 'anio' ] );
                break;
        }
        $this->cargaGUI( __CLASS__ . '/' . $tpl . '.tpl' );
    }

    public function buscaDatosFormatoGuardados( $formato , $solicitud ) {
        switch( $formato ) {
            case '1':$d = $this->modelo->obtieneDatosDomiciliacion( $solicitud );
            case '2':$d = $this->modelo->obtieneDatosDomiciliacion( $solicitud );
            case '3':$d = $this->modelo->obtieneDatosDomiciliacion( $solicitud );
            case '4':$d = $this->modelo->obtieneDatosContratos( $solicitud );
        }
        return $d;
    }

    /*
     * Guarda datos formulario formato
     */
    public function guardaDatosFormularioFormatos() {
        $params = $_GET;
        $tipo   = $params[ 'formDescargaFormatos_tipo' ];
        $r      = "";
        switch( $tipo ) {
            case '1':
                $r = $this->modelo->guardaDatosDomiciliacion( $params );
                break;
            case '2':
                $r = $this->modelo->guardaDatosReferenciasComerciales( $params );
                break;
            case '3':
                $r = $this->modelo->guardaDatosReporteCrediticio( $params );
                break;
            case '4':
                $r = $this->modelo->guardaDatosContratos( $params );
                break;
        }
        echo $r;
    }

    /*
     * Pantalla de validacion de solicitud
     */
    public function pantallaValidacionSolicitud( $params ) {
        //echo "Pantalla de validacion para la solicitud " . $params[ 'idRegistro' ];
        $this->muestraDato( 'scripts'     , array( '/vistas/Registro/js/validacionSolicitud.js?1' ) );
        $this->muestraDato( 'estilos'     , array() );
        $this->muestraDato( 'breadcrumb'  , false );
        $this->muestraDato( 'idSolicitud' , $params[ 'idRegistro' ] );
        $this->muestraDato( 'cierraL'     , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Pantalla de motivo de rechazo de solicitud
     */
    public function pantallaMotivoRechazo( $params ) {
        $this->muestraDato( 'scripts'     , array() );
        $this->muestraDato( 'estilos'     , array() );
        $this->muestraDato( 'breadcrumb'  , false );
        $this->muestraDato( 'idSolicitud' , $params[ 'idSolicitud' ] );
        $this->muestraDato( 'cierraL'     , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /* Pantalla para agregar comentario */
    public function altaComentarioRegistro( $params ) {
        $this->muestraDato( 'scripts'     , array() );
        $this->muestraDato( 'estilos'     , array() );
        $this->muestraDato( 'breadcrumb'  , false );
        $this->muestraDato( 'idSolicitud' , $params[ 'idSelected' ] );
        $this->muestraDato( 'contenido'   , $params[ 'contenido' ] );
        $this->muestraDato( 'cierraL'     , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    public function consultaComentarioRegistro( $params ) {
        echo $this->modelo->comentarioRegistro( $params[ 'id' ] );
    }
    
    public function guardaComentarioRegistro( $params ) {
        echo $this->modelo->altaComentarioRegistro( $params[ 'id' ] , $params[ 'contenido' ] );
    }
    
    /*
     * Guarda registro de validacion
     */
    public function guardaValidacionSolicitud( $params ) {
        echo $this->modelo->guardaResultadoValidacionSolicitud( $params['idSolicitud'] , $params['val'] , $params['motivoRechazo'] , $params['noClienteAudatex'] );
    }
    
    /*
     * Guarda registro de validacion
     */
    public function guardaRechazoSolicitud() {
        $params    = $_POST;
        $motivo    = $params[ 'cancelaSolicitudMotivoRechazo' ];
        $solicitud = $params[ 'cancelaSolicitudMotivoRechazo_idSolicitud' ];
        $val       = $params[ 'cancelaSolicitudMotivoRechazo_val' ];
        echo $this->modelo->guardaResultadoValidacionSolicitud( $solicitud , $val , $motivo , '' , true);
        echo "<script>parent.despuesRechazoProceso();</script>";
    }

    public function verificaValidacionPrevia( $params ) {
        echo $this->modelo->verificaValidacionPrevia( $params[ 'idSol' ] );
    }

    public function enviaRecordatorioComprobante( $params ) {
        $this->modelo->enviaRecordatorioComprobante( $params[ 'idSolicitud' ] );
    }

    /* Carga pantalla para captura de datos ACG */
    public function datosACG( $params ) {
        $idSol = $params[ 'idSol' ];
        $datos = $this->modelo->datosLibresACG( $idSol );
        $this->muestraDato( 'scripts'     , array() );
        $this->muestraDato( 'estilos'     , array() );
        $this->muestraDato( 'idSolicitud' , $idSol );
        $this->muestraDato( 'usuario'     , $datos[ 'usuario' ] );
        $this->muestraDato( 'passwd'      , $datos[ 'passwd' ] );
        $this->muestraDato( 'cierraL'     , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    public function guardaDatosACG( $params ) {
        $this->modelo->guardaDatosLibresACG( $params[ 'id' ] , $params[ 'usuario' ] , $params[ 'passwd' ] );
    }

}



