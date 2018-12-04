<?php
/*
 * Clase que contiene el funcionamiento para la configuracion de la funcionalidad de
 * envio de alertas a traves de correos electronicos
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Junio 2015
 */
include_once _DIRPATH_ . '/lib/classConMySQL.php';

class SMTPConf {
    
    protected $dbConn = null;
    
    public function __construct() {
        $this->dbConn = new classConMySQL();
    }
    
    /* Obtiene los datos SMTP del administrador */
    public function obtieneSMTPAdmin(){
        $sql = " SELECT * FROM ct_mailing WHERE prefix='admin' ";
        $rs  = $this->dbConn->traedatosmysql( $sql );
        $response = array();
        
        if( $rs && !$rs->EOF ){
            $response['smtp']      = $rs->fields['smtp'];
            $response['usuario']   = $rs->fields['usuario'];
            $response['contrasena']= $rs->fields['contrasena'];
            $response['puerto']    = $rs->fields['puerto'];
            $response['seguridad'] = $rs->fields['seguridad'];
            $response['de']        = $rs->fields['de'];
            $response['nombreDe']  = $rs->fields['nombreDe'];
            $response['copia']     = $rs->fields['copia'];
            $rs->MoveNext();
        }
        
        return json_encode( $response );
    }
    
    /* Guarda los datos SMTP del administrador */
    public function guardaSMTPAdmin(){
        $sql  = " UPDATE ct_mailing SET smtp='".$_POST['server']."', usuario='".$_POST['usuario']."', contrasena='".$_POST['contra']."', puerto='".$_POST['puerto']."', ";
        $sql .= " seguridad='".$_POST['sec']."', de='".$_POST['from']."', nombreDe='".$_POST['fromN']."', copia='".$_POST['copy']."' WHERE prefix='admin' ";
        $rs   = $this->dbConn->traedatosmysql( $sql );
        
        if( $rs ){
                return true;
            }else{
                return false;
        }
        
    }
    
}
