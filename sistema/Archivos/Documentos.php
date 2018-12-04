<?php
/*
 * Clase que generara todo tipo de documentos descargables del sistema
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';

/*
 * Dependencias del sistema, creacion de documentos PDF
 */
include_once _DIRPATH_ . '/sistema/Librerias/pdfb/pdfb.php';

class Documentos {

    /*
     * Atributo que contiene la instancia de conexion a la base de datos
     */
    protected $dbCon = null;

    /*
     * Atributo que contiene la instancia de clase 
     */
    protected $pdf = null;
    
    /*
     * Atributo que contiene en un arreglo los datos dinamicos a incluir
     * en cada documento, de acuerdo a su configuracion
     */
    public $datos = array();
    
    /*
     * Atributo que contiene la clave del documento que se va a generar
     */
    public $clave = '';
    
    /*
     * Atributo que contiene las palabras claves que requiere el documento
     * en particular
     */
    protected $palabrasClaves = array();

    /*
     * Atributo que contiene el texto completo que se incluira en el
     * documento a descargar
     */
    protected $texto = '';
    
    /*
     * Atributo que contiene el titulo del documento a descargar
     */
    protected $titulo = '';

    /*
     * Atributo que contiene el nombre del documento generado
     */
    protected $nDoc = '';

    /*
     * Atributo que contiene una bandera booleana para saber si ejecutara codigo PHP o string de texto
     */
    protected $bandera = '';

    /*
     * Atributo que contiene el nombre de la imagen generada
     */
    public $nombreImagen = "";

    /*
     * Constructor de la clase
     */
    public function __construct( $claveDoc , $datos, $bandera = false ) {
        $this->dbCon = new classConMySQL();
        $this->pdf   = new PDFB("p","pt","letter");
        $this->clave = $claveDoc;
        $this->datos = $datos;
	$this->bandera = $bandera;
        $this->generaInformacion();
    }

    /*
     * Metodo que hace la consulta a la bd para obtener todos los datos
     * referentes al texto a incluir en el documento descargable
     */
    protected function generaInformacion() {
        $sql = " SELECT * FROM sis_textos WHERE clave='".$this->clave."' AND status=1 ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        
        while( !$rs->EOF ){
            $this->texto          = $rs->fields['texto'];
            $this->palabrasClaves = explode( ',' , $rs->fields['palabrasClaves'] );
            $this->titulo         = $rs->fields['titulo'];
            $rs->MoveNext();
        }

        $this->generaTexto();
    }

    /*
     * Arma el texto remplazando las palabras claves con los datos
     * enviados a la clase
     */
    protected function generaTexto() {
        //$this->texto = str_replace( $this->palabrasClaves , $this->datos , $this->texto );
        foreach( $this->palabrasClaves AS $clave ) {
            $this->texto = str_replace( $clave , $this->datos[ $clave ] , $this->texto);
        } 
        $this->generaPDFDocumento();
    }

    /*
     * Arma las caracteristicas iniciales del documento a crear
     */
    protected function generaPDFDocumento() {
        $this->pdf->AliasNbPages();
        $this->pdf->SetAuthor( 'Universe Promerc' );
        $this->pdf->SetTitle( 'Documento generado a traves de Universe Promerc' );
        $this->pdf->SetFont( 'Helvetica' , '' , 9 );
        $this->pdf->SetDrawColor( 224 );
        $this->pdf->SetLineWidth( 1 );
        $this->pdf->setSourceFile( _DIRPATH_ . '/sistema/Librerias/pdfb/back.pdf' );
        $tplidx = $this->pdf->ImportPage( 1 );
        $this->pdf->AddPage();
        $this->pdf->useTemplate( $tplidx );
    }

    /*
     * Crea el documento PDF 
     */
    protected function generaPDF() {
        /* Posiciona el texto */
        $this->pdf->SetY( 100 );
        $this->pdf->SetX( 20 );
        $this->pdf->Ln();
        $this->pdf->SetFont( '' , 'B', 13 );
        $this->pdf->Cell( '570' , '20' , $this->titulo, 0 , 0 , 'C' , 0 );
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->SetFont( '' , 'N', 10 );
	if($this->bandera){
            //ejecutamos codigo PHP guardado en la BD
            eval($this->texto);
        }else{
            //Ejecutamos string de texto guardado en la BD
            $this->pdf->MultiCell( '570' , '10' , $this->texto , 0 , 'J' , 0 );
        }		

        /* Posiciona el texto */

        $this->nDoc = $this->clave . '_' . date('ymdhis') . '.pdf';
        $this->pdf->Output( $this->nDoc );
    }

    /*
     * Genera la descarga del archivo PDF
     */
    public function descargaDocumento() {
        /* Genera la estructura PDF */
        $this->generaPDF();

        @header( 'Content-disposition: attachment; filename=' . $this->nDoc );
        @header( 'Content-Type: application/pdf' );
        readfile( $this->nDoc );
    }

    /*
     * Metodo que genera una imagen dentro de la estructura del PDF y lo
     * posiciona de acuerdo a cordenadas dadas
     */
    public function generaImagen( $file , $x , $y , $w , $h , $tipo ){
        if( empty ( $file ) || !file_exists( _TEMPUPLOAD_ . '/' . $file ) ){
            $file = _DIRPATH_ . "/assets/imgs/imagenNoDisponible.jpg";
            $this->pdf->Image( $file , $x , $y , 150 , 180 , 'JPG' );
        }else{
            $file = _TEMPUPLOAD_ . '/' . $file;
            $this->pdf->Image( $file , $x , $y , $w , $h , $tipo );
            @unlink ( $file );
        }
    }

}

