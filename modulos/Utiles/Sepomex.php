<?php
/*
 * Funcionalidad que regresa la infromacion del listado de sepomex a partir 
 * del codigo postal
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Enero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del modulo
 */
include_once _DIRPATH_ . '/modulos/Utiles/modelo/MSepomex.php';

class Sepomex {
    
    /*
     * Variable que contiene la instancia del modelo
     */
    protected $modelo = null;
    
    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->modelo = new MSepomex();
    }
    
    /*
     * Metodo que obtiene un combo con el listado de estados
     */
    public function sepomexEstados( $idCombo ){
        return $this->modelo->sepomexEstados( $idCombo );
    }
    
    /*
     * Metodo que obtiene un combo con todos los municipios de acuerdo
     * al estado proporcionado
     */
    public function sepomexMunicipios( $idCombo , $estado ) {
        return $this->modelo->sepomexMunicipios( $idCombo , $estado );
    }
    
    /*
     * Metodo que retorna estado, localidad y municipio asociados
     * a un codigo postal
     */
    public function sepomexDatosCP( $cp ) {
        return $this->modelo->sepomexDatosCP( $cp );
    }
    
}

