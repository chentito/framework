<?php
/**
 * Controlador del modulo de registro, pantalla principal del sistema
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Modulo
 */
include_once _DIRPATH_ . '/modulos/Home/modelo/MPredefinidos.php';

class Predefinidos {
    
    var $modelo = null;

    /*
     * Constructor de la clase
     */
    public function __construct(){
        new Sesion();
        $this->modelo = new MPredefinidos();
    }

    public function valorPredefinido( $id ) {
        return $this->modelo->cargaPredefinidoIndividual( $id );
    }
    
}
