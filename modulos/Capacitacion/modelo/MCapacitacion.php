<?php
/*
 * Modelo para el funcionamiento de registros
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

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

class MCapacitacion {
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
    protected $nombres = array( "acta" , "solicitud" , "ife" , "edoCta" , "domiciliacion" , "contrato" , "compDomicilio" , "cedula" , "poder" );

    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbConn = new classConMySQL();
    }


    /*
     * Verifica si exiten descargables para el registro seleccionado
     */
    public function verificaRegistroDigitalizados( $id ) {
        $sql = " SELECT IF( COUNT( * ) > 0 , 'true' , 'false' ) AS total FROM reg_digitalizados_certificado WHERE idSolicitud='" . $id . "' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'total' ];
    }

    /* Metodo que guarda los documentos digitalizados de la capacitacion */
    public function actualizaRegistroDigitalizados() {
        ini_set( 'max_execution_time' , 300 );
        $contenido1   = "";
        $contenido2   = "";
        $regId        = $_POST[ 'capacitacion_Digitalizacion_idRegistroID' ];
        if( $regId == "" )return false;
        $mov          = $_POST[ 'capacitacion_Digitalizacion_tipoMovimiento' ];
        $subject      = "";
        $f            = date( 'Y-m-d H:i:s' );

        if( $mov == 'alta' ) {
            mkdir( _DIRPATH_ . '/documentos/' . $regId );
        }

        $uploadCert = new Upload( 'capacitacion_Digitalizacion_certificado' );
        if( $uploadCert->existe ) {
            $uploadCert->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/certificado.pdf' );
            $contenido1 = 'certificado.pdf';
            //$uploadCert->eliminaLayout();
            $subject    = 'Digitalizacion de Certificado';
        }

        $uploadCompPago = new Upload( 'capacitacion_Digitalizacion_comprobantePago' );
        if( $uploadCompPago->existe ) {
            $uploadCompPago->mueveUpload( _DIRPATH_ . '/documentos/' . $regId . '/comprobantePago.pdf' );
            $contenido2 = 'comprobantePago.pdf';
            //$uploadCompPago->eliminaLayout();
            $subject    = 'Digitalizacion de Comprobante de Pago';
        }

        if( $mov == 'alta' && !empty( $subject ) ) {
            $sql = " INSERT INTO reg_digitalizados_certificado (idSolicitud, certificado, comprobante, fechaAlta, status) "
                 . " VALUES ('" . $regId . "','" . ( $contenido1 ) . "','" . ( $contenido2 ) . "','" . $f . "', 1)  ";
            $rs  = $this->dbConn->ejecutaComando( $sql );

            $n   = $this->obtieneNombreComercial( $regId );
            $datosPieza = array (
                'razonSocial' => $n[ 0 ],
                'fecha'       => $f
            );

            if( !empty( $subject ) ){ new Mail( $subject , $this->obtieneDestinatario() , 'avisoDigitalizacion' , $datosPieza ); }

        } elseif( $mov == 'edita' ) {
            $sql = " UPDATE reg_digitalizados_certificado SET "
                 . ( ( strlen( $contenido1 ) > 0 ) ? " certificado='" . ( $contenido1 ) . "', " : "" )
                 . ( ( strlen( $contenido2 ) > 0 ) ? " comprobante='" . ( $contenido2 ) . "', " : "" )
                 . " fechaEdicion='" . date( 'Y-m-d H:i:s' ) . "' "
                 . " WHERE idSolicitud='".$regId."' ";
            $rs  = $this->dbConn->ejecutaComando( $sql );
            
            $n   = $this->obtieneNombreComercial( $regId );
            $datosPieza = array (
                'razonSocial' => $n[ 0 ],
                'fecha'       => $f
            );
            if( !empty( $subject ) ){ new Mail( $subject , $this->obtieneDestinatario() , 'avisoDigitalizacion' , $datosPieza ); }
        }

        if( $rs ) {
                return true;
            } else {
                return false;
        }
    }

    public function obtieneDestinatario() {
        $sql = " SELECT valor FROM sis_predefinidos WHERE id=4 ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'valor' ];
    }

    public function obtieneDatosParticipanteCertificacion( $idSolicitud ) {
        $sql   = " SELECT * FROM reg_datosReferenciasComerciales WHERE idSolicitud='".$idSolicitud."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $param = array();

        $sql3 = " SELECT email FROM sis_usuarios WHERE id=( SELECT usuario FROM reg_altaRegistro WHERE id='".$idSolicitud."' ) ";
        $rs3  = $this->dbConn->ejecutaComando( $sql3 );
        $dest = $rs3->fields[ 'email' ];

        while( !$rs->EOF ) {
            $param[ 'email' ]          = $rs->fields[ 'correoParticipante' ].','.$dest;
            $param[ 'nombre' ]         = $rs->fields[ 'nombreParticipante' ] . " " . $rs->fields[ 'apellidoPaternoParticipante' ] . " " . $rs->fields[ 'apellidoMaternoParticipante' ];
            $param[ 'usuario' ]        = $rs->fields[ 'usuario' ];
            $param[ 'password' ]       = $rs->fields[ 'password' ];
            $param[ 'terminalID' ]     = $rs->fields[ 'terminalID' ];
            $param[ 'companyCode' ]    = $rs->fields[ 'companyCode' ];
            $param[ 'usuarioInpart' ]  = $rs->fields[ 'usuarioInpart' ];
            $param[ 'passwordInpart' ] = $rs->fields[ 'passwordInpart' ];
            $param[ 'usuarioCurso' ]   = $rs->fields[ 'usuarioCurso' ];
            $param[ 'passwordCurso' ]  = $rs->fields[ 'passwordCurso' ];
            $rs->MoveNext();
        }

        $sql2 = " SELECT nombreFiscal, rfcFiscal, nombreComercial, noClienteAudatex FROM reg_altaRegistro WHERE id='".$idSolicitud."' ";
        $rs2  = $this->dbConn->ejecutaComando( $sql2 );

        while( !$rs2->EOF ) {
            $param[ 'noCliente' ]       = $rs2->fields[ 'noClienteAudatex' ];
            $param[ 'razonSocial' ]     = $rs2->fields[ 'nombreFiscal' ];
            $param[ 'nombreComercial' ] = $rs2->fields[ 'nombreComercial' ];
            $param[ 'rfc' ]             = $rs2->fields[ 'rfcFiscal' ];
            $rs2->MoveNext();
        }

        return $param;
    }

    public function obtieneNombreComercial( $id ) {
        $sqlSol = " SELECT nombreComercial, alta FROM reg_altaRegistro WHERE id='".$id."' ";
        $rsSol  = $this->dbConn->ejecutaComando( $sqlSol );
        return array( $rsSol->fields[ 'nombreComercial' ] , $rsSol->fields[ 'alta' ] );
    }

    /*
     * Metodo que descarga digitalizados individuales
     */
    public function descargaDigitalizadoIndividual( $idRegistro , $campo ) {
        $nombre = '';
        switch( $campo ) {
            case 'certificado':$nombre='certificado';break;
            case 'comprobantePago':$nombre='comprobantePago';break;
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

    public function validacionDatosDocumentosCapacitacion( $params ) {
        $sql  = " UPDATE reg_datosReferenciasComerciales SET ";
        $sql .= " usuario='".$params[ 'capacitacion_Digitalizacion_DatosPieza_usuarioAudaclaims' ]."', ";
        $sql .= " password='".$params[ 'capacitacion_Digitalizacion_DatosPieza_contrasenaAudaclaims' ]."', ";
        $sql .= " usuarioInpart='".$params[ 'capacitacion_Digitalizacion_DatosPieza_usuarioInpart' ]."', ";
        $sql .= " passwordInpart='".$params[ 'capacitacion_Digitalizacion_DatosPieza_contrasenaInpart' ]."', ";
        $sql .= " terminalID='".$params[ 'capacitacion_Digitalizacion_DatosPieza_terminalID' ]."', ";
        $sql .= " companyCode='".$params[ 'capacitacion_Digitalizacion_DatosPieza_companyCode' ]."' ";
        $sql .= " WHERE idSolicitud='".$params[ 'capacitacion_Digitalizacion_DatosPieza_idReg' ]."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
                $participante = $this->obtieneDatosParticipanteCertificacion( $params[ 'capacitacion_Digitalizacion_DatosPieza_idReg' ] );
                /* Pieza de correo enviada al validar un certificado */
                $parametros1  = array (
                    'numeroCliente'  => $participante[ 'noCliente' ]     , 'razonSocial' => $participante[ 'razonSocial' ], 'nombreComercial' => $participante[ 'nombreComercial' ],
                    'rfc'            => $participante[ 'rfc' ]           , 'usuario'     => $participante[ 'usuario' ]    , 'password'        => $participante[ 'password' ],
                    'terminalID'     => $participante[ 'terminalID' ]    , 'companyCode' => $participante[ 'companyCode' ], 'usuarioInpart'   => $participante[ 'usuarioInpart' ],
                    'passwordInpart' => $participante[ 'passwordInpart' ], 'email'       => $participante[ 'email' ]
                );
                $imagenes1 = array (
                    './assets/attached/email_pieza2_comprobantePago.jpg' => array( 'img_1' , 'base64' , 'image/jpeg' ),
                    './assets/attached/email_pieza3_comprobantePago.png' => array( 'img_2' , 'base64' , 'image/png' ),
                    './assets/attached/email_pieza1_certificado.jpg'     => array( 'img_3' , 'base64' , 'image/jpeg' )
                );
                
                if( $participante[ 'usuarioInpart' ] != "" && $participante[ 'passwordInpart' ] != "" ) {
                    new Mail( 'Acceso Inpart' , $parametros1[ 'email' ] , 'piezaEnvioProveedorInpart' , $parametros1  );
                    $this->registroEnvio( $params[ 'capacitacion_Digitalizacion_DatosPieza_idReg' ] , 'inpart' , 'certificado' );
                } else {
                    new Mail( 'Capacitacion Certificado' , $parametros1[ 'email' ] , 'piezaEnvioCertificadoCurso' , $parametros1 , '' , '' , $imagenes1 );
                    $this->registroEnvio( $params[ 'capacitacion_Digitalizacion_DatosPieza_idReg' ] , 'acg' , 'certificado' );
                }
                
                return "OK";
            } else {
                return "NOOK";
        }
    }

    private function registroEnvio( $idSolicitud , $tipo , $proceso ) {
        $sql  = " INSERT INTO sis_fechaEnvios (idSolicitud, fecha, tipo, proceso) VALUES( '".$idSolicitud."','".date( 'Y:m:d H:i:s' )."' , '".$tipo."', '".$proceso."' ) ";
        $sql .= " ON DUPLICATE KEY UPDATE fecha='".date( 'Y:m:d H:i:s' )."', tipo='".$tipo."' ";
        $this->dbConn->ejecutaComando( $sql );
    }

    public function validacionDatosDocumentosCapacitacionComprobante( $params ) {
        $sql  = " UPDATE reg_datosReferenciasComerciales SET ";
        $sql .= " usuarioCurso='".$params[ 'capacitacion_Digitalizacion_DatosPieza_usuarioCurso' ]."', ";
        $sql .= " passwordCurso='".$params[ 'capacitacion_Digitalizacion_DatosPieza_contrasenaCurso' ]."' ";
        $sql .= " WHERE idSolicitud='".$params[ 'capacitacion_Digitalizacion_DatosPieza_idReg' ]."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );

        if( $rs ) {
                $participante = $this->obtieneDatosParticipanteCertificacion( $params[ 'capacitacion_Digitalizacion_DatosPieza_idReg' ] );
                /* Pieza de correo enviada al validar un comprobante de pago */
                $parametros = array (
                    'email'    => $participante[ 'email' ]       , 'nombre'   => $participante[ 'nombre' ],
                    'usuario'  => $participante[ 'usuarioCurso' ], 'password' => $participante[ 'passwordCurso' ]
                );
                $imagenes2 = array (
                    './assets/attached/email_pieza1_comprobantePago.jpg' => array( 'img_1' , 'base64' , 'image/jpeg' ),
                    './assets/attached/email_pieza2_comprobantePago.jpg' => array( 'img_2' , 'base64' , 'image/jpeg' ),
                    './assets/attached/email_pieza3_comprobantePago.png' => array( 'img_3' , 'base64' , 'image/png' )
                );
                new Mail( 'Capacitacion Audaclaims Gold' , $participante[ 'email' ] , 'piezaEnvioComprobantePago' , $parametros , '' , '' , $imagenes2 );
                $this->registroEnvio( $params[ 'capacitacion_Digitalizacion_DatosPieza_idReg' ] , 'acg' , 'comprobante' );
                return "OK";
            } else {
                return "NOOK";
        }
    }

    public function obtieneDatosPiezasCapacitacion( $idReg ) {
        $sql   = " SELECT usuario, password, usuarioInpart, passwordInpart, terminalID, companyCode, usuarioCurso, passwordCurso FROM reg_datosReferenciasComerciales WHERE idSolicitud='".$idReg."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $datos = array('usuario'=>'','password'=>'','usuarioInpart'=>'','passwordInpart'=>'','terminalID'=>'','companyCode'=>'','usuarioCurso'=>'','passwordCurso'=>'');

        while( !$rs->EOF ) {
            $datos[ 'usuario' ]        = $rs->fields[ 'usuario' ];
            $datos[ 'password' ]       = $rs->fields[ 'password' ];
            $datos[ 'usuarioInpart' ]  = $rs->fields[ 'usuarioInpart' ];
            $datos[ 'passwordInpart' ] = $rs->fields[ 'passwordInpart' ];
            $datos[ 'terminalID' ]     = $rs->fields[ 'terminalID' ];
            $datos[ 'companyCode' ]    = $rs->fields[ 'companyCode' ];
            $datos[ 'usuarioCurso' ]   = $rs->fields[ 'usuarioCurso' ];
            $datos[ 'passwordCurso' ]  = $rs->fields[ 'passwordCurso' ];
            $rs->MoveNext();
        }

        return $datos;
    }

}
