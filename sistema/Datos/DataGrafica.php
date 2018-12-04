<?php
/*
 * Clase que obtiene los datos a graficar a partir de una consulta
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

class DataGrafica {
    /*
     * Almacenara la instancia de la conexion a la base de datos
     */
    private $dbCon = null;

    /*
     * Atributo en el que se almacena la consulta a ejecutar para obtener los
     * datos a mostrar en la grafica
     */
    private $consulta = '';

    /*
     * Atributo que contiene el tipo de grafica a mostrar que define la estructura
     * de datos necesaria
     */
    private $tipo = '';

    /*
     * Constructor de la clase
     */
    public function __construct( $consulta , $tipo ) {
        new Sesion();
        $this->dbCon = new classConMySQL();

        $this->consulta = $consulta;
        $this->tipo     = $tipo;

        if( $tipo == 'pie' ){
            $this->datosSeriesGraficaPastel();
        }
    }

    /*
     * Metodo que recibe la consulta para 
     */
    public function datosSeriesGraficaPastel() {
        $series = '';
        $sql = $this->consulta;
        $rs  = $this->dbCon->ejecutaComando( $sql );        
        while( !$rs->EOF ){
            $series .= "{ name: '".$rs->fields['muestra1']."', y: ".$rs->fields['muestra2']." },";
            $rs->MoveNext();
        }       
        return trim( $series , ';' );
    }

}

