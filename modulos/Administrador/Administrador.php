<?php/**
 * Controlador del modulo administrativo
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/Template.php';
include_once _DIRPATH_ . '/sistema/Interfaz/JQDataTable.php';
include_once _DIRPATH_ . '/sistema/Interfaz/MenuXML.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

/*
 * Funcionalidades del Modulo
 */
include_once _DIRPATH_ . '/modulos/Administrador/modelo/MAdministrador.php';

class Administrador extends Template {
    
    var $modelo = null;
    
    public function __construct() {
        new Sesion();
        parent::__construct();
        $this->modelo = new MAdministrador();
    }

    public function envioCredenciales() {
        $this->muestraDato( 'scripts'             , array() );
        $this->muestraDato( 'estilos'             , array() );
        $this->muestraDato( 'breadcrumb'          , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Administrativo' , 'Envio de Accesos' ) );
        $this->muestraDato( 'contenidoSeccion'    , "bla bla bla" );
        $this->muestraDato( 'cierraL'             , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }



}


