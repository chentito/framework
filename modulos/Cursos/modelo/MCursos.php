<?php
/*
 * Modelo para el funcionamiento de cursos
 * 
 * @Framework Mexagon
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Agosto 2017
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Datos/DataTable.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
include_once _DIRPATH_ . '/sistema/Librerias/Mail/Mail.php';
include_once _DIRPATH_ . '/sistema/Registros/Acciones.php';

class MCursos {

    /*
     * Interaccion con base de datos
     */
    protected $dbConn = null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbConn = new classConMySQL();
    }

    /*
     * Metodo que guarda la informacion del curso
     */
    public function guardaRegistroCurso( $datos ) {        
        $sql = " INSERT INTO `cur_altaCursos` ( `nombreCurso` , `descripcionCurso` , `costoCurso` , `datosBancariosBanco` , 
                `datosBancariosTitular` , `datosBancariosConvenioCIE` , `datosBancariosCuenta` , `datosBancariosCLABE` , `fechaInicioCurso` , `fechaFinCurso` , 
                `fechaPublicacionCurso` , `status` )
                VALUES (  '".utf8_decode($datos[ 'registro_altaCursos_nombreCurso' ])."', '".utf8_decode($datos[ 'registro_altaCursos_descripcionCurso' ])."', '".$datos[ 'registro_altaCursos_costoCurso' ]."', '".utf8_decode($datos[ 'registro_altaCursos_datosBancarios_banco' ])."', 
                '".utf8_decode($datos[ 'registro_altaCursos_datosBancarios_titular' ])."', '".$datos[ 'registro_altaCursos_datosBancarios_convenioCIE' ]."', '".$datos[ 'registro_altaCursos_datosBancarios_Cuenta' ]."', '".$datos[ 'registro_altaCursos_datosBancarios_CLABE' ]."', 
                '".$datos[ 'registro_altaCursos_fechaInicioCurso' ]."', '".$datos[ 'registro_altaCursos_fechaFinCurso' ]."', '".date( 'Y-m-d' )."', '1' ); ";
        $rs = $this->dbConn->ejecutaComando( $sql );

        if( $rs ){
            return true;
        } else {
            return mysql_error();
        }
    }
    
    /*
     * Metodo para editar la informacion de un curso
     */
    public function editarRegistroCurso( $datos ){
        $sql = " UPDATE cur_altaCursos SET nombreCurso = '".utf8_decode($datos[ 'editarCursos_nomCurso' ])."', descripcionCurso = '".utf8_decode($datos[ 'editarCursos_descCurso' ])."', ";
        $sql .= " costoCurso = '".$datos[ 'editarCursos_cosCurso' ]."', datosBancariosBanco = '".utf8_decode($datos[ 'editarCursos_banco' ])."', ";
        $sql .= " datosBancariosTitular = '".utf8_decode($datos[ 'editarCursos_titular' ])."', datosBancariosConvenioCIE = '".$datos[ 'editarCursos_convenioCIE' ]."', ";
        $sql .= " datosBancariosCuenta = '".$datos[ 'editarCursos_cuenta' ]."', datosBancariosCLABE = '".$datos[ 'editarCursos_CLABE' ]."', ";
        $sql .= " fechaInicioCurso = '".$datos[ 'editarCursos_fInicioCurso' ]."', fechaFinCurso = '".$datos[ 'editarCursos_fFinCurso' ]."' ";
        $sql .= " WHERE id = '".$datos[ 'editarCursos_ID' ]."' ";
        $rs = $this->dbConn->ejecutaComando( $sql );

        if( $rs ){
            return true;
        } else {
            return mysql_error();
        }
    }
    
    /*
     * Metodo para borrar la informacion de un curso
     */
    public function borrarRegistroCurso($datos){
        $sql = " UPDATE cur_altaCursos SET status = '0' WHERE id = '".$datos[ 'idSelected' ]."' ";
        $rs = $this->dbConn->ejecutaComando( $sql );

        if( $rs ){
            return true;
        } else {
            return mysql_error();
        }
    }
    
    /*
     * Metodo para obtener listado de cursos
     */
    public function getCursosDisponibles(){
        //$nombreCamposJson = array("nombreCurso","descripcionCurso","costoCurso","fechaInicioCurso","fechaFinCurso","fechaPublicacionCurso","datosBancariosBanco","datosBancariosTitular","datosBancariosConvenioCIE","datosBancariosCuenta","datosBancariosCLABE","ID");
        //$nombreCamposBD = array("nombreCurso","descripcionCurso","costoCurso","fechaInicioCurso","fechaFinCurso","fechaPublicacionCurso","datosBancariosBanco","datosBancariosTitular","datosBancariosConvenioCIE","datosBancariosCuenta","datosBancariosCLABE","id");
        $nombres = $this->cursosDisponibles_columnasID();
        $sql = " SELECT * FROM cur_altaCursos WHERE status = '1' ";
        //$dataTable = new DataTable( $sql , $nombreCamposJson , $nombreCamposBD );
        $dataTable = new DataTable( $sql , $nombres );
        echo $dataTable->datosDataTable;
    }
    
    /*
     * Metodo que obtiene los ID de columnas para cursos disponibles
     */
    public function cursosDisponibles_columnasID(){
        $columnas = array("nombreCurso","descripcionCurso","costoCurso","fechaInicioCurso","fechaFinCurso","fechaPublicacionCurso","datosBancariosBanco","datosBancariosTitular","datosBancariosConvenioCIE","datosBancariosCuenta","datosBancariosCLABE","id");
                
        return $columnas;
    }
    
    /*
     * Metodo que obtiene nombre HTML de las columnas para cursos disponibles
     */
    public function cursosDisponibles_columnasHTML(){
        $columnas = array("Nombre Curso","Descripci&oacute;n Curso","Costo","Fecha Inicio","Fecha Fin","Fecha Publicaci&oacute;n","Banco","Titular","ConvenioCIE","Cuenta","CLABE","ID");
                
        return $columnas;
    }
    
    /*
     * Metodo que obtiene la posicion de las columnas a ocultar para cursos disponibles
     */
    public function cursosDisponibles_columnasHidden(){
        $columnas = array("7","8","9","10","11","12");
                
        return $columnas;
    }
    
}
