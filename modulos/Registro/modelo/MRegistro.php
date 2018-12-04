<?php
/*
 * Modelo para el funcionamiento de registros
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este arcchivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Datos/DataTable.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
include_once _DIRPATH_ . '/sistema/Librerias/Mail/Mail.php';
include_once _DIRPATH_ . '/sistema/Librerias/PDFMerger/PDFMerger.php';
include_once _DIRPATH_ . '/sistema/Registros/Acciones.php';
include_once _DIRPATH_ . '/sistema/Archivos/Upload.php';


class MRegistro {

    /*
     * Interaccion con base de datos
     */
    protected $dbConn = null;

    /*
     * Instancia de la clase de upload de archivos
     */
    protected $upload = null;

    /*
     * Instancia de la clase de upload de archivos
     */

    /*
     * Documentos a digitalizar
     */
    //protected $nombres = array('solicitudRegistro','autorizacionDomiciliacion','contrato','cedulaFiscal','edoCta','comprobanteDomicilio','actaConstitutiva','poderNotarial','identificacion');
    protected $nombres = array( "acta" , "solicitud" , "ife" , "edoCta" , "domiciliacion" , "contrato" , "compDomicilio" , "cedula" , "poder" );

    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbConn = new classConMySQL();
        //$this->predefinido = new Predefinidos();
    }

    /*
     * Metodo que guarda la informacion del registro
     */
    public function guardaRegistro( $datos ) {
        $aseguradoras = '';
        foreach( $datos[ 'registro_altaRegistro_aseguradoras' ] AS $aseguradora ) {
            $aseguradoras .= $aseguradora . ',';
        }
        $datosUC = array_map( 'strtoupper' , $datos );
        if($datos["registro_altaRegistro_accion"] == ""){
            //Agregamos registro
            $sql  = " INSERT INTO reg_altaRegistro ( nombreComercial, calleComercial, coloniaComercial, delegacionComercial, ";
            $sql .= " ciudadComercial, entidadComercial, paisComercial, cpComercial, telefonoComercial, faxComercial, nombreFiscal, ";
            $sql .= " rfcFiscal, regimenFiscal, metodoPago, calleFiscal, coloniaFiscal, delegacionFiscal, ";
            $sql .= " ciudadFiscal, entidadFiscal, paisFiscal, cpFiscal, telefonoFiscal, ";
            $sql .= " faxFiscal, local, contactoComercial, contactoCuentasPagar, ";
            $sql .= " correoContactoComercial, correoContactoCuentasPagar, telefonoContactoComercial, telefonoContactoCuestasPagar, ";
            $sql .= " antiguedadDomicilio, alta, aseguradoras, sistema, status, representanteLegal,usuario,giroNegocio,giroTexto, ";
            $sql .= " textoAgencia,noClienteAudatex, usoSistema,razonAlta,certificado)";
            $sql .= " VALUES ( '".$datosUC[ 'registro_altaRegistro_Comercial_nombreComercial' ]."','".$datosUC[ 'registro_altaRegistro_Comercial_calle' ]."','".$datosUC[ 'registro_altaRegistro_Comercial_colonia' ]."','".$datosUC[ 'registro_altaRegistro_Comercial_delegacion' ]."',";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_Comercial_ciudad' ]."','".$datosUC[ 'registro_altaRegistro_Comercial_estado' ]."','".$datosUC[ 'registro_altaRegistro_Comercial_pais' ]."','".$datosUC[ 'registro_altaRegistro_Comercial_CP' ]."','".$datosUC[ 'registro_altaRegistro_Comercial_telefono' ]."',";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_Comercial_fax' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_nombreFiscal' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_rfc' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_regimenFiscal' ]."','".$datosUC[ 'registro_altaRegistro_metodoPago' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_calle' ]."',";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_Fiscal_colonia' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_delegacion' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_ciudad' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_estado' ]."',";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_Fiscal_pais' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_CP' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_telefono' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_fax' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_lugarOcupa' ]."',";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_Fiscal_contactoComercial' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_contactoCuentasPagar' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_correoContactoComercial' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_correoContactoCuentasPagar' ]."',";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_Fiscal_telefonoContactoComercial' ]."','".$datosUC[ 'registro_altaRegistro_Fiscal_telefonoContactoCuentasPagar' ]."','".utf8_encode($datosUC[ 'registro_altaRegistro_Fiscal_antiguedadDomicilio' ])."','".date( 'Y-m-d H:i:s' )."','" . trim( $aseguradoras , ',' ) ."','".$datosUC[ 'registro_altaRegistro_usaInpart_usaAudaClaims' ]."','1','".$datosUC[ 'registro_altaRegistro_Fiscal_representanteLegal' ]."','".$_SESSION[ 'idUsuario' ]."','".$datosUC[ 'registro_altaRegistro_giroNegocio' ]."','".$datosUC[ 'registro_altaRegistro_giroNegocio_fabricante' ]."', ";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_giroNegocio_fabricante_idConc' ]."','".$datosUC[ 'registro_altaRegistro_noClienteAudatex' ]."','".$datosUC[ 'registro_altaRegistro_UsaSistema' ]."','".$datosUC[ 'registro_altaRegistro_motivoAlta' ]."','".$datosUC[ 'registro_altaRegistro_certAudaclaims' ]."');";
            $rs = $this->dbConn->ejecutaComando( $sql );
        } else {
            //Editamos registro
            $sql = " UPDATE reg_altaRegistro SET nombreComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_nombreComercial' ]."', calleComercial = ";
            $sql .= " '".$datosUC[ 'registro_altaRegistro_Comercial_calle' ]."',metodoPago='".$datosUC[ 'registro_altaRegistro_metodoPago' ]."', coloniaComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_colonia' ]."', ";
            $sql .= " delegacionComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_delegacion' ]."', ciudadComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_ciudad' ]."', ";
            $sql .= " entidadComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_estado' ]."', paisComercial='".$datosUC[ 'registro_altaRegistro_Comercial_pais' ]."', cpComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_CP' ]."', ";
            $sql .= " telefonoComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_telefono' ]."', faxComercial = '".$datosUC[ 'registro_altaRegistro_Comercial_fax' ]."', ";
            $sql .= " nombreFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_nombreFiscal' ]."', rfcFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_rfc' ]."', regimenFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_regimenFiscal' ]."', ";
            $sql .= " calleFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_calle' ]."', coloniaFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_colonia' ]."', ";
            $sql .= " delegacionFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_delegacion' ]."', ciudadFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_ciudad' ]."', ";
            $sql .= " entidadFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_estado' ]."', paisFiscal='".$datosUC[ 'registro_altaRegistro_Fiscal_pais' ]."', cpFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_CP' ]."', ";
            $sql .= " telefonoFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_telefono' ]."', faxFiscal = '".$datosUC[ 'registro_altaRegistro_Fiscal_fax' ]."', ";
            $sql .= " local = '".$datosUC[ 'registro_altaRegistro_Fiscal_lugarOcupa' ]."', contactoComercial = '".$datosUC[ 'registro_altaRegistro_Fiscal_contactoComercial' ]."', ";
            $sql .= " contactoCuentasPagar = '".$datosUC[ 'registro_altaRegistro_Fiscal_contactoCuentasPagar' ]."', correoContactoComercial = '".$datosUC[ 'registro_altaRegistro_Fiscal_correoContactoComercial' ]."', ";
            $sql .= " correoContactoCuentasPagar = '".$datosUC[ 'registro_altaRegistro_Fiscal_correoContactoCuentasPagar' ]."', telefonoContactoComercial = '".$datosUC[ 'registro_altaRegistro_Fiscal_telefonoContactoComercial' ]."', ";
            $sql .= " telefonoContactoCuestasPagar = '".$datosUC[ 'registro_altaRegistro_Fiscal_telefonoContactoCuentasPagar' ]."', antiguedadDomicilio = '".utf8_encode($datosUC[ 'registro_altaRegistro_Fiscal_antiguedadDomicilio' ])."',aseguradoras='".trim( $aseguradoras , ',' )."', sistema='".$datosUC[ 'registro_altaRegistro_usaInpart_usaAudaClaims' ]."', ";
            $sql .= " representanteLegal='".$datosUC[ 'registro_altaRegistro_Fiscal_representanteLegal' ]."',giroNegocio='".$datosUC[ 'registro_altaRegistro_giroNegocio' ]."', giroTexto='".$datosUC[ 'registro_altaRegistro_giroNegocio_fabricante' ]."', ";
            $sql .= " textoAgencia='".$datosUC[ 'registro_altaRegistro_giroNegocio_fabricante_idConc' ]."',noClienteAudatex='".$datosUC[ 'registro_altaRegistro_noClienteAudatex' ]."', usoSistema='".$datosUC[ 'registro_altaRegistro_UsaSistema' ]."',razonAlta='".$datosUC[ 'registro_altaRegistro_motivoAlta' ]."',certificado='".$datosUC[ 'registro_altaRegistro_certAudaclaims' ]."' ";
            $sql .= " WHERE id = '".$datosUC["registro_altaRegistro_id"]."' ";
            $rs = $this->dbConn->ejecutaComando( $sql );
        }

        if( $rs ) {
                return true;
            } else {
                return mysql_error();
        }
    }

    /*
     * Metodo que regresa el listado de resultados del autocomplete de razon social
     */
    public function autocompleteRazonSocial( $valor , $filtro='' ) {
        $term     = trim( strip_tags( $valor ) );
        $sql      = " SELECT id,nombreComercial,sistema, giroNegocio, giroTexto FROM reg_altaRegistro ";
        $sql     .= " WHERE (nombreComercial LIKE '%".$term."%' OR rfcFiscal LIKE '%".$term."%' ) AND status=1 ";
        if( strlen( $filtro ) > 0 ) {
            $sql .= " AND sistema=1 ";
        }
        if( $_SESSION[ 'perfil' ] == '2' ){
            $sql .= " AND usuario='".$_SESSION[ 'idUsuario' ]."' ";
        }
        $rs       = $this->dbConn->ejecutaComando( $sql );
        $cliente  = array();
        $clientes = array();

        while( !$rs->EOF ){
            $cliente[ 'value' ]   = $rs->fields[ 'nombreComercial' ];
            $cliente[ 'id' ]      = $rs->fields[ 'id' ];
            $cliente[ 'sistema' ] = $rs->fields[ 'sistema' ];
            $cliente[ 'giro' ]    = $rs->fields[ 'giroNegocio' ];
            $cliente[ 'giroTxt' ] = $rs->fields[ 'giroTexto' ];
            $clientes[]           = $cliente;
            $rs->MoveNext();
        }

        echo json_encode( $clientes );
    }

    /*
     * Metodo que regresa el listado de registros dados de alta
     */
    public function listadoRegistros() {
        $sql = " SELECT * FROM reg_altaRegistro WHERE status=1 ";
        $rs  = $this->dbConn->traedatosmysql( $sql );
        $registros = array();
        $registro = array();

        while( !$rs->EOF ) {
            $registro[ 'nombreComercial' ]              = $rs->fields[ 'nombreComercial' ];
            $registro[ 'calleComercial' ]               = $rs->fields[ 'calleComercial' ];
            $registro[ 'coloniaComercial' ]             = $rs->fields[ 'coloniaComercial' ];
            $registro[ 'delegacionComercial' ]          = $rs->fields[ 'delegacionComercial' ];
            $registro[ 'ciudadComercial' ]              = $rs->fields[ 'ciudadComercial' ];
            $registro[ 'entidadComercial' ]             = $rs->fields[ 'entidadComercial' ];
            $registro[ 'cpComercial' ]                  = $rs->fields[ 'cpComercial' ];
            $registro[ 'paisComercial' ]                = $rs->fields[ 'paisComercial' ];
            $registro[ 'telefonoComercial' ]            = $rs->fields[ 'telefonoComercial' ];
            $registro[ 'faxComercial' ]                 = $rs->fields[ 'faxComercial' ];
            $registro[ 'nombreFiscal' ]                 = $rs->fields[ 'nombreFiscal' ];
            $registro[ 'rfcFiscal' ]                    = $rs->fields[ 'rfcFiscal' ];
            $registro[ 'calleFiscal' ]                  = $rs->fields[ 'calleFiscal' ];
            $registro[ 'coloniaFiscal' ]                = $rs->fields[ 'coloniaFiscal' ];
            $registro[ 'delegacionFiscal' ]             = $rs->fields[ 'delegacionFiscal' ];
            $registro[ 'ciudadFiscal' ]                 = $rs->fields[ 'ciudadFiscal' ];
            $registro[ 'estidadFiscal' ]                = $rs->fields[ 'estidadFiscal' ];
            $registro[ 'cpFiscal' ]                     = $rs->fields[ 'cpFiscal' ];
            $registro[ 'paisFiscal' ]                   = $rs->fields[ 'paisFiscal' ];
            $registro[ 'telefonoFiscal' ]               = $rs->fields[ 'telefonoFiscal' ];
            $registro[ 'faxFiscal' ]                    = $rs->fields[ 'faxFiscal' ];
            $registro[ 'local' ]                        = $rs->fields[ 'local' ];
            $registro[ 'contactoComercial' ]            = $rs->fields[ 'contactoComercial' ];
            $registro[ 'contactoCuentasPagar' ]         = $rs->fields[ 'contactoCuentasPagar' ];
            $registro[ 'correoContactoComercial' ]      = $rs->fields[ 'correoContactoComercial' ];
            $registro[ 'correoContactoCuentasPagar' ]   = $rs->fields[ 'correoContactoCuentasPagar' ];
            $registro[ 'telefonoContactoComercial' ]    = $rs->fields[ 'telefonoContactoComercial' ];
            $registro[ 'telefonoContactoCuentasPagar' ] = $rs->fields[ 'telefonoContactoCuentasPagar' ];
            $registro[ 'antiguedadDomicilio' ]          = $rs->fields[ 'antiguedadDomicilio' ];
            $registro[ 'fechaAlta' ]                    = $rs->fields[ 'alta' ];
            $registro[ 'giroNegocio' ]                  = $rs->fields[ 'giroNegocio' ];
            $registro[ 'noClienteAudatex' ]             = $rs->fields[ 'noClienteAudatex' ];
            $registro[ 'usoSistema' ]                   = $rs->fields[ 'usoSistema' ];
            $registro[ 'razonAlta' ]                    = $rs->fields[ 'razonAlta' ];
            $registro[ 'certificado' ]                  = $rs->fields[ 'certificado' ];
            $registros[] = $registro;
            $rs->MoveNext();
        }

        return json_encode( $registros );
    }

    /* Metodo que guarda los documentos digitalizados del registro */
    public function actualizaRegistroDigitalizados() {
        ini_set( 'max_execution_time' , 300 );
        $contenido1 = "";
        $contenido2 = "";
        $contenido3 = "";
        $contenido4 = "";
        $contenido5 = "";
        $contenido6 = "";
        $contenido7 = "";
        $contenido8 = "";
        $contenido9 = "";

        $regId = $_POST[ 'registro_Digitalizacion_idRegistroID' ];
        if( $regId == "" )return false;
        $mov   = $_POST[ 'registro_Digitalizacion_tipoMovimiento' ];

        if( $mov == 'alta' ) {
            mkdir( _DIRPATH_ . '/documentos/' . $regId );
        }

        $this->upload = new Upload( 'registro_Digitalizacion_solicitud' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/solicitud.pdf' );
            $contenido1 = 'solicitud.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_autorizacionDomiciliacion' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/domiciliacion.pdf' );
            $contenido2 = 'domiciliacion.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_contrato' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/contrato.pdf' );
            $contenido3 = 'contrato.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_cedula' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/cedula.pdf' );
            $contenido4 = 'cedula.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_edoCta' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/edoCta.pdf' );
            $contenido5 = 'edoCta.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_comprobanteDom' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/compDomicilio.pdf' );
            $contenido6 = 'compDomicilio.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_actaCons' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/acta.pdf' );
            $contenido7 = 'acta.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_poderNotarial' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/poder.pdf' );
            $contenido8 = 'poder.pdf';
            $this->upload->eliminaLayout();
        }

        $this->upload = new Upload( 'registro_Digitalizacion_identificacion' );
        if( $this->upload ) {
            $this->upload->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/ife.pdf' );
            $contenido9 = 'ife.pdf';
            $this->upload->eliminaLayout();
        }

        if( $mov == 'alta' ){
            $f   = date( 'Y-m-d H:i:s' );
            $sql = " INSERT INTO reg_digitalizados (idRegistro, solicitudRegistro, autorizacionDomiciliacion, contrato, "
                    . " cedulaFiscal, edoCta, comprobanteDomicilio, actaConstitutiva, "
                    . " poderNotarial, identificacion, fechaAlta, status) "
                    . " VALUES ('" . $regId . "','" . ( $contenido1 ) . "','" . ( $contenido2 ) . "','" . ( $contenido3 ) . "',"
                    . " '" . ( $contenido4 ) . "','" . ( $contenido5 ) . "','". ( $contenido6 ) ."','" . ( $contenido7 ) . "',"
                    . " '" . ( $contenido8 ) . "','" . ( $contenido9 ) . "','" . $f . "', 1)  ";
            $rs  = $this->dbConn->ejecutaComando( $sql );

            $n = $this->obtieneNombreComercial( $regId );
            $datosPieza = array(
                'razonSocial' => $n[ 0 ],
                'fecha'       => $f
            );
            new Mail( 'Digitalizacion de Documentos' , $this->obtieneDestinatario() , 'avisoDigitalizacion' , $datosPieza );

        } elseif( $mov == 'edita' ) {
            $sql = " UPDATE reg_digitalizados SET "
                 . ( ( strlen( $contenido1 ) > 0 ) ? " solicitudRegistro='" . ( $contenido1 ) . "', " : "" )
                 . ( ( strlen( $contenido2 ) > 0 ) ? " autorizacionDomiciliacion='" . ( $contenido2 ) . "', " : "" )
                 . ( ( strlen( $contenido3 ) > 0 ) ? " contrato='" . ( $contenido3 ) . "', " : "" )
                 . ( ( strlen( $contenido4 ) > 0 ) ? " cedulaFiscal='" . ( $contenido4 ) . "', " : "" )
                 . ( ( strlen( $contenido5 ) > 0 ) ? " edoCta='" . ( $contenido5 ) . "', " : "" )
                 . ( ( strlen( $contenido6 ) > 0 ) ? " comprobanteDomicilio='" . ( $contenido6 ) . "', " : "" )
                 . ( ( strlen( $contenido7 ) > 0 ) ? " actaConstitutiva='" . ( $contenido7 ) . "', " : "" )
                 . ( ( strlen( $contenido8 ) > 0 ) ? " poderNotarial='" . ( $contenido8 ) . "', " : "" )
                 . ( ( strlen( $contenido9 ) > 0 ) ? " identificacion='" . ( $contenido9 ) . "', " : "" )
                 . " fechaEdicion='" . date( 'Y-m-d H:i:s' ) . "' "
                 //. " fechaAlta='" . date( 'Y-m-d H:i:s' ) . "' "
                 . " WHERE idRegistro='".$regId."' ";
            $rs  = $this->dbConn->ejecutaComando( $sql );
        }

        if( $rs ){
                return true;
            } else {
                return false;
        }
    }

    /*
     * Verifica el RFC si ha sido sado de alta previamente
     */
    public function verificaRFC( $rfc ) {

        $patron = "^[A-Z&Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]$";

        if( !eregi( $patron , $rfc ) ) {
            return json_encode( "<br>* Estructura incorrecta" );
        }

        #$sql    = " SELECT IF( COUNT( * ) > 0 , 0 , 1 ) AS t FROM reg_altaRegistro WHERE rfcFiscal='" . $rfc . "' AND status=1 ";
        #$rs     = $this->dbConn->ejecutaComando( $sql );
        $result = "true";

        #if( $rs && $rs->fields[ 't' ] == '0' ) {
        #    $result = "<br>* El RFC ya se ha registrado previamente";
        #}

        return json_encode( $result );
    }

    /*
     * Verifica si exiten descargables para el registro seleccionado
     */
    public function verificaRegistroDigitalizados( $id ) {
        $sql = " SELECT IF( COUNT( * ) > 0 , 'true' , 'false' ) AS total FROM reg_digitalizados WHERE idRegistro='" . $id . "' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'total' ];
    }

    /*
     * Metodo que descarga digitalizados individuales
     */
    public function descargaDigitalizadoIndividual( $idRegistro , $campo ) {
        $nombre = '';
        switch( $campo ) {
            case 'solicitudRegistro':$nombre='domiciliacion';break;
            case 'autorizacionDomiciliacion':$nombre='domiciliacion';break;
            case 'contrato':$nombre='contrato';break;
            case 'cedulaFiscal':$nombre='cedula';break;
            case 'edoCta':$nombre='edoCta';break;
            case 'comprobanteDomicilio':$nombre='compDomicilio';break;
            case 'actaConstitutiva':$nombre='acta';break;
            case 'poderNotarial':$nombre='poder';break;
            case 'identificacion':$nombre='ife';break;
        }

        $ruta = _DIRPATH_ . '/documentos/' . $idRegistro . '/' .$nombre . '.pdf';
        header( 'Content-Description: File Transfer' );
        header( 'Content-Type: application/pdf' );
        header( 'Content-Disposition: attachment; filename="'.basename($ruta).'"' );
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate' );
        header( 'Pragma: public' );
        header( 'Content-Length: ' . filesize( $ruta ) );
        readfile( $ruta );
        exit;

    }

    /*
     * Ontiene RFC
     */
    private function obtieneRFC( $idReg ) {
        $sql = " SELECT rfcFiscal, nombreComercial FROM reg_altaRegistro WHERE id='" . $idReg . "' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'rfcFiscal' ] . '_' . str_replace( ' ' , '_' , $rs->fields[ 'nombreComercial' ] );
    }

    /*
     * Genera documento zip con todos los digitalizados
     */
    public function generaZIP( $idReg ) {
        $zipname = $this->obtieneRFC( $idReg ) . ".zip";
        $nombres = $this->nombres;

        $zip = new ZipArchive;
        $zip->open( $zipname , ZipArchive::CREATE );
        foreach( $nombres AS $nombre ) {
            $ruta = _DIRPATH_ . '/documentos/' . $idReg . '/' .$nombre . '.pdf';
            if( copy( $ruta , $nombre . '.pdf' ) ) {
                $zip->addFile( $nombre . '.pdf' );
            }
        }
        $zip->close();
        $this->eliminaDigitalizados();

        header( 'Content-Type: application/zip' );
        header( 'Content-disposition: attachment; filename=' . basename( $zipname ) );
        header( 'Content-Length: ' . filesize( $zipname ) );
        readfile( $zipname );
    }

    /*
     * Genera pdf combinado
     */
    public function pdfMerge( $idReg , $acta ) {
        $pdfComp = "Digitalizados_Combinado_" . $this->obtieneRFC( $idReg ) . ".pdf";
        $nombres = $this->nombres;
        $pdf     = new PDFMerger;

        if( $acta ){
            unset( $nombres[0] );
        }

        foreach( $nombres AS $nombre ) {
            $ruta = _DIRPATH_ . '/documentos/' . $idReg . '/' .$nombre . '.pdf';
            if( file_exists( $ruta ) ) {
                $pdf->addPDF( $ruta , 'all' );
            }
        }

        $contenido = $pdf->merge( 'string' , $pdfComp );
        $fpP = fopen( $pdfComp , 'w' );
        fwrite( $fpP , $contenido );
        fclose( $fpP );
        //$this->eliminaDigitalizados();

        header( 'Content-Type: application/pdf' );
        header( 'Content-disposition: attachment; filename=' . $pdfComp );
        header( 'Content-Length: ' . filesize( $pdfComp ) );
        readfile( $pdfComp );
    }

    /*
     * Elimina archivos digitalizados
     */
    private function eliminaDigitalizados() {
        foreach( $this->nombres AS $nombre ) {
            unlink( $nombre . '.pdf' );
        }
    }

    /*
     * Listado de registros
     */
    public function registrosDisponibles_columnasID() {
        $columnas = array( 'id' ,
                           'nombreComercial' ,
                           'calleComercial' ,
                           'coloniaComercial' ,
                           'delegacionComercial' ,
                           'ciudadComercial' ,
                           'cpComercial' ,
                           'telefonoComercial' ,
                           'faxComercial' ,
                           'nombreFiscal' ,
                           'rfcFiscal' ,
                           'calleFiscal' ,
                           'coloniaFiscal' ,
                           'delegacionFiscal' ,
                           'ciudadFiscal' ,
                           'cpFiscal' ,
                           'telefonoFiscal' ,
                           'faxFiscal' ,
                           'local' ,
                           'contactoComercial' ,
                           'contactoCuentasPagar' ,
                           'correoContactoComercial' ,
                           'correoContactoCuentasPagar' ,
                           'telefonoContactoComercial' ,
                           'telefonoContactoCuestasPagar' ,
                           'antiguedadDomicilio' ,
                           'alta' ,
                           'envio' ,
                           'reenvio' ,
                           'validacion' ,//28
                           'rechazo' ,//29
                           'fechaEnvioComprobante' ,
                           //'IF(sistema==1,"ACG","INPART") AS sistema' ,
                           'sistema' ,
                           'usrACG' ,
                           'psswdACG' ,
                           'fechaACG' ,
                           'giroNegocio' ,
                           'giroTexto' ,
                           'noClienteAudatex' ,
                           'ref' ,
                           'estadoRegistro',
                           'paisComercial',
                           'paisFiscal',
                           'representanteLegal',
                           'regimenFiscal', 
                           'giroNegocio', 
                           'giroTexto',
                           'noClienteAudatex',
                           'usuario',
                           'fFenvioU',
                           'feUsrProd',
                           'feUsrCurso',
                           'certificado',
                           'pagado',
                           'comentarios');
        return $columnas;
    }

    public function registrosDisponibles_columnasHTML() {
        $columnas = array( 'ID' , //0
                           'Nombre Comercial' ,  // 1
                           'Calle Comercial' ,  // 2
                           'Colonia Comercial' , // 3
                           'Delegacion Comercial' , // 4
                           'Ciudad Comercial' , // 5
                           'Codigo Postal Comercial' , // 6
                           'Telefono Comercial' , // 7
                           'Fax Comercial' , // 8
                           'Nombre Fiscal' ,  // 9
                           'RFC' , // 10
                           'Calle' , // 11
                           'Colonia' , // 12
                           'Delegacion' , // 13
                           'Ciudad' , // 14
                           'Codigo Postal' , // 15
                           'Telefono' , // 16
                           'Fax' , // 17
                           'Local' , // 18
                           'Contacto Comercial' , // 19
                           'Contacto Cuentas x Pagar' , // 20
                           'Correo Contacto Comercial' , // 21
                           'Correo Contacto Cuentas x Pagar' , // 22
                           'Telefono Contacto Comercial' , // 23
                           'Telefono Contacto Cuentas x Pagar' , // 24
                           'Antiguedad Domicilio' , // 25
                           'Fecha Ingreso' , // 26
                           'Fecha Envio Informacion' , // 27
                           'Fecha Reenvio Informacion' , // 28
                           'Fecha Validacion' , // 29
                           'Fecha Rechazo' , // 30
                           'Fecha Envio Pago' , // 31
                           'Sistema' , // 32
                           'Usuario ACG' , // 33
                           'Password ACG' , // 34
                           'Fecha Datos ACG' , // 35
                           'Giro' , // 36
                           'Agencia' , // 37
                           'No Cliente' , // 38
                           'Ref' , // 39
                           'Estatus', // 40
                           'Pais Comercial', // 41
                           'Pais Fiscal', // 42
                           'Representante Legal', // 43
                           'Regimen Fiscal', // 44
                           'Giro Negocio', // 45
                           'Giro Texto', // 46
                           'Cliente Audatex', // 47
                           'Usuario',//48
                           'Fecha Envio',//49
                           'F.E. Usuarios Prod ACG',//50
                           'F.E. Usuarios Curso',//51
                           'Certificado',//52
                           'Pagado',//53
                           'Comentarios' // 54
                            );
        return $columnas;
    }

    public function registrosDisponibles_columnasHidden() {
        $columnas = array("2","3","4","5","6","7","8","9","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","36","37","38","39","40","42","41");
        return $columnas;
    }

    /*
     * Metodo para obtener listado de registros
     */
    public function getRegistrosDisponibles(){
        $nombres = $this->registrosDisponibles_columnasID();
        //$sql = " SELECT * FROM reg_altaRegistro WHERE status = '1' ";
        $sql  = " SELECT id, nombreComercial, calleComercial, coloniaComercial, delegacionComercial, ciudadComercial, entidadComercial, cpComercial, ";
        $sql .= " paisComercial, telefonoComercial, faxComercial, nombreFiscal, rfcFiscal, regimenFiscal, metodoPago, calleFiscal, coloniaFiscal, ";
        $sql .= " delegacionFiscal, ciudadFiscal, entidadFiscal, cpFiscal, paisFiscal, telefonoFiscal, faxFiscal, representanteLegal, local, ";
        $sql .= " contactoComercial, contactoCuentasPagar, correoContactoComercial, correoContactoCuentasPagar, telefonoContactoComercial, ";
        $sql .= " telefonoContactoCuestasPagar, antiguedadDomicilio, (SELECT DATE(fechaAlta) FROM sis_usuarios WHERE id=AR.usuario LIMIT 1) AS alta, ";
        $sql .= " ( SELECT DATE(fechaAlta) FROM reg_digitalizados WHERE idRegistro=AR.id LIMIT 1) AS envio, ";
        $sql .= " ( SELECT DATE(fechaEdicion) FROM reg_digitalizados WHERE idRegistro=AR.id LIMIT 1) AS reenvio, ";
        $sql .= " ( SELECT DATE(fechaValidacion) FROM reg_validacionSolicitud WHERE idSolicitud=AR.id AND validacion='1' LIMIT 1) AS validacion, ";
        $sql .= " ( SELECT DATE(fechaValidacion) FROM reg_validacionSolicitud WHERE idSolicitud=AR.id AND validacion='0' LIMIT 1) AS rechazo, ";
        $sql .= " aseguradoras, IF(sistema=1,'ACG','INPART') AS sistema, ";
        $sql .= " ( SELECT usuarioACG FROM reg_datosLibresACG WHERE idSolicitud=AR.id LIMIT 1) AS usrACG, ";
        $sql .= " ( SELECT passwdACG FROM reg_datosLibresACG WHERE idSolicitud=AR.id LIMIT 1) AS psswdACG, ";
        $sql .= " ( SELECT fechaACG FROM reg_datosLibresACG WHERE idSolicitud=AR.id LIMIT 1) AS fechaACG, ";
        $sql .= " ( SELECT giro FROM reg_giroNegocio WHERE id=AR.giroNegocio LIMIT 1) AS giroNegocio, ";
        $sql .= " IFNULL((SELECT IF(validacion=1,'Autorizado','Rechazado') AS val FROM reg_validacionSolicitud WHERE idSolicitud=AR.id),'No Validado') AS estadoRegistro, ";
        $sql .= " IF( AR.giroNegocio =2 , ( SELECT nombre FROM reg_fabricantes WHERE id=AR.giroTexto LIMIT 1) , AR.giroTexto) AS giroTexto, ";
        $sql .= " ( SELECT referencia FROM reg_referencias_uso WHERE id_registro=AR.id ) AS ref, ";
        $sql .= " ( SELECT IF(CONCAT(usuarioInpart ,'/',passwordInpart )='/',CONCAT( usuarioCurso,'/',passwordCurso ),CONCAT(usuarioInpart ,'/',passwordInpart )) ";
        $sql .= " FROM reg_datosReferenciasComerciales AS u WHERE u.idSolicitud=AR.id ) AS usuario, ";
        $sql .= " ( SELECT DATE(fecha) AS d FROM sis_fechaEnvios WHERE idSolicitud=AR.id AND proceso='' ) AS fFenvioU, ";
        $sql .= " ( SELECT DATE(fecha) AS d FROM sis_fechaEnvios WHERE idSolicitud=AR.id AND proceso='certificado' ) AS feUsrProd, ";
        $sql .= " ( SELECT DATE(fecha) AS d FROM sis_fechaEnvios WHERE idSolicitud=AR.id AND proceso='comprobante' ) AS feUsrCurso, ";
        $sql .= " ( SELECT IF( COUNT(*) > 0 ,'SI','NO' ) FROM reg_digitalizados_certificado WHERE idSolicitud=AR.id ) AS certificado, ";
        $sql .= " ( SELECT IF(certificado='','No Pagado','Pagado') FROM reg_digitalizados_certificado WHERE idSolicitud=AR.id ) AS pagado, ";
        $sql .= " ( SELECT IF(fechaEdicion='0000-00-00 00:00:00',fechaAlta,fechaEdicion) FROM reg_digitalizados_certificado WHERE idSolicitud=AR.id AND comprobante<>'' ) AS fechaEnvioComprobante, ";
        $sql .= " status,  noClienteAudatex, comentarios FROM reg_altaRegistro AS AR WHERE status = '1' ";
        //new Mail("debug", "cvreyes@mexagon.net", "debug", array( "mensaje" => $sql ));
        $dataTable = new DataTable( $sql , $nombres );
        echo $dataTable->datosDataTable; 
    }

    /*
     * Metodo para obtener datos registro para el id seleccionado
     */
    public function getDatosRegistroID( $datos , $modoArray=false ) {
        $json = array();
        $sql  = " SELECT * FROM reg_altaRegistro WHERE id = '" . $datos["idSelected"] . "' ";
        $rs   = $this->dbConn->ejecutaComando( $sql );

        if( !$rs->EOF ) {
            $json = array (
                "fechaAlta"                    => $rs->fields[ "alta" ],
                "nombreComercial"              => $rs->fields[ "nombreComercial" ],
                "calleComercial"               => $rs->fields[ "calleComercial" ],
                "coloniaComercial"             => $rs->fields[ "coloniaComercial" ],
                "delegacionComercial"          => $rs->fields[ "delegacionComercial" ],
                "ciudadComercial"              => $rs->fields[ "ciudadComercial" ],
                "entidadComercial"             => $this->nombreEntidadFederativa( $rs->fields[ "entidadComercial" ] ),
                "cpComercial"                  => $rs->fields[ "cpComercial" ],
                "paisComercial"                => $rs->fields[ "paisComercial" ],
                "telefonoComercial"            => $rs->fields[ "telefonoComercial" ],
                "faxComercial"                 => $rs->fields[ "faxComercial" ],
                "nombreFiscal"                 => $rs->fields[ "nombreFiscal" ],
                "rfcFiscal"                    => $rs->fields[ "rfcFiscal" ],
                "regimenFiscal"                => $rs->fields[ "regimenFiscal" ],
                "calleFiscal"                  => $rs->fields[ "calleFiscal" ],
                "coloniaFiscal"                => $rs->fields[ "coloniaFiscal" ],
                "delegacionFiscal"             => $rs->fields[ "delegacionFiscal" ],
                "ciudadFiscal"                 => $rs->fields[ "ciudadFiscal" ],
                "entidadFiscal"                => $this->nombreEntidadFederativa( $rs->fields[ "entidadFiscal" ] ),
                "cpFiscal"                     => $rs->fields[ "cpFiscal" ],
                "paisFiscal"                   => $rs->fields[ "paisFiscal" ],
                "telefonoFiscal"               => $rs->fields[ "telefonoFiscal" ],
                "faxFiscal"                    => $rs->fields[ "faxFiscal" ],
                "local"                        => $this->localOcupa( $rs->fields[ "local" ] ),
                "contactoComercial"            => $rs->fields[ "contactoComercial" ],
                "contactoCuentasPagar"         => $rs->fields[ "contactoCuentasPagar" ],
                "correoContactoComercial"      => $rs->fields[ "correoContactoComercial" ],
                "correoContactoCuentasPagar"   => $rs->fields[ "correoContactoCuentasPagar" ],
                "telefonoContactoComercial"    => $rs->fields[ "telefonoContactoComercial" ],
                "telefonoContactoCuestasPagar" => $rs->fields[ "telefonoContactoCuestasPagar" ],
                "antiguedadDomicilio"          => $rs->fields[ "antiguedadDomicilio" ],
                "representanteLegal"           => $rs->fields[ "representanteLegal" ],
                "aseguradoras"                 => $this->nombreAseguradoras( $rs->fields[ "aseguradoras" ] ),
                "giroTexto"                    => $rs->fields[ "giroTexto" ],
                "giroNegocio"                  => $this->obtieneNombreGiroNegocio( $rs->fields[ "giroNegocio" ] ),
                "noClienteAudatex"             => $rs->fields[ "noClienteAudatex" ],
                "usoSistema"                   => $rs->fields[ "usoSistema" ],
                "razonAlta"                    => $rs->fields[ "razonAlta" ],
                "certificado"                  => $rs->fields[ "certificado" ],
                "noClienteAudatex"             => $rs->fields[ "noClienteAudatex" ]
            );
        }

        if( $modoArray ) {
                return $json;
            } else {
                return json_encode($json);
        }
    }

    private function nombreAseguradoras( $arregloAseguradoras ) {
        $aseguradoras = explode( ',' , $arregloAseguradoras );
        $a = '';
        foreach( $aseguradoras AS $aseguradora ) {
            $sql = " SELECT nombre FROM reg_catalogoAseguradoras WHERE id='".$aseguradora."' ";
            $rs  = $this->dbConn->ejecutaComando( $sql );
            $a  .= $rs->fields[ 'nombre' ].';';
        }
        
        return trim( $a , ';' );
    }
    
    private function nombreEntidadFederativa( $id ) {
        $sql = " SELECT estado FROM reg_catalogoEstados WHERE id='".$id."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'estado' ];
    }

    private function localOcupa( $id ) {
        $sql = " SELECT texto FROM reg_tipoLocal WHERE id='".$id."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'texto' ];
    }

    private function obtieneNombreGiroNegocio( $id ) {
        $sql = " SELECT giro FROM reg_giroNegocio WHERE id='".$id."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'giro' ];
    }

    /*
     * Funcion que descarga los datos de Audatex
     */
    public function datosAudatex() {
        $sql  = " SELECT * FROM reg_audatex WHERE id=1 ";
        $rs   = $this->dbConn->ejecutaComando( $sql );
        $dAud = array();

        while( !$rs->EOF ) {
            $dAud[ 'razonSocial' ] = $rs->fields[ 'razonSocial' ];
            $dAud[ 'rfc' ]         = $rs->fields[ 'rfc' ];
            $dAud[ 'direccion' ]   = $rs->fields[ 'direccion' ];
            $rs->MoveNext();
        }

        return $dAud;
    }

    /*
     * Catalogo de aseguradoras
     */
    public function catalogoAseguradoras( $json = false ) {
        $sql = " SELECT id, nombre FROM `reg_catalogoAseguradoras` WHERE status=1";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        $aseguradoras = array();
        $aseguradora  = array();

        while( !$rs->EOF ) {
            $aseguradora[ 'id' ]     = $rs->fields[ 'id' ];
            $aseguradora[ 'nombre' ] = $rs->fields[ 'nombre' ];
            $aseguradoras[] = $aseguradora;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $aseguradoras ) : $aseguradoras;
        return $arr;
    }

    /*
     * Catalogo de paises
     */
    public function catalogoPaises( $json = false ) {
        $sql    = " SELECT id, clave, pais FROM reg_catalogoPaises WHERE status=1 ORDER BY pais ASC ";
        $rs     = $this->dbConn->ejecutaComando( $sql );
        $pais   = array();
        $paises = array();

        while( !$rs->EOF ) {
            $pais[ 'id' ]     = $rs->fields[ 'clave' ];
            $pais[ 'nombre' ] = utf8_encode($rs->fields[ 'pais' ]);
            $paises[]         = $pais;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $paises ) : $paises;
        return $arr;
    }

    /*
     * Catalogo de estados
     */
    public function catalogoEstados( $json = false ) {
        $sql     = " SELECT id, estado FROM reg_catalogoEstados WHERE status=1 ORDER BY estado ASC ";
        $rs      = $this->dbConn->ejecutaComando( $sql );
        $estado  = array();
        $estados = array();

        while( !$rs->EOF ) {
            $estado[ 'id' ]     = $rs->fields[ 'id' ];
            $estado[ 'nombre' ] = $rs->fields[ 'estado' ];
            $estados[]          = $estado;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $estados ) : $estados;
        return $arr;
    }

    /*
     * Catalogo de regimenes fiscales
     */
    public function catalogoRegimenesFiscales( $json = false ) {
        $sql               = " SELECT clave, regimenFiscal FROM reg_catalogoRegimenFiscal WHERE status=1 ";
        $rs                = $this->dbConn->ejecutaComando( $sql );
        $regimenesFiscales = array();
        $regimenFiscal     = array();

        while( !$rs->EOF ) {
            $regimenFiscal[ 'id' ]     = $rs->fields[ 'clave' ];
            $regimenFiscal[ 'nombre' ] = $rs->fields[ 'regimenFiscal' ];
            $regimenesFiscales[]       = $regimenFiscal;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $regimenesFiscales ) : $regimenesFiscales;
        return $arr;
    }

    /*
     * Catalogo tipo de local
     */
    public function catalogoTipoLocal( $json = false ) {
        $sql   = " SELECT id, texto FROM `reg_tipoLocal` WHERE status=1 ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $tipos = array();
        $tipo  = array();

        while( !$rs->EOF ) {
            $tipo[ 'id' ]    = $rs->fields[ 'id' ];
            $tipo[ 'texto' ] = $rs->fields[ 'texto' ];
            $tipos[] = $tipo;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $tipos ) : $tipos;
        return $arr;
    }

    /*
     * Catalogo de bancos
     */
    public function catalogoBancos( $json = false ) {
        $sql    = " SELECT clave, banco FROM reg_catalogoBancos WHERE status=1 ";
        $rs     = $this->dbConn->ejecutaComando( $sql );
        $banco  = array();
        $bancos = array();

        while( !$rs->EOF ) {
            $banco[ 'id' ] = $rs->fields[ 'clave' ];
            $banco[ 'texto' ] = $rs->fields[ 'banco' ];
            $bancos[]         = $banco;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $bancos ) : $bancos;
        return $arr;
    }

    /*
     * Catalogo de metodos de pago
     */
    public function catalogoMetodosPago( $json = false ) {
        $sql         = " SELECT id, metodoPago FROM reg_catalogoMetodoPago WHERE status=1 ";
        $rs          = $this->dbConn->ejecutaComando( $sql );
        $metodoPago  = array();
        $metodosPago = array();

        while( !$rs->EOF ) {
            $metodoPago[ 'id' ]     = $rs->fields[ 'id' ];
            $metodoPago[ 'nombre' ] = $rs->fields[ 'metodoPago' ];
            $metodosPago[]          = $metodoPago;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $metodosPago ) : $metodosPago;
        return $arr;
    }

    /*
     * Catalogo de giros de negocio
     */
    public function catalogoGirosNegocio( $json = false ) {
        $sql          = " SELECT id, giro FROM reg_giroNegocio WHERE status=1 ";
        $rs           = $this->dbConn->ejecutaComando( $sql );
        $giroNegocio  = array();
        $girosNegocio = array();

        while( !$rs->EOF ) {
            $giroNegocio[ 'id' ]     = $rs->fields[ 'id' ];
            $giroNegocio[ 'nombre' ] = $rs->fields[ 'giro' ];
            $girosNegocio[]          = $giroNegocio;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $girosNegocio ) : $girosNegocio;
        return $arr;
    }

    /*
     * Catalogo de fabricantes
     */
    public function catalogoFabricantes( $json = false ) {
        $sql         = " SELECT id, nombre FROM reg_fabricantes WHERE status=1 ORDER BY nombre ASC ";
        $rs          = $this->dbConn->ejecutaComando( $sql );
        $fabricante  = array();
        $fabricantes = array();

        while( !$rs->EOF ) {
            $fabricante[ 'id' ]     = $rs->fields[ 'id' ];
            $fabricante[ 'nombre' ] = $rs->fields[ 'nombre' ];
            $fabricantes[]          = $fabricante;
            $rs->MoveNext();
        }

        $arr = ( $json ) ? json_encode( $fabricantes ) : $fabricantes;
        return $arr;
    }

    /*
     * Guarda informacion formatos
     */
    public function guardaDatosDomiciliacion( $d ) {
        $datos = array_map( 'utf8_decode' , $d );
        $sql   = " INSERT INTO reg_datosDocimiliacion (idSolicitud, cliente_nombreFiscal, nombreComercial, ";
        $sql  .= " rfc, banco, titularCuenta, terminacion, sucursal, clabe, representanteLegal, fechaAlta, status) ";
        $sql  .= " VALUES ( '".$datos[ 'formDescargaFormatos_idSolicitud' ]."', '".$datos[ 'formDomiciliacion_nombreFiscal' ]."', '".$datos[ 'formDomiciliacion_nombreComercial' ]."', '".$datos[ 'formDomiciliacion_rfc' ]."', '".$datos[ 'formDomiciliacion_banco' ]."', ";
        $sql  .= " '".$datos[ 'formDomiciliacion_titularCuenta' ]."', '".$datos[ 'formDomiciliacion_terminacionCuenta' ]."', '".$datos[ 'formDomiciliacion_sucursal' ]."', '".$datos[ 'formDomiciliacion_clabe' ]."', '".$datos[ 'formDomiciliacion_representanteLegal' ]."', '".date( 'Y-m-d H:i:s' )."', '1') ";
        $sql  .= " ON DUPLICATE KEY UPDATE ";
        $sql  .= " cliente_nombreFiscal = '".$datos[ 'formDomiciliacion_nombreFiscal' ]."', nombreComercial='".$datos[ 'formDomiciliacion_nombreComercial' ]."', ";
        $sql  .= " rfc='".$datos[ 'formDomiciliacion_rfc' ]."', banco='".$datos[ 'formDomiciliacion_banco' ]."', titularCuenta='".$datos[ 'formDomiciliacion_titularCuenta' ]."', terminacion='".$datos[ 'formDomiciliacion_terminacionCuenta' ]."', ";
        $sql  .= " sucursal='".$datos[ 'formDomiciliacion_sucursal' ]."', clabe='".$datos[ 'formDomiciliacion_clabe' ]."', representanteLegal='".$datos[ 'formDomiciliacion_representanteLegal' ]."',fechaEdicion='".date( 'Y-m-d H:i:s' )."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
                $e = true;
            } else {
                $e = false;
        }

        return $e;
    }

    public function obtieneDatosDomiciliacion( $solicitud ) {
        $sqlSol  = " SELECT * FROM reg_altaRegistro WHERE id='".$solicitud."' ";
        $rsSol   = $this->dbConn->ejecutaComando( $sqlSol );
        $cliente = $rsSol->fields[ 'nombreFiscal' ];
        $nomCom  = $rsSol->fields[ 'nombreComercial' ];
        $rfc     = $rsSol->fields[ 'rfcFiscal' ];
        $repLeg  = $rsSol->fields[ 'representanteLegal' ];

        $sql   = " SELECT * FROM reg_datosDocimiliacion WHERE idSolicitud = '".$solicitud."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $datos = array( 'banco' => '', 'titularCuenta' => '', 'terminacion' => '', 'sucursal' => '', 'clabe' => '' );

        while( !$rs->EOF ) {
            $datos[ 'banco' ]                = $rs->fields[ 'banco' ];
            $datos[ 'titularCuenta' ]        = $rs->fields[ 'titularCuenta' ];
            $datos[ 'terminacion' ]          = $rs->fields[ 'terminacion' ];
            $datos[ 'sucursal' ]             = $rs->fields[ 'sucursal' ];
            $datos[ 'clabe' ]                = $rs->fields[ 'clabe' ];
            $datos[ 'fechaAlta' ]            = $rs->fields[ 'fechaAlta' ];
            $rs->MoveNext();
        }

        $datos[ 'cliente_nombreFiscal' ] = $cliente;
        $datos[ 'nombreComercial' ]      = $nomCom;
        $datos[ 'rfc' ]                  = $rfc;
        $datos[ 'representanteLegal' ]   = $repLeg;
        return $datos;
    }

    public function guardaDatosReferenciasComerciales( $d ) {
        $datos = array_map( 'utf8_decode' , $d );
        $sql   = " INSERT INTO reg_datosReferenciasComerciales(idSolicitud,  ";
        $sql  .= " nombreParticipante, apellidoPaternoParticipante, apellidoMaternoParticipante, correoParticipante, fechaAlta, usuario, password, referencia, ";
        $sql  .= " terminalID, companyCode, usuarioInpart, passwordInpart, status) ";
        $sql  .= " VALUES ( '".$datos[ 'formDescargaFormatos_idSolicitud' ]."', '".$datos[ 'formReferenciasComerciales_nombreParticipante' ]."', ";
        $sql  .= " '".$datos[ 'formReferenciasComerciales_aPaternoParticipante' ]."', '".$datos[ 'formReferenciasComerciales_aMaternoParticipante' ]."', ";
        $sql  .= " '".$datos[ 'formReferenciasComerciales_correoParticipante' ]."', '".date( 'Y-m-d H:i:s' )."', ";
        $sql  .= " '".$datos[ 'formReferenciasComerciales_usuario' ]."' ,'".$datos[ 'formReferenciasComerciales_contrasena' ]."' ,'".$this->obtieneReferencia($datos[ 'formDescargaFormatos_idSolicitud' ])."', ";
        $sql  .= " '".$datos[ 'formReferenciasComerciales_terminalID' ]."', '".$datos[ 'formReferenciasComerciales_companyCode' ]."', ";
        $sql  .= " '".$datos[ 'formReferenciasComerciales_usuarioInpart' ]."', '".$datos[ 'formReferenciasComerciales_contrasenaInpart' ]."','1') ";
        $sql  .= " ON DUPLICATE KEY UPDATE ";
        $sql  .= " nombreParticipante='".$datos[ 'formReferenciasComerciales_nombreParticipante' ]."', ";
        $sql  .= " apellidoPaternoParticipante='".$datos[ 'formReferenciasComerciales_aPaternoParticipante' ]."', ";
        $sql  .= " apellidoMaternoParticipante='".$datos[ 'formReferenciasComerciales_aMaternoParticipante' ]."', ";
        $sql  .= " correoParticipante='".$datos[ 'formReferenciasComerciales_correoParticipante' ]."', ";
        $sql  .= " usuario='".$datos[ 'formReferenciasComerciales_usuario' ]."', password='".$datos[ 'formReferenciasComerciales_contrasena' ]."', ";
        $sql  .= " usuarioInpart='".$datos[ 'formReferenciasComerciales_usuarioInpart' ]."', passwordInpart='".$datos[ 'formReferenciasComerciales_contrasenaInpart' ]."', ";
        $sql  .= " terminalID='".$datos[ 'formReferenciasComerciales_terminalID' ]."', companyCode='".$datos[ 'formReferenciasComerciales_companyCode' ]."', ";
        $sql  .= " fechaEdicion='".date( 'Y-m-d H:i:s' )."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
                // Envia pieza de acceso a inpart
                if( !empty( $datos[ 'formReferenciasComerciales_usuarioInpart' ] ) && !empty( $datos[ 'formReferenciasComerciales_contrasenaInpart' ] ) ) {
                    $datosPieza = array(
                        'usuario' => trim( $datos[ 'formReferenciasComerciales_usuarioInpart' ] ),
                        'password' => trim( $datos[ 'formReferenciasComerciales_contrasenaInpart' ] )
                    );
                    new Mail( 'Datos acceso Inpart' , $this->obtieneDestinatario().",".$datos[ 'formReferenciasComerciales_correoParticipante' ] , 'piezaEnvioSistemaInpart' , $datosPieza );
                    $this->registroEnvio( $datos[ 'formDescargaFormatos_idSolicitud' ] , 'inpart' );
                }
                $e = true;
            } else {
                $e = false;
        }

        return $e;
    }

    private function registroEnvio( $idSolicitud , $tipo ) {
        $sql  = " INSERT INTO sis_fechaEnvios (idSolicitud, fecha, tipo) VALUES( '".$idSolicitud."','".date( 'Y:m:d H:i:s' )."' , '".$tipo."' ) ";
        $sql .= " ON DUPLICATE KEY UPDATE fecha='".date( 'Y:m:d H:i:s' )."', tipo='".$tipo."' ";trigger_error($sql);
        $this->dbConn->ejecutaComando( $sql );
    }

    public function obtieneReferencia( $idSolicitud ) {
        $sqlv = " SELECT referencia FROM reg_referencias_uso WHERE id_registro='".$idSolicitud."' ";
        $rsv  = $this->dbConn->ejecutaComando( $sqlv );

        if( !$rsv->EOF ){ return $rsv->fields[ 'referencia' ];}

        $sql  = " SELECT id, referencia FROM reg_referencias WHERE status=1 ORDER BY id ASC LIMIT 1 ";
        $rs   = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
            $sql2  = " INSERT INTO reg_referencias_uso (id_referencia, referencia, id_registro, fechaAsignacion) ";
            $sql2 .= " VALUES( '".$rs->fields[ 'id' ]."' , '".$rs->fields[ 'referencia' ]."' , '".$idSolicitud."' , '".date( 'Y-m-d H:i:s' )."' ) ";
            $this->dbConn->ejecutaComando( $sql2 );
            $this->dbConn->ejecutaComando( " UPDATE reg_referencias SET status=0 WHERE id='".$rs->fields[ 'id' ]."' " );
        }

        return $rs->fields[ 'referencia' ];
    }

    public function obtieneDatosReferenciasComerciales( $solicitud ) {
        $sql   = " SELECT * FROM reg_datosReferenciasComerciales WHERE idSolicitud = '".$solicitud."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $datos = array('nombreParticipante' => '','aPaternoParticipante' => '','aMaternoParticipante' => '','correoParticipante' => '','usuario' => '','password' => '');

        while( !$rs->EOF ) {
            $datos[ 'nombreParticipante' ]   = $rs->fields[ 'nombreParticipante' ];
            $datos[ 'aPaternoParticipante' ] = $rs->fields[ 'apellidoPaternoParticipante' ];
            $datos[ 'aMaternoParticipante' ] = $rs->fields[ 'apellidoMaternoParticipante' ];
            $datos[ 'correoParticipante' ]   = $rs->fields[ 'correoParticipante' ];
            $datos[ 'usuario' ]              = $rs->fields[ 'usuario' ];
            $datos[ 'password' ]             = $rs->fields[ 'password' ];
            $datos[ 'fechaAlta' ]            = $rs->fields[ 'fechaAlta' ];
            $datos[ 'referencia' ]           = $rs->fields[ 'referencia' ];
            $datos[ 'terminalID' ]           = $rs->fields[ 'terminalID' ];
            $datos[ 'companyCode' ]          = $rs->fields[ 'companyCode' ];
            $datos[ 'usuarioInpart' ]        = $rs->fields[ 'usuarioInpart' ];
            $datos[ 'passwordInpart' ]       = $rs->fields[ 'passwordInpart' ];
            $rs->MoveNext();
        }

        return $datos;
    }

    public function guardaDatosContratos( $d ) {
        $datos = array_map( 'utf8_decode' , $d );
        $sql   = " INSERT INTO reg_datosContrato (idSolicitud, cliente_nombreComercial, cliente_representanteLegal, cliente_fechaFirmaContrato, status ) ";
        $sql  .= " VALUES ('".$datos[ 'formDescargaFormatos_idSolicitud' ]."', '".$datos[ 'formContratos_nombreComercial' ]."', ";
        $sql  .= " '".$datos[ 'formContratos_representanteLegal' ]."', '".$datos[ 'formReporteCrediticio_solicitante' ]."', '1') ";
        $sql  .= " ON DUPLICATE KEY UPDATE ";
        $sql  .= " cliente_nombreComercial='".$datos[ 'formContratos_nombreComercial' ]."', cliente_representanteLegal='".$datos[ 'formContratos_representanteLegal' ]."', ";
        $sql  .= " cliente_fechaFirmaContrato='".$datos[ 'formContrato_fechaFirmaContrato' ]."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
                $e = true;
            } else {
                $e = false;
        }

        return $e;
    }

    public function obtieneDatosContratos( $solicitud ) {
        $sqlSol  = " SELECT * FROM reg_altaRegistro WHERE id='".$solicitud."' ";
        $rsSol   = $this->dbConn->ejecutaComando( $sqlSol );
        $nomCom  = $rsSol->fields[ 'nombreComercial' ];
        $repLeg  = $rsSol->fields[ 'representanteLegal' ];

        $sql = " SELECT * FROM reg_datosContrato WHERE idSolicitud='".$solicitud."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );

        $datos = array(
            'representanteLegal' => '' ,
            'nombreComercial'    => '' ,
            'dia'                => '' ,
            'mes'                => '' ,
            'anio'               => ''
        );

        while( !$rs->EOF ) {
            $datos[ 'representanteLegal' ] = $rs->fields[ 'cliente_nombreComercial' ];
            $datos[ 'nombreComercial' ]    = $rs->fields[ 'cliente_representanteLegal' ];
            $f = explode( '-' , $rs->fields[ 'cliente_fechaFirmaContrato' ] );
            $datos[ 'dia' ]  = $f[ '2' ];
            $datos[ 'mes' ]  = $f[ '1' ];
            $datos[ 'anio' ] = $f[ '0' ];
            $rs->MoveNext();
        }

        $datos[ 'representanteLegal' ] = $repLeg;
        $datos[ 'nombreComercial' ]    = $nomCom;

        return $datos;
    }

    public function guardaDatosReporteCrediticio( $d ) {
        $datos = array_map( 'utf8_decode' , $d );
        $sql   = " INSERT INTO reg_datosReporteCrediticio (idSolicitud, cliente, domicilioTelefono, ";
        $sql  .= " solicitante, fechaConsulta, folioConsulta, rfc, fechaAlta, status) ";
        $sql  .= " VALUES ('".$datos[ 'formDescargaFormatos_idSolicitud' ]."', '".$datos[ 'formReporteCrediticio_nombre' ]."', ";
        $sql  .= " '".$datos[ 'formReporteCrediticio_domYtel' ]."', '".$datos[ 'formReporteCrediticio_solicitante' ]."', ";
        $sql  .= " '".$datos[ 'formReporteCrediticio_fechaConsulta' ]."', '".$datos[ 'formReporteCrediticio_folioConsulta' ]."', ";
        $sql  .= " '".$datos[ 'formReporteCrediticio_rfc' ]."', '".date( 'Y-m-d H:i:s' )."', '1') ";
        $sql  .= " ON DUPLICATE KEY UPDATE ";
        $sql  .= " cliente='".$datos[ 'formReporteCrediticio_nombre' ]."', domicilioTelefono='".$datos[ 'formReporteCrediticio_domYtel' ]."', ";
        $sql  .= " solicitante='".$datos[ 'formReporteCrediticio_solicitante' ]."', fechaConsulta='".$datos[ 'formReporteCrediticio_fechaConsulta' ]."', ";
        $sql  .= " folioConsulta='".$datos[ 'formReporteCrediticio_folioConsulta' ]."', rfc='".$datos[ 'formReporteCrediticio_rfc' ]."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
                $e = true;
            } else {
                $e = false;
        }

        return $e;
    }

    public function obtieneDatosReporteCrediticio( $solicitud ) {
        $sql   = " SELECT * FROM reg_datosReporteCrediticio WHERE idSolicitud = '".$solicitud."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $datos = array( 'cliente' => '', 'domicilioTelefono' => '', 'solicitante' => '', 'fechaConsulta' => '', 'folioConsulta' => '', 'rfc' => '', 'fechaAlta' => '' );

        while( !$rs->EOF ) {
            $datos[ 'cliente' ]           = $rs->fields[ 'cliente' ];
            $datos[ 'domicilioTelefono' ] = $rs->fields[ 'domicilioTelefono' ];
            $datos[ 'solicitante' ]       = $rs->fields[ 'solicitante' ];
            $datos[ 'fechaConsulta' ]     = $rs->fields[ 'fechaConsulta' ];
            $datos[ 'folioConsulta' ]     = $rs->fields[ 'folioConsulta' ];
            $datos[ 'rfc' ]               = $rs->fields[ 'rfc' ];
            $datos[ 'fechaAlta' ]         = $rs->fields[ 'fechaAlta' ];
            $rs->MoveNext();
        }

        return $datos;
    }

    public function guardaResultadoValidacionSolicitud( $idSolicitud , $validacion , $motivo , $noCliente , $rechazo=false) {
        $sql      = " INSERT INTO reg_validacionSolicitud ( idSolicitud, validacion, motivo, fechaValidacion, usuarioValidacion )";
        $sql     .= " VALUES ('" . $idSolicitud . "', '" . $validacion . "', '" . $motivo . "', '" . date( 'Y-m-d H:i:s' ) . "', '" . $_SESSION[ 'idUsuario' ] . "')  ";
        $sql     .= " ON DUPLICATE KEY UPDATE validacion='".$validacion."', motivo='".$motivo."'; ";
        trigger_error($sql);
        $rs       = $this->dbConn->ejecutaComando( $sql );
        $adjuntos = array();

        if( $rs ) {
                $this->dbConn->ejecutaComando( " UPDATE reg_altaRegistro SET noClienteAudatex='".$noCliente."', estadoRegistro=1 WHERE id='".$idSolicitud."' " );
                $datos = $this->obtieneNombreComercial( $idSolicitud );
                $params = array(
                    'motivo'  => $motivo,
                    'cliente' => $datos[ 0 ],
                    'alta'    => $datos[ 1 ]
                );

                if( strlen( $motivo ) > 0 ) {
                    $this->upload = new Upload( 'cancelaSolicitudMotivoRechazo_adjunto' );
                    if( $this->upload ) {
                        $this->upload->mueveUpload( _DIRPATH_ . '/temp/' . $this->upload->fileName );
                        $adjuntos = array( $this->upload->rutaFinal => $this->upload->fileName );
                        //$this->upload->eliminaLayout();
                    }
                } else {
                    // Pieza de correo para ACG
                    $imagenes2 = array(
                        './assets/attached/acg_1.jpg' => array( 'acg_1' , 'base64' , 'image/jpeg' ),
                        './assets/attached/acg_2.jpg' => array( 'acg_2' , 'base64' , 'image/jpeg' )
                    );
                    /*Envio solo para acg*/
                    if( $this->obtieneTipoSistema( $idSolicitud ) == 'ACG' ) {
                        new Mail( 'Validacion ACG' , $this->obtieneDestinatario( true , $idSolicitud ) , 'piezaValidacionACG' , array() , '' , '' , $imagenes2 );
                    }
                }

                $subject = ( strlen( $motivo ) > 0 ) ? "Rechazo Solicitud" : "Validacion Solicitud" ;
                $pieza   = ( strlen( $motivo ) > 0 ) ? "rechazoValidacion" : "avisoValidacion" ;
                new Mail( $subject , $this->obtieneDestinatario( true , $idSolicitud ) , $pieza , $params , '' , '' , '' , $adjuntos );

                return true;
            } else {
                return false;
        }
    }

    /* Funcion que obtiene el tipo de sistema */
    public function obtieneTipoSistema( $idSolicitud ) {
        $sql = " SELECT sistema FROM reg_altaRegistro WHERE id='" . $idSolicitud . "' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return ( ( $rs->fields[ 'sistema' ] == '1' ) ? 'ACG' : 'Inpart' );
    }

    public function obtieneDestinatario( $destinatarioUsuario=false , $idSol = '') {
        $sql  = " SELECT valor FROM sis_predefinidos WHERE id=4 ";
        $rs   = $this->dbConn->ejecutaComando( $sql );
        $dest = $rs->fields[ 'valor' ] . ',';
        
        if( $destinatarioUsuario ) {
            $sql2 = " SELECT email FROM sis_usuarios WHERE id=( SELECT usuario FROM reg_altaRegistro WHERE id='".$idSol."' ) ";
            $rs2  = $this->dbConn->ejecutaComando( $sql2 );
            $dest .= $rs2->fields[ 'email' ] . ',';
        }
        
        return trim( $dest , ',' );
    }

    public function obtieneNombreComercial( $id ) {
        $sqlSol = " SELECT nombreComercial, nombreFiscal, alta FROM reg_altaRegistro WHERE id='".$id."' ";
        $rsSol  = $this->dbConn->ejecutaComando( $sqlSol );
        $nombre = ( strlen( $rsSol->fields[ 'nombreComercial' ] ) == 0 ) ? $rsSol->fields[ 'nombreFiscal' ] : $rsSol->fields[ 'nombreComercial' ];
        return array( $nombre , $rsSol->fields[ 'alta' ] );
    }

    public function verificaValidacionPrevia( $idSol ) {
        $sql        = " SELECT COUNT( * ) AS tot , validacion FROM reg_validacionSolicitud WHERE idSolicitud='".$idSol."' AND validacion='1' ";
        $rs         = $this->dbConn->ejecutaComando( $sql );
        $verificado = 'nv';
        $validacion = '';

        if( $rs ){
            if( $rs->fields[ 'tot' ] == '1' ){
                $verificado = 'v';
                $validacion = $rs->fields['validacion'];
            }
        }

        return json_encode( array( 'verificado' => $verificado , 'validacion' => $validacion ) );
    }

    public function comentarioRegistro( $id ) {
        $sql        = " SELECT comentarios FROM reg_altaRegistro WHERE id='".$id."' ";
        $rs         = $this->dbConn->ejecutaComando( $sql );
        $comentario = "";
        
        if( $rs ) {
            $comentario = $rs->fields[ 'comentarios' ];
        }
        
        return $comentario;
    }
    
    public function altaComentarioRegistro( $id , $contenido ) {
        $sql = " UPDATE reg_altaRegistro SET comentarios='".$contenido."' WHERE id='".$id."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
            return "Informaci&oacute;n guardada correctamente";
        } else {
            return "Error al guardar la informaci&oacute;n";
        }
    }
    
    public function datosLibresACG( $idSol ) {
        $sql   = " SELECT usuarioACG, passwdACG, fechaACG FROM reg_datosLibresACG WHERE idSolicitud='".$idSol."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $datos = array( 'usuario' => '' , 'passwd' => '' , 'fecha' => '' );
        if( $rs && !$rs->EOF ) {
            $datos[ 'usuario' ] = $rs->fields[ 'usuarioACG' ];
            $datos[ 'passwd' ]  = $rs->fields[ 'passwdACG' ];
            $datos[ 'fecha' ]   = $rs->fields[ 'fechaACG' ];
        }
        return $datos;
    }
    
    public function guardaDatosLibresACG( $id , $usuario , $passwd ) {
        $sql  = " INSERT INTO reg_datosLibresACG (idSolicitud,usuarioACG,passwdACG,fechaACG,status ) VALUES ";
        $sql .= " ( '".$id."' , '".$usuario."' , '".$passwd."' ,'".date( 'Y-m-d H:i:s' )."',1 ) ";
        $sql .= " ON DUPLICATE KEY UPDATE usuarioACG='".$usuario."', passwdACG='".$passwd."', fechaACG='".date( 'Y-m-d H:i:s' )."' ";
        $rs   = $this->dbConn->ejecutaComando( $sql );
        if( $rs ){ return true; }
        else{ return false; }
    }
    
}
