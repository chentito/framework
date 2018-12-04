<?php
/*
 * Clase que genera el template de la autorizacion de domiciliacion
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

require_once _DIRPATH_ . '/sistema/Librerias/pdfb/pdfb.php';

class AutorizacionDomiciliacion extends PDFB {

    /*
     * Atributos publicos
     */
    public $datos      = array();
    public $modoOutput = 'F';
    public $descarga   = true;

    public function generaAutorizacionDomiciliacion( $datos ) {
        $this->datos = $datos;
        $this->AliasNbPages();
        $this->SetAuthor( '.:: Audatex ::.' );
        $this->SetTitle( '.:: Audatex :: Referencias Comerciales ::.' );
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
        $nombrePDF = 'AutorizacionDomiciliacion.pdf';
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
        $this->MultiCell( 570 , 15 , $this->codificacion( 'AUTORIZACIÓN DE DOMICILIACION' ) , 1 , 'C' , 1 );

        // Datos de audatex
        $this->SetFillColor( 160 , 160 , 160 );
        $this->SetDrawColor( 235 , 130 , 15 );
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
        $this->MultiCell( 285 , 12 , $this->codificacion( 'CLIENTE (Nombre Fiscal)' ) , 0 , 'L' , 1 );
        $this->SetY( 235 );
        $this->SetX( 305 );
        $this->MultiCell( 285 , 12 , $this->codificacion( 'Nombre Comercial o Razón Social' ) , 0 , 'L' , 1 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( 247 );
        $this->SetX( 20 );
        $this->MultiCell( 285 , 10 , $this->codificacion( $this->datos[ 'cliente_nombreFiscal' ]  ) , 0 , 'L' , 0 );
        $this->SetY( 247 );
        $this->SetX( 305 );
        $this->MultiCell( 285 , 10 , $this->codificacion( $this->datos[ 'nombreComercial' ] ) , 0 , 'L' , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 10 );
        $this->SetY( 257 );
        $this->SetX( 20 );
        $this->MultiCell( 285 , 12 , $this->codificacion( 'RFC' ) , 0 , 'L' , 1 );
        $this->SetY( 257 );
        $this->SetX( 305 );
        $this->MultiCell( 285 , 12 , $this->codificacion( 'BANCO' ) , 0 , 'L' , 1 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( 269 );
        $this->SetX( 20 );
        $this->MultiCell( 285 , 10 , $this->codificacion( $this->datos[ 'rfc' ] ) , 0 , 'L' , 0 );
        $this->SetY( 269 );
        $this->SetX( 305 );
        $this->MultiCell( 285 , 10 , $this->codificacion( $this->datos[ 'banco' ] ) , 0 , 'L' , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 10 );
        $this->SetY( 279 );
        $this->SetX( 20 );
        $this->MultiCell( 285 , 12 , $this->codificacion( 'REPRESENTANTE O TITULAR DE LA CUENTA' ) , 0 , 'L' , 1 );
        $this->SetY( 279 );
        $this->SetX( 305 );
        $this->MultiCell( 160 , 12 , $this->codificacion( 'Terminación cuenta (4 dígitos)' ) , 0 , 'L' , 1 );
        $this->SetY( 279 );
        $this->SetX( 465 );
        $this->MultiCell( 125 , 12 , $this->codificacion( 'Sucursal' ) , 0 , 'L' , 1 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( 291 );
        $this->SetX( 20 );
        $this->MultiCell( 285 , 10 , $this->codificacion( $this->datos[ 'titularCuenta' ] ) , 0 , 'L' , 0 );
        $this->SetY( 291 );
        $this->SetX( 305 );
        $this->MultiCell( 160 , 10 , $this->codificacion( $this->datos[ 'terminacion' ] ) , 0 , 'L' , 0 );
        $this->SetY( 291 );
        $this->SetX( 465 );
        $this->MultiCell( 125 , 10 , $this->codificacion( $this->datos[ 'sucursal' ] ) , 0 , 'L' , 0 );
        $this->SetFont( 'Helvetica' , 'B' , 10 );
        $this->SetY( 301 );
        $this->SetX( 20 );
        $this->MultiCell( 125 , 12 , $this->codificacion( 'No. cuenta clabe:' ) , 0 , 'L' , 1 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->SetY( 301 );
        $this->SetX( 145 );
        $this->MultiCell( 445 , 12 , $this->codificacion( $this->datos[ 'clabe' ] ) , 0 , 'L' , 1 );

        // Texto autorizacion
        $this->SetY( $this->GetY() + 115 );
        $this->SetX( 40 );
        $autorizacion  = "Autorizo al Banco Receptor para que realice por mi cuenta los pagos por los conceptos ";
        $autorizacion .= "que en este documento se detallan, con cargo a la cuenta bancaria identificada por la CLABE. ";
        $autorizacion .= "Convengo que  el Banco Receptor queda liberado de toda responsabilidad si el Emisor ejercitara ";
        $autorizacion .= "acciones contra mí, derivados de la Ley o el Contrato que tengamos celebrado, y que el Banco ";
        $autorizacion .= "Receptor no estará obligado a efectuar ninguna reclamación al Emisor; ni a interponer recursos de ";
        $autorizacion .= "ninguna especie contra multas, sanciones o cobros indebidos, todo lo cual, en caso de ser necesario, ";
        $autorizacion .= "será ejecutado por mí. El Banco Receptor tampoco será responsable si el Emisor no entregara oportunamente ";
        $autorizacion .= "los comprobantes de servicios, o si los pagos se realizaran extemporáneamente por razones ajenas al Banco ";
        $autorizacion .= "Receptor, el cual tendrá absoluta libertad de cancelarme este servicio si en mi cuenta no existieran fondos ";
        $autorizacion .= "suficientes para cubrir uno o más de los pagos que le requiera el Emisor, o bien, ésta estuviera bloqueada por algún motivo.";
        $this->MultiCell( 530 , 11 , $this->codificacion( $autorizacion ) , 1 , 'J' , 0 );       

    }

    public function Header() {
        $this->formato();

    }

    public function Footer() {
        /* Aviso Confidencialidad */
        $aviso  = 'AVISO DE PRIVACIDAD.- En cumplimiento a lo establecido en la Ley Federal de Protección de datos ';
        $aviso .= 'Personales en Posesión de los Particulares, AUDATEX LTN, S. de R.L. de C.V., en su carácter de responsable, ';
        $aviso .= 'hace de su conocimiento por medio del presente Aviso de Privacidad, la adopción de las medidas administrativas, ';
        $aviso .= 'físicas y técnicas a su alcance, para asegurar la máxima protección en el tratamiento de sus datos personales, ';
        $aviso .= 'los cuales fueron proporcionados únicamente en virtud de la relación jurídica generada en el contrato suscrito ';
        $aviso .= 'con esta Sociedad. Asimismo se informa que la conservación y protección de los datos personales recabados, ';
        $aviso .= 'se llevará a cabo durante la vigencia del Contrato; al término del plazo indicado, AUDATEX LTN, S. de R.L. de C.V., ';
        $aviso .= 'procederá a su cancelación, previo bloqueo de los mismos para su futura supresión. Si es su deseo ejercer los derechos ';
        $aviso .= 'de acceso, rectificación, cancelación y oposición otorgados por la ley de la materia, respecto de sus datos personales, ';
        $aviso .= 'agradeceremos sea tan amable de presentar de manera personal en las oficinas de AUDATEX LTN, S. de R.L. de C.V., ';
        $aviso .= 'la solicitud respectiva para dichos efectos.';
        $this->SetY( -130 );
        $this->SetX( 20 );
        $this->MultiCell( 350 , 8 , $this->codificacion( $aviso ) , 0 , 'L' , 0 );

        /* Firmas */
        $this->SetDrawColor( 170 , 165 , 165 );
        $this->SetY( -130 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 100 , '' ,1 , 'J' , 0 );
        $this->SetY( -120 );
        $this->SetX( 380 );
        $this->MultiCell( 200 , 10 , $this->codificacion( 'Nombre del Representante(s) Legal(s) de la Empresa' ) , 0 , 'C' , 0 );
        $this->SetY( -100 );
        $this->SetX( 380 );
        $this->MultiCell( 50 , 10 , $this->codificacion( 'Solicitante:' ) , 0 , 'R' , 0 );
        $this->SetY( -100 );
        $this->SetX( 430 );
        $this->MultiCell( 150 , 10 , $this->codificacion( $this->datos[ 'representanteLegal' ] ) , 0 , 'CB' , 0 );
        $this->SetY( -70 );
        $this->SetX( 380 );
        $this->MultiCell( 50 , 10 , $this->codificacion( 'Firma:' ) , 0 , 'R' , 0 );
        $this->SetY( -70 );
        $this->SetX( 430 );
        $this->MultiCell( 150 , 10 , '________________________________' , 0 , 'C' , 0 );
        $this->SetY( -50 );
        $this->SetX( 380 );
        $this->MultiCell( 50 , 10 , $this->codificacion( 'Fecha:' ) , 0 , 'R' , 0 );
        $this->SetY( -50 );
        $this->SetX( 430 );
        $this->MultiCell( 150 , 10 , '________________________________' , 0 , 'C' , 0 );
        $this->SetY( -50 );
        $this->SetX( 430 );
        $this->MultiCell( 150 , 10 , $this->codificacion( $this->datos[ 'fechaAlta' ] ) , 0 , 'C' , 0 );
    }

    private function codificacion( $cadena ) {
        return mb_convert_encoding( utf8_decode( trim( $cadena ) ) , 'iso-8859-1', 'HTML-ENTITIES' );
    }

}
