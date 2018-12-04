<?php
/*
 * Clase que genera un archivo CSV a partir de una consulta almacenada en cierta
 * variable de sesion
 * 
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

class Excel {

    /*
     * Instancia para la conexion a la base de datos
     */
    protected $dbCon = null;

    /*
     * Consulta a ejecutar para obtener los datos
     */
    private $consulta = '';

    /*
     * Datos a desplegar en el archivo
     */
    private $datosExcel = array();

    /*
     * Constructor de la clase
     */
    public function __construct( $consulta="" ) {
        new Sesion();
        $this->dbCon = new classConMySQL();
        $this->consulta = ( ( $consulta == "" ) ? $_SESSION['consultaExporta'] : $consulta );
        $this->arregloDatos();
    }

    /*
     * Recorre el recordset de los datos a deplegar en el archivo
     */
    public function arregloDatos() {
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rs = $this->dbCon->ejecutaComando( $this->consulta );
        if( strlen( $_SESSION['tituloreporte'] ) > 0 ) {
            $this->datosExcel[] = array( $_SESSION['tituloreporte'] );
        }
        $cont = 0;
        
        foreach( $rs AS $renglon ){
            $t = array();
            foreach( $renglon AS $ll => $r ){
                if( $cont == 0 ){
                    $t[] = $ll;
                }else{
                    $t[] = $r;
                }                
            }            
            $cont ++;
            $this->datosExcel[] = $t;
        }
    }

    /*
     * Genera reporte descargable
     */
    public function generaReporte() {
        $path          = _TEMPDOWN_ . '/';
        $nombreArchivo = 'reporteExcel.csv';
        $fp            = fopen( $path . $nombreArchivo , 'w' );

        foreach( $this->datosExcel as $campos ) {
            fputcsv( $fp , $campos );
        }

        fclose( $fp );
        header( 'Content-Description: File Transfer' );
        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment; filename=' . $nombreArchivo );
        header( 'Content-Transfer-Encoding: binary' );
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Pragma: public' );
        header( 'Content-Length:' . filesize( $path . $nombreArchivo ) );
        readfile( $path . $nombreArchivo );
        unlink( $path . $nombreArchivo );
    }
    

}

