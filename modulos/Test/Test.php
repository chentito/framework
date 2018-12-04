<?php
/**
 * Controlador de pruebas para implementacion de acciones de acuerdo a las 
 * solicitudes del usuario
 *
 * @Framework
 * @Autor Carlos Reyes
 * @Fecha Agosto 2017
 */
if( !defined( "_SESIONACTIVA_" ) ){ die( "No se permite el acceso directo a este script" ); }

/*
 * Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/TemplateV2.php';
include_once _DIRPATH_ . '/sistema/Interfaz/JQDataTable.php';
include_once _DIRPATH_ . '/sistema/Interfaz/MenuXML.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

/*
 * Modulo
 */
include_once _DIRPATH_ . '/modulos/Registro/modelo/MRegistro.php';

class Test {

    private $modelo = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
    }

    /*
     * Carga vista test
     */
    public function vistaTest() {
        $parametros = array(
            'scripts' => array( '/vistas/Registro/js/altaRegistro.js' ),
            'estilos' => array( '/vistas/Registro/js/altaRegistro.js' ),
            'cierraL' => true
        );
        Template::generaVista( __CLASS__ . '/' . __FUNCTION__ . '.tpl' , $parametros );
    }



}
