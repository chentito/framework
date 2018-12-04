<?php
/*
 * Clase que genera el template de la autorizacion para solicitar reporte de credito
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

require_once _DIRPATH_ . '/sistema/Librerias/pdfb/pdfb.php';

class AutorizacionReporteCredito extends PDFB {

    /*
     * Atributos publicos
     */
    public $datos      = array();
    public $modoOutput = 'F';
    public $descarga   = true;

    public function generaAutorizacionReporteCredito( $d ) {

        $this->datos = $d;

        $this->AliasNbPages();
        $this->SetAuthor( '.:: Audatex ::.' );
        $this->SetTitle( '.:: Audatex :: Autorizacion Reporte de Credito ::.' );
        $this->SetFont( 'Helvetica' , '' , 8 );
        $this->SetDrawColor( 224 );
        $this->SetLineWidth( 1 );
        $this->setSourceFile( _DIRPATH_ . '/sistema/Librerias/pdfb/default.pdf' );
        $tplidx = $this->ImportPage( 1 );
        $this->AddPage();
        $this->useTemplate( $tplidx );
        $this->SetAutoPageBreak( true , 20 );

        $miPDF = $this->guardaPDF();
        if( $this->modoOutput == "S" ) {
            return $miPDF;
        }
    }

    private function guardaPDF() {
        $nombrePDF = 'AutorizacionReporteCredito.pdf';
        $pdf = $this->Output( $nombrePDF , $this->modoOutput );

        if( $this->modoOutput == 'F' ) {
            $fp = fopen( $nombrePDF , 'r' );
            fread( $fp , filesize( $nombrePDF ) );
            fclose( $fp );
        }

        if( $this->descarga ) {
            header( 'Content-disposition: attachment; filename=' . $nombrePDF );
            header( 'Content-Type: application/pdf' );
            readfile( $nombrePDF );
        }

        if( $this->modoOutput == 'S' ) {
            return $pdf;
        }
        @unlink( $nombrePDF );
    }

    private function formato() {

        /* Logotipo */
        $this->Image( _DIRPATH_ . '/assets/imgs/img_logo.jpg' , 20 , 20 , 0 , 0 );

        /* Titulo */
        $this->SetDrawColor( 235 , 130 , 15  );
        $this->SetFillColor( 235 , 130 , 15  );
        $this->SetTextColor( 255 , 255 , 255 );
        $this->SetFont( 'Helvetica' , 'B' , 14 );
        $this->SetY( 90 );
        $this->SetX( 20 );
        $this->MultiCell( 570 , 15 , $this->codificacion( 'AUTORIZACIÓN DE REPORTE DE CRÉDITO' ) , 1 , 'C' , 1 );

        // Datos de audatex
        //$this->SetDrawColor( 235 , 130 , 15 );
        $this->SetFillColor( 160 , 160 , 160 );
        $this->SetTextColor( 0 , 0 , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 12 );
        $this->SetY( 130 );
        $this->SetX( 20 );
        $this->MultiCell( 570 , 15 , $this->codificacion( 'DATOS AUDATEX' ) , 0 , 'C' , 1 );
        $this->SetFont( 'Helvetica' , 'B' , 10 );
        $this->SetY( 145 );
        $this->SetX( 20 );
        $this->MultiCell( 470 , 12 , $this->codificacion( 'EMISOR' ) , 0 , 'L' , 1 );
        $this->SetY( 145 );
        $this->SetX( 490 );
        $this->MultiCell( 100 , 12 , $this->codificacion( 'RFC' ) , 0 , 'L' , 1 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( 157 );
        $this->SetX( 20 );
        $this->MultiCell( 470 , 10 , $this->codificacion( $this->datos[ 'audatex' ][ 'razonSocial' ] ) , 0 , 'L' , 0 );
        $this->SetY( 157 );
        $this->SetX( 490 );
        $this->MultiCell( 100 , 10 , $this->codificacion( $this->datos[ 'audatex' ][ 'rfc' ] ) , 0 , 'L' , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 10 );
        $this->SetY( 167 );
        $this->SetX( 20 );
        $this->MultiCell( 125 , 12 , $this->codificacion( 'DATOS DEL EMISOR' ) , 0 , 'L' , 1 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( 179 );
        $this->SetX( 20 );
        $this->MultiCell( 570 , 10 , $this->codificacion( $this->datos[ 'audatex' ][ 'direccion' ] ) , 0 , 'L' , 0 );

        // Datos del cliente
        $this->SetDrawColor( 235 , 130 , 15 );
        $this->SetFont( 'Helvetica' , 'B' , 12 );
        $this->SetY( 220 );
        $this->SetX( 20 );
        $this->MultiCell( 570 , 15 , $this->codificacion( 'DATOS CLIENTE' ) , 0 , 'C' , 1 );
        $this->SetFont( 'Helvetica' , 'B' , 10 );
        $this->SetY( 235 );
        $this->SetX( 20 );
        $this->MultiCell( 470 , 12 , $this->codificacion( 'CLIENTE (Nombre Fiscal)' ) , 0 , 'L' , 1 );
        $this->SetY( 235 );
        $this->SetX( 490 );
        $this->MultiCell( 100 , 12 , $this->codificacion( 'RFC' ) , 0 , 'L' , 1 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( 247 );
        $this->SetX( 20 );
        $this->MultiCell( 285 , 10 , $this->codificacion( $this->datos[ 'cliente' ] ) , 0 , 'L' , 0 );
        $this->SetY( 247 );
        $this->SetX( 305 );
        $this->MultiCell( 285 , 10 , $this->codificacion( $this->datos[ 'rfc' ] ) , 0 , 'L' , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 10 );
        $this->SetY( 257 );
        $this->SetX( 20 );
        $this->MultiCell( 285 , 12 , $this->codificacion( 'Domicilio y Teléfono:' ) , 0 , 'L' , 1 );
        $this->SetY( 257 );
        $this->SetX( 305 );
        $this->MultiCell( 285 , 12 , $this->codificacion( 'Fecha de solicitud:' ) , 0 , 'L' , 1 );
        
        $textoAutorizacion  = "Por este conducto autorizo expresamente a AUDATEX, S. DE R.L. DE C.V., ";
        $textoAutorizacion .= "para que por conducto de sus funcionarios facultados lleve a cabo las ";
        $textoAutorizacion .= "investigaciones sobre mi comportamiento crediticio en las Sociedades de ";
        $textoAutorizacion .= "Información Crediticia que se estime conveniente. \nAsí mismo, declaro que ";
        $textoAutorizacion .= "conozco la naturaleza y alcance de la información que se solicitará, del uso ";
        $textoAutorizacion .= "que AUDATEX, S. DE R.L. DE C.V., hará de tal información y de que ésta podrá ";
        $textoAutorizacion .= "realizar consultas periódicas de mi historial crediticio, consintiendo que esta ";
        $textoAutorizacion .= "autorización se encuentre vigente por un periodo de 3 años contados a partir de la ";
        $textoAutorizacion .= "fecha de su expedición y en todo caso durante el tiempo que mantengamos relación jurídica. ";
        $textoAutorizacion .= "\nEstoy consciente y acepto que este documento quede bajo propiedad de ";
        $textoAutorizacion .= "AUDATEX, S. DE R.L. DE C.V., para efectos de control y cumplimiento del artículo 28 de la ";
        $textoAutorizacion .= "Ley para Regular las Sociedades de Información Crediticia.";
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( $this->GetY() + 100 );
        $this->SetX( 40 );
        $this->MultiCell( 530 , 11 , $this->codificacion( $textoAutorizacion ) , 1 , 'J' , 0 );
    }

    public function Header() {
        $this->formato();

    }

    public function Footer() {
    
        /* Firmas */
        $this->SetDrawColor( 170 , 165 , 165 );
        $this->SetY( -130 );
        $this->SetX( 20 );
        $this->MultiCell( 200 , 100 , '' ,1 , 'J' , 0 );
        $this->SetY( -120 );
        $this->SetX( 20 );
        $this->MultiCell( 200 , 10 , $this->codificacion( 'Nombre del Representante(s) Legal(s) de la Empresa' ) , 0 , 'C' , 0 );
        $this->SetY( -100 );
        $this->SetX( 20 );
        $this->MultiCell( 50 , 10 , $this->codificacion( 'Solicitante:' ) , 0 , 'R' , 0 );
        $this->SetY( -100 );
        $this->SetX( 70 );
        $this->MultiCell( 150 , 10 , $this->codificacion( $this->datos[ 'solicitante' ] ) , 0 , 'B' , 0 );
        $this->SetY( -70 );
        $this->SetX( 20 );
        $this->MultiCell( 50 , 10 , $this->codificacion( 'Firma:' ) , 0 , 'R' , 0 );
        $this->SetY( -70 );
        $this->SetX( 70 );
        $this->MultiCell( 150 , 10 , '________________________________' , 0 , 'C' , 0 );
        $this->SetY( -50 );
        $this->SetX( 20 );
        $this->MultiCell( 50 , 10 , $this->codificacion( 'Fecha:' ) , 0 , 'R' , 0 );
        $this->SetY( -50 );
        $this->SetX( 70 );
        $this->MultiCell( 150 , 10 , '________________________________' , 0 , 'B' , 0 );
        $this->SetY( -50 );
        $this->SetX( 70 );
        $this->MultiCell( 150 , 10 , $this->codificacion( $this->datos[ 'fechaAlta' ] ) , 0 , 'C' , 0 );
        
        /* Uso */
        $this->SetY( -160 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 150 , '' ,1 , 'J' , 0 );
        $this->SetY( -150 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 10 , $this->codificacion( 'Para uso exclusivo de la empresa que efectúa la consulta' ) , 0 , 'C' , 0 );
        $this->SetY( -130 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 10 , $this->codificacion( 'Fecha de consulta' ) , 0 , 'C' , 0 );
        $this->SetY( -115 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 10 , $this->codificacion( $this->datos[ 'fechaConsulta' ] ), 0 , 'CB' , 0 );
        $this->SetY( -90 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 10 , $this->codificacion( 'Folio consulta BC' ) , 0 , 'C' , 0 );
        $this->SetY( -75 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 10 , $this->codificacion( $this->datos[ 'folioConsulta' ] ) , 0 , 'CB' , 0 );
        $this->SetY( -50 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 10 , $this->codificacion( 'IMPORTANTE:  Es obligatorio para la empresa que consulta anotar la fecha y folio de la captura proporcionada por el Sistema de Buró de Crédito.' ) , 0 , 'C' , 0 );

    }

    private function codificacion( $cadena ) {
        return mb_convert_encoding( utf8_decode( trim( $cadena ) ) , 'iso-8859-1', 'HTML-ENTITIES' );
    }

}
