<?php
/*
 * Clase que regresa la estructura XML de una consulta para ser mostrada
 * dentro de la estructura grid
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die("No se permite el acceso directo a este archivo"); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

class DataGrid {

    /*
     * Almacenara la instancia de la conexion a la base de datos
     */
    private $dbCon = null;

    /*
     * Almacena el recordset, conjunto de datos a ser mostrados dentro del grid
     */
    private $recordSet = null;

    /*
     * Consulta a ser ejecutada para obtener los datos a mostrar en el grid
     */
    private $consulta = '';
    
    /*
     * Titulo del reporte
     */
    private $tituloReporte = '';

    /*
     * Pagina actual
     */
    private $page = '';

    /*
     * Registros por pagina
     */
    private $limit = '';

    /*
     * Campo por el cual se ordena
     */
    private $sidx = ' id ';

    /*
     * Tipo de orden
     */
    private $sord = '';

    /*
     * Total de paginas en el grid
     */
    private $total_pages = 0;

    /*
     * Registros totales
     */
    private $count = 0;
    
    /*
     * Where filtros
     */
    private $whereFiltros = '';

    /*
     * Where consulta
     */
    private $whereConsulta = '';
    
    /*
     * Sentencia de orden de la consulta a ejecutar
     */
    private $ordenConsulta = '';

    /*
     * Estructura XML resultado a ser desplegada dentro del grid
     */
    public $datosXML = '';
    
    /*
     * Constructor de clase, recibe todos los parametros utiles para armar la
     * estructura de datos a mostrar dentro del grid
     */
    public function __construct( $consulta , $titulo='' ) {
        new Sesion();
        $this->dbCon = new classConMySQL();
        $this->page  = isset( $_GET['page'] ) ? $_GET['page'] : '';
        $this->limit = isset( $_GET['rows'] ) ? $_GET['rows'] : '10';
        $this->sidx  = isset( $_GET['sidx'] ) ? $_GET['sidx'] : '';
        $this->sord  = isset( $_GET['sord'] ) ? $_GET['sord'] : 'desc';
        $this->consulta = $consulta;
        $this->tituloReporte = $titulo;
        $this->whereConsulta();
        $this->cargaDatos();
    }

    /*
     * Where consulta SQL
     */
    public function whereConsulta() {
        $partes = explode( "WHERE" , $this->consulta );
        $this->whereConsulta = isset( $partes[1] ) ? $partes[1] : '';
        $this->consulta = $partes[0];
        $this->filtros();
        return true;
    }

    /*
     * Verifica los parametros enviados para los filtros adicionales en la consulta
     */
    private function filtros() {
        if( isset( $_GET["searchField"]  ) && $_GET["searchField"]  != "" && 
            isset( $_GET["searchString"] ) && $_GET["searchString"] != "" && 
            isset( $_GET["searchOper"]   ) && $_GET["searchOper"]   != ""){
                switch( $_GET['searchOper'] ){
                    case 'eq':$oper = " = '".$_GET['searchString']."'";break;//igual
                    case 'ne':$oper = " <> '".$_GET['searchString']."'";break;//diferente
                    case 'lt':$oper = " < '".$_GET['searchString']."'";break;//Menor que
                    case 'le':$oper = " <= '".$_GET['searchString']."'";break;//Menor o igual
                    case 'gt':$oper = " > '".$_GET['searchString']."'";break;//Mayor que
                    case 'ge':$oper = " >= '".$_GET['searchString']."'";break;//Mayor igual            
                    case 'bw':$oper = " like '".$_GET['searchString']."%'";break;//Empieza con
                    case 'bn':$oper = " not like '".$_GET['searchString']."%'";break;//No empieza con
                    case 'in':$oper = " IN( '".$_GET['searchString']."' )";break;//Esta en
                    case 'ni':$oper = " NOT IN( '".$_GET['searchString']."' )";break;//No esta en
                    case 'ew':$oper = " like '%".$_GET['searchString']."'";break;//Acaba con
                    case 'en':$oper = " not like '%".$_GET['searchString']."'";break;//Acaba con
                    case 'cn':$oper = " like '%".$_GET['searchString']."%'";break;//Contiene
                    case 'nc':$oper = " not like '%".$_GET['searchString']."%'";break;//No contiene
                }
                $this->whereFiltros = "  ".$_GET["searchField"].$oper;
        }
    }
    
    private function cargaDatos() {        
        $this->ejecucionConsulta();
    }

    /*
     * Metodo que ejecuta el comando y obtiene la cantidad de registros a 
     * desplegar dentro del grid
     */
    private function ejecucionConsulta() {
        $sql  = $this->consulta . ' WHERE ' ;
        $sql .= ( strlen( $this->whereFiltros ) > 1 )  ? $this->whereFiltros  : '' ;
        $sql .= ( strlen( $this->whereConsulta ) > 1 ) ? ( ( strlen($this->whereFiltros) > 1 ) ? ' AND '.$this->whereConsulta : $this->whereConsulta )  : '' ;
        $this->count = $this->dbCon->num_regmysql( $sql );
        $_SESSION['consultaExporta'] = $sql;
        $_SESSION['tituloreporte'] = $this->tituloReporte;
        
        $this->paginacion();
        $sql .= $this->ordenConsulta;
        $this->consulta = $sql;
        /*
         * Comienza el armado de la estructura XML
         */
        $this->armaXML();
    }

    /*
     * Metodo que realiza el proceso de paginacion de los registros a 
     * ser mostrados dentro del grid
     */
    private function paginacion() {
        $this->total_pages = 0;
        if( !$this->sidx ){ $this->sidx = 1; }
        if( $this->count > 0 && $this->limit > 0) { $this->total_pages = ceil( $this->count / $this->limit ); }
        else { $this->total_pages = 0; }
        if ( $this->page > $this->total_pages ){ $this->page = $this->total_pages; }
        $start = $this->limit * $this->page - $this->limit;
        if( $start < 0 ){ $start = 0; }
        $this->ordenConsulta = " ORDER BY " . $this->sidx . " " . $this->sord . " LIMIT ".$start .",". $this->limit;
    }

    /*
     * Comienza a hacer el armado de la estructura XML a mostrar dentro del grid
     */
    public function armaXML() {
        ob_clean();
        header("Content-type: text/xml;charset=utf-8");
        $this->datosXML  = "<?xml version='1.0' encoding='utf-8'?>";
        $this->datosXML .= "<rows>";
        $this->datosXML .= "<page>".$this->page."</page>";
        $this->datosXML .= "<total>".$this->total_pages."</total>";
        $this->datosXML .= "<records>".$this->count."</records>";
        $this->datosXML .= $this->recordset();
    }

    /*
     * Metodo que realiza el recorrido sobre el recordset y genera
     * la estructura xml para el grid
     */
    public function recordset() {
        $xml_elementos = '';
        $this->dbCon->fetchMode( ADODB_FETCH_NUM );
        $rs = $this->dbCon->ejecutaComando( $this->consulta );

        foreach( $rs AS $k => $row ){
            $tamanio = count( $row );
            for( $i = 0 ; $i < $tamanio ; $i ++ ){
                if( $i == 0 ){$xml_elementos .= "<row id='" . $row[0] . "'>";}
                else{$xml_elementos .= "<cell><![CDATA[" . utf8_encode($row[$i]) . "]]></cell>";}
            }
            $xml_elementos .= "</row>";
        }

        $xml_elementos .= '</rows>';
        return $xml_elementos;
    }

}

