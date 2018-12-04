<?php
/*
 * Modelo para el funcionamiento de usuarios, regla de negocio e interaccion con repositorio
 * de datos.
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

class MUsuarios {
    
    /*
     * Interaccion con base de datos
     */
    protected $dbConn = null;
    
    /*
     * Constructor del modelo de usuarios
     */
    public function __construct() {
        $this->dbConn = new classConMySQL();
    }

    /*
     * Metodo que consulta y regresa el listado de empleados
     */
    public function listado(){
        $sql = " SELECT * FROM usuarios ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        $usrs = array();
        while( !$rs->EOF ){
            $usrs[] = array( 'id' => $rs->fields['id'] , 'nombre' => utf8_encode( $rs->fields['nombre'] ) , 'edad' => $rs->fields['edad'] , 'estatus' => $rs->fields['status'] );
            $rs->MoveNext();
        }
        return $usrs;
    }

    /*
     * Metodo para la edicion de datos de un empleado dado
     */
    public function edita( $idUsr ){
        $sql   = " SELECT * FROM usuarios WHERE id='".$idUsr."' ";
        $rs    = $this->dbConn->ejecutaComando( $sql );
        $datos = array();
        while( !$rs->EOF ){
            $datos['id']      = $rs->fields['id'];
            $datos['nombre']  = utf8_encode( $rs->fields['nombre'] );
            $datos['edad']    = $rs->fields['edad'];
            $datos['status'] = $rs->fields['status'];
            $rs->MoveNext();
        }
        return $datos;
    }

}
