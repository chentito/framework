<?php
/*
 * Modelo para todas las funcionalidades de la clase utiles, reglas de negocio
 * asi como conexion a la base de datos.
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Enero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';

class MUtiles {

    /*
     * Atributo que contiene la instancia a la conexion a la base de datos
     */
    protected $dbCon = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbCon = new classConMySQL();
    }
    
    /*
     * Metodo que genera un combo dinamico a partir de una consulta, el primer campo de 
     * la consulta sera tomado como valor y el segundo como texto
     */
    public function generaComboDinamico( $nombreCombo , $consulta ) {
        $this->dbCon->fetchMode( ADODB_FETCH_NUM );
        $rs = $this->dbCon->ejecutaComando( $consulta );
        $html = '<select name="'.$nombreCombo.'" id="'.$nombreCombo.'">';
        $html .= '<option value="">-</option>';
        while( !$rs->EOF ) {
            $html .= '<option value="'.$rs->fields[0].'">'.($rs->fields[1]).'</values>';
            $rs->MoveNext();
        }
        $html .= '</select>';
        return $html;
    }
    
    /*
     * Metodo que genera un combo dinamigo para un grid, el primer campo de
     * la consulta sera tomado como valor y el segundo como texto
     */
    public function generaComboDinamicoGrid( $consulta ) {
        $this->dbCon->fetchMode( ADODB_FETCH_NUM );
        $rs = $this->dbCon->ejecutaComando( $consulta );
        $html = '-:-;';
        while( !$rs->EOF ) {
            $html .= $rs->fields[0].':'.$rs->fields[1].';';
            $rs->MoveNext();
        }
        return trim( $html , ';' );
    }
 
    
    /* **********************************************
     * 
     *        INICIA FUNCIONALIDAD SEPOMEX
     * 
     ************************************************/

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
            $datos[$contador]['estado']    = utf8_encode( $rs->fields['estado'] );
            $datos[$contador]['municipio'] = utf8_encode( $rs->fields['municipio'] );
            $datos[$contador]['ciudad']    = utf8_encode( $rs->fields['ciudad'] );
            $datos[$contador]['colonia']   = utf8_encode( $rs->fields['asentamiento'] );
            $contador ++;
            $rs->MoveNext();
        }
        
        if( $contador == 0 ){
            $datos = false;
        }
        
        return $datos;
    }
    
    /*
     * Metodo que genera un combo html que contiene todos los estados
     */
    public function sepomexEstados( $idCombo ) {
        return $this->generaComboDinamico( $idCombo , " SELECT DISTINCT estado,estado FROM sis_sepomex ORDER BY estado ASC " );
    }
    
    /*
     * Metodo que genera un combo html que contiene todos los
     * municipios de un estado en particular
     */
    public function sepomexMunicipios( $idCombo , $estado ) {
        return $this->generaComboDinamico( $idCombo , " SELECT DISTINCT municipio,municipio FROM sis_sepomex WHERE estado='".$estado."' ORDER BY municipio ASC  " );
    }

    /*
     * Metodo que genera elementos html desde los datos
     * encontrados en la tabla sepomex
     */
    public function elementosSepomex( $cp ) {
        $sql = " SELECT * FROM sis_sepomex WHERE cp='".$cp."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $elementos = array();
        $colonias  = array();
        
        while( !$rs->EOF ) {
            $colonias[]               = utf8_encode( $rs->fields[ 'asentamiento' ] );
            $elementos[ 'municipio' ] = utf8_encode( $rs->fields[ 'municipio' ] );
            $elementos[ 'estado' ]    = utf8_encode( $rs->fields[ 'estado' ] );
            $elementos[ 'ciudad' ]    = utf8_encode( $rs->fields[ 'ciudad' ] );
            $rs->MoveNext();
        }
        $elementos[ 'colonia' ] = $colonias;
        return json_encode( $elementos );
    }

}
