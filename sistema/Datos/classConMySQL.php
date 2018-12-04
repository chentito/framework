<?php
/*
 * Clase que controla la conexion a la base de datos
 *
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */

/*
 * Dependencias del sistema, Libreria ADODB
 */
include_once _DIRPATH_ . '/sistema/Librerias/adodb/adodb.inc.php';

class classConMySQL {
    /*
     * Parametros de conexion
     */
    private $host         = _DBHOST_;
    private $useri        = _DBUSR_;
    private $pwd          = _DBPASS_;
    public $dbase         = _DBNAME_;
    public $conexionmysql = null;
    public $affected      = 0;
    public $insertID      = 0;
    public $error         = '';
    public $errorCod      = '';

    /*
     * Constructor de clase
     */
    public function __construct() {
        $this->dbase = _DBNAME_;
    }

    /*
     * Instancia de la conexion
     */
    public function setConexion($conn) {
        $this->conexionmysql = $conn;
    }

    /*
     *
     */
    public function getConexion() {
        if($this->conexionmysql == null){
                $this->conectaMysql("HASH");
        }
        return $this->conexionmysql;
    }

    /*
     * Conexion a MySQL
     */
    public function conectaMysql( $fetchas="HASH" ){
        $db = &ADONewConnection( 'mysqli' );
        $db->Connect( $this->host , $this->useri , $this->pwd , $this->dbase );
        if($fetchas == "HASH"){
            $db->SetFetchMode( ADODB_FETCH_ASSOC );
        }
        $this->setConexion( $db );
    }

    /*
     * Ejecucion del comando SQL enviado
     */
    public function ejecutaComando( $lsQuery ){
        $rsd = $this->getConexion()->execute( $lsQuery );
        if( $rsd ){
            $this->affected = $this->getConexion()->Affected_Rows();
            $this->insertID = $this->getConexion()->Insert_ID();
        }else{
            $this->error    = $this->getConexion()->ErrorMsg();
            $this->errorCod = $this->getConexion()->ErrorNo();
        }

        return $rsd;
    }

    /*
     * Conteo de registros
     */
    public function num_regmysql( $lsQuery ) {
        $rsdDatos = $this->getConexion()->Execute( $lsQuery );
        $numreg = $rsdDatos->RecordCount();
        return $numreg;
    }

    /*
     * Tipo de estructura que se retorna en el recordset
     */
    public function fetchMode( $mode ) {
        $this->getConexion()->SetFetchMode( $mode );
    }

    /*
     * Desconexion de la instancia
     */
    public function desconecta() {
        $this->conexionmysql = null;
    }

}
