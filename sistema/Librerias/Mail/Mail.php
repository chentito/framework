<?php
/*
 * Clase que hace el envio de correos electronicos a traves de la libreria PHP Mailer
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Mayo 2015
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
require_once _DIRPATH_ . '/sistema/Librerias/Mail/class.smtp.php';
require_once _DIRPATH_ . '/sistema/Librerias/Mail/class.phpmailer.php';

class Mail{

    public $to          = '';
    public $estadoEnvio = false;
    protected $dbCon    = null;
    protected $mailer   = null;
    private $smtpCon    = array();

    public function __construct( $subject , $to , $pieza , $datosPieza , $test=false , $params=array() , $imagenes=array() , $adjuntos=array() ){
        $this->dbCon       = new classConMySQL();
        $this->mailer      = new PHPMailer();
        $this->estadoEnvio = $this->enviaPiezaMail($subject , $to , $pieza , $datosPieza , $test , $params , $imagenes , $adjuntos );
    }

    /* Envio del correo electronico */
    public function enviaPiezaMail( $subject , $to , $pieza , $datosPieza , $test , $params , $imagenes , $adjuntos ){
        $this->to = $to;
        if( $this->smtpDatosConexion() ) {
            /* Datos conexion */
            $this->mailer->isSMTP();
            //$this->mailer->isMail();
            $this->mailer->Host       = ( $test ) ? $params['sistema_configSMTP_servidor'] : $this->smtpCon['host'];
            $this->mailer->Port       = ( $test ) ? $params['sistema_configSMTP_puerto']   : $this->smtpCon['port'];
            $this->mailer->Username   = ( $test ) ? $params['sistema_configSMTP_usuario']  : $this->smtpCon['usr'];
            $this->mailer->Password   = ( $test ) ? $params['sistema_configSMTP_passwd']   : $this->smtpCon['passwd'];
            $this->mailer->From       = ( $test ) ? $params['sistema_configSMTP_de']       : $this->smtpCon['from'];
            $this->mailer->FromName   = ( $test ) ? $params['sistema_configSMTP_deNombre'] : $this->smtpCon['fromName'];
            $this->mailer->SMTPAuth   = true;
            $this->mailer->SMTPSecure = ( ( $this->smtpCon['sec'] == 'no' ) ? '' : $this->smtpCon['sec'] );
            $this->mailer->SMTPOptions = array(
                'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true )
            );
            /* Destinatarios */
            $destinatarios = explode( ',' , ( ( $test ) ? $params['sistema_configSMTP_enviarPruebaA'] : $this->to ) );
            foreach( $destinatarios AS $destinatario ){
                if( $this->esCorreoValido( $destinatario ) ){$this->mailer->addAddress( $destinatario );}
            }
            $copias = explode( ',' , $this->smtpCon['copy'] );
            foreach( $copias AS $copia ) {
                if( $this->esCorreoValido( $copia ) ) { $this->mailer->addCC( $copia ); }
            }
            /* Pieza de correo */
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $this->obtienePiezaCorreo( $pieza , $datosPieza );
            $this->mailer->AltBody = $subject;
            $this->mailer->isHTML( true );
            if( !empty( $imagenes ) ) {
                foreach( $imagenes AS $ruta => $id ) {
                    $this->mailer->AddEmbeddedImage( $ruta , $id[ 0 ] , $id[ 0 ] , $id[ 1 ] , $id[ 2 ] );
                }
            }
            /* Documentos adjuntos en el correo */
            if( !empty( $adjuntos ) ) {
                foreach(  $adjuntos AS $ruta => $nombre ) {
                    $this->mailer->addAttachment( $ruta , $nombre );
                }
            }

            //$this->mailer->SMTPDebug = 2;
            if( !$this->mailer->send() ) {
                    trigger_error( _ERRORENVIOCORREOELECTRONICO_ . $this->mailer->ErrorInfo );
                    return _ERRORENVIOCORREOELECTRONICO_;
                }else{
                    trigger_error( _EXITOENVIOCORREOELETRONICO_ );
                    return true;
            }
        }else{
            trigger_error( _ERRORCONFIGURACIONSMTP_ );
            return _ERRORCONFIGURACIONSMTP_;
        }
    }

    /* Obtiene los datos de la cuenta SMTP */
    private function smtpDatosConexion() {
        $sql = " SELECT * FROM sis_mailing WHERE id='1' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        if( !$rs->EOF ){
            $this->smtpCon['host']     = $rs->fields['smtp'];
            $this->smtpCon['port']     = $rs->fields['puerto'];
            $this->smtpCon['sec']      = $rs->fields['seguridad'];
            $this->smtpCon['usr']      = $rs->fields['usuario'];
            $this->smtpCon['passwd']   = $rs->fields['contrasena'];
            $this->smtpCon['from']     = $rs->fields['de'];
            $this->smtpCon['fromName'] = $rs->fields['nombreDe'];
            $this->smtpCon['copy']     = $rs->fields['copia'];
            return true;
        }else{
            return false;
        }
    }

    private function obtienePiezaCorreo( $id , $datos ){
        $sql  = " SELECT * FROM sis_mailingTemplates WHERE idty='".$id."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        $busca = array();
        $reemplaza = array();
        $html = '';

        if( !$rs->EOF ){$html = $rs->fields["template"];}

        foreach( $datos AS $k => $v ){
            $busca[]     = '{$'.$k.'}';
            $reemplaza[] = $v;
        }

        return str_replace( $busca , $reemplaza , $html );
    }

    /* Verifica la estructura de las cuentas de correo electronico destino */
    private function esCorreoValido( $cuenta ){
        if( preg_match( '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/' , $cuenta ) ) {
            return true;
        }else{
            return false;
        }
    }

}
