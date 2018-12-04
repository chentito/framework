<?php
/*
 * Clase que generara un documento personalizado en formato PDF
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Marzo 2017
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

class DocumentoPDF extends PDFB {

    /*
     * Atributo que contiene la instancia de conexion a la base de datos
     */
    protected $dbCon = null;

    /*
     * Atributo que contiene el nombre del archivo
     */
    public $nombrePDF = 'default.pdf';

    /*
     * Atrubuto que contiene la ruta de donde sera creado el archivo a descargar
     */
    public $ruta = '';

    /*
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct( "p" , "pt" , "letter" );
        $this->AliasNbPages();
        $this->SetAuthor( 'Universe Promerc' );
        $this->SetTitle( 'Documento generado a traves de Universe Promerc' );
        $this->SetFont( 'Helvetica' , '' , 9 );
        $this->SetDrawColor( 224 );
        $this->SetLineWidth( 1 );
        $this->setSourceFile( _DIRPATH_ . '/sistema/Archivos/background/FormatoPromerc.pdf' );
        $this->AddPage();
        $tplidx = $this->ImportPage( 1 );
        $this->useTemplate( $tplidx );
    }

    /*
     * Descarga documento generado
     */
    public function descargaDocumento() {
        $this->Output( $this->nombrePDF );
        @header( 'Content-disposition: attachment; filename=' . $this->nombrePDF );
        @header( 'Content-Type: application/pdf' );
        //readfile( $this->ruta . $this->nombrePDF );
    }

}
