<?php
/*
 * Clase que genera el template de la solicitud de registro con la informacion del prospecto
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Agosto 2017
 */

require_once _DIRPATH_ . '/sistema/Librerias/pdfb/pdfb.php';

class SolicitudRegistro extends PDFB {

    /*
     * Atributos publicos
     */
    public $datos      = array();
    public $modoOutput = 'F';
    public $descarga   = true;

    public function generaSolicitudRegistro( $datosReg ) {
        $datos[ 'codigoCliente' ]                = ( empty( $datos ) ) ? "" : $datosReg[ "noCta" ];
        $datos[ 'fechaAlta' ]                    = ( empty( $datos ) ) ? "" : $datosReg[ "fechaAlta" ];
        $datos[ 'nombreComercial' ]              = ( empty( $datos ) ) ? "" : $datosReg[ "nombreComercial" ];
        $datos[ 'calleComercial' ]               = ( empty( $datos ) ) ? "" : $datosReg[ "calleComercial" ];
        $datos[ 'coloniaComercial' ]             = ( empty( $datos ) ) ? "" : $datosReg[ "coloniaComercial" ];
        $datos[ 'delegacionComercial' ]          = ( empty( $datos ) ) ? "" : $datosReg[ "delegacionComercial" ];
        $datos[ 'ciudadComercial' ]              = ( empty( $datos ) ) ? "" : $datosReg[ "ciudadComercial" ];
        $datos[ 'entidadComercial' ]             = ( empty( $datos ) ) ? "" : $datosReg[ "entidadComercial" ];
        $datos[ 'cpComercial' ]                  = ( empty( $datos ) ) ? "" : $datosReg[ "cpComercial" ];
        $datos[ 'telefonoComercial' ]            = ( empty( $datos ) ) ? "" : $datosReg[ "telefonoComercial" ];
        $datos[ 'faxComercial' ]                 = ( empty( $datos ) ) ? "" : $datosReg[ "faxComercial" ];
        $datos[ 'nombreFiscal' ]                 = ( empty( $datos ) ) ? "" : $datosReg[ "nombreFiscal" ];
        $datos[ 'rfcFiscal' ]                    = ( empty( $datos ) ) ? "" : $datosReg[ "rfcFiscal" ];
        $datos[ 'calleFiscal' ]                  = ( empty( $datos ) ) ? "" : $datosReg[ "calleFiscal" ];
        $datos[ 'coloniaFiscal' ]                = ( empty( $datos ) ) ? "" : $datosReg[ "coloniaFiscal" ];
        $datos[ 'delegacionFiscal' ]             = ( empty( $datos ) ) ? "" : $datosReg[ "delegacionFiscal" ];
        $datos[ 'ciudadFiscal' ]                 = ( empty( $datos ) ) ? "" : $datosReg[ "ciudadFiscal" ];
        $datos[ 'entidadFiscal' ]                = ( empty( $datos ) ) ? "" : $datosReg[ "entidadFiscal" ];
        $datos[ 'cpFiscal' ]                     = ( empty( $datos ) ) ? "" : $datosReg[ "cpFiscal" ];
        $datos[ 'telefonoFiscal' ]               = ( empty( $datos ) ) ? "" : $datosReg[ "telefonoFiscal" ];
        $datos[ 'faxFiscal' ]                    = ( empty( $datos ) ) ? "" : $datosReg[ "faxFiscal" ];
        $datos[ 'contactoComercial' ]            = ( empty( $datos ) ) ? "" : $datosReg[ "contactoComercial" ];
        $datos[ 'correoContactoComercial' ]      = ( empty( $datos ) ) ? "" : $datosReg[ "correoContactoComercial" ];
        $datos[ 'telefonoContactoComercial' ]    = ( empty( $datos ) ) ? "" : $datosReg[ "telefonoContactoComercial" ];
        $datos[ 'contactoCuentasPagar' ]         = ( empty( $datos ) ) ? "" : $datosReg[ "contactoCuentasPagar" ];
        $datos[ 'correoContactoCuentasPagar' ]   = ( empty( $datos ) ) ? "" : $datosReg[ "correoContactoCuentasPagar" ];
        $datos[ 'telefonoContactoCuentasPagar' ] = ( empty( $datos ) ) ? "" : $datosReg[ "telefonoContactoCuestasPagar" ];
        $datos[ 'local' ]                        = ( empty( $datos ) ) ? "" : $datosReg[ "local" ];
        $datos[ 'antiguedad' ]                   = ( empty( $datos ) ) ? "" : $datosReg[ "antiguedadDomicilio" ];
        $datos[ 'representanteLegal' ]           = ( empty( $datos ) ) ? "" : $datosReg[ "representanteLegal" ];
        $datos[ 'giroNegocio' ]                  = ( empty( $datos ) ) ? "" : $datosReg[ "giroNegocio" ];
        $datos[ 'giroTexto' ]                    = ( empty( $datos ) ) ? "" : $datosReg[ "giroTexto" ];
        $datos[ 'noClienteAudatex' ]             = ( empty( $datos ) ) ? "" : $datosReg[ "noClienteAudatex" ];
        $datos[ 'usoSistema' ]                   = ( empty( $datos ) ) ? "" : $datosReg[ "usoSistema" ];
        $datos[ 'razonAlta' ]                    = ( empty( $datos ) ) ? "" : $datosReg[ "razonAlta" ];
        $datos[ 'certificado' ]                  = ( empty( $datos ) ) ? "" : $datosReg[ "certificado" ];
        $datos[ 'aseguradoras' ]                 = ( empty( $datos ) ) ? "" : $datosReg[ "aseguradoras" ];
        $this->datos = $datos;

        $this->AliasNbPages();
        $this->SetAuthor( '.:: Audatex ::.' );
        $this->SetTitle( '.:: Audatex :: Solicitud de Registro ::.' );
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
        $nombrePDF = 'SolicitudRegistro.pdf';
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
        $this->MultiCell( 570 , 15 , 'SOLICITUD DE REGISTRO' , 1 , 'C' , 1 );

        /* Datos */

        /* Codigo Cliente */
        $this->SetFillColor( 160 , 160 , 160 );
        $yCodigo = $this->GetY() + 10;
        $this->SetY( $yCodigo );
        $this->SetX( 20 );
        $this->SetDrawColor( 235 , 130 , 15 );
        $this->SetTextColor( 0 , 0 , 0 );
        $this->SetFont( 'Helvetica' , 'N' , 10 );
        $this->MultiCell( 150 , 11 , $this->codificacion( 'Código de cliente' ) , 0 , 'R' , 0 );
        $this->SetY( $yCodigo );
        $this->SetX( 170 );
        $this->MultiCell( 150 , 11 , $this->codificacion( $this->datos[ 'codigoCliente' ] ) , 1 , 'L' , 0 );

        /* Fecha Alta */
        $this->SetFont( 'Helvetica' , 'N' , 8 );
        $this->SetY( $yCodigo - 8 );
        $this->SetX( 380 );
        $this->MultiCell( 210 , 11 , 'Fecha de alta en el sistema' , 0 , 'C' , 0 );
        $this->SetY( $yCodigo  );
        $this->SetX( 380 );
        $this->MultiCell( 210 , 11 , $this->codificacion( $this->datos[ 'fechaAlta' ] ) , 0 , 'C' , 0 );
        $this->SetY( $yCodigo + 10 );
        $this->SetX( 380 );
        $this->MultiCell( 210 , 11 , $this->codificacion( 'día       mes       año' ) , 'T' , 'C' , 0 );

        /* Direccion comercial */
        $this->SetFont( 'Helvetica' , 'B' , 12 );
        $this->SetY( $this->GetY() + 10 );
        $this->SetX( 20 );
        $this->MultiCell( 570 , 13 , $this->codificacion( 'DIRECCIÓN COMERCIAL' ) , 0 , 'C' , 1 );

        $y1 = $this->GetY();
        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $this->SetY( $y1 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Nombre Comercial:' ) , 0 , 'L' , 1 );
         $this->SetY( $y1 );
        $this->SetX( 210 );
        $this->MultiCell( 380 , 11 , '' , 0 , 'C' , 0 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $this->SetY( $this->GetY() );
        $this->SetX( 20 );
        $this->MultiCell( 570 , 11 , $this->codificacion( $this->datos[ 'nombreComercial' ] ) , 0 , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y2 = $this->GetY();
        $this->SetY( $y2 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Calle y Número Exterior e Interior:' ) , 0 , 'L' , 1 );
        $this->SetY( $y2 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Colonia:' ) , 0 , 'L' , 1 );
        $this->SetY( $y2 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Delegación/Municipio:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y3 = $this->GetY();
        $this->SetY( $y3 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'calleComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y3 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'coloniaComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y3 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'delegacionComercial' ] ) , 0 , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y4 = $this->GetY();
        $this->SetY( $y4 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Ciudad/Población:' ) , 0 , 'L' , 1 );
        $this->SetY( $y4 );
        $this->SetX( 210 );
        $this->MultiCell( 150 , 11 , $this->codificacion( 'Entidad Federativa:' ) , 0 , 'L' , 1 );
        $this->SetY( $y4 );
        $this->SetX( 360 );
        $this->MultiCell( 40 , 11 , $this->codificacion( 'CP:' ) , 0 , 'L' , 1 );
        $this->SetY( $y4 );
        $this->SetX( 400 );
        $this->MultiCell( 95 , 11 , $this->codificacion( 'Teléfono:' ) , 0 , 'L' , 1 );
        $this->SetY( $y4 );
        $this->SetX( 495 );
        $this->MultiCell( 95 , 11 , $this->codificacion( 'Fax:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y5 = $this->GetY();
        $this->SetY( $y5 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'ciudadComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y5 );
        $this->SetX( 210 );
        $this->MultiCell( 150 , 11 , $this->codificacion( $this->datos[ 'entidadComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y5 );
        $this->SetX( 360 );
        $this->MultiCell( 40 , 11 , $this->codificacion( $this->datos[ 'cpComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y5 );
        $this->SetX( 400 );
        $this->MultiCell( 95 , 11 , $this->codificacion( $this->datos[ 'telefonoComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y5 );
        $this->SetX( 495 );
        $this->MultiCell( 95 , 11 , $this->codificacion( $this->datos[ 'faxComercial' ] ) , 0 , 'L' , 0 );

        /* Datos Fiscales */
        $this->SetFont( 'Helvetica' , 'B' , 12 );
        $this->SetY( $this->GetY() + 20 );
        $this->SetX( 20 );
        $this->MultiCell( 570 , 13 , $this->codificacion( 'DATOS FISCALES' ) , 0 , 'C' , 1 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y6 = $this->GetY();
        $this->SetY( $y6 );
        $this->SetX( 20 );
        $this->MultiCell( 380 , 11 , $this->codificacion( 'Nombre Fiscal:' ) , 0 , 'L' , 1 );
        $this->SetY( $y6 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'RFC:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y7 = $this->GetY();
        $this->SetY( $y7 );
        $this->SetX( 20 );
        $this->MultiCell( 380 , 11 , $this->codificacion( $this->datos[ 'nombreFiscal' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y7 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'rfcFiscal' ] ) , 0 , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y8 = $this->GetY();
        $this->SetY( $y8 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Calle y Número Exterior e Interior:' ) , 0 , 'L' , 1 );
        $this->SetY( $y8 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Colonia:' ) , 0 , 'L' , 1 );
        $this->SetY( $y8 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Delegación/Municipio:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y9 = $this->GetY();
        $this->SetY( $y9 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'calleFiscal' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y9 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'coloniaFiscal' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y9 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'delegacionFiscal' ] ) , 0 , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y10 = $this->GetY();
        $this->SetY( $y10 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Ciudad/Población:' ) , 0 , 'L' , 1 );
        $this->SetY( $y10 );
        $this->SetX( 210 );
        $this->MultiCell( 150 , 11 , $this->codificacion( 'Entidad Federativa:' ) , 0 , 'L' , 1 );
        $this->SetY( $y10 );
        $this->SetX( 360 );
        $this->MultiCell( 40 , 11 , $this->codificacion( 'CP:' ) , 0 , 'L' , 1 );
        $this->SetY( $y10 );
        $this->SetX( 400 );
        $this->MultiCell( 95 , 11 , $this->codificacion( 'Teléfono:' ) , 0 , 'L' , 1 );
        $this->SetY( $y10 );
        $this->SetX( 495 );
        $this->MultiCell( 95 , 11 , $this->codificacion( 'Fax:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y11 = $this->GetY();
        $this->SetY( $y11 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'ciudadFiscal' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y11 );
        $this->SetX( 210 );
        $this->MultiCell( 150 , 11 , $this->codificacion( $this->datos[ 'entidadFiscal' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y11 );
        $this->SetX( 360 );
        $this->MultiCell( 40 , 11 , $this->codificacion( $this->datos[ 'cpFiscal' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y11 );
        $this->SetX( 400 );
        $this->MultiCell( 95 , 11 , $this->codificacion( $this->datos[ 'telefonoFiscal' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y11 );
        $this->SetX( 495 );
        $this->MultiCell( 95 , 11 , $this->codificacion( $this->datos[ 'faxFiscal' ] ) , 0 , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y12 = $this->GetY();
        $this->SetY( $y12 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Contacto Comercial:' ) , 0 , 'L' , 1 );
        $this->SetY( $y12 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Correo Contacto Comercial:' ) , 0 , 'L' , 1 );
        $this->SetY( $y12 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Teléfono Contacto Comercial:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y13 = $this->GetY();
        $this->SetY( $y13 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'contactoComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y13 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'correoContactoComercial' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y13 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'telefonoContactoComercial' ] ) , 0 , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y14 = $this->GetY();
        $this->SetY( $y14 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Contacto Cuentas por Cobrar:' ) , 0 , 'L' , 1 );
        $this->SetY( $y14 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Correo Contacto Cuentas por Cobrar:' ) , 0 , 'L' , 1 );
        $this->SetY( $y14 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Teléfono Contacto Cuentas por Cobrar:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y15 = $this->GetY();
        $this->SetY( $y15 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'contactoCuentasPagar' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y15 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'correoContactoCuentasPagar' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y15 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'telefonoContactoCuentasPagar' ] ) , 0 , 'L' , 0 );

        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y16 = $this->GetY();
        $this->SetY( $y16 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'El local que ocupa es:' ) , 0 , 'L' , 1 );
        $this->SetY( $y16 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Antiguedad en domicilio:' ) , 0 , 'L' , 1 );
        $this->SetY( $y16 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Giro de Negocio:' ) , 0 , 'L' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y17 = $this->GetY();
        $this->SetY( $y17 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'local' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y17 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'antiguedad' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y17 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'giroNegocio' ] . ' ' . $this->datos[ 'giroTexto' ] ) , 0 , 'L' , 0 );
        
        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y20 = $this->GetY();
        $this->SetY( $y20 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Usted ya utiliza el sistema?' ) , 0 , 'L' , 1 );
        $this->SetY( $y20 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Cual es su codigo de cliente?' ) , 0 , 'L' , 1 );
        $this->SetY( $y20 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Por que requiere esta alta?' ) , 0 , 'L' , 1 );
        
        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y21 = $this->GetY();
        $this->SetY( $y21 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'usoSistema' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y21 );
        $this->SetX( 210 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'noClienteAudatex' ] ) , 0 , 'L' , 0 );
        $this->SetY( $y21 );
        $this->SetX( 400 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'razonAlta' ] ) , 0 , 'L' , 0 );
        
        $this->SetFont( 'Helvetica' , 'B' , 9 );
        $y22 = $this->GetY();
        $this->SetY( $y22 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( 'Cuenta con Certificado Audaclaims Gold?' ) , 0 , 'L' , 1 );
        
        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y23 = $this->GetY();
        $this->SetY( $y23 );
        $this->SetX( 20 );
        $this->MultiCell( 190 , 11 , $this->codificacion( $this->datos[ 'certificado' ] ) , 0 , 'L' , 0 );
        
        /* Comunicacion */
        $this->SetFont( 'Helvetica' , 'B' , 12 );
        $y18 = $this->GetY() + 20;
        $this->SetY( $y18 );
        $this->SetX( 20 );
        $this->MultiCell( 260 , 13 , $this->codificacion( 'COMUNICACIÓN' ) , 0 , 'C' , 1 );
        $this->SetY( $y18 );
        $this->SetX( 330 );
        $this->MultiCell( 260 , 13 , $this->codificacion( 'CONTRATO QUE ACOMPAÑA' ) , 0 , 'C' , 1 );

        $this->SetFont( 'Helvetica' , 'N' , 9 );
        $y19 = $this->GetY();
        $this->SetY( $y19 );
        $this->SetX( 20 );
        $this->MultiCell( 260 , 13 , $this->codificacion( 'Aseguradora(s)' ) , 0 , 'L' , 0 );
        
        
        $aseguradoras = explode( ';' , $this->datos[ 'aseguradoras' ] );
        $yAseg = $y19;
        foreach( $aseguradoras AS $aseguradora ) {
            $this->SetY( $yAseg + 10 );
            $this->SetX( 20 );
            $this->MultiCell( 260 , 13 , $aseguradora , 0 , 'L' , 0 );
            $yAseg = $yAseg + 10;
        }

        
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
        $this->MultiCell( 150 , 10 , $this->datos[ 'representanteLegal' ] , 0 , 'C' , 0 );
        $this->SetY( -100 );
        $this->SetX( 430 );
        $this->MultiCell( 150 , 10 , '________________________________' , 0 , 'C' , 0 );
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
