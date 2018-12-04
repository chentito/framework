<?php
/*
 * Funcionalidad que regresa la infromacion del listado de sepomex a partir 
 * del codigo postal
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Enero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';

/*
 * Funcionalidades de los modulos
 */
include_once _DIRPATH_ . '/modulos/Utiles/Utiles.php';

class MSepomex {

    /*
     * Variable que contiene la instancia a la base de datos
     */
    protected $dbCon = null;
    
    /*
     * Variable que contiene la instancia de las funcionalidades
     * utiles del sistema
     */
    protected $utiles = null;
    
    /*
     * Codigo Postal
     */
    public $cp = 00000;
    
    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbCon = new classConMySQL();
        $this->utiles = new Utiles();
    }
    
    /*
     * Metodo que regresa todos los campos relacionados al 
     * codigo postal
     */
    public function sepomexDatosCP( $cp ) {
        $sql = " SELECT * FROM sis_sepomex WHERE cp='".$cp."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
                
        $contador = 0;
        while (!$rs->EOF){
            $datos[$contador]['estado']    = $rs->fields['estado'];
            $datos[$contador]['municipio'] = $rs->fields['municipio'];
            $datos[$contador]['ciudad'] = $rs->fields['ciudad'];
            $datos[$contador]['colonia'] = $rs->fields['asentamiento'];
            $contador ++;
            $rs->MoveNext();
        }
        
        return $datos;
    }
    
    /*
     * Metodo que genera un combo html que contiene todos los estados
     */
    public function sepomexEstados( $idCombo ) {
        return $this->utiles->generaComboDinamico( $idCombo , " SELECT DISTINCT estado,estado FROM sis_sepomex ORDER BY estado ASC " );
    }
    
    /*
     * Metodo que genera un combo html que contiene todos los
     * municipios de un estado en particular
     */
    public function sepomexMunicipios( $idCombo , $estado ) {
        return $this->utiles->generaComboDinamico( $idCombo , " SELECT DISTINCT municipio,municipio FROM sis_sepomex WHERE estado='".$estado."' ORDER BY municipio ASC  " );
    }
    
}

