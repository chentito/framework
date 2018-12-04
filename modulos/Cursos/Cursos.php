<?php
/**
 * Controlador del modulo de cursos
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Agosto 2017
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Interfaz/Template.php';
include_once _DIRPATH_ . '/sistema/Interfaz/JQDataTable.php';
include_once _DIRPATH_ . '/sistema/Interfaz/MenuXML.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';

/*
 * Funcionalidades del Modulo
 */
include_once _DIRPATH_ . '/modulos/Cursos/modelo/MCursos.php';

class Cursos extends Template {
    
    var $modelo = null;
    
    /*
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->modelo = new MCursos();
    }

    /*
     * Alta de un curso
     */
    public function altaCursos() {
        $this->muestraDato( 'scripts'    , array( '/vistas/Cursos/js/altaCursos.js' ) );
        $this->muestraDato( 'estilos'    , array( '/vistas/Cursos/css/altaCursos.css' ) );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Cursos' ,  'Alta de Cursos' ) );
        $this->muestraDato( 'cierraL'    , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }
    
    /*
     * Guardar un curso
     */
    public function guardaCurso() {
        $this->modelo->guardaRegistroCurso( $_POST );
    }
    
    /*
     * Editar un curso
     */
    public function editaCurso() {
        $this->modelo->editarRegistroCurso( $_POST );        
    }
    
    /*
     * Borrar un curso
     */
    public function borraCurso() {
        $this->modelo->borrarRegistroCurso( $_POST );        
    }

    /*
     * Cursos Disponibles
     */
    public function cursosDisponibles(){
        $columnasID = $this->modelo->cursosDisponibles_columnasID();        
        $columnasHTML = $this->modelo->cursosDisponibles_columnasHTML();        
        $columnasHidden = $this->modelo->cursosDisponibles_columnasHidden();
        $paths = array( 'ajax' => '/Cursos/getInformacionCursos/' );
        $selectRow = true;
        $detailControl = true;
        $editForm = true;
        $viewForm = false;
        $botones = array("copiar" => true, "csv" => true, "excel" => true, "pdf" => true, "imprimir" => true, "eliminar" => true);
        $botonesPers     = array();
        $jsAfterEditForm = '$("#editarCursos_btnGuardar").button(); $("#editarCursos_fInicioCurso").datepicker({minDate: new Date(),dateFormat:"yy-mm-dd",monthNames: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct", "Nov","Dic"],dayNamesMin: ["D","L","M","M","J","V","S"]}); $("#editarCursos_fFinCurso").datepicker({minDate: new Date(),dateFormat:"yy-mm-dd",monthNames: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct", "Nov","Dic"],dayNamesMin: ["D","L","M","M","J","V","S"]});';
        $dataTable = new JQDataTable( "tableCursosDisponibles", "registro_cursosDisponibles_form", "CURSOS DISPONIBLES", $columnasID, $columnasHTML, $columnasHidden, $paths, $selectRow, $detailControl, $editForm, $viewForm, $jsAfterEditForm, $botones, $botonesPers );
        $this->muestraDato( 'scripts' , array("/vistas/Cursos/js/cursosDisponibles.js") );        
        $this->muestraDato( 'estilos' , array( '/vistas/Cursos/css/cursosDisponibles.css' ) );        
        $this->muestraDato( 'contenidoSeccion' , $dataTable->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Cursos' ,  'Cursos Disponibles' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }
 
    /*
     * Obtiene listado de cursos
     */
    public function getInformacionCursos(){
        $this->modelo->getCursosDisponibles();
    }
    
}