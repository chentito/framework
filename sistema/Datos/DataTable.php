<?php
/*
 * Clase que regresa la estructura de una consulta para ser mostrada
 * dentro de DataTable
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Agosto 2017
 */
if( !defined( "_SESIONACTIVA_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

class DataTable {

    /*
     * Almacenara la instancia de la conexion a la base de datos
     */
    private $dbCon = null;   

    /*
     * Consulta a ser ejecutada para obtener los datos a mostrar en DataTable
     */
    private $consulta = '';
    
    /*
     * Nombres campos JSON
     */
    private $nombreCamposJson = '';
    
    /*
     * Nombres campos BD
     */
    private $nombreCamposBD = '';
    
    /*
     * Estructura resultado a ser desplegada dentro de DataTable
     */
    public $datosDataTable = '';
    
    /*
     * Constructor de clase, recibe todos los parametros utiles para armar la
     * estructura de datos a mostrar dentro del grid
     */
    //public function __construct( $consulta , $nombreCamposJson=array() , $nombreCamposBD=array() ) {
    public function __construct( $consulta , $nombres=array() ) {
        new Sesion();
        $this->dbCon            = new classConMySQL();
        $this->consulta         = $consulta;
        $this->nombreCamposJson = $nombres;
        $this->nombreCamposBD   = $nombres;
        $this->cargaDatos();
    }
           
    private function cargaDatos() {        
        $this->ejecucionConsulta();
    }

    /*
     * Metodo que ejecuta el comando y obtiene la cantidad de registros a 
     * desplegar dentro del DataTable
     */
    private function ejecucionConsulta() {
        $this->datosDataTable = '';
        //if( count($this->nombreCamposJson) == count($this->nombreCamposBD) ){
            //Ambos arreglos son iguales, entonces podemos ejecutar consulta
            $i = 1;
            $sql = $this->consulta;
            $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
            $rsDatos  = $this->dbCon->ejecutaComando( $sql );
            $totalRegistros = $this->dbCon->num_regmysql($sql);
            $this->datosDataTable .= '{';
            $this->datosDataTable .= '"draw": 6,';
            $this->datosDataTable .=  '"recordsTotal": '.$totalRegistros.',';
            $this->datosDataTable .=  '"recordsFiltered": '.$totalRegistros.',';
            $this->datosDataTable .= '"data": [';
            while (!$rsDatos->EOF){            
                $this->datosDataTable .= '{';
                for($a = 0; $a < count($this->nombreCamposJson); $a ++){
                    $this->datosDataTable .= '"'.$this->nombreCamposJson[$a].'": "'.str_replace(array("\n","\r")," ",utf8_encode($rsDatos->fields[$this->nombreCamposBD[$a]])).'"';
                    if($a < (count($this->nombreCamposJson) - 1) ){ $this->datosDataTable .= ','; }
                }
                $this->datosDataTable .= '}';
                if($i < $totalRegistros){ $this->datosDataTable .= ','; }

                $i ++;
                $rsDatos->MoveNext();
            }
            $this->datosDataTable .= ']}';
        //}
    }
           
} //Fin clase