<?php
/*
 * Clase que genera el template de la autorizacion de domiciliacion
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

require_once _DIRPATH_ . '/sistema/Librerias/pdfb/pdfb.php';

class Contratos extends PDFB {

    /*
     * Atributos publicos
     */
    public $datos      = array();
    public $modoOutput = 'F';
    public $descarga   = true;

    public function generaContrato( $datos ) {
        $this->datos = $datos;
        $this->AliasNbPages();
        $this->SetAuthor( '.:: Audatex ::.' );
        $this->SetTitle( '.:: Audatex :: Contratos ::.' );
        $this->SetFont( 'Helvetica' , '' , 8 );
        $this->SetDrawColor( 224 );
        $this->SetLineWidth( 1 );
        $pageCount = $this->setSourceFile( _DIRPATH_ . '/sistema/Librerias/pdfb/Audatex_Inpart.pdf' );
      
        for( $i = 1 ; $i <= $pageCount ; $i ++ ) {
            $pageCount = $this->setSourceFile( _DIRPATH_ . '/sistema/Librerias/pdfb/Audatex_Inpart.pdf' );
            $idPag = $this->ImportPage( $i );
            $this->AddPage();
            $this->useTemplate($idPag);
            
            $dia  = $this->datos[ 'dia' ];
            $mes  = $this->nombreMes( $this->datos[ 'mes' ] );
            $anio = $this->datos[ 'anio' ];
            $rl   = $this->datos[ 'representanteLegal' ];
            $nc   = $this->datos[ 'nombreComercial' ];
            
            if( $i == 1 ) {
                $this->SetY( 170 );
                $this->SetX( 55 );
                $this->Cell( 160 , 10 , $nc , 0 , 0 , 'C' , 0 );
                $this->SetY( 170 );
                $this->SetX( 396 );
                $this->Cell( 170 , 10 , $rl , 0 , 0 , 'C' , 0 );
            } elseif( $i == 3 ) {
                $this->SetY( 700 );
                $this->SetX( 120 );
                $this->Cell( 30 , 10 , $dia , 0 , 0 , 'C' , 0 );
                $this->SetY( 700 );
                $this->SetX( 215 );
                $this->Cell( 90 , 10 , $mes , 0 , 0 , 'C' , 0 );
                $this->SetY( 700 );
                $this->SetX( 320 );
                $this->Cell( 30 , 10 , $anio , 0 , 0 , 'C' , 0 );
            } elseif( $i == 4 ) {
                $this->SetY( 230 );
                $this->SetX( 70 );
                $this->Cell( 243 , 10 , $nc , 0 , 0 , 'C' , 0 );
                $this->SetY( 240 );
                $this->SetX( 70 );
                $this->Cell( 243 , 10 , $rl , 0 , 0 , 'C' , 0 );
            }
        }

        $miPDF = $this->guardaPDF();
        if( $this->modoOutput == "S" ) {
            return $miPDF;
        }
    }

    private function nombreMes( $mes ) {
        switch( $mes ){
            case '01':$nombre="Enero";break;
            case '02':$nombre="Febrero";break;
            case '03':$nombre="Marzo";break;
            case '04':$nombre="Abril";break;
            case '05':$nombre="Mayo";break;
            case '06':$nombre="Junio";break;
            case '07':$nombre="Julio";break;
            case '08':$nombre="Agosto";break;
            case '09':$nombre="Septiembre";break;
            case '10':$nombre="Octubre";break;
            case '11':$nombre="Noviembre";break;
            case '12':$nombre="Diciembre";break;
            default  :$nombre="";
        }
        return $nombre;
    }
    
    private function guardaPDF() {
        $nombrePDF = 'ContratoImpart.pdf';
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

    }

    public function Header() {
        $this->formato();

    }

    public function Footer() {
        
    }

    private function codificacion( $cadena ) {
        return mb_convert_encoding( utf8_decode( trim( $cadena ) ) , 'iso-8859-1', 'HTML-ENTITIES' );
    }

}
