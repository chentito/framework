<?php
/*
 * Clase que contiene todos los metodos para exportar la informacion mostrada en los grids,
 * tanto en formato excel como en pdf
 * 
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){ die( "No se permite el acceso directo a este archivo" ); }

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/Excel.php';
include_once _DIRPATH_ . '/sistema/Datos/PDF.php';

/*
 * Funcionalidades del modulo
 */
include_once _DIRPATH_ . '/modulos/Utiles/modelo/MUtiles.php';

class Utiles {

    /*
     * Atrributo que contiene la instancia al modelo de la clase
     */
    private $modelo = null;
    
    /*
     * Constructror de la clase
     */
    public function __construct() {
        $this->modelo = new MUtiles();
    }

    /*
     * Metodo que invoca al reporte en formato excel
     */
    public function generaExcel() {
        $excel = new Excel();
        $excel->generaReporte();
    }

    /*
     * Metodo que invoca al reporte en formato excel
     */
    public function generaExcelInventarioCompleto() {
        $sql = " SELECT sku, fechaIngreso, serie, nombre, marca, costo, moneda, unidadMedida, color, peso, unidadPeso, ancho, largo, alto,talla, sabor, "
             . " descripcion, cantidad, responsable, cliente, rack, posicionRack, almacenamiento, estado, fechaAsignacion, fechaEntrega, fechaDevolucion, "
             . " fechaReactivacion, modelo, capacidad, almacen, resurtido, delivery, consigna, imei FROM `inv_item` WHERE status=1 ";
        $excel = new Excel( $sql );
        $excel->generaReporte();
    }

    /*
     * Metodo que invoca al reporte en formato pdf
     */
    public function generaPDF() {
        
    }

    /*
     * Metodo que genera la estructura html de un combo con la informacion de clientes
     */
    public function generaComboDinamico( $input , $consulta ) {
        return $this->modelo->generaComboDinamico( $input , $consulta );
    }
    
    /*
     * Metodo que genera combo para grid con el listado de magnitudes disponibles
     * para las unidades de medicion
     */
    public function generaComboDinamicoGrid( $consulta ) {
        return $this->modelo->generaComboDinamicoGrid( $consulta );
    }

    /****************************************
     * 
     *            FUNCIONALIDAD SEPOMEX
     * 
     ****************************************/
    
    /*
     * Metodo que realiza una busqueda de todos los elementos relacionados a un
     * CP en particular
     */
    public function sepomexDatosCP(){
        $cp = $_POST['cp'];
        echo json_encode( $this->modelo->sepomexDatosCP( $cp ) );
    }

    /*
     * Metodo que regresa elementos html desde lo encontrado en la base de datos de sepomex
     */
    public function elementosDesdeSepomex( $cp ){
        return $this->modelo->elementosSepomex( $cp );
    }

}
