<?php
/*
 * Clase con la funcionalidad de hacer el upload de ficheros al servidor
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Enero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

class Upload {

    /*
     * Variable que almacena la ruta temporal del fichero en el servidor
     */
    public $rutaTemporal = '/var/www/html/temp/';
    //public $rutaTemporal = '/var/www/vhosts/facturacionaudatex.com.mx/httpdocs/temp/';

    /*
     * Variable que almacena la ruta real del fichero una vez adjuntado
     */
    public $rutaFinal = '/var/www/html/temp/';
    //public $rutaFinal = '/var/www/vhosts/facturacionaudatex.com.mx/httpdocs/temp/';

    /*
     * Variable que contiene solo el nombre del archivo, sin la ruta
     */
    public $fileName = '';

    /*
     * Variable que contiene el formato(extension) del archivo adjuntado
     */
    public $formato = '';
    
    /*
     * Variable que contiene el nombre del archivo recientemente adjuntado
     */
    public $adjunto = "";
    
    /*
     * Variable que comprueba que el input fue llenado con un archivo valido
     */
    public $existe = false;

    /*
     * Constructor de la clase
     */
    public function __construct( $input ) {
        if ( isset( $_FILES[ $input ]['tmp_name'] ) && $_FILES[ $input ]['name'] != "" ){
            $nFile = str_replace(" ","",str_replace("(","",str_replace(")","",$_FILES[ $input ]['name'])));
            $this->adjunto = $_FILES[ $input ]['tmp_name'];
            if ( ! copy( $_FILES[ $input ]['tmp_name'] , $this->rutaFinal . $nFile ) ){
                    return false;
                }else{
                    $this->existe    = true;
                    $this->fileName  = $nFile;
                    $this->rutaFinal = $this->rutaFinal . $nFile ;
                    $arregloElementos = explode( '.' , $nFile );
                    $this->formato   = $arregloElementos[ count( explode( '.' , $nFile ) ) - 1 ];
                    return true;
            }
        }else{
            $this->existe = false;
            return false;
        }
    }
    
    /*
     * Funcion que elimina el fichero recien adjuntado
     */
    public function eliminaLayout(){
        unlink( $this->rutaFinal );
    }
    
    /*
     * Funcion que mueve el archivo subido a un directorio en particular
     */
    public function mueveUpload( $destino ) {
        move_uploaded_file( $this->adjunto , $destino );
    }
    
}

