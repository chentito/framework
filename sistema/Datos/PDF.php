<?php
/*
 * Clase que genera un archivo PDF a partir de una consulta almacenada en cierta
 * variable de sesion
 * 
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
require_once _DIRPATH_ . '/sistema/Librerias/pdfb/pdfb.php';

class PDF extends PDFB {

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
    private $datosPDF = array();
    
    /*
     * Constructor de la clase
     */
    public function __construct() {
        new Sesion();
        $this->dbCon = new classConMySQL();
        $this->consulta = $_SESSION['consultaExporta'];
        $this->arregloDatos();
    }

    /*
     * Funcionalidad en el header del archivo PDF
     */
    function Header(){}

    /*
     * Funcionalidad en el footer del archivo PDF
     */
    function Footer(){}

    /*
     * Tabla principal que contiene los datos a mostrar dentro del archivo
     */
    function FancyTable( $header , $data , $footer ){
        $this->SetY( 40 );
        $this->SetFillColor( 116 , 116 , 120 );
        $this->SetTextColor( 255 );
        $this->SetDrawColor( 116 , 116 , 120 );
        $this->SetLineWidth( .3 );
        $this->SetFont( '' , 'B' );
        $w = array( 178 , 178 , 178 , 178 );

        for($i=0;$i<count($header);$i++){
            $this->Cell($w[$i],20,$header[$i],1,0,'C',1);
        }

        $this->Ln();
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = false;
        $registros = count( $data );

        for( $j = 0 ; $j < $registros ; $j++ ){
            for( $i=0 ; $i<=3 ; $i++ ){
                @$this->Cell( $w[$i] , 10 , $data[$j][$i] , 'LR' , 0 , 'R' , $fill );
            }
            $fill =! $fill;
            $this->Ln();
        }

        for($i=0;$i<count($footer);$i++){
            $this->Cell($w[$i],20,$footer[$i],1,0,'C',1);
        }

        $this->Cell(array_sum($w),0,'','T');
    }
    
    
}

