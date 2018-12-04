<?php
/*
 * Clase que contiene la funcionalidad de lectura y registro de layouts procesados
 * para alimentar los inventarios
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Enero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Librerias/Excel/reader.php';

class Layout {

    /*
     * Nombre de columnas de layout
     */
    protected $nColumnasLayout = array( 1  => "SKU"           , 2 => "FECHA_INGRESO", 3 => "SERIE"    , 4 => "NOMBRE"       , 5 => "MARCA"         , 6 => "COSTO" , 7 => "MONEDA"          , 8 => "UNIDAD_MEDIDA", 9 => "COLOR",
                                        10 => "PESO"          ,11 => "UNIDAD_PESO"  ,12 => "ANCHO"    ,13 => "LARGO"        ,14 => "ALTO"          ,15 => "TALLA" ,16 => "SABOR"           ,17 => "DESCRIPCION"  ,18 => "CANTIDAD",
                                        19 => "RESPONSABLE"   ,20 => "CLIENTE"      ,21 => "RACK"     ,22 => "POSICION_RACK",23 => "ALMACENAMIENTO",24 => "ESTADO",25 => "FECHA_ASIGNACION",26 => "FECHA_ENTREGA",27 => "FECHA_DEVOLUCION",
                                        28 => "ALMACENAMIENTO",29 => "MODELO"       ,30 => "CAPACIDAD",31 => "ALMACEN"      ,32 => "RESURTIDO"     ,33 => "TIPO"  ,34 => "DELIVERY"        ,35 => "CONSIGNA"     ,36 => "IMEI");

    /*
     * Delimitador de campos para el archivo csv
     */
    protected $delimitador = ';';

    /*
     * Total de campos por renglon en cada item del layout
     */
    protected $campos = 36;

    /*
     * Posiciones obligatorias en la estructura de cada item
     */
    protected $obligatorios = array();

    /*
     * Posiciones de las columnas que deberan tener un formato de fecha
     */
    protected $fecha = array( 2 , 25 , 26 , 27 , 28 );

    /*
     * Variable que contiene la instancia a la base de datos
     */
    protected $dbConn = null;

    /*
     * Variable que contiene el nombre del layout a ser procesado
     */
    protected $layout = '';
    
    /*
     * Variable que contiene un identificador numerico para el layout
     */
    protected $idtyLayout = 0;

    /*
     * Variable que contiene el nombre del fichero
     */
    protected $fileName = '';

    /*
     * Identificador del layout recien procesado
     */
    protected $layoutIdty = '';

    /*
     * Total de registros afectados por el ultimo layout configurado
     */
    protected $registrosLayoutProc = 0;

    /*
     * Variable que contiene el mensaje resultado del procesamiento del layout
     */
    public $mensaje = '';

    /*
     * Atributo que contiene los mensajes de cada detalle por renglon del layout
     */
    private $mensajeDetalle = '';


    /*
     * Arreglo que contiene los datos extraidos del layout
     */
    public $datos = array();

    /*
     * Bandera que contiene un valor booleano del resultado del procesamiento
     * del layout adjuntado
     */
    public $esCorrecto = false;

    /*
     * Almacen
     */
    public $almacen = 0;

    /*
     * Cliente
     */
    public $cliente = 0;

    /*
     * Constructor de la clase
     */
    public function __construct( $nombreLayout , $fileName , $cliente , $almacen ) {
        $this->dbConn  = new classConMySQL();
        $this->layout  = $nombreLayout;
        $this->fileName = $fileName;
        $this->almacen = $almacen;
        $this->cliente = $cliente;
    }

    /*
     * Metodo que procesa layout a ser adjuntado
     */
    public function procesaLayout( $formato ) {
        if( $formato == 'csv' ){
            $metodo = $this->procesa_csv();
        }elseif( $formato == 'xls' ){
            $metodo = $this->procesa_xls();
        }

        if( $metodo ) {
            $datos = $this->datos;
            $mensaje = $this->mensaje;

            /*
             * Guarda la infromacion del layout siempre y cuando
             * al menos un renglon haya sido correcto
             */
            if( $this->registrosLayoutProc >= "1" ){
		$this->registraLayout();
                $this->guardaDetalleUploadLayout();
            }

            return array( $datos , $mensaje );
        }else{
            $this->mensaje = _PROCLAYOUTERRORESTRUCTURA_;
            return false;
        }
    }

    /*
     * Realiza la lectura del fichero csv
     */
    public function procesa_csv() {
        $datosFile  = array();
        $datosLinea = array();
        $mensaje    = '';
        $linea      = 0;

        if( ( $puntero = fopen( $this->layout , "r" ) ) !== false ) {
            while( ( $datos = fgetcsv( $puntero , 1000 , $this->delimitador ) ) !== false ) {
                $tamanio = count( $datos );
                if( $tamanio != $this->campos ) {
                    /*
                     * Error en cantidad de campos
                     */
                    $mensaje .= 'Error en cantidad de campos en la linea ' . $linea . ', deben ser '.$this->campos.' y son ' . $tamanio . ' <br>';
                }else{
                    /*
                     * Procesamiento de campos
                     */
                    for( $pos = 0 ; $pos < $tamanio; $pos ++ ) {

                        /*
                         * Verifica si un dato obligatorio no esta vacio
                         * (se basa en la posicion dentro del arreglo)
                         */
                        if( in_array( $pos , $this->obligatorios ) ){
                            /*
                             * Verifica los campos obligatorios
                             */
                            if( strlen( $datos[ $pos ] ) == 0 ){
                                    $mensaje .= _PROCLAYOUTERROROBLIGATORIEDAD_1_ . ' ' . $pos . ' ' . _PROCLAYOUTERROROBLIGATORIEDAD_2_ . ' ' . $linea . ' ' . _PROCLAYOUTERROROBLIGATORIEDAD_3_ . '<br>';
                                }else{
                                    $datosLinea[] = $datos[ $pos ];
                            }
                        }else{
                            $datosLinea[] = $datos[ $pos ];
                        }
                    }
                    $datosFile[] = $datosLinea;
                    $datosLinea = array();
                }
                $linea ++;
            }
            fclose( $puntero );
        }

        $this->datos = $datosFile;
        if( strlen( $mensaje ) == 0 ){
            $mensaje = _PROCLAYOUTEXITO_ . $linea . _PROCLAYOUTLINEASAFF_;
            $this->esCorrecto = true;
        }

        $this->mensaje = $mensaje;
        return true;
    }

    /*
     * Realiza la lectura del fichero xls
     */
    public function procesa_xls() {
        $datosFile  = array();
        $datosLinea = array();
        $linea      = 0;
        $this->idLayout();

        $excel = new Spreadsheet_Excel_Reader();
        $excel->read( $this->layout );

        /*
         * Recorre los datos de la hoja inicial del documento, comienza con indice 2 para despreciar el
         * primer renglon que contiene los nombres de columnas
         */
        for( $renglon = 2 ; $renglon <= $excel->sheets[0]['numRows'] ; $renglon ++ ){

            $errExsitencia = false;
            //$marca = $excel->sheets[0]['cells'][$renglon][5];
            $marca = $this->cliente;
            $reglas = $this->reglasEstructuraLayoutMarca( $marca );

            for( $columna = 1 ; $columna <= $excel->sheets[0]['numCols'] ; $columna ++ ){
                
                if( $excel->sheets[0]['numCols'] != $this->campos ){
                    $this->mensajeDetalle .= "El renglon ".$renglon." no cumple con la cantidad de columnas, renglon omitido.|";
                }else{
                    $valor = ( isset( $excel->sheets[0]['cells'][$renglon][$columna] ) ) ? $excel->sheets[0]['cells'][$renglon][$columna] : '';
                    if( $reglas[ $columna - 1 ] == "1" && $valor == '' ){
                        $errExsitencia = true;
                        $this->mensajeDetalle .= "<br>Error renglon ".$renglon." columna ".$this->nColumnasLayout[$columna] ." es obligatoria y se encuentra vacia, renglon omitido.|";
                    }

                    $datosLinea[ $columna ] = utf8_encode( $valor );
                }

            }

            if(!$errExsitencia){
                $this->afectaInventarios( $datosLinea , $renglon );
            }

            $datosLinea  = array();
            $linea ++;
        }

        if( $this->registrosLayoutProc >= "1" ){
            $mensaje = _PROCLAYOUTEXITO_ . $this->registrosLayoutProc . _PROCLAYOUTLINEASAFF_;
            $this->esCorrecto = true;
            $this->registrosLayoutProc = $this->registrosLayoutProc;
        }else{
            $mensaje = addslashes( $this->mensajeDetalle );
        }
        trigger_error($mensaje);
        $this->mensaje = $mensaje;
        return true;
    }

    /*
     * Metodo que guarda el detalle completo del layout adjuntado
     */
    private function guardaDetalleUploadLayout() {
        $sql  = " INSERT INTO inv_detalle_uploadLayout( idLayout , detalle , status ) ";
        $sql .= " VALUES( '" . $this->layoutIdty . "' , '" . addslashes( $this->mensajeDetalle ) . "' ,'1' ) ";
        $this->dbConn->ejecutaComando( $sql );
    }

    /*
     * Metodo que genera la estructura a validar de acuerdo a la marca encontrada en el layout
     */
    private function reglasEstructuraLayoutMarca( $marca ) {
        $sql    = " SELECT reglas FROM inv_reglaValLayout WHERE marca='$marca' ";
        $rs     = $this->dbConn->ejecutaComando( $sql );
        $reglas = array();

        while( !$rs->EOF ) {
            $reglas = explode( ',' , $rs->fields['reglas'] );
            $rs->MoveNext();
        }

        return $reglas;
    }

    /*
     * Almacena informacion de los inventarios extraida del layout
     * dentro de la estructura de items en la base de datos
     */
    public function afectaInventarios( $renglon , $renglonCont ) {
        
        /* Alimenta catalogo de productos */
        $sqlItem = "INSERT INTO inv_item ( `sku`, `fechaIngreso`, `serie`, `nombre`, `marca`, "
                 . " `costo`, `moneda`, `unidadMedida`, `color`, `peso`, `unidadPeso`, "
                 . " `ancho`, `largo`, `alto`, `talla`, `sabor`, `descripcion`, "
                 . " `cantidad`, `responsable`, `cliente`, `rack`, `posicionRack`, `almacenamiento`, "
                 . " `estado`, `fechaAsignacion`, `fechaEntrega`, `fechaDevolucion`, `fechaReactivacion`, `modelo`, "
                 . " `capacidad`, `almacen`, `resurtido`, `delivery`, `consigna`, "
                 . " `imei`, `idLayout`, `status`, `proceso`) VALUES ("
                 . " '".$this->floattostr($renglon[1])."', '".$this->formatoFecha($renglon[2])."', '".$this->floattostr($renglon[3])."', '" . strtoupper( $renglon[4] ) . "', '".$this->cliente."', "
                 . " '".str_replace("$","",$renglon[6])."', '" . strtoupper( $renglon[7] ) . "', '" . strtoupper( $renglon[8] ) . "', '" . strtoupper( $renglon[9] ) . "', '" . strtoupper( $renglon[10] ) . "', '" . strtoupper( $renglon[11] ) . "', "
                 . " '" . strtoupper( $renglon[12] ) . "', '" . strtoupper( $renglon[13] ) . "', '" . strtoupper( $renglon[14] ) . "', '" . strtoupper( $renglon[15] ) . "', '" . strtoupper( $renglon[16] ) . "', '" . strtoupper( $renglon[17] ) . "', "
                 . " '" . strtoupper( $renglon[18] ) . "', '" . strtoupper( $renglon[19] ) . "', '".$this->cliente."', '" . strtoupper( $renglon[21] ) . "', '" . strtoupper( $renglon[22] ) . "', '" . strtoupper( $renglon[28] ) . "', "
                 . " '" . strtoupper( $renglon[24] ) . "', '" . $this->formatoFecha( $renglon[25] ) . "', '" . $this->formatoFecha( $renglon[26] )."', '" . $this->formatoFecha( $renglon[27] ) . "', '" . $this->formatoFecha( $renglon[27] ) . "', '" . $renglon[29] . "', "
                 . " '" . strtoupper( $renglon[30] ) . "', '" . $this->almacen . "', '" . $this->formatoFecha( $renglon[32] ) . "', '" . strtoupper( $renglon[34] ) . "', '" . strtoupper( $renglon[35] ) . "', "
                 . " '" . $this->floattostr($renglon[36]) . "', '" . $this->idtyLayout . "', 1, ".(( $renglon[29] == "" ) ? "1" : "4" ).")";
        $rs      = $this->dbConn->ejecutaComando( $sqlItem );

        if( $rs ) {
            if( $renglon[5] == "" ) {
                $this->generaExistencias( $this->floattostr( $renglon[1] ) , $this->almacen , $renglon[18] , $this->cliente );
            }
            $this->altaLote( $renglonCont , $renglon[29] , $this->floattostr($renglon[1]) , $this->floattostr($renglon[36]) , $this->floattostr($renglon[3]) , $renglon[24] , $renglon[5] ,$this->almacen , $renglon[19] , $this->formatoFecha($renglon[2]) );
            $this->mensajeDetalle .= "Renglon " . $renglonCont . " agregado correctamente.|";
        } else {
            /* Alimenta Lote */
            if( $this->dbConn->errorCod == '1062' ) {
                $this->altaLote( $renglonCont , $renglon[29] , $this->floattostr($renglon[1]) , $this->floattostr($renglon[36]) , $this->floattostr($renglon[3]) , $renglon[24] , $renglon[5] , $this->almacen , $renglon[19] , $this->formatoFecha($renglon[2]) );
            }

            $this->mensajeDetalle .= "Error en renglon " . $renglonCont . "[".$this->dbConn->error."]|";
            //trigger_error( "Error alta item " . $this->dbConn->error . "  " . $this->dbConn->errorCod . " " . $sqlItem );
        }
    }

    /* Metodo que hace el alta de producto para un modelo en particular */
    private function altaLote( $renglonCont , $modelo , $sku , $imei , $serie , $estado , $marca , $almacen , $responsable , $fechaAlta ) {
        if( $marca != '' ) {
            $sqlLote  = " INSERT INTO inv_lote(modelo, sku, imei, serie, estado, marca, almacen, responsable, status, fechaAlta, idtyLayout, proceso ) ";
            $sqlLote .= " VALUES ( '".$modelo."' , '".$sku."' , '".$imei."' , '".$serie."' , '".$estado."' , '".$marca."' , '".$almacen."' , '".$responsable."' , 1 , '".$fechaAlta."' , '".$this->idtyLayout."' ,  1 ) ";
            $rs       = $this->dbConn->ejecutaComando( $sqlLote );

            if( $rs ) {
                $this->movimientoAltaInventario( $sku );
                $this->generaExistencias( $sku , $almacen, "1" , $marca );
                $this->registrosLayoutProc++;
                $this->mensajeDetalle .= "Renglon " . $renglonCont . " agregado correctamente.|";
                return true;
            }else{
                $this->mensajeDetalle .= "Error en renglon " . $renglonCont . "[".$this->dbConn->error."]|";
                //trigger_error( "Error alta lote " . $this->dbConn->error . "  " . $this->dbConn->errorCod . " " . $sqlLote );
                return false;
            }
        }else{
            $this->registrosLayoutProc++;
            return true;
        }
    }

    /* Metodo que guarda el movimiento de alta por cada sku */
    private function movimientoAltaInventario( $sku ) {
        $sqlAlta  = " INSERT INTO inv_historialItem (movimiento,descripcion, sku, fechaMovimiento, usuarioSolicita, usuarioAutoriza) VALUES ";
        $sqlAlta .= " (1,'Alta de producto','".$sku."','".date('Y-m-d H:i:s')."','".$_SESSION['usuario']."','".$_SESSION['usuario']."') ";
        $this->dbConn->ejecutaComando( $sqlAlta );
    }
    
    /* Metodo que genera el identificador del layout adjuntado */
    private function idLayout() {
        $caracteres = array( 1 , 2 , 3 , 4 , 5 , 6 ,
                             7 , 8 , 9 ,'a','b','c',
                            'd','e','f','g','h','i',
                            'j','k','l','m','n','o',
                            'p','q','r','s','t','u',
                            'v','w','x','y','z','A',
                            'B','C','D','E','F','G',
                            'H','I','J','K','L','M',
                            'N','O','P','Q','R','S',
                            'T','U','V','W','X','Y','Z');
        $idty       = '';
        for( $i = 0 ; $i < 9 ; $i ++ ) {
            $idty .= $caracteres[ rand( 0 , count( $caracteres )-1 ) ];
        }

        $this->idtyLayout = $idty;
        return $idty;
    }

    /*
     * Metodo que registra un layout una vez que ya ha sido procesado
     */
    public function registraLayout() {
        $sql  = " INSERT INTO inv_layout( nombreLayout, idtyLayout, registros, fechaUso, usuario, idtyAlmacen, idtyCliente, status ) VALUES ";
        $sql .= " ( '" . addslashes( $this->fileName ) . "' , '".$this->idtyLayout."' , '".$this->registrosLayoutProc."' , '".date('Y-m-d H:i:s')."' , '".$_SESSION['usuario']."' , '".$this->almacen."' , '".$this->cliente."' , '1' )";
        $rs  = $this->dbConn->ejecutaComando( $sql );

        if( $rs ){
		$this->layoutIdty = $this->dbConn->insertID;
                return true;
            }else{
                return false;
        }
    }

    /*
     * Nombre fichero layout sin la ruta
     */
    public function obtieneNombreFichero() {
        $partes = explode( '/' , $this->layout );
        return $partes[ count( $partes ) - 1 ];
    }

    /*
     * Metodo que verifica si un layout ha sido previamente procesado
     */
    public function verificaLayout() {
        $sql = " SELECT COUNT(*) AS total FROM inv_layout WHERE nombreLayout='".$this->fileName."' ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        $ban = false;

        while( !$rs->EOF ){
            if ( $rs->fields['total'] > 0 ){
                $this->mensaje = _PROCLAYOUTERRORREPETIDO_;
                $ban = true;
            }
            $rs->MoveNext();
        }

        return $ban;
    }

    /*
     * Convierte las fechas extraidas desde el archivo excel
     */
    private function formatoFecha( $datoExcel ) {
        if( $datoExcel == '0000-0000' || $datoExcel == '' ) {
                return gmdate("Y-m-d", mktime(0, 0, 0, 1, 1, 2014));
            } else {
                $unixDate = ( $datoExcel - 25569) * 86400;
                return gmdate("Y-m-d", $unixDate);
        }
    }

    /*
     * Metodo que elimina la notacion cientifica
     */
    function floattostr( $val ){
        if( ctype_alnum( $val ) )return $val;
        else return sprintf( "%.0f" , $val );
    }

    /*
     * Metodo que agrega el registro de existencias
     */
    private function generaExistencias( $sku , $almacen, $cantidad, $cliente ) {
        $sql = " INSERT INTO inv_existencias(sku, almacen, cantidad, fechaRegistro, cliente ) "
             . " VALUES( '".$sku."', '".$almacen."', '".$cantidad."', '".date( 'Y-m-d H:i:s' )."', '".$cliente."' ) "
             . " ON DUPLICATE KEY UPDATE cantidad=cantidad+".$cantidad."; ";
        $rs  = $this->dbConn->ejecutaComando( $sql );
        if( $rs )return true;
        else return false;
    }

}
