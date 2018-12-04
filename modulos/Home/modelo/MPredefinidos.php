<?php
/*
 * Modelo para la carga de valores predefinidos
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Junio 2018
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

class MPredefinidos {
    
    /*
     * Interaccion con base de datos
     */
    protected $dbConn = null;
    
    /*
     * Contiene el valor del predefinido
     */
    public $valor = "";

    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbConn = new classConMySQL();
    }
    
    public function cargaPredefinidosConstantes() {
        $sql = " SELECT clave, valor FROM sis_predefinidos  ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        
        while( !$rs->EOF ) {
            define( $rs->fields[ 'clave' ] , $rs->fields[ 'valor' ] );
            $rs->MoveNext();
        }
        
    }
    
    public function cargaPredefinidoIndividual( $id ) {
        $sql = " SELECT valor FROM sis_predefinidos WHERE id = '".$id."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        return $rs->fields[ 'valor' ];
    }
    
}
