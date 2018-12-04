<?php
/*
 * Despachador el cual hara el redireccionamiento correspondiente de acuerdo al
 * controlador y a la accion solicitada a traves de la peticion http
 * 
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este archivo");}

class Despachador {

    /*
     * Controlador solicitado desde la peticion http
     */
    private $controlador = "";

    /*
     * Accion solicitada desde la peticion http
     */
    private $accion = "";

    /*
     * Query string enviado desde la peticion http
     */
    private $qString = "";

    /*
     * Mensaje de error en el redireccionamiento, cuando la peticion no
     * es encontrada o no es valida
     */
    private $errMsg = "";

    /*
     * Contrictor de la clase
     */
    public function __construct() {
        $this->controlador = isset( $_GET['controlador'] ) ? ucfirst( $_GET['controlador'] )       : 'Home' ;
        $this->accion      = isset( $_GET['accion'] )      ? $_GET['accion']                       : 'index' ;
        $this->qString     = isset( $_GET['qstring'] )     ? $this->parametros( $_GET['qstring'] ) : '' ;
    }

    /*
     * Metodo que ejecuta y envia al navegador el resultado de la peticion solicitada.
     */
    public function ejecuta(){
        try{
                $this->solicitud();
            } catch( Exception $e ) {
                print $e->getMessage();
        }
    }

    /*
     * Metodo que transforma el query string en un arreglo llave/valor
     */
    private function parametros( $qString ) {
        $parametros = array();
        $qStringR   = str_replace( '&' , '|' , $qString );
        $partes     = explode( '|' , $qStringR );

        foreach ( $partes AS $parte ) {
            $param = explode( '=' , $parte );
            foreach( $param AS $p ) {
                $parametros[ $param[0] ] = utf8_decode( $param[1] );
            }
        }

        return $parametros;
    }

    /*
     * Verifica que la solicitud exista en los modulos de desarrollo
     */
    private function solicitud(){
        if ( ! file_exists( './modulos/' . $this->controlador . '/' . $this->controlador . '.php' ) ) {
            throw new Exception( _DESPACHADORCONTROLADORDESCONOCIDO_ , 404 );
        } else {
            include_once './modulos/' . $this->controlador . '/' . $this->controlador . '.php';
            $objeto = new $this->controlador();
            if( ! method_exists( $objeto , $this->accion  ) ) {
                throw new Exception( _DEPACHADORACCIONDESCONOCIDA_ , 404 );
            } else {
                call_user_func( array( $objeto , $this->accion ) , $this->qString );
            }
        }
    }

}
