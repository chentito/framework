<?php
/*
 * Archivo que lleva el control de la sesiones a nivel de base de datos
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';

class Sesion {

    protected $dbConn = null;

    function __construct () {
        $this->dbConn = new classConMySQL();
        session_set_save_handler(
            array( $this , "on_session_start"   ),
            array( $this , "on_session_end"     ),
            array( $this , "on_session_read"    ),
            array( $this , "on_session_write"   ),
            array( $this , "on_session_destroy" ),
            array( $this , "on_session_gc"      )
        );
        @session_start();
    }

    function on_session_start( $save_path , $session_name ){}

    function on_session_end(){}

    function on_session_read( $key ){
        $stmt  = " SELECT session_data FROM sistema_sesiones WHERE session_id ='".addslashes( $key )."' ";
        $stmt .= " AND session_expiration > unix_timestamp(now())";
        $sth   = $this->dbConn->ejecutaComando( $stmt );

        if($sth){
            if(strlen($sth->fields['session_data']) > 5){
                    return($sth->fields['session_data']);
                }else{
                    $this->dbConn->ejecutaComando(" DELETE FROM sistema_sesiones WHERE session_id = '".addslashes($key)."' ");
            }
        }else{
            $this->dbConn->ejecutaComando(" DELETE FROM sistema_sesiones WHERE session_id = '".addslashes($key)."' ");
            $this->on_session_destroy( $key );
            ?>
            <script>location.replace('/home/login/');</script>
            <?php
        }
    }
    
    function on_session_write( $key , $value ){
        $tiempoExpiraSesion = _SESSIONTIME_ . " hour";
        
        $this->dbConn->ejecutaComando("DELETE FROM sistema_sesiones WHERE session_expiration < unix_timestamp(now())");
        $val = addslashes($value);
        $insert_stmt  = " INSERT INTO sistema_sesiones VALUES('".addslashes($key)."', ";
        $insert_stmt .= " '$val',unix_timestamp(date_add(now(), interval ".$tiempoExpiraSesion."))) ";

        $update_stmt  = "UPDATE sistema_sesiones SET session_data ='".$val."', ";
        $update_stmt .= "session_expiration = unix_timestamp(date_add(now(), interval ".$tiempoExpiraSesion.")) ";
        $update_stmt .= "WHERE session_id ='".addslashes( $key )."'";

        $this->dbConn->ejecutaComando( $insert_stmt );

        if( strlen($val) > 0){
            $this->dbConn->ejecutaComando($insert_stmt);
        }else{
            $this->on_session_destroy($key);            
            ?>
            <script>location.replace('/home/login/');</script>
            <?php
        }

        $err = $this->dbConn->error;

        if ($err != ""){
            $this->dbConn->ejecutaComando($update_stmt);
        }else{}
    }

    function on_session_destroy( $key ) {
        $this->dbConn->ejecutaComando("DELETE FROM sistema_sesiones WHERE session_id = '".addslashes( $key )."'");
    }

    function on_session_gc( $max_lifetime ){
        $this->dbConn->ejecutaComando("DELETE FROM sistema_sesiones WHERE session_expiration < unix_timestamp(now())");
    }

}

?>
