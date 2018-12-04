<?php
/*
 * Controlador del modulo de Inventarios
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015 / Septiembre 2016 ajuste de rutinas por cambio de estructura layout
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/Template.php';
include_once _DIRPATH_ . '/sistema/Interfaz/JQGrid.php';

/*
 * Funcionalidades del Modulo
 */
include_once _DIRPATH_ . '/modulos/Inventarios/modelo/MInventarios.php';

class Inventarios extends Template {

    protected $modelo = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        new Sesion();
        parent::__construct();
        $this->modelo = new MInventarios();
    }

    /* ***************************
     *      LISTADO DE ALMACENES
     * ***************************/

    /*
     * Funcionalidad de catalogo de almacenes
     */
    public function catalogoAlmacenes(){
        $columnas = $this->modelo->catalogoAlmacenes_arreglo();
        $paths    = array( 'principal' => '/Inventarios/listadoAlmacenes/' ,
                           'excel'     => '/Utiles/generaExcel/' ,
                           'pdf'       => '/Inventarios/listadoAlmacenesPDF/',
                           'elimina'   => '/Inventarios/eliminaAlmacen/' ,
                           'agrega'    => '/Inventarios/agregaAlmacen/' ,
                           'edita'     => '/Inventarios/editaAlmacen/' );
        $grid     = new JQGrid( 'CatalogoAlmacenes' , 'Cat&aacute;logo de Almacenes' , $columnas, $paths , true);
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/catalogo_almacenes.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Cat&aacute;logos' , 'Cat&aacute;logo de Almacenes' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    /*
     * Metodo que recibe la peticion para el listado de almacenes
     */
    public function listadoAlmacenes(){
        $this->modelo->datosGridListadoAlmacenes();
    }

    /*
     * Metodo que agrega la informacion de un nuevo almacen
     */
    public function agregaAlmacen(){
        $this->modelo->agregaAlmacen();
    }

    /*
     * Metodo qwe cambia los datos de un almacen
     */
    public function editaAlmacen(){
        $this->modelo->editaAlmacen();
    }

    /*
     * Metodo que elimina un almacen
     */
    public function eliminaAlmacen(){
        $this->modelo->eliminaAlmacen();
    }

    /*
     * Metodo que abre una nueva ventana para mostrar el video
     * del almacen
     */
    public function muestraVideoAlmacen( $param ){
        $datos = $this->modelo->datosAccesoVideo( $param['id'] );
        $this->muestraDato( 'scripts' , array() );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'path' , $datos['path'] );
        $this->muestraDato( 'usuario' , $datos['usuario'] );
        $this->muestraDato( 'contrasena' , $datos['contrasena'] );
        $this->muestraDato( 'breadcrumb' , false );
        $this->muestraDato( 'cierraL' , false );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /* ***************************
     *      CATALOGO DE MOVIMIENTOS ENTRE ALMACENES
     * ***************************/
    
    /*
     * Funcionalidad de catalogo de movimientos a almacen
     */
    public function catalogoMovimientos(){
        $columnas = $this->modelo->catalogoMovimientosAlmacen_arreglo();
        $paths    = array('principal' => '/Inventarios/listadoMovimientosAlmacen/' ,
                          'excel'     => '/Utiles/generaExcel/' ,
                          'pdf'       => '/Inventarios/listadoAlmacenesPDF/',
                          'elimina'   => '/Inventarios/eliminaMovimientoAlmacen/' ,
                          'agrega'    => '/Inventarios/agregaMovimientoAlmacen/' ,
                          'edita'     => '/Inventarios/editaMovimientoAlmacen/' );
        $grid     = new JQGrid( 'CatalogoMovimientosALmacen' , 'Cat&aacute;logo de Movimientos en Almacen' , $columnas, $paths );
        $this->muestraDato( 'scripts' , array() );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Cat&aacute;logos' , 'Cat&aacute;logo de Movimientos en Almacenes' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    /*
     * Metodo que recibe la peticion para el listado de movimientos entre almacenes
     */
    public function listadoMovimientosAlmacen(){
        $this->modelo->datosGridListadoMovimientosAlmacen();
    }

    /*
     * Metodo que agrega un nuevo movimiento sobre los almacenes
     */
    public function agregaMovimientoAlmacen(){
        $this->modelo->agragaMovimientoAlmacen();
    }

    /*
     * Metodo que edita el movimiento de almacenes
     */
    public function editaMovimientoAlmacen(){
        $this->modelo->editaMovimientoAlmacen();
    }
    
    /*
     * Metodo que elimina el movimiento sobre un almnacen
     */
    public function eliminaMovimientoAlmacen(){
        $this->modelo->eliminaMovimientoAlmacen();
    }
 
    /* ***************************
     *      CATALOGO DE UNIDADES
     * ***************************/
    /*
     * Metodo que genera la interfaz grafica del catalogo de unidades de medida
     */
    public function catalogoUnidades() {
        $columnas = $this->modelo->catalogoUnidadesMedicion_arreglo();
        $paths    = array('principal' => '/Inventarios/listadoUnidadesMedicion/' ,
                          'excel'     => '/Utiles/generaExcel/' ,
                          'pdf'       => '/Utiles/generaPDF/',
                          'elimina'   => '/Inventarios/eliminaUnidadMedicion/' ,
                          'agrega'    => '/Inventarios/agregaUnidadMedicion/' ,
                          'edita'     => '/Inventarios/editaUnidadMedicion/' );
        $grid     = new JQGrid( 'CatalogoUnidadesMedicion' , 'Cat&aacute;logo de Unidades de Medici&oacute;n' , $columnas, $paths );
        $this->muestraDato( 'scripts' , array() );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Cat&aacute;logos' , 'Cat&aacute;logo de Unidades' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    /*
     * Metodo que regresa el XML de las unidades de Medicion
     */
    public function listadoUnidadesMedicion() {
        $this->modelo->datosGridListadoUnidadesMedicion();
    }
    
    /*
     * Metodo que elimina una unidad de medicion
     */
    public function eliminaUnidadMedicion() {
        $this->modelo->eliminaUnidadMedicion();
    }
    
    /*
     * Metodo que genera una nueva unidad de medicion
     */
    public function agregaUnidadMedicion() {
        $this->modelo->agregaUnidadMedicion();
    }
    
    /*
     * Metodo que edita una unidad de medicion existente
     */
    public function editaUnidadMedicion() {
        $this->modelo->editaUnidadMedicion();
    }

    /* ***************************
     *      CONSULTA DE INVENTARIOS
     * ***************************/

    public function consultaInventarios() {
        $columnas = $this->modelo->catalogoItemsInventarios_arreglo();
        $paths    = array('principal' => '/Inventarios/datosGridListadoItemsInventarios/' ,
                          'excel'     => '/Utiles/generaExcelInventarioCompleto/' ,
                          'pdf'       => '/Utiles/generaPDF/');
        $grid     = new JQGrid( 'ConsultaInventarios' , 'Consulta de Inventarios' , $columnas, $paths , true );
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/consulta_inventarios.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Consulta de Inventarios' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    public function datosGridListadoItemsInventarios() {
        $this->modelo->datosGridListadoItemsInventarios();
    }
    
    public function informacionPorLotes( $params ){
        $id       = $params['id'];
        $columnas = $this->modelo->catalogoItemsInventariosPorLotes_arreglo();
        $paths    = array('principal' => '/Inventarios/datosGridListadoItemsInventariosPorLotes/id='.$id.'/' ,
                          'excel'     => '/Utiles/generaExcel/' ,
                          'pdf'       => '/Utiles/generaPDF/');
        $grid     = new JQGrid( 'ListadoInventariosPorLotes' , 'Detalle de Lotes' , $columnas , $paths );
        $this->muestraDato( 'scripts' , array() );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , false );        
        $this->muestraDato( 'cierraL' , false );
        $this->cargaGUIDefault();
    }

    public function datosGridListadoItemsInventariosPorLotes( $params ) {
        $id = $params['id'];
        $this->modelo->datosGridListadoItemsInventariosPorLotes( $id );
    }

    /*
     * Movimiento que carga el contenido de la ficha tecnica de cada item
     */
    public function fichaTecnicaItem( $param ){
        $datos = $this->modelo->informacionTecnicaItem( $param[ 'id' ] , $param[ 'idty' ] );
        foreach( $datos[0] AS $k => $v ){
            if( $k == "fechaIngreso" ){
                if( $v > date( "Y-m-d" ) ){$v="N/A";}
            }
            $this->muestraDato( $k , $v );
        }
        $this->muestraDato( 'urlImagen' , "/Inventarios/generaImagenItem/id=".$param['idty']."|date=".date("YmdHis")."/" );
        $this->muestraDato( 'idty' , $param['idty'] );
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/ficha_tecnica.js') );
        $this->muestraDato( 'estilos' , array('/vistas/Inventarios/css/ficha_tecnica.css') );
        $this->muestraDato( 'cierraL' , false );        
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Edita Item de Inventario
     */
    public function editaItemInventario( $param ) {
        $combos   = $this->modelo->combosAltaEnAlmacenes();
        $valores  = $this->modelo->informacionTecnicaItem( $param[ 'id' ] , $param[ 'idty' ] );
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/edita_inventarios.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'valItemEdita_id' , $valores[0]['id'] );
        $this->muestraDato( 'valItemEdita_cliente' , $valores[0]['cliente'] );
        $this->muestraDato( 'valItemEdita_almacen' , $valores[0]['almacen'] );
        $this->muestraDato( 'valItemEdita_nombre' , $valores[0]['nombre'] );
        $this->muestraDato( 'valItemEdita_descripcion' , $valores[0]['descripcion'] );
        $this->muestraDato( 'valItemEdita_marca' , $valores[0]['marca'] );
        $this->muestraDato( 'valItemEdita_serie' , $valores[0]['serie'] );
        $this->muestraDato( 'valItemEdita_imei' , $valores[0]['imei'] );
        $this->muestraDato( 'valItemEdita_responsable' , $valores[0]['responsable'] );
        $this->muestraDato( 'valItemEdita_estado' , $valores[0]['estado'] );
        $this->muestraDato( 'valItemEdita_sku' , $valores[0]['sku'] );
        $this->muestraDato( 'valItemEdita_modelo' , $valores[0]['modelo'] );
        $this->muestraDato( 'valItemEdita_talla' , $valores[0]['talla'] );
        $this->muestraDato( 'valItemEdita_peso' , $valores[0]['peso'] );
        $this->muestraDato( 'valItemEdita_unidadPeso' , $valores[0]['unidadPeso'] );
        $this->muestraDato( 'valItemEdita_capacidad' , $valores[0]['capacidad'] );
        $this->muestraDato( 'valItemEdita_costo' , $valores[0]['costo'] );
        $this->muestraDato( 'valItemEdita_moneda' , $valores[0]['moneda'] );
        $this->muestraDato( 'valItemEdita_unidadMedida' , $valores[0]['unidadMedida'] );
        $this->muestraDato( 'valItemEdita_alto' , $valores[0]['alto'] );
        $this->muestraDato( 'valItemEdita_ancho' , $valores[0]['ancho'] );
        $this->muestraDato( 'valItemEdita_largo' , $valores[0]['largo'] );
        $this->muestraDato( 'valItemEdita_sabor' , $valores[0]['sabor'] );
        $this->muestraDato( 'valItemEdita_color' , $valores[0]['color'] );
        //$this->muestraDato( 'valItemEdita_empaque' , $valores[0]['empaque'] );
        $this->muestraDato( 'valItemEdita_rack' , $valores[0]['rack'] );
        $this->muestraDato( 'valItemEdita_posicionRack' , $valores[0]['posicionRack'] );
        $this->muestraDato( 'indicaciones' , _ALTAINVTEXTOSTIT_ );
        $this->muestraDato( 'seleccioneAlmacen' , _ALTAINVSELALMACEN_ );
        $this->muestraDato( 'seleccioneCliente' , _ALTAINVSELCLIENTE_ );
        $this->muestraDato( 'seleccioneLayout' , _ALTAINVSELLAYOUT );
        $this->muestraDato( 'cmbAlmacenes' , $combos[0] );
        $this->muestraDato( 'cmbClientes' , $combos[1] );   
        $this->muestraDato( 'informacionAGuardar' , _ALTAINVINFOACARGAR_ );
        $this->muestraDato( 'textoBotonAltaLayout' , _ALTAINVTEXTOBOTON_ );
        $this->muestraDato( 'textoCargaMasiva' , _ALTAINVCARGAMASIVA_ );
        $this->muestraDato( 'textoCargaIndividual' , _ALTAINVCARGAINDIV_ );
        $this->muestraDato( 'txtCargaIndNombre' , _ALTAINVINDCAMPONOMBRE_ );
        $this->muestraDato( 'txtCargaIndDescripcion' , _ALTAINVINDCAMPODESCRIPCION_ );
        $this->muestraDato( 'txtCargaIndMarca' , _ALTAINVINDCAMPOMARCA_ );
        $this->muestraDato( 'txtCargaIndSKU' , _ALTAINVINDCAMPOSKU_ );
        $this->muestraDato( 'txtCargaIndModelo' , _ALTAINVINDCAMPOMODELO_ );
        $this->muestraDato( 'txtCargaIndCantidad' , _ALTAINVINDCAMPOCANTIDAD_ );
        $this->muestraDato( 'txtCargaIndTalla' , _ALTAINVINDCAMPOTALLA_ );
        $this->muestraDato( 'txtCargaIndPeso' , _ALTAINVINDCAMPOPESO_ );
        $this->muestraDato( 'txtCargaIndUPeso' , _ALTAINVINDCAMPOUPESO_ );
        $this->muestraDato( 'txtCargaIndCapacidad' , _ALTAINVINDCAMPOCAPACIDAD_ );
        $this->muestraDato( 'txtCargaIndCosto' , _ALTAINVINDCAMPOCOSTO_ );
        $this->muestraDato( 'txtCargaIndMoneda' , _ALTAINVINDCAMPOMONEDA_ );
        $this->muestraDato( 'txtCargaIndUMedida' , _ALTAINVINDCAMPOUMEDIDA_ );
        $this->muestraDato( 'txtCargaIndAlto' , _ALTAINVINDCAMPOALTO_ );
        $this->muestraDato( 'txtCargaIndAncho' , _ALTAINVINDCAMPOANCHO_ );
        $this->muestraDato( 'txtCargaIndLargo' , _ALTAINVINDCAMPOLARGO_ );
        $this->muestraDato( 'txtCargaIndSabor' , _ALTAINVINDCAMPOSABOR_ );
        $this->muestraDato( 'txtCargaIndColor' , _ALTAINVINDCAMPOCOLOR_ );
        $this->muestraDato( 'txtCargaIndEmpaque' , _ALTAINVINDCAMPOEMPAQUE_ );
        $this->muestraDato( 'txtCargaIndRack' , _ALTAINVINDCAMPORACK_ );
        $this->muestraDato( 'txtCargaIndPRack' , _ALTAINVINDCAMPOPRACK_ );
        $this->muestraDato( 'txtCargaIndTamano' , _ALTAINVINDCAMPOTAMANO_ );
	$this->muestraDato( 'txtBotonGuardaItemLote' , _ALTAINVTEXTOBOTONITEMLOTE_ );
	$this->muestraDato( 'txtCargaIndIMEI' , _ALTAINVINDCAMPOIMEI_ );
	$this->muestraDato( 'txtCargaIndSerie' , _ALTAINVINDCAMPOSERIE_ );
	$this->muestraDato( 'txtCargaIndResponsable' , _ALTAINVINDCAMPORESPONSABLE_ );
	$this->muestraDato( 'txtCargaIndEstado' , _ALTAINVINDCAMPOESTADO_ );
	$this->muestraDato( 'cmbuMedida' , $combos[2] );
        $this->muestraDato( 'cmbUnidadPeso' , $combos[3] );
	$this->muestraDato( 'seleccioneImagen' , _ALTAINVINDIVIMG_ );
        $this->muestraDato( 'breadcrumb' , false );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Accion que guarda la edicion del item
     */
    public function guardaEdicionItemInventario() {
        $response = $this->modelo->guardaEdicionItemInventario();
	echo '<script>parent.resultadoProcesoEdicionItem("' . ( addslashes( $response ) ) .'");</script>';
    }

    /*
     * Accion que genera la imagen del item
     */
    public function generaImagenItem( $param ) {
        $this->modelo->generaImagenItem( $param['id'] );
    }
    
    /*
     * Accion que sube la imagen del item
     */
    public function uploadImagenItem() {
        $id = $_POST["idImagenItemFichaTecnica"];
        $response = $this->modelo->uploadImagenItem($id);
        echo '<script>parent.resultadoUpdateImagenItem("' . ( addslashes( $response ) ) .'");  </script>';
    }
    
    /*
     * Accion que genera reporte en PDF del detalle del producto
     */
    public function generaPDFFichaTecnicaItem( $param ) {
        $this->modelo->generaPDFFichaTecnicaItem( $param['id'] );
    }

    /*
     * Accion que elimina un elemento del inventario
     */
    public function eliminaElementoInventario( $param ){
        $this->modelo->eliminaElementoInventario( $param[ 'id' ] , $param[ 'almacen' ] , $param[ 'sku' ] );
    }


    /* ***************************
     *      MOVIMIENTOS EN ALMACENES
     * ***************************/
    public function altaInventarios() {
        $combos   = $this->modelo->combosAltaEnAlmacenes();
        $columnas = $this->modelo->layoutsProcesados_arreglo();
        $paths    = array('principal' => '/Inventarios/listadoLayoutsProcesados/' ,
                          'excel'     => '/Utiles/generaExcel/' ,
                          'pdf'       => '/Utiles/generaPDF/');
        $grid     = new JQGrid( 'HistorialLayoutsProcesados' , 'Layouts Procesados' , $columnas, $paths , true );
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/alta_inventarios.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'indicaciones' , _ALTAINVTEXTOSTIT_ );
        $this->muestraDato( 'seleccioneAlmacen' , _ALTAINVSELALMACEN_ );
        $this->muestraDato( 'seleccioneCliente' , _ALTAINVSELCLIENTE_ );
        $this->muestraDato( 'seleccioneLayout' , _ALTAINVSELLAYOUT );
        $this->muestraDato( 'cmbAlmacenes' , $combos[0] );
        $this->muestraDato( 'cmbClientes' , $combos[1] );   
        $this->muestraDato( 'informacionAGuardar' , _ALTAINVINFOACARGAR_ );
        $this->muestraDato( 'textoBotonAltaLayout' , _ALTAINVTEXTOBOTON_ );
        $this->muestraDato( 'textoCargaMasiva' , _ALTAINVCARGAMASIVA_ );
        $this->muestraDato( 'textoCargaIndividual' , _ALTAINVCARGAINDIV_ );
        $this->muestraDato( 'gridTemporal' , $grid->html );
        $this->muestraDato( 'txtCargaIndNombre' , _ALTAINVINDCAMPONOMBRE_ );
        $this->muestraDato( 'txtCargaIndDescripcion' , _ALTAINVINDCAMPODESCRIPCION_ );
        $this->muestraDato( 'txtCargaIndMarca' , _ALTAINVINDCAMPOMARCA_ );
        $this->muestraDato( 'txtCargaIndSKU' , _ALTAINVINDCAMPOSKU_ );
        $this->muestraDato( 'txtCargaIndModelo' , _ALTAINVINDCAMPOMODELO_ );
        $this->muestraDato( 'txtCargaIndCantidad' , _ALTAINVINDCAMPOCANTIDAD_ );
        $this->muestraDato( 'txtCargaIndTalla' , _ALTAINVINDCAMPOTALLA_ );
        $this->muestraDato( 'txtCargaIndPeso' , _ALTAINVINDCAMPOPESO_ );
        $this->muestraDato( 'txtCargaIndUPeso' , _ALTAINVINDCAMPOUPESO_ );
        $this->muestraDato( 'txtCargaIndCapacidad' , _ALTAINVINDCAMPOCAPACIDAD_ );
        $this->muestraDato( 'txtCargaIndCosto' , _ALTAINVINDCAMPOCOSTO_ );
        $this->muestraDato( 'txtCargaIndMoneda' , _ALTAINVINDCAMPOMONEDA_ );
        $this->muestraDato( 'txtCargaIndUMedida' , _ALTAINVINDCAMPOUMEDIDA_ );
        $this->muestraDato( 'txtCargaIndAlto' , _ALTAINVINDCAMPOALTO_ );
        $this->muestraDato( 'txtCargaIndAncho' , _ALTAINVINDCAMPOANCHO_ );
        $this->muestraDato( 'txtCargaIndLargo' , _ALTAINVINDCAMPOLARGO_ );
        $this->muestraDato( 'txtCargaIndSabor' , _ALTAINVINDCAMPOSABOR_ );
        $this->muestraDato( 'txtCargaIndColor' , _ALTAINVINDCAMPOCOLOR_ );
        $this->muestraDato( 'txtCargaIndEmpaque' , _ALTAINVINDCAMPOEMPAQUE_ );
        $this->muestraDato( 'txtCargaIndRack' , _ALTAINVINDCAMPORACK_ );
        $this->muestraDato( 'txtCargaIndPRack' , _ALTAINVINDCAMPOPRACK_ );
        $this->muestraDato( 'txtCargaIndTamano' , _ALTAINVINDCAMPOTAMANO_ );
	$this->muestraDato( 'txtBotonGuardaItemLote' , _ALTAINVTEXTOBOTONITEMLOTE_ );
	$this->muestraDato( 'txtCargaIndIMEI' , _ALTAINVINDCAMPOIMEI_ );
	$this->muestraDato( 'txtCargaIndSerie' , _ALTAINVINDCAMPOSERIE_ );
	$this->muestraDato( 'txtCargaIndResponsable' , _ALTAINVINDCAMPORESPONSABLE_ );
	$this->muestraDato( 'txtCargaIndEstado' , _ALTAINVINDCAMPOESTADO_ );
	$this->muestraDato( 'txtCargaFechaIngreso' , _ALTAINVINDCAMPOFECHINGRESO_ );
	$this->muestraDato( 'cmbuMedida' , $combos[2] );
        $this->muestraDato( 'cmbUnidadPeso' , $combos[3] );
	$this->muestraDato( 'seleccioneImagen' , _ALTAINVINDIVIMG_ );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Movimiento en Inventarios' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Obtiene en archivo el detalle de subida de un layout
     */
    public function detalleLayoutDescarga( $param ) {
        $this->modelo->detalleLayoutDescarga( $param['id'] );
    }
    
    /*
     * Obtiene la estructura XML para el grid
     */
    public function listadoLayoutsProcesados() {
        $this->modelo->datosGridLayoutsProcesados();
    }

    /*
     * Recepcion de datos para agregar a inventarios
     */
    public function altaDatosInventarios() {
        $datos = $_POST;
        $this->modelo->procesaAltaEnAlmacenes($datos);

        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Alta en almacenes
     */
    public function procesaAltaInventarios( $params ){
        $response = $this->modelo->procesaLayoutInventario( $params );
        echo '<script>parent.resultadoProcesoLayut("' . ( addslashes( $response ) ) .'");</script>';
    }

    /*
     * Carga Inventario Individual
     */
    public function procesaAltaInventariosIndiv(){
        $response = $this->modelo->procesaAltaInventariosIndiv();
	echo '<script>parent.resultadoProcesoImagen("' . ( addslashes( $response ) ) .'");</script>';
    }

    /*
     * Guarda Item Lote
     */
    public function guardaItemLote(){
        $response = $this->modelo->guardarItemLote();
        echo $response;
    }

    /*
     * Movimientos en el inventario
     */
    public function movimientoInventarios() {
        $combos   = $this->modelo->combosSeleccionAlmacenInventario();
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/movimientos_inventarios.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'comboAlmaEntrada' , $combos[0] );
        $this->muestraDato( 'comboAlmaSalida' , $combos[1] );
        $this->muestraDato( 'comboLayoutsLotes' , $combos[2] );
        $this->muestraDato( 'tituloMovAlmacenes' , _MOVINVALMACENESTITULO_ );
        $this->muestraDato( 'tituloMovIndAlmacenes' , _MOVINVALMACENESINDTITULO_ );
        $this->muestraDato( 'txtSelAlmaEntrada' , _MOVINVSELAMACENENTRADA_ );
        $this->muestraDato( 'txtSelAlmaSalida' , _MOVINVSELALMACENSALIDA_ );
        $this->muestraDato( 'txtSeleccioneLoteLayout' , _MOVINVSELLOTELAYOUT_ );
        $this->muestraDato( 'txtBusquedaSKU' , _MOVINVBUSQUEDASKU_ );
        $this->muestraDato( 'txtBusquedaSKUPiezas' , _MOVINVBUSQUEDASKUPIEZAS_ );
        $this->muestraDato( 'txtRealizaTraspaso' , _MOVINVBOTONTRASPASAINV_ );
        $this->muestraDato( 'txtRealizaTraspasoInd' , _MOVINVBOTONTRASPASAINVIND_ );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Movimiento de Inventarios' ) );
        $this->muestraDato( 'cierraL' , true );        
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    /*
     * Movimiento que regresa los almacenes disponibles para recibir traspaso
     */
    public function cargaAlmacenesEntradaTraspaso( $param ) {
        $id = $param['id'];
        $response = $this->modelo->cargaAlmacenesEntradaTraspaso( $id );
        echo $response;
    }
    
    /*
     * Movimiento que regresa los layouts del almacen de salida
     */
    public function cargaLayoutsTraspasoAlmacenSalida( $param ) {
        $id = $param['id'];
        $response = $this->modelo->cargaLayoutsTraspasoAlmacenSalida($id);
        echo $response;
    }

    /*
     * Movimiento de SKU individual entre almacenes (Nueva forma)
     */
    public function movIndividualBusquedaSKU() {
        $response = $this->modelo->movIndividualBusquedaSKU();
        echo $response;
    }

    /*
     * Movimiento para almacenar el traslado individual previa autorizacion
     */
    public function enviaNuevoTraspasoIndividual() {
        $response = $this->modelo->enviaNuevoTraspasoIndividual();
        echo $response;
    }

    /* ***************************
     *      TRASLADO DE INVENTARIOS
     * ***************************/
   
   /* Realiza el traslado de inventarios de un almacen a otro de un lote de productos, es decir de un layout */
   public function trasladoDeInventarios() {
       $this->modelo->trasladoInventarios();
   }
   
   /* Realiza el traslado de inventarios de un almacen a otro de manera individual, por porductos */
   public function trasladoDeInventariosIndividual() {
       $this->modelo->trasladoInventariosIndividual();
   }
    
   /* Funcionalidad autcomplete de sku */
   public function skuAutocomplete() {
       return $this->modelo->skuAutocomplete( $_GET['term'] );
   }
   
   /* ****************************
    *             EXISTENCIAS POR ALMACEN
    * ****************************/
   /* Carga la interfaz grafica para el alta de existencias */
   public function existenciasPorAlmacen() {
        $combos   = $this->modelo->combosSeleccionAlmacenInventario();
        $this->muestraDato( 'txtTitFormExistencias' , _EXISTENCIASFORMTITULO_ );
        $this->muestraDato( 'txtSelCli' , _EXISTENCIASELCLIENTE_ );
        $this->muestraDato( 'comboSelClientes' , $combos[3] );
        $this->muestraDato( 'txtSelSKU' , _EXISTENCIASSELSKU_ );
        $this->muestraDato( 'txtSelAlmacen' , _EXISTENCIASSELALMACEN_ );
        $this->muestraDato( 'comboSelAlmacen' , $combos[0] );
        $this->muestraDato( 'txtCantSurtir' , _EXISTENCIASCANTIDAD_ );
        $this->muestraDato( 'txtAgregaExistencias' , _EXISTENCIASBTNAGREGA_ );
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/existencias_inventarios.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Existencias' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
   }
   
   /* Afecta las existencias de acuerdo al almacen y a la cantidad de entrada */
   public function altaExistenciasSKU() {
       $this->modelo->afectaExistenciasSKU();
   }
 
   /*
    * AUTORIZACION DE TRASLADOS
    */
    public function autorizacionTraslados() {
       $columnas = $this->modelo->autorizacionTraslados_arreglo();
       $paths    = array('principal' => '/Inventarios/listadoAutorizacionTraslados/' ,
                          'excel'     => '/Utiles/generaExcel/' ,
                          'pdf'       => '/Utiles/generaPDF/');
        $grid     = new JQGrid( 'ListadoAutorizacionesTraslados' , 'Autorizaciones de Traslados' , $columnas, $paths , true );
        $this->muestraDato( 'scripts' , array('/vistas/Inventarios/js/traspasos.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Autorizaciones' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

   /*
    * Consulta los datos a mostrar en el grid
    */
    public function listadoAutorizacionTraslados() {
       $this->modelo->datosGridAutorizacionesTraslados();
    }
   
   /*
    * Pantalla para procesar traslado
    */
    public function procesarTrasladoIndividual( $params ) {        
        $this->muestraDato( 'comentarios' , $params['comentarios'] );
        $this->muestraDato( 'origen' , $params['origen'] );
        $this->muestraDato( 'destino' , $params['destino']);
        $this->muestraDato( 'layout' , ( ( $params['layout'] == '0' ) ? $params[ 'sku' ] : $params[ 'layout' ] ) );
        $this->muestraDato( 'total' , $params['total']);
        $this->muestraDato( 'idTraslado' , $params['id']);
        $this->muestraDato( 'elementos' , true );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Existencias' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
   }
   
   /*
    * Metodo que aplica el traslado una vez aceptado
    */
   public function aplicarTraslado( $params ) {
       $this->modelo->aplicarTraslado( $params );
   }
   
   /*
    * Metodo que aplica el rechazo de un traslado
    */
   public function rechazaTraslado( $params ) {
       $this->modelo->rechazaTraslado( $params );
   }
   
   /*
    * Surtido de existencias 2017
    */
    public function OpcionesSurtirSKU() {
        echo $this->modelo->OpcionesSurtirSKU();
    }
   
   /*
    * Agrega existencias
    */
    public function generaNuevasExistencias() {
        echo $this->modelo->agregaNuevasExistencias();
    }
   
   /*
    * Pantalla para generar el formato de salida
    */
    public function generaFormatoSalida( $params ) {
        $this->muestraDato( 'scripts'   , array() );
        $this->muestraDato( 'estilos'   , array() );
        $this->muestraDato( 'idty' , $params[ 'id' ] );
        $this->muestraDato( 'breadcrumb' , false );
        $this->muestraDato( 'cierraL' , false );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

   /*
    * Evento que genera el vale de dalida
    */
   public function generaValeSalida() {
       $params = $_GET;
       $this->modelo->generaValeSalida( $params );
   }

   /*
    * Metodo que muestra el formulario para los datos de entrada de cada alta 
    * de existencias en el inventario
    */
   public function ValeEntradasInventario( $param ) {
        $combos = $this->modelo->comboMovimientosInventarios();
        $datosVale = $this->modelo->datosValeMovimiento( $param[ 'id' ] );
        $this->muestraDato( 'scripts'          , array( '/vistas/Inventarios/js/valeEntradaSalida.js' ) );
        $this->muestraDato( 'estilos'          , array() );
        $this->muestraDato( 'idMov'            , $param[ 'id' ] );
        $this->muestraDato( 'creado'           , $datosVale[ 'creado' ] );
        $this->muestraDato( 'noPedido'         , $datosVale[ 'noPedido' ] );
        $this->muestraDato( 'fechaPedido'      , $datosVale[ 'fechaPedido' ] );
        $this->muestraDato( 'solicitante'      , $datosVale[ 'solicitante' ] );
        $this->muestraDato( 'autorizante'      , $datosVale[ 'autorizante' ] );
        $this->muestraDato( 'nombreQuienRecoge', $datosVale[ 'nombreQuienRecoge' ] );
        $this->muestraDato( 'nombreQuienRecibe', $datosVale[ 'nombreQuienRecibe' ] );
        $this->muestraDato( 'nombreGuardia'    , $datosVale[ 'nombreGuardia' ] );
        $this->muestraDato( 'fechaMovimiento'  , $datosVale[ 'fechaMovimiento' ] );
        $this->muestraDato( 'observaciones'    , $datosVale[ 'observaciones' ] );
        $this->muestraDato( 'comboMovimientos' , $combos[ 0 ] );
        $this->muestraDato( 'selectMovs'       , explode( ',' , $datosVale[ 'idsMovsS' ] ));        trigger_error(serialize( explode( ',' , $datosVale[ 'idsMovsS' ] ) ));
        $this->muestraDato( 'todos'            , $datosVale[ 'todos' ] );
        $this->muestraDato( 'breadcrumb'       , false );
        $this->muestraDato( 'cierraL'          , false );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
   }
   
   /*
    * Vales de entradas/salidas
    */
   
   /*
    * Pantalla que contiene el grid con cada entrada y salida lista para generar el vale
    */
   public function valesEntradasSalidas() {
        $columnas = $this->modelo->listadoEntradasSalidas_arreglo();
        $paths    = array( 'principal' => '/Inventarios/listadoEntradasSalidasXML/' ,
                           'excel'     => '/Utiles/generaExcel/',
                           'adicional' => array(
                                0 => array(
                                    'recurso' => 'valeMasivo()',
                                    'msj'     => 'Crear vale masivo',
                                    'icono'   => 'ui-icon-calculator',
                                    'tipo'    => 'fx'
                                )                               
                           )
                        );
        $grid     = new JQGrid( 'ListadoMovimientosES' , 'Movimientos de Entrada/Salida' , $columnas, $paths , true);
        $this->muestraDato( 'scripts'   , array( '/vistas/Inventarios/js/valeEntradaSalida.js' ) );
        $this->muestraDato( 'estilos'   , array() );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Vales E/S' ) );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
   }
   
   /*
    * Obtiene XML con la informacion de movimientos de entradas y salidas
    */
   public function listadoEntradasSalidasXML() {
       $this->modelo->listadoEntradasSalidasXML();
   }

   /*
    * Metodo que guarda la informacion del vale
    */
   public function guardaInformacionVale() {
       echo $this->modelo->guardaInformacionVale();
   }

   /*
    * Metodo que obtiene el motivo de movimiento del almacen
    */
   public function obtieneMotivoMovimiento( $params ) {
       echo $this->modelo->obtieneMotivoMovimiento( $params[ 'id' ] );
   }

   /*
    * Metodo para generar el pdf de la entrada/salida
    */
   public function generaValeEntradaSalida( $params ) {
       $this->modelo->generaValeEntradaSalida( $params[ 'id' ] );
   }

   /*
    * Salidas
    */
   public function Salidas() {
        $this->muestraDato( 'scripts'   , array( '/vistas/Inventarios/js/salidas.js' ) );
        $this->muestraDato( 'estilos'   , array() );
        $this->muestraDato( 'txtSelSKUSal' , _EXISTENCIASSELSKUSAL_ );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Inventarios' , 'Salidas' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
   }
 
   /*
    * Salida de sku de almacen
    */
    public function OpcionesSalidaSKU() {
        echo $this->modelo->OpcionesSalidaSKU();
    }
   
   /*
    * Agrega existencias
    */
    public function generaSalidaExistencias() {
        echo $this->modelo->agregaSalidasAExistencias();
    }

}

