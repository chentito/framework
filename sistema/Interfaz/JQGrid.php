<?php
/*
 * Clase que contiene la estructura de un GRID de consulta
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

class JQGrid {

    /*
     * Variable que almacena el nombre del grid
     */
    private $nombreGrid = '';

    /*
     * Variable que almacena el nombre del paginador
     */
    private $nombrePager = '';

    /*
     * Arreglo de paths donde se hara la consulta de datos
     */
    private $paths = array();

    /*
     * Arreglo que almacena la estructura de columnas a mostrarse dentro del grid
     */
    private $columnas = array();

    /*
     * Variable que contiene la estructura completa del grid
     */
    public $html = '';
    
    /*
     * Variable que almacena una bandera para saber si el evento select row tendra alguna accion
     */
    public $selectRow = false;
    
    /*
     * Constructor de la clase
     * $nombre: es el nombre del grid
     * $columnas: es la estructrura de los datos y columnas que se mostraran en el grid
     * $paths: son las rutas a ejecutar para las diferentes acciones que tendra el grid
     *         por ejemplo, ruta para editar $paths[edita]='../../Sistema/...'
     */
    public function __construct( $nombre , $titulo , $columnas=array() , $paths=array() , $selectRow=false ) {
        $this->nombreGrid  = $nombre;
        $this->nombrePager = $nombre . '_pager';
        $this->paths       = $paths;
        $this->columnas    = $columnas;
        $this->selectRow   = $selectRow;
        $this->armaGrid( $titulo );
    }

    /*
     * Metodo que genera la estructura completa para el despliegue del GRID: javascript
     * y html, con la configuracion correspondiente
     */
    private function armaGrid( $titulo ){
        $html  = '<script>';
        $html .= $this->grid( $titulo );
        $html .= $this->pager();
        $html .= '';
        $html .= '</script>';
        $html .= $this->contenedor();
        $this->html = $html;
    }

    /*
     * Crea el contenedor html donde se cargara el grid
     */
    private function contenedor(){
        $html  = '<fieldset class="ui-widget ui-widget-content">';
        $html .= '<table id="' . $this->nombreGrid . '"></table>';
        $html .= '<div id="' . $this->nombrePager . '"></div>';
        $html .= '</fieldset>'; 
        return $html;
    }

    /*
     * Metodo que contiene la estructura del Grid
     */
    private function grid( $titulo ) {
        $html  = '$("#' . $this->nombreGrid . '").jqGrid({';
        $html .= 'url        : "' . $this->paths['principal'].'",';
        $html .= 'hidegrid   : false,';
        $html .= 'viewrecords: true,';
        $html .= 'autowidth  : true,';
        $html .= 'shrinkToFit: true,';
        $html .= 'zIndex     : 800,';
        $html .= 'datatype   : "xml",';
        $html .= 'mtype      : "GET",';
        $colNames = '';
        $colModel = '';
        foreach( $this->columnas AS $columna => $atributos ) {
            $colNames .= '"' . $columna . '",';
            $colModel .= '{';
            $colModelContent = '';
            foreach( $atributos AS $llave => $valor ) {
                if( $llave == 'editrules' || $llave == 'editoptions' ){ $colModelContent .= $llave . ':' . $valor . ','; }
                //elseif( is_bool( $valor ) ){ $colModelContent .= $llave . ':' . ( boolval( $valor ) ? 'true' : 'false' ) . ','; }
                elseif( is_bool( $valor ) ){ $colModelContent .= $llave . ':' . ( (bool)( $valor ) ? 'true' : 'false' ) . ','; }
                else{ $colModelContent .= $llave . ':"'.$valor .'",'; }
            }
            $colModel .= trim( $colModelContent , ',' );
            $colModel .= '},';
        }
        $html .= 'colNames   :';
        $html .= '[' . trim( $colNames , ',' ) . '],';
        $html .= 'colModel   :';
        $html .= '[' . trim( $colModel , ',' ) . '],';
	$html .= 'gridComplete: function(){  if($("#' . $this->nombreGrid . '").parent().width() > $("#RightPane").width()){ $("#' . $this->nombreGrid . '").setGridWidth($("#breadCrumbContainer").width()); }  },';
        $html .= 'pager      : "#' . $this->nombrePager . '",';
        $html .= 'rowNum     : 10,';
        $html .= 'rowList    : [10,20],';
        $html .= 'sortname   : "id",';
        $html .= 'sortorder  : "desc",';
        $html .= 'caption    : "' . $titulo . '",';
        $html .= 'height     : 250,';
        $html .= 'onSelectRow: function(id){';
        if( $this->selectRow ){$html .= 'if (typeof select_row == "function") { select_row(id); }';}
        $html .= '}});';
        $html .= '';
        return $html;
    }

    /*
     * Metodo que contiene la estructura del paginador
     */
    private function pager(){
        $html  = '$("#' . $this->nombreGrid . '").jqGrid("navGrid","#' . $this->nombrePager . '",';
        $html .= '{';
        $html .= isset( $this->paths['elimina'] ) ? 'del:true,' : 'del:false,' ;
        $html .= isset( $this->paths['agrega'] )  ? 'add:true,' : 'add:false,' ;
        $html .= isset( $this->paths['edita'] )   ? 'edit:true,' : 'edit:false,' ;
	$html .= isset( $this->paths['ver'] )   ? 'view:true' : 'view:false' ;
        $html .= '},';
        $html .= '{   /* Edicion */';
        $html .= 'zIndex           : 1000,';
        $html .= 'height           : "auto",';
	$html .= 'width            : "auto",';
        $html .= 'reloadAfterSubmit: true,';
        $html .= 'closeAfterEdit   : true,';
        $html .= 'modal            : true,';
        $html .= 'url              : "' . ( isset( $this->paths['edita'] ) ? $this->paths['edita'] : '' ) . '",';
        $html .= 'caption          : "Edita Registro",';
        $html .= 'bSubmit          : "Guardar Cambios",';
        $html .= 'bCancel          : "Cancelar",';
	$html .= 'recreateForm     : true';
        $html .= '},';
        $html .= '{   /* Alta */';
        $html .= 'zIndex           : 1000,';
        $html .= 'height           : "auto",';
	$html .= 'width            : "auto",';
        $html .= 'reloadAfterSubmit: true,';
        $html .= 'closeAfterAdd    : true,';
        $html .= 'modal            : true,';
        $html .= 'url              : "' . ( isset( $this->paths['agrega'] ) ? $this->paths['agrega'] : '' ) . '",';
        $html .= 'caption          : "Agregar Registro",';
        $html .= 'bSubmit          : "Guardar Registro",';
        $html .= 'bCancel          : "Cancelar",';
	$html .= 'recreateForm     : true';
        $html .= '},';
        $html .= '{   /* Baja */';
        $html .= 'zIndex           : 1000,';
        $html .= 'reloadAfterSubmit: true,';
        $html .= 'caption          : "Eliminar Registro",';
        $html .= 'msg              : "Eliminar registro seleccionado ?",';
        $html .= 'url              : "' . ( isset( $this->paths['elimina'] ) ? $this->paths['elimina'] : '' ) . '",';
        $html .= 'bSubmit          : "Aceptar",';
        $html .= 'bCancel          : "Cerrar"';
        $html .= '},{sopt : ["eq","ne","lt","le","gt","ge","bw","bn","ew","en","cn","nc"]}';
	$html .= ',{   /* Vista */ ';
        $html .= 'height           : "auto",';
        $html .= 'jqModal          : false,';
        $html .= 'closeOnEscape    : true';
        $html .= '}';
        $html .= ')';
        $html .= isset( $this->paths['excel'] ) ? $this->estructuraExcel() : '' ;
        $html .= isset( $this->paths['pdf'] )   ? $this->estructuraPDF()   : '' ;
        $html .= ( isset( $this->paths['adicional'] ) && count( $this->paths[ 'adicional' ] ) > 0  ) ? $this->boton() : '' ;
        $html .= ';';
        return $html;
    }

    /*
     * Regresa la estructura del boton para la descarga en formato excel
     */
    public function estructuraExcel(){
        $html  = '.jqGrid("navButtonAdd","#' . $this->nombrePager . '",{';
        $html .= 'caption:"",';
        $html .= 'buttonicon:"ui-icon-calculator",';
        $html .= 'onClickButton: function(){';
        $html .= 'window.location = "' . $this->paths['excel'] . '";';
        $html .= '},';
        $html .= 'position: "last",';
        $html .= 'title:"Exportar Excel",';
        $html .= 'msg:"Exportar a Excel",';
        $html .= 'cursor: "pointer"';
        $html .= '})';
        return $html;
    }

    /*
     * Regresa la estructura del boton para la descarga en formato pdf
     */
    public function estructuraPDF(){
        $html  = '.jqGrid("navButtonAdd","#' . $this->nombrePager . '",{';
        $html .= 'caption:"",';
        $html .= 'buttonicon:"ui-icon-script",';
        $html .= 'onClickButton:function(){';
        $html .= 'window.location = "' . $this->paths['pdf'] . '";';
        $html .= '},';
        $html .= 'position: "last",';
        $html .= 'title:"Exportar PDF",';
        $html .= 'msg:"Exportar a PDF",';
        $html .= 'cursor:"pointer"';
        $html .= '})';
        return $html;
    }

    /*
     * Metodo que contiene la estructura de botones adicionales en el paginador
     */
    public function boton(){
        $html = '';
        foreach( $this->paths[ 'adicional' ] AS $icono ) {
            $html .= '.jqGrid("navButtonAdd","#' . $this->nombrePager . '",{';
            $html .= 'caption:"",';
            $html .= 'buttonicon:"' . $icono[ 'icono' ] . '",';
            $html .= 'onClickButton:function(){';
                if( $icono[ 'tipo' ] == 'url' ){ $html .= 'window.location = "' . $icono[ 'recurso' ] . '";'; }
            elseif( $icono[ 'tipo' ] == 'fx'  ){ $html .= $icono[ 'recurso' ] . '();'; }
            $html .= '},';
            $html .= 'position:"last"';
            $html .= 'title:"'.( ( isset( $icono[ 'msj' ] ) ) ? $icono[ 'msj' ] : '' ).'",';
            $html .= 'msg:"'.( ( isset( $icono[ 'msj' ] ) ) ? $icono[ 'msj' ] : '' ).'",';
            $html .= 'cursor:"pointer"';
            $html .= '})';
        }
        return $html;
    }

}

