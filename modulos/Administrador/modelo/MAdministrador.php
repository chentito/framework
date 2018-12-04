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

class MAdministrador {

    private $dbConn = null;
    
    public function __construct() {
        $this->dbConn = new classConMySQL();
    }

    
    
}
