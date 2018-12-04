<?php
/*
 * Modelo para el funcionamiento de home, el cual procesa pantalla principal del sistema
 * y el proceso para el logeo y deslogeo de usuarios
 *
 * @Framework
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
include_once _DIRPATH_ . '/sistema/Librerias/Mail/Mail.php';
include_once _DIRPATH_ . '/sistema/Registros/Acciones.php';

class MHome {
    /*
     * Interaccion con base de datos
     */
    protected $dbConn = null;

    /*
     * Manejador de sesion
     */
    protected $sesion = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbConn = new classConMySQL();
    }

    /*
     * Metodo que verifica los datos de acceso al sistema
     */
    public function verificaAcceso( $usuario , $contrasena , $recordar , $tabla ) {
        $sql = " SELECT * FROM sistema_" . $tabla . " WHERE usuario='" . trim( $usuario )
             . "' AND contrasena='" . trim( md5( $contrasena ) ) . "' AND status='1' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        $msj = '';

        if( !$rs->EOF ) {
            while( !$rs->EOF ) {
                if( $rs->fields['status'] == 0 ) {
                    $msj = _ACCESOSISTEMA_ERROR_VIGENCIA_;
                } else {
                    $this->sesion = new Sesion();
                    $_SESSION['tipoAcceso']      = $tabla;
                    $_SESSION['sesion']          = true;
                    $_SESSION['usuario']         = $usuario;
                    $_SESSION['idUsuario']       = $rs->fields['id'];
                    $_SESSION['nombreUsuario']   = $rs->fields['nombre'];
                    $_SESSION['perfil']          = $rs->fields['perfil'];
                    $_SESSION['procesID']        = rand(1111111,9999999);
                    new Acciones( _ACCIONACCESOSISTEMA_ );
                    
                    if( $recordar == "true" ) {
                        $year = time() + 31536000;
                        setcookie( 'datosAcceso_remember' , session_id() , $year , '/' );
                    } elseif( $recordar == "false" ) {
                        $pasado = time() - 100;
                        setcookie( 'datosAcceso_remember' , session_id() , $pasado );
                    }
                    $msj = true;
                }
                $rs->MoveNext();
            }
            return $msj;
        }else{
            return _ACCESOSISTEMA_ERROR_CREDENCIALES_;
        }
    }

    /*
     * Metodo que renueva las credenciales de un acceso olvidado
     */
    public function recuperaAcceso( $email ){
        $sql = " SELECT * FROM sis_usuarios WHERE email='" . $email . "' AND status='1' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );

        if( ! $rs->EOF ){
            $password = $this->nuevoPassword();
            $sql = " UPDATE sis_usuarios SET contrasena='" . md5( $password ) . "' WHERE email='".$email."' AND status='1' ";
            $rs2 = $this->dbConn->ejecutaComando( $sql );
            if( $rs2 ){
                $envio = new Mail( "Recupera datos de acceso" , $email , 'actualizacionContrasena' , array( 'nombre'=>$rs->fields['nombre'] , 'usuario'=>$rs->fields['usuario'] , 'passwd'=>$password ) );
                return _EXITORECUPERAPASSWD_;
            }else{
                return _ERRORACTUALIZAPASSWD_;
            }
        }else{
            return _INFOUSRRECUPERAPASSWD_;
        }
    }

    /*
     * Metodo que genera el acceso a un usuario de captura
     */
    public function solicitaAcceso( $params ) {
        if( $this->disponibilidad( $params[ 'email' ] ) == '0' ) {
                return $this->enviaDatosAccesoUsuarioCaptura( $params );
            } else {
                return "La cuenta proporcionada ya se encuentra en uso.";
        }
    }

    /*
     * Verifica disponibilidad
     */
    private function disponibilidad( $email ) {
        $sql = " SELECT COUNT(*) AS t FROM sis_usuarios WHERE email='".$email."' AND perfil=2 AND status=1 ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 't' ];
    }

    private function enviaDatosAccesoUsuarioCaptura( $params ) {
        if( $this->altaUsuarioAccesoCaptura( $params ) ) {
            $envio = new Mail( 'Acceso Plataforma Provisioning' , $params[ 'email' ] , 'enviaDatosAccesoCaptura' , $params );
        }
        return $envio->estadoEnvio;
    }

    private function altaUsuarioAccesoCaptura( $params ) {
        $sql  = " INSERT INTO sis_usuarios (nombre, usuario, contrasena, email, edad, perfil, fechaAlta, status) ";
        $sql .= " VALUES ( '" . addslashes( $params[ 'nombre' ] ) . "' , '" . addslashes( $params[ 'usuario' ] ) . "' , '" . md5( trim( $params[ 'contrasena' ] ) ) . "', ";
        $sql .= " '".$params[ 'email' ]."', 0, 2, '" . date( 'Y-m-d H:i:s' ) . "', 1) ";
        return $this->dbConn->ejecutaComando( $sql );
    }

    /*
     * Metodo que finaliza la sesion activa
     */
    public function cierraSesion() {
        new Sesion();
        $accion = $_SESSION['accion'];
        new Acciones( _ACCIONABANDONASISTEMA_ );
        $this->registraSalida();
        session_unset();
        session_destroy();
        header( "Location:" . _URL_ . '/Home/' . $accion . '/'  );
    }

    /*
     * Metodo que registra los inicios de sesion
     */
    public function registraAcceso() {
        $sql  = " INSERT INTO sis_accesos(usuario, perfil, navegador, ip, fechaEntrada, procid,sessionid) VALUES ";
        $sql .= " ('".$_SESSION['usuario']."','".$_SESSION['perfil']."','".$_SERVER['HTTP_USER_AGENT']."','".$_SERVER['REMOTE_ADDR']."','".date("Y-m-d H:i:s")."','".$_SESSION['procesID']."','".  session_id()."') ";
        $this->dbConn->ejecutaComando( $sql );
    }

    /*
     * Metodo que registra la salida del sistema
     */
    public function registraSalida(){
        $sql = " UPDATE sis_accesos SET fechaSalida='".date("Y-m-d H:i:s")."' WHERE procid='".$_SESSION['procesID']."' ";
        $this->dbConn->ejecutaComando( $sql );
    }

    /*
     * Regenera la contrasena para recuperar el acceso de un usuario
     */
    public function nuevoPassword(){
        $caracteres = array( 0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z' );
        $password = '';
        for( $i = 0 ; $i < 10 ; $i ++ ){
            $password .= $caracteres[ rand(1,39) ];
        }
        return $password;
    }

}
