<?php
/*
 * Clase que despliega todo el contenido de algun template en particular
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Librerias/Smarty/Smarty.class.php';

class Template extends Smarty {

    /*
     * Constructor de la clase
     */
    public function __construct(){
        parent::__construct();
    }

    /*
     * Mostrar datos en el template a traves de una variable
     */
    public function muestraDato( $variable , $valor ){
        parent::assign( $variable , $valor );
    }

    /*
     * Carga del archivo tpl correspondiente en caso de ser uno personalizado
     */
    public function cargaGUI( $ruta ) {
        parent::display( _DIRPATH_ . '/vistas/' . $ruta );
    }

    /*
     * Carga del archivo tpl correspondiente en caso de ser uno personalizado
     */
    public function cargaGUIDefault() {
        parent::display( _DIRPATH_ . '/vistas/Default/default.tpl' );
    }

    /*
     * Uso opcional de breadcrumb
     */
    public function usa_breadcrumb() {
        
    }

    /*
     * Uso opcional de footer (Util para cerrar dialog cargando) 
     */
    public function usa_footer(){
        
    }

}
