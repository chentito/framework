<?php
/*
 * Modelo para el funcionamiento del modulo inventarios
 * 
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015 / Septiembre 2016 ajuste de rutinas por cambio de layout
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Datos/DataGrid.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
include_once _DIRPATH_ . '/sistema/Registros/Acciones.php';
include_once _DIRPATH_ . '/sistema/Archivos/Upload.php';
include_once _DIRPATH_ . '/sistema/Archivos/Documentos.php';
include_once _DIRPATH_ . '/sistema/Archivos/DocumentoPDF.php';

/*
 * Funcionalidades de los modulos
 */
include_once _DIRPATH_ . '/modulos/Utiles/Utiles.php';
include_once _DIRPATH_ . '/modulos/Inventarios/Layout.php';

class MInventarios {

    /*
     * Instancia que almacena la funcionalidad para el upload de ficheros al servidor
     */
    protected $upload = null;
    
    /*
     * Instancia de conexion a la base de datos
     */
    protected $dbCon = null;
    
    /*
     * Instancia de clase de utilerias
     */
    protected $utiles = null;

    public $contentImg = null;
    
    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbCon = new classConMySQL();
        $this->utiles = new Utiles();
    }

    /* ***************************
     *      ALMACENES
     * ***************************/

    /*
     * Metodo que contiene la estructura de las columnas del grid de catalogo de almacenes
     */
    public function catalogoAlmacenes_arreglo() {
    	$columnas = array(
            'Clave'         => array( 'name'=>'clave'        ,'index'=>'clave'        ,'width'=>90 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Nombre'        => array( 'name'=>'nombre'       ,'index'=>'nombre'       ,'width'=>180,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Direccion'     => array( 'name'=>'direccion'    ,'index'=>'direccion'    ,'width'=>200,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Observaciones' => array( 'name'=>'observaciones','index'=>'observaciones','width'=>200,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Cliente'       => array( 'name'=>'cliente'      ,'index'=>'cliente'      ,'width'=>100,'align'=>'center','editable'=>true,'editrules'=>'{required:true}','edittype'=>'select','editoptions'=>'{value:"'.$this->comboClientes().'"}' ),
            'Video'         => array( 'name'=>'video_path'   ,'index'=>'video_path'   ,'width'=>200,'align'=>'center','editable'=>true,'editrules'=>'{required:false}' ),
            'Accesar'       => array( 'name'=>'access'       ,'index'=>'access'       ,'width'=>200,'align'=>'center','editable'=>false,'sortable'=>false ),
            'Usuario'       => array( 'name'=>'video_usuario','index'=>'video_usuario','width'=>80,'align'=>'center' ,'editable'=>true,'editrules'=>'{required:false}' ),
            'Password'      => array( 'name'=>'video_passwd' ,'index'=>'video_passwd' ,'width'=>80,'align'=>'center' ,'editable'=>true,'editrules'=>'{required:false}' ),
            'Estatus'       => array( 'name'=>'status'       ,'index'=>'status'       ,'width'=>60 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}','edittype'=>'select','editoptions'=>'{value:"1:Activo;2:Inactivo"}')
        );
        return $columnas;
    }

    /* Obtiene el combo de clientes disponibles */
    public function comboClientes() {
        $sql = "SELECT id, nombreCliente FROM cli_listado WHERE status=1";
        if( $_SESSION['tipoAcceso'] == 'clientes' ){
            $sql .= " AND id='".$_SESSION['valor']."' ";
        }
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND id IN (".$marcas.") ";
        }
        return $this->utiles->generaComboDinamicoGrid( $sql );
    }
    
    /*
     * Metodo que solicita la estructura XML del listado de almacenes
     */
    public function datosGridListadoAlmacenes() {
        $sql  = " SELECT a.id, a.clave, a.nombre, a.direccion, a.observaciones, l.nombreCliente, a.video_path,CONCAT( '<a href=\"', a.video_path ,'\" target=\"_blank\">Accesar</a>' ) AS access, a.video_usuario, a.video_passwd, IF(a.status=1,'Activo','Inactivo') AS status FROM inv_almacenes AS a LEFT JOIN cli_listado AS l ON l.id=a.cliente WHERE a.status IN (1,2)";
        if( $_SESSION['tipoAcceso'] == 'clientes' ) {
            $sql .= " AND l.id='".$_SESSION['valor']."' ";
        }
        $grid = new DataGrid( $sql , 'Catalogo de Almacenes' );
        echo $grid->datosXML;
    }

    /* Metodo que agrega un almacen */
    public function agregaAlmacen() {
        $sql  = " INSERT INTO inv_almacenes(clave, nombre, direccion, observaciones, cliente, fechaAlta, fechaModifica, video_path, video_usuario, video_passwd, status) ";
        $sql .= " VALUES( '".$_POST['clave']."' , '".utf8_decode($_POST['nombre'])."' , '".utf8_decode($_POST['direccion'])."' , '".utf8_decode($_POST['observaciones'])."' , '".$_POST['cliente']."' , '".date( 'Y-m-d H:i:s' )."' , '".date( 'Y-m-d H:i:s' )."' ,  '".$_POST['video_path']."' , '".$_POST['video_usuario']."' , '".$_POST['video_passwd']."' , '".$_POST['status']."' ) ";
        $rs   = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){ return true; }
        else{ return false; }
    }

    /* Metodo que edita un almacen */
    public function editaAlmacen() {
        $sql  = " UPDATE inv_almacenes SET clave='".$_POST['clave']."', nombre='".utf8_decode($_POST['nombre'])."', direccion='".utf8_decode($_POST['direccion'])."', video_path='".$_POST['video_path']."',video_usuario='".$_POST['video_usuario']."',video_passwd='".$_POST['video_passwd']."', ";
        $sql .= " observaciones='".utf8_decode($_POST['observaciones'])."', cliente='".$_POST['cliente']."' , status='".$_POST['status']."', fechaModifica='".date( 'Y-m-d H:i:s' )."' WHERE id='".$_POST['id']."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){ return true; }
        else{ return false; }
    }

    /* Metodo que elimina almacenes */
    public function eliminaAlmacen() {
        $sql = " UPDATE inv_almacenes SET status=3 , fechaModifica='".date( 'Y-m-d H:i:s' )."' WHERE id='".$_POST['id']."' ";
        $rsp = $this->dbCon->ejecutaComando($sql);

        if( $rsp ){ return true; }
        else{ return false; }
    }

    /* Metodo que obtiene camaras de acceso al video de un almacen */
    public function datosAccesoVideo( $id ) {
        $sql = " SELECT video_path,video_usuario,video_passwd FROM inv_almacenes WHERE id='".$id."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();

        while( !$rs->EOF ) {
            $datos['path']       = $rs->fields['video_path'];
            $datos['usuario']    = $rs->fields['video_usuario'];
            $datos['contrasena'] = $rs->fields['video_passwd'];
            $rs->MoveNext();
        }

        return $datos;
    }

    /* ***************************
     *      MOVIMIENTOS ENTRE ALMACENES
     * ***************************/

    /*
     * Metodo que contiene la estructrua de las columnas del grid de catalogo de movimientos entre almacenes
     */
    public function catalogoMovimientosAlmacen_arreglo() {
        $columnas = array(
            'ID'         => array( 'name'=>'idty'      ,'index'=>'idty'      ,'width'=>90 ,'align'=>'center','editable'=>false,'editrules'=>'{required:true}'),
            'Movimiento' => array( 'name'=>'movimiento','index'=>'movimiento','width'=>690,'align'=>'center','editable'=>true,'editrules'=>'{required:true}'),
            'Estatus'    => array( 'name'=>'status'    ,'index'=>'status'    ,'width'=>60 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}','edittype'=>'select','editoptions'=>'{value:"1:Activo;2:Inactivo"}')
        );
        return $columnas;
    }

    /*
     * Metodo que solicita la estructura XML del listado de moviemientos de almacenes
     */
    public function datosGridListadoMovimientosAlmacen() {
        $sql = " SELECT id, id AS idty, movimiento, IF(status=1,'Activo','Inactivo') AS status FROM inv_movimientos WHERE status IN (1,2) ";
        $grid = new DataGrid( $sql , 'Movimientos entre almacenes');
        echo $grid->datosXML;
    }

    /*
     * Metodo que agrega un nuevo movimiento de almacen
     */
    public function agragaMovimientoAlmacen() {
        $sql  = " INSERT INTO inv_movimientos(movimiento, fechaAlta, status) ";
        $sql .= " VALUES( '" . $_POST['movimiento'] . "' , '" . date( 'Y-m-d H:i:s' ) . "' , '1' ) ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        
        if( $rs ){ return true; }
        else{ return false; }
    }
    
    /*
     * Metodo que edita el movimiento de almacen
     */
    public function editaMovimientoAlmacen() {
        $sql = " UPDATE inv_movimientos SET movimiento='".$_POST['movimiento']."',  fechaModifica='" . date( 'Y-m-d H:i:s' ) . "' WHERE id='".$_POST["id"]."'";        
        $rs   = $this->dbCon->ejecutaComando( $sql );
        
        if( $rs ){ return true; }
        else{ return false; }
    }
    
    /*
     * Metodo que elimina un tipo de movimiento 
     */
    public function eliminaMovimientoAlmacen() {
        $sql = " UPDATE inv_movimientos SET status=3, fechaModifica='" . date( 'Y-m-d H:i:s' ) . "' WHERE id='".$_POST["id"]."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        
        if( $rs ){ return true; }
        else{ return false; }
    }

    /*
     * Nuevo movimiento individual entre almacenes
     */
    public function movIndividualBusquedaSKU() {
        $sku  = $_POST['sku'];
        $sql  = " SELECT e.cliente AS cli, e.sku, e.almacen AS alm, e.cantidad, a.clave, c.clave AS marca FROM ";
        $sql .= " inv_existencias AS e LEFT JOIN inv_almacenes AS a ON a.id=e.almacen LEFT JOIN cli_listado AS c ON c.id=e.cliente WHERE e.sku='".$sku."' AND e.cantidad>=0 ";
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND e.cliente IN (".$marcas.") ";
        }
        $sql .= " ORDER BY e.cliente ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        $html = '';
        $i    = 0;

        if( !$rs->EOF ) {
            while( !$rs->EOF ) {
                $i ++;
                $opcionesEntrada = json_decode( $this->cargaAlmacenesEntradaTraspaso( $rs->fields[ 'alm' ] ) );
                $select = '<select id="movIndividualNuevo_almacenDestion_'.$i.'" name="movIndividualNuevo_almacenDestion_'.$i.'" >';
                foreach( $opcionesEntrada AS $opcion) {
                    $select .= '<option value="' . $opcion->id . '">' . $opcion->clave . '</option>';
                }
                $select .= '</select>';

                $html .= '<table width="100%">'
                            . '<tr>'
                                . '<td width="2%">SKU:</td>'
                                . '<td width="8%"><input value="'.$rs->fields[ 'sku' ].'" id="movIndividualNuevo_sku_'.$i.'" name="movIndividualNuevo_sku_'.$i.'" size="15" readonly /></td>'
                                . '<td width="8%">Almacen Origen:</td>'
                                . '<td><input value="'.$rs->fields[ 'clave' ].'" readonly /><input type="hidden" value="'.$rs->fields[ 'alm' ].'" id="movIndividualNuevo_origen_'.$i.'" name="movIndividualNuevo_origen_'.$i.'" /></td>'
                                . '<td>Existencias:</td>'
                                . '<td><input value="'.$rs->fields[ 'cantidad' ].'" id="movIndividualNuevo_existencias_'.$i.'" name="movIndividualNuevo_existencias_'.$i.'" size="10" readonly /></td>'
                                . '<td>Destino:</td>'                                
                                . '<td width="12%">'.$select.'</td>'
                                . '<td>Marca:</td>'                                
                                . '<td><input value="'.$rs->fields[ 'marca' ].'" id="movIndividualNuevo_marca_'.$i.'" name="movIndividualNuevo_marca_'.$i.'" size="12" readonly /></td>'
                                . '<td>Elementos a traspasar:</td>'
                                . '<td><input value="" id="movIndividualNuevo_cantidadMover_'.$i.'" name="movIndividualNuevo_cantidadMover" size="5" /></td>'
                                . '<td><button id="btnMovIndividualNuevo_cantidadMover_'.$i.'" name="btnMovIndividualNuevo_cantidadMover_'.$i.'">Traspasar</button>'
                                . '<script>$(\'#btnMovIndividualNuevo_cantidadMover_'.$i.'\').button().click(function(){nuevoTraspasoIndividual('.$i.')});</script>'
                                . '</td>'
                                . '<input type="hidden" id="movIndividualNuevo_cliente_'.$i.'" name="movIndividualNuevo_cliente_'.$i.'" value="'.$rs->fields[ 'cli' ].'" />'
                            . '</tr>'
                        . '</table>';
                $rs->MoveNext();
            }
        }else{
            $html .= '<center>El SKU no fue encontrado en alguno de los almacenes disponibles</center>';
        }

        return $html;
    }

    /*
     * Guarda solicitud de movimiento individual entre almacenes
     */
    public function enviaNuevoTraspasoIndividual() {
        $origen   = $_POST[ 'almacenOrigen' ];
        $destino  = $_POST[ 'almacenDestino' ];
        $sku      = $_POST[ 'sku' ];
        $cantidad = $_POST[ 'cantidadMover' ];
        $cliente  = $_POST[ 'cliente' ];
        $sql  = " INSERT INTO inv_trasladoMasivo(fechaSolicitud, origen, destino, layout, sku, total, usuarioSolicita, marca, aplicado, status) VALUES ";
        $sql .= "( '".date("Y-m-d H:i:s")."', '".$origen."', '".$destino."', 0, '".$sku."', '".$cantidad."', '".$_SESSION['idUsuario']."', '".$cliente."',0, 1 )";
        $rs   = $this->dbCon->ejecutaComando( $sql );

        if( $rs ) {
                return "OK";
            } else {
                return "NOOK";
        }
    }

    /* ***************************
     *      CONSULTA DE INVENTARIOS
     * ***************************/
 
     /*
     * Metodo que contiene la estructrua de las columnas del grid de consulta de almacenes, se mostraran los items principales sin el detalle completo
     */
    public function catalogoItemsInventarios_arreglo() {
        $columnas = array(
            'ID'      => array( 'name'=>'idty'    ,'index'=>'idty'       ,'width'=>40 ,'align'=>'center','editable'=>false),
            'SKU'     => array( 'name'=>'sku'     ,'index'=>'e.sku'      ,'width'=>90 ,'align'=>'center','editable'=>false),            
            'Nombre'  => array( 'name'=>'nombre'  ,'index'=>'i.nombre'   ,'width'=>150,'align'=>'center','editable'=>false),            
            'Modelo'  => array( 'name'=>'modelo'  ,'index'=>'modelo'     ,'width'=>80 ,'align'=>'center','editable'=>false),
            'Cliente' => array( 'name'=>'cliente' ,'index'=>'cliente'    ,'width'=>50 ,'align'=>'center','editable'=>false),
            'Almacen' => array( 'name'=>'almacen' ,'index'=>'almacen'    ,'width'=>70 ,'align'=>'center','editable'=>false),
            'Cantidad'=> array( 'name'=>'cantidad','index'=>'cantidad'   ,'width'=>60 ,'align'=>'center','editable'=>false),
            'Layout'  => array( 'name'=>'layout'  ,'index'=>'i.idLayout' ,'width'=>50 ,'align'=>'center','editable'=>false),            
            'Estatus' => array( 'name'=>'proceso' ,'index'=>'proceso'    ,'width'=>50 ,'align'=>'center','editable'=>false),            
            'OPC'     => array( 'name'=>'opt'     ,'index'=>'opt'        ,'width'=>60 ,'align'=>'center','editable'=>false)
        );
        return $columnas;
    }

    /*
     * Metodo que agrega las opciones adicionales en el grid de listado de inventarios
     */
    public function opcionesGridListadoInventarios() {
        $html  = '<div style="display-inline">';
        $html .= '&nbsp;<span id="verLoteItemInventarios" name="verLoteItemInventarios" onclick="muestraDetalleLotes()" class="ui-icon ui-icon-calculator" title="Ver Lote" style="cursor: pointer;display: inline-block"></span>';
        $html .= '&nbsp;<span id="editaItemInventarios" name="editaItemInventarios" onclick="editaItemInventarios()" class="ui-icon ui-icon-pencil" title="Editar Elemento" style="cursor: pointer;display: inline-block"></span>';
        $html .= '&nbsp;<span id="printGridInventarios"  name="printGridInventarios"  onclick="generaFichaTecnica()"  class="ui-icon ui-icon-contact"  title="Ver Ficha T&eacute;cnica" style="cursor: pointer;display: inline-block"></span>';
        $html .= '&nbsp;<span id="eliminaItemInventarios" name="eliminaItemInventarios" onclick="eliminaItemInventarios()" class="ui-icon ui-icon-trash" title="Eliminar Elemento" style="cursor: pointer;display: inline-block"></span>';
        $html .= '</div>';
        return $html;
    }

    /*
     * Metodo que solicita la estructura XML del listado principal de items para el inventario
     */
    public function datosGridListadoItemsInventarios() {
        #$sql  = " SELECT inv_item.id AS id,inv_item.id AS idty, inv_item.sku as sku, inv_item.nombre, modelo, cli_listado.nombreCliente AS cliente, ";
        #$sql .= " inv_almacenes.clave AS almacen,inv_item.cantidad AS cantidad, inv_item.idLayout, sis_status_item.descripcion, '".$this->opcionesGridListadoInventarios()."' AS opt ";
        #$sql .= " FROM inv_item LEFT JOIN cli_listado ON inv_item.cliente=cli_listado.id LEFT JOIN inv_almacenes ON inv_item.almacen=inv_almacenes.id ";
        #$sql .= " LEFT JOIN sis_status_item ON inv_item.proceso=sis_status_item.id WHERE inv_item.status IN (1,2) ";
        $sql  = " SELECT e.id AS id, i.id AS idty, IF(i.modelo<>'N/A','',e.sku) AS sku, i.nombre, i.modelo AS modelo, c.clave AS cliente , a.clave AS almacen, e.cantidad AS cantidad, i.idLayout, ";
        $sql .= " s.descripcion AS proceso , '".$this->opcionesGridListadoInventarios()."' AS opt FROM inv_existencias AS e ";
        $sql .= " LEFT JOIN inv_item AS i ON e.sku=i.sku LEFT JOIN cli_listado AS c ON c.id=e.cliente LEFT JOIN inv_almacenes AS a ON a.id=e.almacen LEFT JOIN sis_status_item AS s ON i.status=s.id ";
        $sql .= " WHERE i.status IN (1,2) ";
        if( $_SESSION['tipoAcceso'] == 'clientes' ) {
            $sql .= " AND i.cliente='".$_SESSION['valor']."' ";
        }
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND i.cliente IN (".$marcas.") ";
        }

        $grid = new DataGrid( $sql , 'Items en inventario');
        echo $grid->datosXML;
    }

    /*
     * Metodo que contiene la estructura de columnas del grid de consulta de inventarios por lotes
     */
    public function catalogoItemsInventariosPorLotes_arreglo() {
        $columnas = array(
            'ID'          => array( 'name'=>'idty'           ,'index'=>'idty'          ,'width'=>70 ,'align'=>'center','editable'=>false),
            'Modelo'      => array( 'name'=>'modelo'         ,'index'=>'l.modelo'      ,'width'=>150,'align'=>'center','editable'=>false),
            'SKU'         => array( 'name'=>'sku'            ,'index'=>'l.sku'         ,'width'=>170,'align'=>'center','editable'=>false),
            'IMEI'        => array( 'name'=>'imei'           ,'index'=>'l.imei'        ,'width'=>170 ,'align'=>'center','editable'=>false),
            'Estado'      => array( 'name'=>'estado'         ,'index'=>'l.estado'      ,'width'=>80 ,'align'=>'center','editable'=>false),            
            'F.Alta'      => array( 'name'=>'fechaAlta'      ,'index'=>'l.fechaAlta'   ,'width'=>80 ,'align'=>'center','editable'=>false),            
            'Responsable' => array( 'name'=>'responsable'    ,'index'=>'l.responsable' ,'width'=>150 ,'align'=>'center','editable'=>false),
            'Estatus'     => array( 'name'=>'proceso'        ,'index'=>'s.descripcion' ,'width'=>90,'align'=>'center','editable'=>false)
        );

        return $columnas;
    }

    /*
     * Metodo que solicita la estructura XML del listado de inventarios por lotes
     */
    public function datosGridListadoItemsInventariosPorLotes( $id ) {
        $sqlModelo = " SELECT modelo FROM inv_item WHERE id ='".$id."' ";
        $rsModelo  = $this->dbCon->ejecutaComando( $sqlModelo );        
        $modelo    = $rsModelo->fields['modelo'];
        $sql       = " SELECT l.id, l.id AS idty, l.modelo , l.sku, l.imei, l.estado, l.fechaAlta, l.responsable, s.descripcion ";
        $sql      .= " FROM inv_lote AS l LEFT JOIN sis_status_item AS s ON l.proceso=s.id WHERE l.modelo='".$modelo."' ";
        $grid      = new DataGrid( $sql , 'Inventarios por Lotes :: Modelo '.$modelo );
        echo $grid->datosXML;
    }

    /*
     * Metodo que hace la consulta para la informacion tecnica de cada item
     */
    public function informacionTecnicaItem( $id , $idty ) {
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $sql   = " SELECT * FROM inv_item WHERE id='".$idty."' ";
        $rs    = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
        
        foreach( $rs AS $k=>$v ) {
            $datos[ $k ] = $v;
        }

        $sqlCant = " SELECT cantidad FROM inv_existencias WHERE id='".$id."' ";
        $rsCant  = $this->dbCon->ejecutaComando( $sqlCant );
        $datos[ 0 ][ 'cantidad' ] = $rsCant->fields[ 'cantidad' ];

        return $datos;
    }

    /*
     * Metodo que genera la imagen del Item
     */
    public function generaImagenItem( $id ) {
        $contenidoImagen = "";
        $sql = " SELECT file FROM inv_item WHERE id = '".$id."' ";
        $rs    = $this->dbCon->ejecutaComando( $sql );
        if($rs){
            $contenidoImagen = $rs->fields['file'];
            if($contenidoImagen == ""){
                //Mostramos imagen default
                $filename = _DIRPATH_ ."/assets/imgs/imagenNoDisponible.jpg";
                $gestor = fopen( $filename , "r" );
                $contenidoImagen = fread( $gestor , filesize( $filename ) );
                fclose( $gestor );
                header("Content-type: image/jpeg");
                echo $contenidoImagen;
            }else{
                header("Content-type: image/jpeg");
                echo $contenidoImagen;
            }
        }
    }

    /*
     * Metodo que hace el upload de la imagen del item en la base de datos
     */
    public function uploadImagenItem($id) {
        $input        = 'imagenItenFichaTecnica';
        $this->upload = new Upload( $input );
        $fp           = fopen( $this->upload->rutaFinal , 'r' );
        $content      = fread( $fp , filesize( $this->upload->rutaFinal ) );
        $content      = addslashes( $content );
        $this->upload->eliminaLayout();

        $sql  = " UPDATE inv_item SET file = '".$content."' WHERE id = '".$id."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * Metodo que genera un reporte en PDF de la ficha tecnica de un item
     */
    public function generaPDFFichaTecnicaItem( $id ) {
        $sql = " SELECT * FROM inv_item WHERE id='".$id."' ";
        $rs = $this->dbCon->ejecutaComando( $sql );
        $datos = array();

        while( !$rs->EOF ){
            $imagen                    = $rs->fields['file'];
            $sku                       = $rs->fields['sku'];
            $datos[ 'sku' ]            = $sku;
            $datos[ 'nombre' ]         = $rs->fields[ 'nombre' ];
            $datos[ 'modelo' ]         = $rs->fields[ 'modelo' ];
            $datos[ 'imei' ]           = $rs->fields[ 'imei' ];
            $datos[ 'descripcion' ]    = $rs->fields[ 'descripcion' ];
            $datos[ 'marca' ]          = $rs->fields[ 'marca' ];
            $datos[ 'cantidad' ]       = $rs->fields[ 'cantidad' ];
            $datos[ 'talla' ]          = $rs->fields[ 'talla' ];
            $datos[ 'peso' ]           = $rs->fields[ 'peso' ];
            $datos[ 'unidadPeso' ]     = $rs->fields[ 'unidadPeso' ];
            $datos[ 'capacidad' ]      = $rs->fields[ 'capacidad' ];
            $datos[ 'costo' ]          = $rs->fields[ 'costo' ];
            $datos[ 'moneda' ]         = $rs->fields[ 'moneda' ];
            $datos[ 'unidadMedida' ]   = $rs->fields[ 'unidadMedida' ];
            $datos[ 'alto' ]           = $rs->fields[ 'alto' ];
            $datos[ 'ancho' ]          = $rs->fields[ 'ancho' ];
            $datos[ 'largo' ]          = $rs->fields[ 'largo' ];
            $datos[ 'sabor' ]          = $rs->fields[ 'sabor' ];
            $datos[ 'color' ]          = $rs->fields[ 'color' ];
            $datos[ 'empaque' ]        = $rs->fields[ 'empaque' ];
            $datos[ 'rack' ]           = $rs->fields[ 'rack' ];
            $datos[ 'posicionRack' ]   = $rs->fields[ 'posicionRack' ];
            $datos[ 'almacen' ]        = $rs->fields[ 'almacen' ];
            $datos[ 'fechaIngreso' ]   = $rs->fields[ 'fechaIngreso' ];
            $datos[ 'resurtido' ]      = $rs->fields[ 'resurtido' ];
            $datos[ 'tamano' ]         = $rs->fields[ 'tamano' ];
            $datos[ 'almacenamiento' ] = $rs->fields[ 'almacenamiento' ];
            $datos[ 'cliente' ]        = $rs->fields[ 'cliente' ];
            $rs->MoveNext();
        }

        $documento = new Documentos( 'detalleitem' , $datos , true );
        if( $imagen != '' ){
            $this->generaImagenPDF( $imagen , $sku );
            $documento->generaImagen( 'img_' . $sku . '.jpg' , 35 , 195 , 150 , 150 , 'jpg' );
        }
        $documento->descargaDocumento();
    }

    /*
     * Elimina elemento del inventario
     */
    public function eliminaElementoInventario( $id , $almacen , $sku ) {
        #$sql = " DELETE FROM inv_item WHERE id='".$id."' ";
        #$rs = $this->dbCon->ejecutaComando( $sql );
        #if( $rs ) {
        $sqlEx = " UPDATE inv_existencias SET cantidad=0 WHERE sku='".$sku."' AND almacen=(SELECT id FROM inv_almacenes WHERE clave='".$almacen."') ";
        $rs    = $this->dbCon->ejecutaComando( $sqlEx );
        if( $rs ) {
                echo "OK";
            } else {
                echo "NOOK";
        }
    }

    /*
     * Metodo que genera la imagen del item para el reporte PDF
     */
    protected function generaImagenPDF( $imagen , $sku ) {
        if( file_exists( _TEMPUPLOAD_ . '/img_' . $sku . '.jpg' ) ){ @unlink( _TEMPUPLOAD_ . '/img_' . $sku . '.jpg' ); }
        $file = @fopen( _TEMPUPLOAD_ . '/img_' . $sku . '.jpg' , 'x+' );
        @fwrite( $file , $imagen );
        @fclose( $file );
    }

    /* ***************************
     *      CATALOGO DE UNIDADES DE MEDICION
     * ***************************/
    
    /*
     * Metodo que contiene la estructura de las columnas del grid de catalogo de almacenes
     */
    public function catalogoUnidadesMedicion_arreglo() {
        $consulta = " SELECT id,magnitud FROM inv_magnitudes WHERE status=1 ";
        $columnas = array(
            'Id'       => array( 'name'=>'idty'    ,'index'=>'idty'    ,'width'=>90 ,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Unidad'   => array( 'name'=>'unidad'  ,'index'=>'unidad'  ,'width'=>200,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Magnitud' => array( 'name'=>'magnitud','index'=>'magnitud','width'=>230,'align'=>'center','editable'=>true,'editrules'=>'{required:true}','edittype'=>'select','editoptions'=>'{value:"'.$this->utiles->generaComboDinamicoGrid($consulta).'"}' ),
            'Estatus'  => array( 'name'=>'status'  ,'index'=>'status'  ,'width'=>60 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}','edittype'=>'select','editoptions'=>'{value:"1:Activo;2:Inactivo"}')
        );
        return $columnas;
    }

    /*
     * Metodo que contiene los datos a mostrar en el grid de unidades de medicion
     */
    public function datosGridListadoUnidadesMedicion() {
        $sql = " SELECT uni.id, uni.id AS idty, uni.unidad, mag.magnitud, IF(uni.status=1,'Activo','Inactivo') AS status FROM inv_unidades AS uni LEFT JOIN inv_magnitudes AS mag ON uni.magnitud=mag.id WHERE uni.status IN (1,2)  ";
        $grid = new DataGrid( $sql , 'Unidades de Medida' );
        echo $grid->datosXML;
    }

    /*
     * Metodo que elimina una unidad de medicion en particular
     */
    public function eliminaUnidadMedicion(){
        $sql = " UPDATE inv_unidades SET status=3, fechaModifica='".date('Y-m-d H:i:s')."' WHERE id='" . $_POST['id'] . "' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){ return true; }
        else{ return false; }
    }

    /*
     * Metodo que edita una unidad de medicion
     */
    public function editaUnidadMedicion() {
        $sql = " UPDATE inv_unidades SET unidad='".$_POST['unidad']."', magnitud='".$_POST['magnitud']."', status='".$_POST['status']."', fechaModifica='".date('Y-m-d H:i:s')."' WHERE id='".$_POST['id']."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        
        if( $rs ){ return true; }
        else{ return false; }
    }
    
    /*
     * Metodo que agrega una nueva unidad de medicion al catalogo
     */
    public function agregaUnidadMedicion() {
        $sql = " INSERT INTO inv_unidades(unidad, magnitud, status, fechaAlta, fechaModifica) VALUES( '".$_POST['unidad']."', '".$_POST['magnitud']."', '".$_POST['status']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."' ) ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        
        if( $rs ){ return true; }
        else{ return false; }
    }

    /* ***************************
     *      ALTA EN ALMACENES
     * ***************************/

    /*
     * Listado de layouts procesados
     */
    public function layoutsProcesados_arreglo() {
        $columnas = array(
            'Nombre'    => array( 'name'=>'nombreLayout','index'=>'nombreLayout','width'=>180,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'ID'        => array( 'name'=>'idtyLayout'  ,'index'=>'idtyLayout'  ,'width'=>180,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Registros' => array( 'name'=>'registros'   ,'index'=>'registros'   ,'width'=>180,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Fecha'     => array( 'name'=>'fechaUso'    ,'index'=>'fechaUso'    ,'width'=>180,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Usuario'   => array( 'name'=>'usuario'     ,'index'=>'usuario'     ,'width'=>180,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Almacen'   => array( 'name'=>'idtyAlmacen' ,'index'=>'idtyAlmacen' ,'width'=>180,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Marca'     => array( 'name'=>'idtyCliente' ,'index'=>'idtyCliente' ,'width'=>180,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Detalle'   => array( 'name'=>'detalle'     ,'index'=>'detalle'     ,'width'=>60,'align'=>'center','editable'=>false,'editrules'=>'{required:true}','sortable'=>false )
        );
        return $columnas;
    }
    
    /*
     * Opcion para la descarga de layouts
     */
    public function opcionesGridDetallesLayouts() {
        $html  = '<div style="display-inline">';
        $html .= '&nbsp;<span id="detalleLayoutProc" name="detalleLayoutProc" onclick="muestraDetallePorLayout()" class="ui-icon ui-icon-calculator" title="Ver Detalle" style="cursor: pointer;display: inline-block"></span>';
        $html .= '</div>';
        return $html;
    }

    /*
     * Metodo que genera la descarga del detalle de alta de layout
     */
    public function detalleLayoutDescarga( $id ) {
        $sql       = " SELECT detalle FROM inv_detalle_uploadLayout WHERE idLayout='".$id."' ";
        $rs        = $this->dbCon->ejecutaComando( $sql );
        $contenido = '';

        while( !$rs->EOF ) {
            $contenido = $rs->fields['detalle'];
            $rs->MoveNext();
        }

        header( "Content-type: text/plain" );
        header( "Content-Disposition: attachment; filename=detalle.txt" );
        echo str_replace( "|" , "\n" , $contenido );
    }

    /*
     * Crea la estructura XML necesaria para mostrar la informacion en el grid
     */
    public function datosGridLayoutsProcesados() {
        $sql  = " SELECT a.id,l.nombreLayout, l.idtyLayout, l.registros, l.fechaUso, l.usuario, a.clave, cl.clave, '".$this->opcionesGridDetallesLayouts()."' AS detalle FROM inv_layout AS l LEFT JOIN inv_almacenes AS a ON l.idtyAlmacen=a.id LEFT JOIN cli_listado AS cl ON l.idtyCliente=cl.id WHERE l.status IN (1,2)";
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND l.idtyCliente IN (".$marcas.") ";
        }
        $grid = new DataGrid( $sql , 'Layouts Procesados' );
        echo $grid->datosXML;
    }

    /*
     * Metodo que genera los combos dinamicos del alta en almacenes
     */
    public function combosAltaEnAlmacenes() {
    	/* Combo de Almacenes */
        $sql1 = " SELECT id, clave FROM inv_almacenes WHERE status='1' ";
        if( $_SESSION['tipoAcceso'] == 'clientes' ){
            $sql1 .= " AND cliente='".$_SESSION['valor']."' ";
        }
        $cmbAlmacenes = $this->utiles->generaComboDinamico( 'altaInventarios_comboAlmacenes' , $sql1 );
        /* Combo Clientes */
        $sql2 = " SELECT id, nombreCliente FROM cli_listado WHERE status='1' ";
        if( $_SESSION['tipoAcceso'] == 'clientes' ){
            $sql2 .= " AND id='".$_SESSION['valor']."' ";
        }
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql2 .= " AND id IN (".$marcas.") ";
        }
        $cmbClientes = $this->utiles->generaComboDinamico( 'altaInventarios_comboClientes' , $sql2 );
	/* Combo Unidad de Medida */
        $cmbUnidadDeMedida = $this->utiles->generaComboDinamico( 'altaInventariosInd_uMedida' , 'SELECT id, unidad FROM inv_unidades WHERE status=\'1\' ' );
        /* Combo Unidad Peso */
        $cmbUnidadPeso = $this->utiles->generaComboDinamico( 'altaInventariosInd_unidadPeso' , 'SELECT id, unidad FROM inv_unidades WHERE status=\'1\' ' );

        return array( $cmbAlmacenes , $cmbClientes, $cmbUnidadDeMedida, $cmbUnidadPeso );
    }

    /*
     * Procesa el archivo csv recien adjuntado
     */
    public function procesaLayoutInventario() {
        $input = 'altaInventarios_LayoutAdjuntar';
        $this->upload = new Upload( $input );
        $mensaje = '';
        $proceso = '';
        $datos   = '';

        $layout = new Layout( $this->upload->rutaFinal , $this->upload->fileName , $_POST['altaInventarios_comboClientes'] , $_POST['altaInventarios_comboAlmacenes'] );

        if( $layout->verificaLayout() ){
                /*
                 * El layout ha sido previamente procesado
                 */
                 $mensaje = $layout->mensaje;
            }else{
                /*
                 * Se procesa el layout
                 */
                $proceso = $layout->procesaLayout( $this->upload->formato );
                $mensaje = $layout->mensaje;
                $datos   = $layout->datos;
        }

        $this->upload->eliminaLayout();
        return $mensaje;
    }

    public function procesaAltaEnAlmacenes(){
        
    }

    /*
     * Metodo para guardar Item y lotes en base de datos
     */
    public function guardarItemLote(){

    }

    /*
     * Metodo para guardar la edicion de un item del inventario
     */
    public function guardaEdicionItemInventario() {
        $input = 'editaInventarios_ImagenAdjuntar';
        $this->upload = new Upload( $input );
	$fp = fopen($this->upload->rutaFinal, 'r');
        $content = addslashes( fread($fp, filesize($this->upload->rutaFinal)) );
        $this->upload->eliminaLayout();

        $sql  = " UPDATE inv_item SET nombre='" . strtoupper( $_POST['editaInventariosInd_nombre'] ) . "', descripcion='" . strtoupper( $_POST['editaInventariosInd_descripcion'] ) . "', serie='" . strtoupper( $_POST['editaInventariosInd_serie'] ) . "', ";
        $sql .= " marca='" . strtoupper( $_POST['editaInventariosInd_marca'] ) ."', sku='" . strtoupper( $_POST['editaInventariosInd_sku'] ) . "', modelo='" . strtoupper( $_POST['editaInventariosInd_modelo'] ) . "', ";
        $sql .= " responsable='" . strtoupper( $_POST['editaInventariosInd_responsable'] ) . "', estado='" . strtoupper( $_POST['editaInventariosInd_estado'] ) . "', cantidad='1', ";
        $sql .= " talla='" . strtoupper( $_POST['editaInventariosInd_talla'] ) . "', peso='" . strtoupper( $_POST['editaInventariosInd_peso'] ) . "', unidadPeso='" . strtoupper( $_POST['altaInventariosInd_unidadPeso'] ) . "', ";
        $sql .= " capacidad='" . strtoupper( $_POST['editaInventariosInd_capacidad'] ) . "', costo='" . strtoupper( $_POST['editaInventariosInd_costo'] ) . "', moneda='" . strtoupper( $_POST['editaInventariosInd_moneda'] ) . "', ";
        $sql .= " unidadMedida='" . strtoupper( $_POST['altaInventariosInd_uMedida'] ) . "', alto='" . strtoupper( $_POST['editaInventariosInd_alto'] ) . "', ancho='" . strtoupper( $_POST['editaInventariosInd_ancho'] ) . "', ";
        $sql .= " largo='" . strtoupper( $_POST['editaInventariosInd_largo'] ) . "', sabor='" . strtoupper( $_POST['editaInventariosInd_sabor'] ) . "', color='" . strtoupper( $_POST['editaInventariosInd_color'] ) . "', ";
        $sql .= " rack='" . strtoupper( $_POST['editaInventariosInd_rack'] ) . "', posicionRack='" . strtoupper( $_POST['editaInventariosInd_posicionRack'] ) . "', almacen='" . strtoupper( $_POST['altaInventarios_comboAlmacenes'] ) . "', ";
        $sql .= " fechaIngreso='".date('Y-m-d')."', cliente='".$_POST['altaInventarios_comboClientes']."', status='1',  ";
        if( !empty( $content ) ){ $sql .= " file='".$content."', "; }
        $sql .= " imei='".$_POST['editaInventariosInd_imei']."' ";
        $sql .= " WHERE id='".$_POST['editaInventariosInd_id']."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        if( $rs ) {
            return _EDITAITEMINVEXITO_;
        } else {
            trigger_error( "CONSULTA:" . $sql );
            return _EDITAITEMINVERROR_;
        }
    }

    /*
     * Procesa imagen inventario individual
     */
    public function procesaAltaInventariosIndiv() {
        $input = 'altaInventarios_ImagenAdjuntar';
        $this->upload = new Upload( $input );
	$fp = fopen($this->upload->rutaFinal, 'r');
        $content = fread($fp, filesize($this->upload->rutaFinal));
        $content = addslashes($content);
        $this->upload->eliminaLayout();

        $sql  = " INSERT INTO inv_item( nombre, descripcion, serie, marca, ";
        $sql .= " sku, modelo, responsable, estado, cantidad, talla, ";
        $sql .= " peso, unidadPeso, capacidad, costo, moneda, ";
        $sql .= " unidadMedida, alto, ancho, largo, sabor, ";
        $sql .= " color, rack, posicionRack, almacen, fechaIngreso, ";
        $sql .= " resurtido, cliente, almacenamiento, idLayout, status, ";
        $sql .= " file,imei,proceso) VALUES('" . strtoupper( $_POST['altaInventariosInd_nombre'] ) . "','" . strtoupper( $_POST['altaInventariosInd_descripcion'] ) . "','" . strtoupper( $_POST['altaInventariosInd_serie'] ) . "','".$_POST['altaInventarios_comboClientes']."', ";
        $sql .= " '" . strtoupper( $_POST['altaInventariosInd_sku'] ) . "','" . strtoupper( $_POST['altaInventariosInd_modelo'] ) . "','" . strtoupper( $_POST['altaInventariosInd_responsable'] ) . "','" . strtoupper( $_POST['altaInventariosInd_estado'] ) . "','" . $_POST['altaInventariosInd_cantidad'] . "','" . strtoupper( $_POST['altaInventariosInd_talla'] ) . "', ";
        $sql .= " '" . strtoupper( $_POST['altaInventariosInd_peso'] ) . "','" . strtoupper( $_POST['altaInventariosInd_unidadPeso'] ) . "','" . strtoupper( $_POST['altaInventariosInd_capacidad'] ) . "','".$_POST['altaInventariosInd_costo']."','" . strtoupper( $_POST['altaInventariosInd_moneda'] ) . "', ";
        $sql .= " '" . $_POST['altaInventariosInd_uMedida'] . "','" . strtoupper( $_POST['altaInventariosInd_alto'] ) ."','" . strtoupper( $_POST['altaInventariosInd_ancho'] ) ."','" . strtoupper( $_POST['altaInventariosInd_largo'] ) . "','" . strtoupper( $_POST['altaInventariosInd_sabor'] ) . "', ";
        $sql .= " '" . strtoupper( $_POST['altaInventariosInd_color'] ) . "', '" . strtoupper( $_POST['altaInventariosInd_rack'] ) . "', '" . strtoupper( $_POST['altaInventariosInd_posRack'] ) . "', '".$_POST['altaInventarios_comboAlmacenes1']."', '".$_POST['altaInventariosInd_fechaIngreso']."', ";
        $sql .= " '2001-01-01','".$_POST['altaInventarios_comboClientes1']."','','0','1', ";
        $sql .= " '".$content."','".$_POST['altaInventariosInd_imei']."','1') ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){
            $this->generaExistencias( $_POST['altaInventariosInd_sku'] , $_POST['altaInventarios_comboAlmacenes1'], $_POST['altaInventariosInd_cantidad'], $_POST['altaInventarios_comboClientes1']);
            $sqlLote  = " INSERT INTO inv_lote(modelo, sku, imei, serie, estado, marca, almacen, responsable, status, fechaAlta, idtyLayout, proceso ) ";
            $sqlLote .= " VALUES ( '".$_POST['altaInventariosInd_modelo']."' , '".$_POST['altaInventariosInd_sku']."' , '".$_POST['altaInventariosInd_imei']."' , '".$_POST['altaInventariosInd_serie']."' , '".$_POST['altaInventariosInd_estado']."' , '".$_POST['altaInventarios_comboClientes']."' , '".$_POST['altaInventarios_comboAlmacenes1']."' , '".$_POST['altaInventariosInd_responsable']."' , 1 , '".date('Y-m-d')."' , 'M' ,  1 ) ";
            $this->dbCon->ejecutaComando( $sqlLote );
            return true;
        }else{
            if( $this->dbCon->errorCod == '1062' ){
                $sqlLote  = " INSERT INTO inv_lote(modelo, sku, imei, serie, estado, marca, almacen, responsable, status, fechaAlta, idtyLayout, proceso ) ";
                $sqlLote .= " VALUES ( '".$_POST['altaInventariosInd_modelo']."' , '".$_POST['altaInventariosInd_sku']."' , '".$_POST['altaInventariosInd_imei']."' , '".$_POST['altaInventariosInd_serie']."' , '".$_POST['altaInventariosInd_estado']."' , '".$_POST['altaInventarios_comboClientes']."' , '".$_POST['altaInventarios_comboAlmacenes1']."' , '".$_POST['altaInventariosInd_responsable']."' , 1 , '".date('Y-m-d')."' , 'M' ,  1 ) ";
                $this->dbCon->ejecutaComando( $sqlLote );
                return true;
            }else{
                return false;
            }
        }
    }

    /*
     * Metodo que agrega el registro de existencias
     */
    private function generaExistencias( $sku , $almacen , $cantidad , $cliente ) {
        $sql = " INSERT INTO inv_existencias(sku, almacen, cantidad, fechaRegistro, cliente ) "
             . " VALUES( '".$sku."', '".$almacen."', '".$cantidad."', '".date( 'Y-m-d H:i:s' )."', '".$cliente."' ) "
             . " ON DUPLICATE KEY UPDATE cantidad=cantidad+".$cantidad."; ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        $sql2  = " INSERT INTO `inv_movInventarios` ( `tipo`, `sku`, `almacen`, `cliente`, `cantidad`, `fechaMovimiento`, `usuario`, `status`) VALUES "
               . " ( '1', '".$sku."', '".$almacen."', '".$cliente."', '".$cantidad."', '".date("Y-m-d H:i:s")."', '".$_SESSION['idUsuario']."',1) ";
        $this->dbCon->ejecutaComando( $sql2 );

        if( $rs )return true;
        else return false;
    }

    /* ***************************
     *      MOVIMIENTOS EN INVENTARIO
     * ***************************/

    /*
     * Metodo que genera los combos dinamicos del alta en almacenes
     */
    public function combosSeleccionAlmacenInventario() {
        /* Combo de Almacenes */
        $sql1 = " SELECT id, clave FROM inv_almacenes WHERE status='1' ";
        if( $_SESSION['tipoAcceso'] == 'clientes' ){
            $sql1 .= " AND cliente='".$_SESSION['valor']."' ";
        }
        $cmbAlmacenEntrada = $this->utiles->generaComboDinamico( 'movInventarios_almacenEntrada' , $sql1 );
        
        /* Combo Clientes */
        $sql2 = " SELECT id, clave FROM inv_almacenes WHERE status='1' ";
        if( $_SESSION['tipoAcceso'] == 'clientes' ){
            $sql2 .= " AND cliente='".$_SESSION['valor']."' ";
        }
        $cmbAlmacenSalida = $this->utiles->generaComboDinamico( 'movInventarios_almacenSalida' , $sql2 );
        
        /* Combo Layouts */
        $sqlL  = ' SELECT idtyLayout, CONCAT(nombreLayout," / ",idtyLayout) AS layout FROM inv_layout WHERE status=\'1\' ';
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sqlL .= " AND idtyCliente IN (".$marcas.") ";
        }
        $cmbLayoutsProcs = $this->utiles->generaComboDinamico( 'movInventarios_seleccionaLayout' , $sqlL );

        /* Combo CLientes */
        $sql3 = " SELECT id, nombreCliente FROM cli_listado WHERE status=1 ";
        if( $_SESSION['tipoAcceso'] == 'clientes' ){
            $sql3 .= " AND id='".$_SESSION['valor']."' ";
        }
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql3 .= " AND id IN (".$marcas.") ";
        }
        $cmbClientesExt  = $this->utiles->generaComboDinamico( 'existenciasComboClientes' , $sql3 );

        return array( $cmbAlmacenEntrada , $cmbAlmacenSalida , $cmbLayoutsProcs , $cmbClientesExt );
    }

    /*
     * Metodo que regresa listado de almacenes disponibles para entrada
     */
    public function cargaAlmacenesEntradaTraspaso( $idSalida ){
        $sql   = " SELECT id, clave FROM inv_almacenes WHERE id <> ".$idSalida." AND status='1' ";
        $rs    = $this->dbCon->ejecutaComando( $sql );
        $datos = array();

        while( !$rs->EOF ) {
            $datos[] = array( "id" => $rs->fields['id'] , "clave" => $rs->fields['clave'] );
            $rs->MoveNext();
        }

        return json_encode( $datos );
    }

    /*
     * Metodo que regresa los layouts del almacen seleccionado de salida
     */
    public function cargaLayoutsTraspasoAlmacenSalida( $idSalida ) {
        $sql   = " SELECT idtyLayout, CONCAT(nombreLayout,'/',idtyLayout) AS clave FROM inv_layout WHERE idtyAlmacen = ".$idSalida." AND status='1' ";
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND idtyCliente IN (".$marcas.") ";
        }
        $rs    = $this->dbCon->ejecutaComando( $sql );
        $datos = array();

        while( !$rs->EOF ) {
            $datos[] = array( "id" => $rs->fields['idtyLayout'] , "clave" => $rs->fields['clave'] );
            $rs->MoveNext();
        }

        return json_encode( $datos );
    }

    /*
     * Metodo que verifica los parametros para el traslado de inventarios entre
     * almacenes
     */
    public function trasladoInventarios() {
        $almacenEntrada = $_POST['almacenEntrada'];
        $almacenSalida  = $_POST['almacenSalida'];
        $loteLayout     = $_POST['loteLayout'];
        $afectados      = 0;

        /* Verifica elementos items a trasladar */
        $sqlItem = " SELECT COUNT(*) AS total FROM inv_item WHERE almacen='".$almacenSalida."' AND idLayout='".$loteLayout."' AND proceso=1 AND status=1 ";
        $rsItem  = $this->dbCon->ejecutaComando( $sqlItem );
        
        if( $rsItem->fields['total'] > 0 ){
            $afectados     = $rsItem->fields['total'];            
            $sqlItemUpdate = " UPDATE inv_item SET proceso=2 WHERE almacen='".$almacenSalida."' AND idLayout='".$loteLayout."' AND proceso=1 AND status=1 ";
            $rsItemUpdate  = $this->dbCon->ejecutaComando( $sqlItemUpdate );
            
            $sqlMarca = " SELECT idtyCliente FROM inv_layout WHERE idtyLayout='".$loteLayout."'  ";
            $rsMarca  = $this->dbCon->ejecutaComando( $sqlMarca );
            
            if( $rsItemUpdate ){
                $this->registraTraspaso( $almacenSalida , $almacenEntrada , $loteLayout , $rsMarca->fields['idtyCliente'] , $afectados );
            }            
        } else {
            /* Lo que se traslada sera el lote */
            $sqlMarca = " SELECT marca FROM inv_lote WHERE idtyLayout='".$loteLayout."' LIMIT 1 ";
            $rsMarca  = $this->dbCon->ejecutaComando( $sqlMarca );
            $sqlLote = " UPDATE inv_lote SET proceso=2 WHERE almacen='".$almacenSalida."' AND idtyLayout='".$loteLayout."' AND proceso=1 AND status=1 ";
            $rsLote  = $this->dbCon->ejecutaComando( $sqlLote );
            if( $rsLote ){
                $afectados = $this->dbCon->affected;
                $this->registraTraspaso( $almacenSalida , $almacenEntrada , $loteLayout , $rsMarca->fields['marca'] , $afectados );
            }
        }

        if( $afectados == 0 ){
                echo _MOVINVNORESULTADOS_;
            } else {
                echo _MOVINVAFECTADOS_1_ . $afectados . _MOVINVAFECTADOS_2_;
        }
             
    }

    /*
     * Metodo que registra el traspaso a ejecutar
     */
    private function registraTraspaso( $origen , $destino , $layout , $marca , $total , $sku='') {
        $sqlTraspaso  = " INSERT INTO inv_trasladoMasivo (fechaSolicitud, origen, destino, layout, sku, total, usuarioSolicita, usuarioAutoriza, marca, aplicado, status) VALUES ";
        $sqlTraspaso .= " ( '".date('Y-m-d H:i:s')."', '".$origen."', '".$destino."', '".$layout."', '".$sku."', '".$total."', '".$_SESSION['idUsuario']."', '0', '".$marca."', 0, 1 ) ";
        $this->dbCon->ejecutaComando( $sqlTraspaso );
    }
    
    /*
     * Metodo que verifica los parametros para el traslado de inventarios
     * entre almacenes de forma individual, es decir, a traves del sku de 
     * cada producto
     */
    public function trasladoInventariosIndividual() {
        $almacenEntrada = $_POST['almacenEntrada'];
        $almacenSalida  = $_POST['almacenSalida'];
        $sku            = $_POST['sku'];
        $cantidad       = $_POST['piezas'];
        
        /* Busca que el sku exista en el almacen de origen y se encuentre en estatus de "en almacen" */
        $sqlL = " SELECT COUNT(*) AS tot FROM inv_lote WHERE status=1 AND sku='".$sku."' AND almacen='".$almacenSalida."' AND proceso=1 ";
        $rsL  = $this->dbCon->ejecutaComando( $sqlL );
        
        if( $rsL && $rsL->fields['tot'] > 0 ){
            $sqlUpLote = " UPDATE inv_lote SET proceso=2 WHERE status=1 AND sku='".$sku."' AND almacen='".$almacenSalida."' ";
            $rsUpLote  = $this->dbCon->ejecutaComando( $sqlUpLote );
            if( $rsUpLote ){
                $sqlMarca = " SELECT marca FROM inv_lote WHERE sku='".$sku."' LIMIT 1 ";
                $rsMarca  = $this->dbCon->ejecutaComando( $sqlMarca );
                $this->registraTraspaso( $almacenSalida , $almacenEntrada , 0 , $rsMarca->fields['marca'], $cantidad , $sku );
                echo _MOVINVINDCORRECTO_;
            }
        }else{
            $sql_1 = " SELECT id,cantidad FROM inv_item WHERE almacen='".$almacenSalida."' AND sku='".$sku."' AND status='1' ";
            $rs_1  = $this->dbCon->ejecutaComando( $sql_1 );
            
            if( $cantidad > $rs_1->fields['cantidad'] ){
                echo _MOVINVINDERRORCANTIDAD_ . ' Existen solo:' . $rs_1->fields['cantidad'];
            }else{
                $sqlUpItem = " UPDATE inv_item SET proceso=2 WHERE sku='".$sku."' AND almacen='".$almacenSalida."' ";
                $rsUpItem  = $this->dbCon->ejecutaComando( $sqlUpItem );
                
                if( $rsUpItem ){
                    $sqlMarca = " SELECT marca FROM inv_item WHERE sku='".$sku."' AND almacen='".$almacenSalida."' LIMIT 1 ";
                    $rsMarca  = $this->dbCon->ejecutaComando( $sqlMarca );
                    $this->registraTraspaso( $almacenSalida , $almacenEntrada , 0 , $rsMarca->fields['marca'], $cantidad , $sku );
                    echo _MOVINVINDCORRECTO_;
                }                
            }            
        }        
    }

    /*
     * Metodo que genera el autocomplete del listado de skus por almacen
     */
    public function skuAutocomplete( $sku ) {
        $term = trim( strip_tags( $sku ) );
        $sql  = " SELECT sku, modelo, imei FROM `inv_lote` WHERE sku like '%".$term."%' AND status=1 ";
        $sql .= " UNION ";
        $sql .= " SELECT sku, modelo, imei FROM `inv_item` WHERE sku like '%".$term."%' AND status=1  ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        $producto   = array();
        $productos  = array();

        while( !$rs->EOF ){
            $producto[ 'value' ] = $rs->fields[ 'sku' ] . ' | ' . $rs->fields[ 'modelo' ] . '|' . $rs->fields[ 'imei' ];
            $producto[ 'id' ]    = $rs->fields[ 'sku' ];
            $productos[]         = $producto;
            $rs->MoveNext();
        }

        echo json_encode( $productos );
    }
    
    /* ***************************
     *      EXISTENCIAS EN ALMACENES
     * ***************************/
    
    public function afectaExistenciasSKU() {
        $cantidad = $_POST['cantidad'];
        $almacen  = $_POST['almacen'];
        $sku      = $_POST['sku'];
        $sql = " UPDATE inv_item SET cantidad=cantidad+".$cantidad." WHERE almacen='".$almacen."' AND sku='".$sku."' AND status=1 ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        
        if( $rs ){
                echo _EXISTENCIASAGREGADASEXITOSAMENTE_;
            }else{
                echo _EXISTENCIASERROR_;
        }
    }
    
    /* ***************************
     *      AUTORIZACION DE TRASLADOS
     * ***************************/
  
    public function autorizacionTraslados_arreglo() {
        $columnas = array(
            'Fecha Solicitud' => array( 'name'=>'fechaSolicitud' ,'index'=>'fechaSolicitud' ,'width'=>100,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Fecha Traslado'  => array( 'name'=>'fechaTraslado'  ,'index'=>'fechaTraslado'  ,'width'=>100,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'A.Origen'        => array( 'name'=>'origen'         ,'index'=>'origen'         ,'width'=>90 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'A.Destino'       => array( 'name'=>'destino'        ,'index'=>'destino'        ,'width'=>90 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Layout'          => array( 'name'=>'layout'         ,'index'=>'layout'         ,'width'=>80,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'SKU'             => array( 'name'=>'sku'            ,'index'=>'sku'            ,'width'=>80,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Elementos'       => array( 'name'=>'total'          ,'index'=>'total'          ,'width'=>50,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Solicitante'     => array( 'name'=>'usuarioSolicita','index'=>'usuarioSolicita','width'=>90,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Autorizo'        => array( 'name'=>'usuarioAutorizo','index'=>'usuarioAutorizo','width'=>90,'align'=>'center','editable'=>true,'editrules'=>'{required:false}' ),
            'Marca'           => array( 'name'=>'marca'          ,'index'=>'marca'          ,'width'=>100,'align'=>'center','editable'=>true,'editrules'=>'{required:false}' ),
            'Comentarios'     => array( 'name'=>'comentarios'    ,'index'=>'comentarios'    ,'width'=>190 ,'align'=>'center','editable'=>true,'editrules'=>'{required:false}' ),
            'Estado'          => array( 'name'=>'estado'         ,'index'=>'estado'         ,'width'=>60 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Opc'             => array( 'name'=>'opc'            ,'index'=>'opc'            ,'width'=>50 ,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' )
        );
        return $columnas;
    }

    /* Obtiene los datos a mostrar en el grid de los traslados pendientes */
    public function datosGridAutorizacionesTraslados() {
        $sql  = " SELECT t.id, t.fechaSolicitud, t.fechaTraslado, a.clave AS origen, a2.clave AS destino, t.layout, t.sku, t.total, u.usuario AS usuarioSolicita, u2.usuario AS usuarioAutoriza, l.clave AS marca, t.comentarios, ";
        $sql .= " IF(t.aplicado=0,'En Transito',IF(t.aplicado=1,'Trasladado','Rechazado')) AS estado, '".$this->opcionesGridTrasladoInventarios()."' AS opc FROM inv_trasladoMasivo AS t LEFT JOIN inv_almacenes AS a ON t.origen=a.id ";
        $sql .= " LEFT JOIN inv_almacenes AS a2 ON t.destino=a2.id LEFT JOIN cli_listado AS l ON l.id=t.marca ";
        $sql .= " LEFT JOIN sis_usuarios AS u ON t.usuarioSolicita=u.id LEFT JOIN sis_usuarios AS u2 ON t.usuarioAutoriza=u2.id";
        $sql .= " WHERE t.status=1";
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND t.marca IN (".$marcas.") ";
        }
        $grid = new DataGrid( $sql , 'Traslados entre Almacenes' );
        echo $grid->datosXML;
    }

    /*
     * Metodo que agrega las opciones adicionales en el grid de listado de inventarios
     */
    public function opcionesGridTrasladoInventarios() {
        $html  = '<div style="display-inline">';
        $html .= '&nbsp;<span id="verLoteItemInventarios" name="verLoteItemInventarios" onclick="procesarTraslado()" class="ui-icon ui-icon-unlocked" title="Procesar Traslado" style="cursor: pointer;display: inline-block"></span>';
        $html .= '&nbsp;<span id="descargarFormatoMovimiento" name="descargarFormatoMovimiento" onclick="descargarFormato()" class="ui-icon ui-icon-print" title="Descargar Formato Salida" style="cursor: pointer;display: inline-block"></span>';
        $html .= '</div>';
        return $html;
    }

    /*
     * Metodo que aplica los cambios para efectuar el traslado
     */
    public function aplicarTraslado( $params ) {
        $idTraslado  = $params['id'];
        $comentarios = $params['comentarios'];
        $rsUpdate    = false;
        $rsUpdate2   = false;

        $sql = " SELECT * FROM inv_trasladoMasivo WHERE id='".$idTraslado."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        if( !$rs->EOF ){
            $origen  = $rs->fields['origen'];
            $destino = $rs->fields['destino'];
            $layout  = $rs->fields['layout'];
            $total   = $rs->fields['total'];
            $sku     = $rs->fields['sku'];
            $cliente = $rs->fields['marca'];

            if( $layout == 0 ) {
                /* Si no es especifica un layout, entonces se trata de un traslado individual */
                $this->aplicarTrasladoNuevoIndividual( $sku , $cliente , $origen , $destino, $total , $idTraslado , $comentarios );
            } else {
                $sqlUpdate = " UPDATE inv_item SET almacen='".$destino."', proceso=1 WHERE idLayout='".$layout."' ";
                $rsUpdate  = $this->dbCon->ejecutaComando( $sqlUpdate );
                $totalItem = $this->dbCon->affected;

                $sqlUpdate2 = " UPDATE inv_lote SET almacen='".$destino."', proceso=1 WHERE idtyLayout='".$layout."' ";
                $rsUpdate2  = $this->dbCon->ejecutaComando( $sqlUpdate2 );
                $totalLote  = $this->dbCon->affected;

                if( ($totalItem + $totalLote) == $total ) {
                    /* Afecta la tabla de existencias */
                    
                    $sqlExistencias = "";
                    $this->dbCon->ejecutaComando( $sqlExistencias );
                }
            }

            if( $rsUpdate && $rsUpdate2 ) {
                $sqlLayoutUpdate = " UPDATE inv_layout SET idtyAlmacen='".$destino."' WHERE idtyLayout='".$layout."' ";
                $this->dbCon->ejecutaComando( $sqlLayoutUpdate );
                $sqlUpdateT  = " UPDATE inv_trasladoMasivo SET comentarios='".addslashes( $comentarios )."', aplicado=1, usuarioAutoriza='".$_SESSION['idUsuario']."', ";
                $sqlUpdateT .= " fechaTraslado='".date('Y-m-d H:i:s')."' WHERE id='".$idTraslado."'  ";
                $this->dbCon->ejecutaComando( $sqlUpdateT );
            }
        }
    }

    /*
     * Metodo que aplica los cambios para efectuar el traslado
     */
    public function aplicarTrasladoNuevoIndividual( $sku , $cliente, $origen, $destino, $cantidad , $idty , $comentarios ) {
        /* Primero agrega existencias en el destino */
        $sql  = " INSERT INTO inv_existencias(sku, almacen, cantidad, fechaRegistro, cliente ) VALUES ( '".$sku."', '".$destino."', '".$cantidad."', '".date("Y-m-d H:i:s")."', '".$cliente."' ) ";
        $sql .= " ON DUPLICATE KEY UPDATE cantidad=cantidad+".$cantidad." ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){
            /* Despues elimina lo trasladado del punto de origen */
            $sql2 = " UPDATE inv_existencias SET cantidad=cantidad-".$cantidad." WHERE sku='".$sku."' AND almacen='".$origen."' ";
            $rs2  = $this->dbCon->ejecutaComando( $sql2 );
        }

        if( $rs && $rs2 ) {
                $sql  = " UPDATE inv_trasladoMasivo SET comentarios='".addslashes( $comentarios )."', aplicado=1, ";
                $sql .= " usuarioAutoriza='".$_SESSION['idUsuario']."', fechaTraslado='".date('Y-m-d H:i:s')."' WHERE id='".$idty."' ";
                $this->dbCon->ejecutaComando( $sql );
                return "OK";
            } else {
                return "NOOK";
        }
    }

    /*
     * Metodo que rechaza la peticion de un traslado
     */
    public function rechazaTraslado( $params ) {
        $idTraslado  = $params['id'];
        $comentarios = $params['comentarios'];

        $sql = " SELECT * FROM inv_trasladoMasivo WHERE id='".$idTraslado."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        if( !$rs->EOF ){
            $origen  = $rs->fields['origen'];
            $layout  = $rs->fields['layout'];
            $total   = $rs->fields['total'];
            $sku     = $rs->fields['sku'];

            if( $layout == 0 ){
                $sqlUpdate = " UPDATE inv_item SET proceso=1 WHERE almacen='".$origen."' AND proceso=2 AND status=1 AND sku='".$sku."' ";
                $rsUpdate  = $this->dbCon->ejecutaComando( $sqlUpdate );
                $totalItem = $this->dbCon->affected;

                $sqlUpdate2 = " UPDATE inv_lote SET proceso=1 WHERE almacen='".$origen."' AND proceso=2 AND sku='".$sku."' ";
                $rsUpdate2  =$this->dbCon->ejecutaComando( $sqlUpdate2 );
                $totalLote = $this->dbCon->affected;
                
            }else{
                $sqlUpdate = " UPDATE inv_item SET proceso=1 WHERE almacen='".$origen."' AND proceso=2 AND status=1 AND idLayout='".$layout."' ";
                $rsUpdate  = $this->dbCon->ejecutaComando( $sqlUpdate );
                $totalItem = $this->dbCon->affected;

                $sqlUpdate2 = " UPDATE inv_lote SET proceso=1 WHERE almacen='".$origen."' AND proceso=2 AND idtyLayout='".$layout."' ";
                $rsUpdate2  =$this->dbCon->ejecutaComando( $sqlUpdate2 );
                $totalLote = $this->dbCon->affected;

                if( ($totalItem + $totalLote) == $total ){
                }
            }

            if( $rsUpdate && $rsUpdate2 ) {
                $sqlUpdateT  = " UPDATE inv_trasladoMasivo SET comentarios='".addslashes( $comentarios )."', aplicado=3, usuarioAutoriza='".$_SESSION['idUsuario']."', ";
                $sqlUpdateT .= " fechaTraslado='".date('Y-m-d H:i:s')."' WHERE id='".$idTraslado."'  ";
                $this->dbCon->ejecutaComando( $sqlUpdateT );
            }
        }
    }

    /*
     * Surtido de existencias 2017
     */
    public function OpcionesSurtirSKU() {
        $sku = trim( $_POST[ 'sku' ] );
        $sql  = " SELECT e.cliente AS cli, e.sku, e.almacen AS alm, e.cantidad, a.clave, c.clave AS marca FROM ";
        $sql .= " inv_existencias AS e LEFT JOIN inv_almacenes AS a ON a.id=e.almacen LEFT JOIN cli_listado AS c ON c.id=e.cliente WHERE e.sku='".$sku."' AND e.cantidad>=0 ";
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND e.cliente IN (".$marcas.") ";
        }
        $sql .= " ORDER BY e.cliente ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        $html = '';
        $i    = 0;

        if( !$rs->EOF ) {
            while( !$rs->EOF ) {
                $i ++;
                $opcionesEntrada = json_decode( $this->cargaAlmacenesEntradaTraspaso( 0 ) );
                $select = '<select id="nvoSurtido_origen_'.$i.'" name="nvoSurtido_origen_'.$i.'" >';
                foreach( $opcionesEntrada AS $opcion) {
                    $select .= '<option value="' . $opcion->id . '" ' . ( ( $rs->fields[ 'clave' ] == $opcion->clave ) ? 'selected' : '' ) . ' >' . $opcion->clave . '</option>';
                }
                $select .= '</select>';
                
                $html .= '<table width="100%">'
                            . '<tr>'
                                . '<td width="8%">Almacen Origen:</td>'
                                //. '<td><input value="'.$rs->fields[ 'clave' ].'" readonly /><input type="hidden" value="'.$rs->fields[ 'alm' ].'" id="nvoSurtido_origen_'.$i.'" name="nvoSurtido_origen_'.$i.'" /></td>'
                                . '<td>'.$select.'</td>'
                                . '<td>Existencias:</td>'
                                . '<td><input value="'.$rs->fields[ 'cantidad' ].'" id="nvoSurtido_existencias_'.$i.'" name="nvoSurtido_existencias_'.$i.'" size="10" readonly /></td>'
                                . '<td>Marca:</td>'                                
                                . '<td><input value="'.$rs->fields[ 'marca' ].'" id="nvoSurtido_marca_'.$i.'" name="nvoSurtido_marca_'.$i.'" size="12" readonly /></td>'
                                . '<td>Cantidad:</td>'
                                . '<td><input type="number" value="" id="nvoSurtidoExistencias_cantidadAgregar_'.$i.'" name="nvoSurtidoExistencias_cantidadAgregar_'.$i.'" size="5" /></td>'
                                . '<td><button id="btnNvoSkuSurtir_cantidadMover_'.$i.'" name="btnNvoSkuSurtir_cantidadMover_'.$i.'">Surtir</button>'
                                . '<script>$(\'#btnNvoSkuSurtir_cantidadMover_'.$i.'\').button().click(function(){surtirSKU('.$i.')});</script>'
                                . '</td>'
                                . '<input type="hidden" id="nvoSurtido_cliente_'.$i.'" name="nvoSurtido_cliente_'.$i.'" value="'.$rs->fields[ 'cli' ].'" />'
                            . '</tr>'
                        . '</table>';
                $rs->MoveNext();
            }
        }else{
            $html .= '<center>El SKU no fue encontrado en alguno de los almacenes disponibles</center>';
        }

        return $html;
    }

    /*
     * Agrega surtido a tabal existencias
     */
    public function agregaNuevasExistencias() {
        return $this->generaExistencias( $_POST[ 'sku' ] , $_POST[ 'origen' ] , $_POST[ 'cantidad' ] , $_POST[ 'cliente' ] );
    }

    /*
     * Genera detalle del traslado
     */
    public function datosTraslado( $idTraslado ) {
        $sql   = " SELECT t.id AS id, sku, total, fechaTraslado, fechaSolicitud, a.clave AS origen, a2.clave AS destino, u.nombre AS solicita, u2.nombre AS autoriza, comentarios, l.clave AS marca ";
        $sql  .= " FROM inv_trasladoMasivo AS t LEFT JOIN sis_usuarios AS u ON t.usuarioSolicita=u.id LEFT JOIN sis_usuarios AS u2 ON t.usuarioAutoriza=u2.id ";
        $sql  .= " LEFT JOIN inv_almacenes AS a ON t.origen=a.id LEFT JOIN inv_almacenes AS a2 ON t.destino=a2.id ";
        $sql  .= " LEFT JOIN cli_listado AS l ON t.marca=l.id ";
        $sql  .= " WHERE t.id='".$idTraslado."' ";
        $rs    = $this->dbCon->ejecutaComando( $sql );
        $datos = array();

        while( !$rs->EOF ) {
            $datos[ 'id' ]             = $rs->fields[ 'id' ];
            $datos[ 'fechaSolicitud' ] = $rs->fields[ 'fechaSolicitud' ];
            $datos[ 'fechaTraslado' ]  = $rs->fields[ 'fechaTraslado' ];
            $datos[ 'origen' ]         = $rs->fields[ 'origen' ];
            $datos[ 'destino' ]        = $rs->fields[ 'destino' ];
            $datos[ 'solicita' ]       = $rs->fields[ 'solicita' ];
            $datos[ 'autoriza' ]       = $rs->fields[ 'autoriza' ];
            $datos[ 'comentarios' ]    = $rs->fields[ 'comentarios' ];
            $datos[ 'marca' ]          = $rs->fields[ 'marca' ];

            $sql2 = " SELECT nombre, unidadMedida FROM inv_item WHERE sku='" . $rs->fields[ 'sku' ] . "' ";
            $rs2  = $this->dbCon->ejecutaComando( $sql2 );
            while ( !$rs2->EOF ) {
                $datos[ 'detalle' ][] = array(
                                            'linea'    => 'a',
                                            'codigo'   => $rs->fields[ 'sku' ],
                                            'producto' => $rs2->fields['nombre'], 
                                            'unidad' => $rs2->fields['unidadMedida'],
                                            'cantidad' => $rs->fields[ 'total' ] 
                                        );
                $rs2->MoveNext();
            }
            $rs->MoveNext();
        }

        return $datos;
    }

    /*
     * Genera documento con el vale de salida
     */
    public function generaValeSalida( $params ) {
        $datos = $this->datosTraslado( $params[ 'valeSalida_idty' ] );

        $doc = new DocumentoPDF();
        $doc->nombrePDF = "ValeSalida.pdf";
        $doc->ruta      = _DIRPATH_ . '/modulos/Inventarios/';
        
        $detalle = $datos[ 'detalle' ];
        $doc->SetY( 130 );
        $doc->SetX( 60 );
        $doc->SetFont( '' , 'B', 14 );
        $doc->Cell( 490 , 20 , 'SALIDAS DE ALMACEN' , 0 , 0 , 'C' , false );
        $doc->SetY( 150 );
        $doc->SetX( 60 );
        $doc->SetFont( '' , 'B', 12 );
        $doc->Cell( 490 , 15 , $datos[ 'marca' ] , 0 , 0 , 'C' , false );
        $doc->SetFont( '' , 'N', 8 );
        $doc->SetY( 190 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Fecha de Pedido' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'fechaSolicitud' ] , 1 , 0 , 'C' , false );
        $doc->SetFont( '' , 'B', 12 );
        $doc->SetFillColor( 37 , 119 , 202 );
        $doc->SetTextColor( 255 , 255 , 255 );
        $doc->SetX( 450 );
        $doc->MultiCell( 100 , 30 , mb_convert_encoding( 'SALIDAS DE ALMAC&Eacute;N' , 'iso-8859-1' , 'HTML-ENTITIES' ) , 1 , 'C' , true );
        $doc->SetFont( '' , 'N', 8 );
        $doc->SetTextColor( 0 , 0 , 0 );
        $doc->SetY( 200 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Pedido' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $params[ 'valeSalida_noPedido' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 210 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Proveedor' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'solicita' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 220 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Nombre Autorizo' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'autoriza' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 230 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Motivo' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $params[ 'valeSalida_motivoSalida' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 240 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Nombre Entrega' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $params[ 'valeSalida_nombreRecoge' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 255 );
        $doc->SetX( 60 );
        $doc->SetFillColor( 37  , 119 , 202 );
        $doc->SetTextColor( 255 , 255 , 255 );
        $doc->SetFont( '' , 'B', 8 );
        $doc->Cell( 50 , 10 , 'LINEA' , 1 , 0 , 'C' , true );
        $doc->Cell( 50 , 10 , 'CODIGO' , 1 , 0 , 'C' , true );
        $doc->Cell( 290 , 10 , 'PRODUCTO' , 1 , 0 , 'C' , true );
        $doc->Cell( 50 , 10 , 'UNIDAD' , 1 , 0 , 'C' , true );
        $doc->Cell( 50 , 10 , 'CANTIDAD' , 1 , 0 , 'C' , true );
        $doc->SetTextColor( 0 , 0 , 0 );
        $doc->SetFont( '' , 'N', 8 );

        for( $i = 0 ; $i < count( $detalle ) ; $i ++ ) {
            $doc->SetY( $doc->GetY() + 10 );
            $doc->SetX( 60 );
            $doc->Cell( 50  , 10 , $detalle[$i][ 'linea' ]    , 1 , 0 , 'C' , false );
            $doc->Cell( 50  , 10 , $detalle[$i][ 'codigo' ]   , 1 , 0 , 'C' , false );
            $doc->Cell( 290 , 10 , $detalle[$i][ 'producto' ] , 1 , 0 , 'C' , false );
            $doc->Cell( 50  , 10 , $detalle[$i][ 'unidad' ]   , 1 , 0 , 'C' , false );
            $doc->Cell( 50  , 10 , $detalle[$i][ 'cantidad' ] , 1 , 0 , 'C' , false );
        }

        $doc->SetY( $doc->GetY() + 50 );
        $doc->SetX( 60 );
        $doc->Cell( 390 , 10 , date( 'm/d/Y H:i' ) , 1 , 0 , 'C' , false );
        $doc->Cell( 100 , 10 , $params[ 'valeSalida_nombreRecibe' ] , 1 , 0 , 'C' , false);
        $doc->SetY( $doc->GetY() + 10 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 30 , 'Recibido por' , 1 , 0 , 'L' , false );
        $doc->SetX( 160 );
        $doc->Cell( 390 , 30 , '' , 1 , 0 , 'C' , false );
        $doc->SetY( $doc->GetY() + 20 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 30 , 'Observaciones' , 0 , 0 , 'L' , false );
        $doc->SetX( 160 );        
        $doc->Rect( 60 , $doc->GetY()+10 , 490 , 40 );
        $doc->SetY( $doc->GetY() + 10 );
        $doc->SetX( 160 );
        $doc->MultiCell( 390 , 10 , mb_convert_encoding( $datos[ 'comentarios' ] , 'iso-8859-1' ) , 0 ,  'L' , false );
        $yGuardia = $doc->GetY() + 60;
        $doc->SetY( $yGuardia+20 );
        $doc->SetX( 450 );
        $doc->Cell( 100 , 10 , $params[ 'valeSalida_nombreGuardia' ] , 0 , 0 , 'C' , false );
        $doc->SetY( $yGuardia+30 );
        $doc->SetX( 450 );
        $doc->Cell( 100 , 10 , 'GUARDIA' , 0 , 0 , 'C' , false );
        $doc->Rect( 450 , $yGuardia , 100 , 40 );
        $doc->descargaDocumento();
    }

    /*
     * Vales Entrada/Salida
     */
    public function listadoEntradasSalidas_arreglo() {
    	$columnas = array(
            'SKU'      => array( 'name'=>'sku'            ,'index'=>'sku'            ,'width'=>200 ,'align'=>'center','editable'=>false ),
            'Almacen'  => array( 'name'=>'almacen'        ,'index'=>'almacen'        ,'width'=>200,'align'=>'center','editable'=>false ),
            'Cliente'  => array( 'name'=>'cliente'        ,'index'=>'cliente'        ,'width'=>140,'align'=>'center','editable'=>false ),
            'Cantidad' => array( 'name'=>'cantidad'       ,'index'=>'cantidad'       ,'width'=>120,'align'=>'center','editable'=>false ),
            'Tipo'     => array( 'name'=>'tipo'           ,'index'=>'tipo'           ,'width'=>140,'align'=>'center','editable'=>false ),
            'Fecha'    => array( 'name'=>'fechaMovimiento','index'=>'fechaMovimiento','width'=>180,'align'=>'center','editable'=>false ),
            'Usuario'  => array( 'name'=>'usuario'        ,'index'=>'usuario'        ,'width'=>100,'align'=>'center','editable'=>false ),
            'OPC'      => array( 'name'=>'opc'            ,'index'=>'opc'            ,'width'=>80,'align'=>'center','editable'=>false,'sortable'=>false ),
        );
        return $columnas;
    }
 
    /*
     * Consulta para obtener el listado de movimientos de entrada y de salida
     */
    public function listadoEntradasSalidasXML(){
        $sql  = " SELECT m.id AS id, m.sku, a.clave AS almacen, c.clave AS cliente, m.cantidad, IF( m.tipo=1 , 'Entrada' , IF( m.tipo=2 , 'Salida' , '' ) ) AS tipo, m.fechaMovimiento, ";
        $sql .= " u.usuario AS usuario, '".$this->opcionesListadoEntradasSalidas()."' AS opc FROM inv_movInventarios AS m LEFT JOIN inv_almacenes AS a ON a.id=m.almacen LEFT JOIN cli_listado AS c ON c.id=m.cliente LEFT JOIN sis_usuarios AS u ";
        $sql .= " ON u.id=m.usuario WHERE m.status=1 ";
        $grid = new DataGrid( $sql , 'Movimientos de Entrada/Salida' );
        echo $grid->datosXML;
    }

    /*
     * Opciones del listado de movimientos para crear o descargar los vales
     */
    public function opcionesListadoEntradasSalidas() {
        $html  = '<div style="display-inline">';
        $html .= '&nbsp;<span id="generaValeEntradaSalida"  name="generaValeEntradaSalida"  onclick="generaValeEntradaSalida()"  class="ui-icon ui-icon-image"  title="Crear Vale" style="cursor: pointer;display: inline-block"></span>';
        $html .= '</div>';
        return $html;
    }

    /*
     * Combo de tipo de movimientos al inventario
     */
    public function comboMovimientosInventarios() {
        $movs = $this->utiles->generaComboDinamico( 'valeEntradaSalida_motivoMovimiento' , "SELECT id, movimiento FROM inv_movimientos WHERE status=1" );
        return array( $movs );
    }
 
    /*
     * Metodo que obtiene los datos de un vale si se ha generado previamente
     */
    public function datosValeMovimiento( $idMov ) {
        $sql = " SELECT * FROM inv_movInventariosVales WHERE idMov='".$idMov."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
        $datos[ 'motivo' ]            = "";
        $datos[ 'noPedido' ]          = "";
        $datos[ 'fechaPedido' ]       = "";
        $datos[ 'solicitante' ]       = "";
        $datos[ 'autorizante' ]       = "";
        $datos[ 'nombreQuienRecoge' ] = "";
        $datos[ 'nombreQuienRecibe' ] = "";
        $datos[ 'nombreGuardia' ]     = "";
        $datos[ 'fechaMovimiento' ]   = "";
        $datos[ 'observaciones' ]     = "";
        $datos[ 'idsMovs' ]           = "";
        $datos[ 'creado' ]            = false;

        while( !$rs->EOF ) {
            $datos[ 'motivo' ]            = $rs->fields[ 'motivo' ];
            $datos[ 'noPedido' ]          = $rs->fields[ 'noPedido' ];
            $datos[ 'fechaPedido' ]       = $rs->fields[ 'fechaPedido' ];
            $datos[ 'solicitante' ]       = $rs->fields[ 'solicitante' ];
            $datos[ 'autorizante' ]       = $rs->fields[ 'autorizante' ];
            $datos[ 'nombreQuienRecoge' ] = $rs->fields[ 'nombreQuienRecoge' ];
            $datos[ 'nombreQuienRecibe' ] = $rs->fields[ 'nombreQuienRecibe' ];
            $datos[ 'nombreGuardia' ]     = $rs->fields[ 'nombreGuardia' ];
            $datos[ 'fechaMovimiento' ]   = $rs->fields[ 'fechaMovimiento' ];
            $datos[ 'observaciones' ]     = $rs->fields[ 'observaciones' ];
            $datos[ 'idsMovsS' ]          = $rs->fields[ 'idMov' ];
            $datos[ 'creado' ]            = true;
            $rs->MoveNext();
        }

        $sql = " SELECT id, sku FROM inv_movInventarios WHERE status=1 ";
        $rs2  = $this->dbCon->ejecutaComando( $sql );
        $todos = array();
        while( !$rs2->EOF ) {
            $todos[ $rs2->fields[ 'sku' ] ] = $rs2->fields[ 'id' ];
            $rs2->MoveNext();
        }
        $datos[ 'todos' ] = $todos;
        return $datos;
    }

    /*
     * Metodo que guarda la informacion del vale de entrada/salida
     */
    public function guardaInformacionVale() {
        $sql  = " INSERT INTO `inv_movInventariosVales` ( `idMov`, `idMovs`, `motivo`, `noPedido`, ";
        $sql .= " `fechaPedido`, `solicitante`, `autorizante`, `nombreQuienRecoge`, ";
        $sql .= " `nombreQuienRecibe`, `nombreGuardia`, `fechaMovimiento`, `usuarioAlta`, ";
        $sql .= " `fechaEdicion`, `usuarioEdita`, `observaciones`, `status`) ";
        $sql .= " VALUES ( '".$_GET[ 'valeEntradaSalida_IDMovimiento' ]."', '" . implode( ',' , $_GET[ 'valeEntradaSalida_IDMovimientos' ] ) . "', '".$_GET[ 'valeEntradaSalida_motivoMovimiento' ]."', '".$_GET[ 'valeEntradaSalida_noPedido' ]."', ";
        $sql .= " '".$_GET[ 'valeEntradaSalida_fechaPedido' ]."', '".$_GET[ 'valeEntradaSalida_solicitante' ]."', '".$_GET[ 'valeEntradaSalida_autorizante' ]."', '".$_GET[ 'valeEntradaSalida_nombreRecoge' ]."', ";
        $sql .= " '".$_GET[ 'valeEntradaSalida_nombreRecibe' ]."', '".$_GET[ 'valeEntradaSalida_nombreGuardia' ]."', '".$_GET[ 'valeEntradaSalida_fechaMovimiento' ]."', '".$_SESSION[ 'idUsuario' ]."', ";
        $sql .= " '".date("Y-m.d H:i:s")."', '0', '".$_GET[ 'valeEntradaSalida_observaciones' ]."', '1' ) ON DUPLICATE KEY UPDATE ";
        $sql .= " idMovs='".implode( ',' , $_GET[ 'valeEntradaSalida_IDMovimientos' ] )."',";
        $sql .= " `motivo`='".$_GET[ 'valeEntradaSalida_motivoMovimiento' ]."', `noPedido`='".$_GET[ 'valeEntradaSalida_noPedido' ]."', ";
        $sql .= " `fechaPedido`='".$_GET[ 'valeEntradaSalida_fechaPedido' ]."', `solicitante`='".$_GET[ 'valeEntradaSalida_solicitante' ]."', `autorizante`='".$_GET[ 'valeEntradaSalida_autorizante' ]."', `nombreQuienRecoge`='".$_GET[ 'valeEntradaSalida_nombreRecoge' ]."', ";
        $sql .= " `nombreQuienRecibe`='".$_GET[ 'valeEntradaSalida_nombreRecibe' ]."', `nombreGuardia`='".$_GET[ 'valeEntradaSalida_nombreGuardia' ]."', `fechaMovimiento`='".$_GET[ 'valeEntradaSalida_fechaMovimiento' ]."', ";
        $sql .= " `fechaEdicion`='".date( 'Y-m-d H:i:s' )."', `usuarioEdita`='".$_SESSION['idUsuario']."', `observaciones`='".$_GET[ 'valeEntradaSalida_observaciones' ]."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        if( $rs ) {
                return true;
            } else {
                return false;
        }
    }

    /*
     * Obtiene el motivo de movimiento
     */
    public function obtieneMotivoMovimiento( $idMov ) {
        $sql = " SELECT motivo FROM inv_movInventariosVales WHERE idMov='".$idMov."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        return $rs->fields[ 'motivo' ];
    }

    /*
     * Metodo que genera pdf del vale de entrada/salida
     */
    public function generaValeEntradaSalida( $idMov ) {
        $datos = $this->informacionMovimientoEntradaSalida( $idMov );
        $doc = new DocumentoPDF();
        $doc->nombrePDF = "ValeSalida.pdf";
        $doc->ruta      = _DIRPATH_ . '/modulos/Inventarios/';
        
        $doc->SetY( 130 );
        $doc->SetX( 60 );
        $doc->SetFont( '' , 'B', 14 );
        $doc->Cell( 490 , 20 , $datos[ 'movimiento' ].' ALMACEN' , 0 , 0 , 'C' , false );
        $doc->SetY( 150 );
        $doc->SetX( 60 );
        $doc->SetFont( '' , 'B', 12 );
        $doc->Cell( 490 , 15 , $datos[ 'cliente' ] , 0 , 0 , 'C' , false );
        $doc->SetFont( '' , 'N', 8 );
        $doc->SetY( 190 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Fecha de Pedido' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'fechaPedido' ] , 1 , 0 , 'C' , false );
        $doc->SetFont( '' , 'B', 12 );
        $doc->SetFillColor( 37 , 119 , 202 );
        $doc->SetTextColor( 255 , 255 , 255 );
        $doc->SetX( 450 );
        $doc->MultiCell( 100 , 30 , mb_convert_encoding( $datos[ 'movimiento' ].' DE ALMAC&Eacute;N' , 'iso-8859-1' , 'HTML-ENTITIES' ) , 1 , 'C' , true );
        $doc->SetFont( '' , 'N', 8 );
        $doc->SetTextColor( 0 , 0 , 0 );
        $doc->SetY( 200 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Pedido' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'noPedido' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 210 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Proveedor' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'solicitante' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 220 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Nombre Autorizo' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'autorizante' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 230 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Motivo' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , utf8_decode( $datos[ 'motivo' ] ) , 1 , 0 , 'C' , false );
        $doc->SetY( 240 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 10 , 'Nombre Entrega' , 1 , 0 , 'C' , false );
        $doc->SetX( 160 );
        $doc->Cell( 290 , 10 , $datos[ 'nombreQuienRecoge' ] , 1 , 0 , 'C' , false );
        $doc->SetY( 255 );
        $doc->SetX( 60 );
        $doc->SetFillColor( 37  , 119 , 202 );
        $doc->SetTextColor( 255 , 255 , 255 );
        $doc->SetFont( '' , 'B', 8 );
        $doc->Cell( 50 , 10 , 'LINEA' , 1 , 0 , 'C' , true );
        $doc->Cell( 50 , 10 , 'CODIGO' , 1 , 0 , 'C' , true );
        $doc->Cell( 290 , 10 , 'PRODUCTO' , 1 , 0 , 'C' , true );
        $doc->Cell( 50 , 10 , 'UNIDAD' , 1 , 0 , 'C' , true );
        $doc->Cell( 50 , 10 , 'CANTIDAD' , 1 , 0 , 'C' , true );
        $doc->SetTextColor( 0 , 0 , 0 );
        $doc->SetFont( '' , 'N', 8 );

        $nY = $doc->GetY() + 10;
        for( $i = 0 ; $i < count( $datos[ 'detalle' ] ) ; $i ++ ) {
            $doc->SetY( $nY );
            $doc->SetX( 60 );
            $doc->MultiCell(50  , 10 , $datos[ 'detalle' ][ $i ][ 'linea' ] , 1 , 'C' , 0 );
            $arrY[] = $this->GetY();
            $doc->SetY( $nY );
            $doc->SetX( 110 );
            $doc->MultiCell(50  , 10 , $datos[ 'detalle' ][ $i ][ 'sku' ], 1 , 'C' , 0 );
            $arrY[] = $this->GetY();
            $doc->SetY( $nY );
            $doc->SetX( 160 );
            $doc->MultiCell( 290 , 10 , $datos[ 'detalle' ][ $i ][ 'nombre' ] , 1 , 'C' , 0 );
            $arrY[] = $this->GetY();
            $doc->SetY( $nY );
            $doc->SetX( 450 );
            $doc->MultiCell( 50  , 10 , $datos[ 'detalle' ][ $i ][ 'unidadMedida' ] , 1 , 'C' , 0 );
            $arrY[] = $this->GetY();
            $doc->SetY( $nY );
            $doc->SetX( 500 );
            $doc->MultiCell( 50  , 10 , $datos[ 'detalle' ][ $i ][ 'cantidad' ] , 1 , 'C' , 0 );
            $arrY[] = $this->GetY();
            $nY = max( $arrY );
            $arrY = array();
        }

        $doc->SetY( $doc->GetY() + 50 );
        $doc->SetX( 60 );
        $doc->Cell( 390 , 10 , date( 'm/d/Y H:i' ) , 1 , 0 , 'C' , false );
        $doc->Cell( 100 , 10 , $datos[ 'nombreQuienRecibe' ] , 1 , 0 , 'C' , false);
        $doc->SetY( $doc->GetY() + 10 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 30 , 'Recibido por' , 1 , 0 , 'L' , false );
        $doc->SetX( 160 );
        $doc->Cell( 390 , 30 , '' , 1 , 0 , 'C' , false );
        $doc->SetY( $doc->GetY() + 20 );
        $doc->SetX( 60 );
        $doc->Cell( 100 , 30 , 'Observaciones' , 0 , 0 , 'L' , false );
        $doc->SetX( 160 );        
        $doc->Rect( 60 , $doc->GetY()+10 , 490 , 40 );
        $doc->SetY( $doc->GetY() + 10 );
        $doc->SetX( 160 );
        $doc->MultiCell( 390 , 10 , mb_convert_encoding( $datos[ 'observaciones' ] , 'iso-8859-1' ) , 0 ,  'L' , false );
        $yGuardia = $doc->GetY() + 60;
        $doc->SetY( $yGuardia+20 );
        $doc->SetX( 450 );
        $doc->Cell( 100 , 10 , $datos[ 'nombreGuardia' ] , 0 , 0 , 'C' , false );
        $doc->SetY( $yGuardia+30 );
        $doc->SetX( 450 );
        $doc->Cell( 100 , 10 , 'GUARDIA' , 0 , 0 , 'C' , false );
        $doc->Rect( 450 , $yGuardia , 100 , 40 );
        $doc->descargaDocumento();
    }

    /*
     * Obtiene informacion para generar el vale de salida / entrada
     */
    private function informacionMovimientoEntradaSalida( $idMov ) {
        $sql   = " SELECT M.tipo AS tipo, C.clave AS cliente, M.sku AS sku, A.clave AS almacen, M.cantidad AS cantidad, MV.movimiento AS motivo, V.noPedido AS noPedido, ";
        $sql  .= " V.fechaPedido AS fechaPedido, V.solicitante AS solicitante, V.autorizante AS autorizante, V.nombreQuienRecoge AS nombreQuienRecoge, V.nombreQuienRecibe AS nombreQuienRecibe, ";
        $sql  .= " V.nombreGuardia AS nombreGuardia, V.observaciones AS observaciones, V.idMovs AS movs ";
        $sql  .= " FROM inv_movInventarios as M LEFT JOIN inv_movInventariosVales as V ON M.id=V.idMov ";
        $sql  .= " LEFT JOIN inv_almacenes AS A ON A.id=M.almacen LEFT JOIN cli_listado AS C ON C.id=M.cliente ";
        $sql  .= " LEFT JOIN inv_movimientos AS MV ON MV.id=V.motivo WHERE M.id='".$idMov."' ";
        $rs    = $this->dbCon->ejecutaComando( $sql );
        $datos = array();

        while( !$rs->EOF ) {
            $datos[ 'movimiento' ]        = ( ( $rs->fields[ 'tipo' ] == 1 ) ? 'ENTRADAS' : ( ( $rs->fields[ 'tipo' ] == 2 ) ? 'SALIDAS' : '' ) );
            $datos[ 'tipo' ]              = $rs->fields[ 'tipo' ];
            $datos[ 'cliente' ]           = $rs->fields[ 'cliente' ];
            $datos[ 'almacen' ]           = $rs->fields[ 'almacen' ];
            $datos[ 'motivo' ]            = $rs->fields[ 'motivo' ];
            $datos[ 'noPedido' ]          = $rs->fields[ 'noPedido' ];
            $datos[ 'fechaPedido' ]       = $rs->fields[ 'fechaPedido' ];
            $datos[ 'solicitante' ]       = $rs->fields[ 'solicitante' ];
            $datos[ 'autorizante' ]       = $rs->fields[ 'autorizante' ];
            $datos[ 'nombreQuienRecoge' ] = $rs->fields[ 'nombreQuienRecoge' ];
            $datos[ 'nombreQuienRecibe' ] = $rs->fields[ 'nombreQuienRecibe' ];
            $datos[ 'nombreGuardia' ]     = $rs->fields[ 'nombreGuardia' ];
            $datos[ 'observaciones' ]     = $rs->fields[ 'observaciones' ];            
            $datos[ 'movs' ]              = $rs->fields[ 'movs' ];            
            /* Consulta las caracteristicas del sku */
            #$sqlItem = " SELECT unidadMedida, nombre, sku FROM inv_item WHERE sku='".$rs->fields[ 'sku' ]."' ";
            $sqlItem  = " SELECT i.unidadMedida AS unidadMedida, i.nombre AS nombre, i.sku AS sku, m.cantidad AS ";
            $sqlItem .= " cantidad FROM inv_item AS i LEFT JOIN inv_movInventarios AS m ON i.sku=m.sku WHERE i.sku IN ";
            $sqlItem .= " ( SELECT sku FROM inv_movInventarios WHERE id IN ( ".$rs->fields[ 'movs' ]." ) ) ";
            $rsItem  = $this->dbCon->ejecutaComando( $sqlItem );  
            $cont    = 0;
            while( !$rsItem->EOF ) {
                $datos[ 'detalle' ][ $cont ] = array(
                    'linea'        => 1,
                    'nombre'       => $rsItem->fields[ 'nombre' ],
                    'sku'          => $rsItem->fields[ 'sku' ],
                    'unidadMedida' => $rsItem->fields[ 'unidadMedida' ],
                    'cantidad'     => $rsItem->fields[ 'cantidad' ]
                );
                $cont ++;
                $rsItem->MoveNext();
            }            
            $rs->MoveNext();
        }

        return $datos;
    }

    /*
     * Salidas SKU
     */

    /*
     * Surtido de existencias 2017
     */
    public function OpcionesSalidaSKU() {
        $sku = trim( $_POST[ 'sku' ] );
        $sql  = " SELECT e.cliente AS cli, e.sku, e.almacen AS alm, e.cantidad, a.clave, c.clave AS marca FROM ";
        $sql .= " inv_existencias AS e LEFT JOIN inv_almacenes AS a ON a.id=e.almacen LEFT JOIN cli_listado AS c ON c.id=e.cliente WHERE e.sku='".$sku."' AND e.cantidad>=0 ";
        if( isset($_SESSION['usoMarcas']) ) {
            $marcas = str_replace( '|' , ',' , $_SESSION['usoMarcas'] );
            $sql .= " AND e.cliente IN (".$marcas.") ";
        }
        $sql .= " ORDER BY e.cliente ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        $html = '';
        $i    = 0;

        if( !$rs->EOF ) {
            while( !$rs->EOF ) {
                $i ++;
                $opcionesEntrada = json_decode( $this->cargaAlmacenesEntradaTraspaso( 0 ) );
                $select = '<select id="salidasAlmacen_origen_'.$i.'" name="salidasAlmacen_origen_'.$i.'" >';
                foreach( $opcionesEntrada AS $opcion) {
                    $select .= '<option value="' . $opcion->id . '" ' . ( ( $rs->fields[ 'clave' ] == $opcion->clave ) ? 'selected' : '' ) . ' >' . $opcion->clave . '</option>';
                }
                $select .= '</select>';
                
                $html .= '<table width="100%">'
                            . '<tr>'
                                . '<td width="8%">Almacen Origen:</td>'
                                . '<td>'.$select.'</td>'
                                . '<td>Existencias:</td>'
                                . '<td><input value="'.$rs->fields[ 'cantidad' ].'" id="salidasAlmacen_existencias_'.$i.'" name="salidasAlmacen_existencias_'.$i.'" size="10" readonly /></td>'
                                . '<td>Marca:</td>'                                
                                . '<td><input value="'.$rs->fields[ 'marca' ].'" id="salidasAlmacen_marca_'.$i.'" name="salidasAlmacen_marca_'.$i.'" size="12" readonly /></td>'
                                . '<td>Cantidad:</td>'
                                . '<td><input type="number" value="" id="salidasAlmacen_cantidadSalir_'.$i.'" name="salidasAlmacen_cantidadSalir_'.$i.'" size="5" /></td>'
                                . '<td><button id="salidasAlmacen_cantidadSacar_'.$i.'" name="salidasAlmacen_cantidadSacar_'.$i.'">Eliminar</button>'
                                . '<script>$(\'#salidasAlmacen_cantidadSacar_'.$i.'\').button().click(function(){salidaSKU('.$i.')});</script>'
                                . '</td>'
                                . '<input type="hidden" id="salidasAlmacen_cliente_'.$i.'" name="salidasAlmacen_cliente_'.$i.'" value="'.$rs->fields[ 'cli' ].'" />'
                            . '</tr>'
                        . '</table>';
                $rs->MoveNext();
            }
        }else{
            $html .= '<center>El SKU no fue encontrado en alguno de los almacenes disponibles</center>';
        }

        return $html;
    }
 
    /*
     * Genera registro de salidas
     */
    public function agregaSalidasAExistencias() {
        return $this->generaSalidas( $_POST[ 'sku' ] , $_POST[ 'origen' ] , $_POST[ 'cantidad' ] , $_POST[ 'cliente' ] );
    }
 
    /*
     * Metodo que agrega el registro de salidas
     */
    private function generaSalidas( $sku , $almacen , $cantidad , $cliente ) {
        $sql = " INSERT INTO inv_existencias(sku, almacen, cantidad, fechaRegistro, cliente ) "
             . " VALUES( '".$sku."', '".$almacen."', '".$cantidad."', '".date( 'Y-m-d H:i:s' )."', '".$cliente."' ) "
             . " ON DUPLICATE KEY UPDATE cantidad=cantidad-".$cantidad."; ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        $sql2  = " INSERT INTO `inv_movInventarios` ( `tipo`, `sku`, `almacen`, `cliente`, `cantidad`, `fechaMovimiento`, `usuario`, `status`) VALUES "
               . " ( '2', '".$sku."', '".$almacen."', '".$cliente."', '".$cantidad."', '".date("Y-m-d H:i:s")."', '".$_SESSION['idUsuario']."',1) ";
        $this->dbCon->ejecutaComando( $sql2 );

        if( $rs )return true;
        else return false;
    }
}

