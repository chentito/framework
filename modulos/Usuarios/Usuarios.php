<?php
/**
 * Controlador del modulo de usuarios
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/Template.php';

/*
 * Funcionalidades del Modulo
 */
include_once _DIRPATH_ . '/modulos/Usuarios/modelo/MUsuarios.php';

class Usuarios extends Template {
    
    /*
     * Contiene la funcionalidad del modelo
     */
    private $mUsuarios = null;

    /*
     * Constructor de la clase
     */
    public function __construct(){
        parent::__construct();
        $this->mUsuarios = new MUsuarios();
    }

    public function index(){
        $this->muestraDato( 'usuario' , 'Carlitos' );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    public function hola(){
        echo "hola";
    }
    
    public function listado(){
        $usrs = $this->mUsuarios->listado();
        $this->muestraDato( 'usuarios' , $usrs );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    public function edita( $param ){
        $datos = $this->mUsuarios->edita( $param['idUsuario'] );
        $this->muestraDato( 'nombre' , $datos['nombre'] );
        $this->muestraDato( 'edad'   , $datos['edad'] );
        $this->muestraDato( 'status' , $datos['status'] );
        $this->muestraDato( 'id'     , $datos['id'] );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

}
