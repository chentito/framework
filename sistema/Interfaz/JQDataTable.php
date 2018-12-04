<?php
/*
 * Clase que contiene la estructura de jquery DataTable de consulta
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Agosto 2017
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

class JQDataTable {

    /*
     * Variable que almacena el nombre del DataTable
     */
    private $nombreDataTable = '';
    
    /*
     * Variable que almacena el id del form que contiene DataTable
     */
    private $nombreFormDataTable = '';
            
    /*
     * Arreglo de paths donde se hara la consulta de datos en el DataTable
     */
    private $paths = array();

    /*
     * Arreglo que almacena la estructura de columnasHTML a mostrarse dentro del DataTable
     */
    private $columnasHTML = array();
    
    /*
     * Arreglo que almacena la estructura de columnasID a mostrarse dentro del DataTable
     */
    private $columnasID = array();
    
    /*
     * Arreglo que almacena la estructura de columnas que estaran ocultas dentro del DataTable
     */
    private $columnasHidden = array();

    /*
     * Variable que contiene la estructura completa del DataTable
     */
    public $html = '';
    
    /*
     * Variable que almacena una bandera para saber si el evento select row tendra alguna accion
     */
    public $selectRow = false;
    
    /*
     * Variable que almacena una bandera para saber si el DataTable llevara columna detalle registro
     */
    private $detailControl = false;
    
    /*
     * Variable que almacena una bandera para saber si se llamara funcion para edit form
     */
    private $editForm = false;
    
    /*
     * Variable que almacena una bandera para saber si se llamara funcion para view form
     */
    private $viewForm = false;
    
    /*
     * Variable que almacena codigo javascript a ejecutar despues de mostrar edit form
     */
    private $jsAfterEditForm = false;
    
    /*
     * Variable que almacena titulo DataTable
     */
    private $titulo = '';
    
    /*
     * Variable arreglo con botones a mostrar
     */
    private $botones = array( "copiar" => false, "csv" => false, "excel" => false, "pdf" => false, "imprimir" => false, "eliminar" => false );
    
    /*
     * Variable arreglo con botones personalizados a mostrar
     */
    private $botonesPers = array();
    
    /*
     * Constructor de la clase
     * $nombre: es el nombre del DataTable
     * $columnas: es la estructrura de los datos y columnas que se mostraran en el DataTable
     * $paths: es la ruta para ejecutar la consulta de datos en el DataTable
     *         por ejemplo, ruta para editar $paths[edita]='../../Sistema/...'
     */
    public function __construct( $nombre , $nombreForm , $titulo , $columnasID=array(), $columnasHTML=array(), $columnasHidden=array(), $paths=array() , $selectRow=false, $detailControl=false, $editForm=false, $viewForm=false, $jsAfterEditForm="", $botones=array(), $botonesPers=array() ) {
        $this->nombreDataTable              = $nombre;
        $this->nombreFormDataTable          = $nombreForm;        
        $this->paths                        = $paths;
        $this->columnasID                   = $columnasID;
        $this->columnasHTML                 = $columnasHTML;
        $this->selectRow                    = $selectRow;
        $this->detailControl                = $detailControl;
        $this->columnasHidden               = $columnasHidden;
        $this->editForm                     = $editForm;
        $this->viewForm                     = $viewForm;
        $this->jsAfterEditForm              = $jsAfterEditForm;
        $this->titulo                       = $titulo;
        $this->botones                      = $botones;
        $this->botonesPers                  = $botonesPers;
        $this->armaDataTable( $titulo );
    }

    /*
     * Metodo que genera la estructura completa para el despliegue del DataTable: javascript
     * y html, con la configuracion correspondiente
     */
    private function armaDataTable( $titulo ){
        
        $html  = '<script>';
        $html .= $this->dataTable();        
        $html .= '';
        $html .= '</script>';
        $html .= $this->contenedor($titulo);
                        
        $this->html = $html;
    }

    /*
     * Metodo que contiene la estructura del DataTable
     */
    private function dataTable() {
        $i = 1;
        $j = 1;
                                
        $html  = '$(document).ready( function () {';
        //Mostramos boton eliminar registro DataTable
        /*if($this->nombreBotonEliminarDataTable != ""){
            $html .= '$("#'.$this->nombreBotonEliminarDataTable.'").button();';
        }*/
        //Mostramos boton eliminar registro DataTable

        //Mostramos estructura DataTable
        $html .= 'var table = $("#'.$this->nombreDataTable.'").DataTable( {';
        $html .= '"pageLength": 10,';
        $html .= '"language": {';
        $html .= '"emptyTable": "No hay datos disponibles en la tabla",';
        $html .= '"lengthMenu": "Mostrando _MENU_ registros por p&aacute;gina",';
        $html .= '"zeroRecords": "Registros no encontrados - disculpe",';
        $html .= '"info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",';
        $html .= '"infoEmpty": "No hay registros disponibles",';
        $html .= '"infoFiltered": "(filtrando de _MAX_ registros totales)",';
        $html .= '"loadingRecords": "Cargando...",';
        $html .= '"processing":     "Procesando...",';
        $html .= '"search":         "Buscar:",';
        $html .= '"paginate": {';
        $html .= '"first":      "Primera",';
        $html .= '"last":       "Ultima",';
        $html .= '"next":       "Siguiente",';
        $html .= '"previous":   "Anterior"';
        $html .= '}';
        $html .= '},';
        $html .= '"processing": true,';
        $html .= '"serverSide": false,';
        $html .= '"ajax": "'.$this->paths["ajax"].'",';
        
        if( count($this->botones) > 0 ){
            $html .= 'dom: "Bfrtip",';
            $html .= 'buttons: [';
            //Boton copiar
            if($this->botones["copiar"]){
                $html .= '{';
                $html .= 'extend: "copy",';
                $html .= 'text: "Copiar",';
                $html .= 'title: "'.$this->titulo.'"';
                $html .= '},';
            }
            //Boton csv
            if($this->botones["csv"]){
                $html .= '{';
                $html .= 'extend: "csv",';
                $html .= 'text: "CSV",';
                $html .= 'title: "'.$this->titulo.'"';
                $html .= '},';
            }
            //Boton Excel
            if($this->botones["excel"]){
                $html .= '{';
                $html .= 'extend: "excel",';
                $html .= 'text: "EXCEL",';
                $html .= 'title: "'.$this->titulo.'"';
                $html .= '},';
            }
            //Boton PDF
            if($this->botones["pdf"]){
                $html .= '{';
                $html .= 'extend: "pdf",';
                $html .= 'text: "PDF",';
                $html .= 'title: "'.$this->titulo.'",';
                $html .= 'orientation: "landscape"';
                $html .= '},';
            }
            //Boton print
            if($this->botones["imprimir"]){
                $html .= '{';
                $html .= 'extend: "print",';
                $html .= 'text: "Imprimir",';
                $html .= 'title: "'.$this->titulo.'"';                
                $html .= '},';
            }
            //Boton eliminar personalizado
            if($this->botones["eliminar"]){
                $html .= '{';                
                $html .=  'text: "Eliminar",';
                $html .= 'action: function ( e, dt, node, config ) {';
                
                //Mostramos dialog modal confirm
                $html .= '$( \'body\' ).append( \'<div title="'.$this->titulo.'" id="dialog-confirm">Esta seguro que desea eliminar el registro?</div>\' );';
                $html .= '$( "#dialog-confirm" ).dialog({';
                $html .= 'resizable: false,';
                $html .= 'height: "auto",';
                $html .= 'width: 400,';
                $html .= 'modal: true,';
                $html .= 'buttons: {';
                $html .= '"Aceptar": function() {';
                //Borramos registro
                $html .= 'var row_selected = table.row(".selected").data();';
                $html .= 'var idSelected = row_selected.id;';
                $html .= '$.ajaxSetup({async:false});';
                $html .= '$.post( "../../Cursos/borraCurso/" , { idSelected:idSelected }, function( d ) {';
                $html .= 'if(d == ""){';
                $html .= 'dialogoAviso("Borrar Cursos", "<p>Informaci&oacute;n borrada exitosamente</p>");';
                $html .= 'table.row(".selected").remove().draw( false );';
                $html .= '}else{';
                $html .= 'dialogoAviso("Borrar Cursos", "<p>Ocurrio un error al borrar la informaci&oacute;n, por favor intente nuevamente:</p>");';
                $html .= '}';
                $html .= '});';
                $html .= '$( this ).dialog( "close" );';
                //Borramos registro
                $html .= '},';
                $html .= 'Cancel: function() {';
                $html .= '$( this ).dialog( "close" );';
                $html .= '}';
                $html .= '}';
                $html .= '});';
                //Mostramos dialog modal confirm                                           
                $html .= 'return false;';
                
                $html .= '}';
                $html .= '},';
            }
            
            //Botones personalizados
            if( count($this->botonesPers) > 0 ){
                foreach ($this->botonesPers as $k => $v) {
                    if($this->botonesPers[$k]){
                        $html .= '{';
                        $html .=  'text: "'.$k.'",';
                        $html .= 'action: function ( e, dt, node, config ) {';                                                
                        $html .= $k.'( e, dt, node, config );';
                        $html .= 'return false;';
                        $html .= '}';
                        $html .= '},';
                    }
                }
            }
            //Botones personalizados
                        
            $html .= '],';
        }        
        //Mostramos estructura DataTable
        
        //Mostramos columnas DataTable
        $html .= '"columns": [';
        if($this->detailControl){
            $html .= '{';
            $html .= '"className":      "details-control",';
            $html .= '"orderable":      false,';
            $html .= '"data":           null,';
            $html .= '"defaultContent": ""';
            $html .= '},';
        }
        foreach($this->columnasID as $idColumna){
            $html .= '{ "data": "'.$idColumna.'" }';
            if($i != count($this->columnasID)){ $html .= ','; }
            $i ++;
        }
        $html .= ']';
        //Mostramos columnas DataTable
        
        //Mostramos columnas ocultas DataTable
        if( count($this->columnasHidden) > 0 ){
            $html .= ',"columnDefs": [';
            foreach($this->columnasHidden as $columnasHide){
                $html .= '{';
                $html .= '"targets": [ '.$columnasHide.' ],';
                $html .= '"visible": false';
                $html .= '}';
                if($j != count($this->columnasHidden)){ $html .= ','; }
                $j ++;
            }
            $html .= ']';
        }
        //Mostramos columnas ocultas DataTable
                        
        $html .= '} );';
                
        //Mostramos detalle registro
        if($this->detailControl){
            $html .= '$("#'.$this->nombreDataTable.' tbody").on("click", "td.details-control", function () {';
            $html .= 'var tr = $(this).closest("tr");';
            $html .= 'var row = table.row( tr );';
            $html .= 'if ( row.child.isShown() ) {';
            $html .= 'row.child.hide();';
            $html .= 'tr.removeClass("shown");';
            $html .= '}else{';
            if($this->editForm){
                $html .= 'row.child( formEdit(row.data()) ).show();';
            }
            if($this->viewForm){
                $html .= 'row.child( formView(row.data()) ).show();';
            }
            $html .= 'tr.addClass("shown");';
            if($this->jsAfterEditForm != ""){
                $html .= $this->jsAfterEditForm;
            }            
            $html .= '}';
            $html .= '} );';
        }
        
        if($this->selectRow){
            /* Seleccionar fila */
            $html .= '$("#'.$this->nombreDataTable.' tbody").on( "click", "tr", function () {';
            $html .= 'if ( $(this).hasClass("selected") ) {';
            $html .= '$(this).removeClass("selected");';
            $html .= '}else{';
            $html .= 'table.$("tr.selected").removeClass("selected");';
            $html .= '$(this).addClass("selected");';
            $html .= '}';
            $html .= '} );';
        }
                    
        $html .= '} );';
        
        
        
        
        
        return $html;
    }    
    
    /*
     * Crea el contenedor html donde se cargara el grid
     */
    private function contenedor($titulo){
        $html  = '<form id="'.$this->nombreFormDataTable.'" name="'.$this->nombreFormDataTable.'">';
        $html .= '<fieldset class="ui-widget ui-widget-content">';
        $html .= '<legend><b>'.$titulo.'</b></legend>';
        /*if($this->nombreBotonEliminarDataTable != ""){
            $html .= '<center><button id="'.$this->nombreBotonEliminarDataTable.'" name="'.$this->nombreBotonEliminarDataTable.'">Eliminar</button></center>';
        }*/
        $html .= '<br />';
        $html .= $this->armaTablaHTML();        
        $html .= '</fieldset>';
        $html .= '<br />';
        $html .= '</form>';                
        
        return $html;
    }    
    
    /*
     * Crea la tabla HTML para DataTable
     */
    private function armaTablaHTML(){
        $html  = '<table id="'.$this->nombreDataTable.'" class="display" width="100%">';
        $html .= '<thead>';
        $html .= '<tr>';
        if($this->detailControl){ $html .= '<th></th>'; }
        foreach ($this->columnasHTML as $htmlColumna) {
            $html .= '<th>'.$htmlColumna.'</th>';
        }        
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $html .= '</tbody>';
        $html .= '</table>';
        
        return $html;
    }
 
} // Fin clase