<?php
include_once _DIRPATH_.'/sistema/Librerias/adodb/adodb.inc.php';

class classConMySQL{

    private $host         = _DBHOST_;
    private $useri        = _DBUSR_;
    private $pwd          = _DBPASS_;
    public $dbase         = _DBNAME_;
    public $conexionmysql = null;

    public function __construct(){
        $this->dbase = _DBNAME_;        
    }

    public function setConexion($conn){
        $this->conexionmysql = $conn;
    }

    public function getConexion(){
        if($this->conexionmysql == null){
                $this->conectaMysql("HASH");
        }
        return $this->conexionmysql;
    }

    public function conectaMysql( $fetchas="HASH" ){
        $db = &ADONewConnection('mysql');
        $db->Connect($this->host, $this->useri, $this->pwd, $this->dbase); 
        if($fetchas == "HASH"){       
            $db->SetFetchMode(ADODB_FETCH_ASSOC);
        }
        $this->setConexion($db);
    }

    public function traedatosmysql($lsQuery){
        $rsd=$this->getConexion()->execute($lsQuery);
        return $rsd;
    }

    public function desconecta(){
        $this->conexionmysql = null;
    }

    public function num_regmysql($lsQuery){
        $rsdDatos=$this->getConexion()->Execute($lsQuery);
        $numreg = $rsdDatos->RecordCount();	        
        return $numreg;
    }
    
}
