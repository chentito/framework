<?php
/*
 * Clase que genera el template de las referencias comerciales
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

require_once _DIRPATH_ . '/sistema/Librerias/pdfb/pdfb.php';

class ReferenciasComerciales extends PDFB {

    /*
     * Atributos publicos
     */
    public $datos      = array();
    public $modoOutput = 'F';
    public $descarga   = true;

    public function generaRegerenciasComerciales( $d ) {
        $this->datos = $d;
        $this->AliasNbPages();
        $this->SetAuthor( '.:: Audatex ::.' );
        $this->SetTitle( '.:: Audatex :: Capacitacion Virtual ::.' );
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
        $nombrePDF = 'CapacitacionVirtual.pdf';
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
        $this->MultiCell( 570 , 15 , 'CAPACITACION VIRTUAL' , 1 , 'C' , 1 );

        $this->SetDrawColor( 235 , 130 , 15 );
        $this->SetTextColor( 0 , 0 , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 12 );
        $yCap = $this->GetY() + 20 ;
        $this->SetFont( 'Helvetica' , 'N' , 8 );
        $this->SetY( $yCap );
        $this->SetX( 20 );
        $this->MultiCell( 130 , 12 , $this->codificacion( 'Nombre completo del Participante:' ) , 0 , 'L' , 0 );
        $this->SetY( $yCap );
        $this->SetX( 150 );
        $this->MultiCell( 440 , 12 , $this->codificacion( $this->datos[ 'nombreParticipante' ] . " " . $this->datos[ 'aPaternoParticipante' ] . " " . $this->datos[ 'aMaternoParticipante' ]  ) , 0 , 'C' , 0 );
        $this->SetY( $yCap + 12 );
        $this->SetX( 150 );
        $this->MultiCell( 240 , 12 , $this->codificacion( 'NOMBRE(S)' ) , 'T' , 'C' , 0 );
        $this->SetY( $yCap + 12 );
        $this->SetX( 390 );
        $this->MultiCell( 100 , 12 , $this->codificacion( 'APELLIDO PATERNO' ) , 'T' , 'C' , 0 );
        $this->SetY( $yCap + 12 );
        $this->SetX( 490 );
        $this->MultiCell( 100 , 12 , $this->codificacion( 'APELLIDO MATERNO' ) , 'T' , 'C' , 0 );

        $this->SetFont( 'Helvetica' , 'N' , 8 );
        $this->SetY( $yCap + 40 );
        $this->SetX( 20 );
        $this->MultiCell( 90 , 12 , $this->codificacion( 'Correo del Participante:' ) , 0 , 'L' , 0 );
        $this->SetY( $yCap + 40 );
        $this->SetX( 110 );
        $this->MultiCell( 350 , 12 , $this->codificacion( $this->datos[ 'correoParticipante' ] ) , 0 , 'L' , 0 );
        $this->SetY( $yCap + 40 );
        $this->SetX( 110 );
        $this->MultiCell( 350 , 12 , '' , 'B' , 'L' , 0 );
        $this->SetY( $yCap + 40 );
        $this->SetX( 460 );
        $this->MultiCell( 30 , 12 , $this->codificacion( 'Firma:' ) , 0 , 'L' , 0 );
        $this->SetY( $yCap + 40 );
        $this->SetX( 490 );
        $this->MultiCell( 100 , 12 , '' , 'B' , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'N' , 8 );
        $this->SetY( $yCap + 70 );
        $this->SetX( 20 );
        $this->MultiCell( 40 , 12 , $this->codificacion( 'Usuario PSW:' ) , 0 , 'L' , 0 );
        $this->SetY( $yCap + 70 );
        $this->SetX( 60 );
        $this->MultiCell( 110 , 24 , $this->datos[ 'usuario' ] ."/" .$this->datos[ 'password' ], 1 , 'C' , 0 );

        $this->SetY( $yCap + 70 );
        $this->SetX( 230 );
        $this->MultiCell( 80 , 12 , $this->codificacion( 'Fecha de Solicitud:' ) , 0 , 'L' , 0 );
        $this->SetY( $yCap + 82 );
        $this->SetX( 230 );
        $this->MultiCell( 80 , 12 , $this->codificacion( 'Fecha de Entrega:' ) , 0 , 'L' , 0 );
        $this->SetY( $yCap + 70 );
        $this->SetX( 310 );
        $this->MultiCell( 110 , 12 , $this->codificacion( $this->datos[ 'fechaAlta' ] ) , 1 , 'L' , 0 );
        $this->SetY( $yCap + 82 );
        $this->SetX( 310 );
        $this->MultiCell( 110 , 12 , '' , 1 , 'L' , 0 );

        $this->SetY( $yCap + 70 );
        $this->SetX( 480 );
        $this->MultiCell( 110 , 12 , $this->codificacion( 'Factura:' ) , 0 , 'L' , 0 );
        $this->SetY( $yCap + 82 );
        $this->SetX( 480 );
        $this->MultiCell( 110 , 12 , '' , 1 , 'L' , 0 );
        
        $this->SetDrawColor( 235 , 130 , 15 );
        $this->SetTextColor( 0 , 0 , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 14 );

        $texto  = "El curso tiene un precio de $ 1,682.00 pesos VA Incluido y dicho curso es para certificar a una persona. ";
        $texto .= "Se puede tomar el curso desde cualquier equipo que cumpla con los requerimientos mínimos y la plataforma está disponible las 24 horas. ";
        $texto .= "No contamos con cursos presenciales, únicamente virtuales.";
        $this->SetY( $yCap + 200 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( $texto ) , 0 , 'J' , 0 );
        
        $this->SetY( $yCap + 400 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( 'Datos Bancarios' ) , 0 , 'J' , 0 );
        $this->SetFont( 'Helvetica' , 'N' , 14 );
        
        $this->SetY( $yCap + 414 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( 'Beneficiario: AUDATEX LTN, S. DE R.L.  DE C.V.' ) , 0 , 'J' , 0 );
        
        $this->SetY( $yCap + 428 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( 'Banco: BBVA  Bancomer, S.A.' ) , 0 , 'J' , 0 );
        
        $this->SetY( $yCap + 442 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( 'CONVENIO CIE: 000855758' ) , 0 , 'J' , 0 );
        
        $this->SetY( $yCap + 456 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( 'Cuenta Concentradora: 0100918768' ) , 0 , 'J' , 0 );
        
        $this->SetY( $yCap + 470 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( 'REFERENCIA  BANCARIA:' . $this->datos[ 'referencia' ] ) , 0 , 'J' , 0 );
        
        $this->SetY( $yCap + 490 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( 'CLABE PARA TRANSFERENCIAS' ) , 0 , 'J' , 0 );
        
        $this->SetY( $yCap + 504 );
        $this->SetX( 100 );
        $this->MultiCell( 415 , 14 , $this->codificacion( '012 180 00100918768 2' ) , 0 , 'J' , 0 );

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
