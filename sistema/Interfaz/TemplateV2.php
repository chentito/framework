<?php
/*
 * Clase que tiene la funcionalidad de templates
 * 
 * @Framework
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */

if( !defined( "_SESIONACTIVA_" ) ){ die( "No se permite el acceso directo a este arcchivo" ); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Librerias/Smarty/Smarty.class.php';

class TemplateV2 extends Smarty{
    
    /*
     * Constructor de la clase
     */
    public function __construct(){}

    /*
     * Metodo que genera la interfaz grafica con todos sus elementos
     */
    public static function generaVista( $path , $parametros ) {
        $template = new Smarty();
        foreach ( $parametros AS $ll => $v ) {
            $template->assign( $ll , $v );
        }
        $template->display( _DIRPATH_ . '/vistas/' . $path );
    }

}
