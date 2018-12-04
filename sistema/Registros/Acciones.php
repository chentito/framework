<?php
/*
 * Clase que registra todas las acciones realizadas por los diferentes usuarios
 * durante el tiempo que se encuentran logeados en el sistema
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
require_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';

class Acciones {

    /*
     * Instancia de conexion a base de datos
     */
    protected $dbCon = null;

    /*
     * Constructor de la clase
     */
    public function __construct( $accion ) {
        new Sesion();
        $this->dbCon = new classConMySQL();
        $sql  = " INSERT INTO sis_acciones ( usuario , procid , fecha , accion , status ) ";
        $sql .= " VALUES ( '" . $_SESSION['usuario'] . "' , '" . $_SESSION['procesID'] . "' , '" . date( 'Y-m-d H:i:s' ) . "' , '" . $accion . "' , '1' ) ";
        if( !empty( $accion ) ){ $rs   = $this->dbCon->ejecutaComando( $sql ); }
        else { $rs = false; }

        if( $rs ){ return true; }
        else{ return false; }
    }

}

