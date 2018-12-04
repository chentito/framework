<?php
/*
 * Modelo de la funcionalidad de dashboard (graficas)
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/DataGrafica.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';

class MDashboard {
    
    /*
     * Interaccion con base de datos
     */
    protected $dbConn = null;
    
    /*
     * Atributo que contiene la instancia de la conexion a la base de datos
     */
    protected $datosG =  null;

    /*
     * Constructor de la clase
     */
    public function __construct() {
        $this->dbConn = new classConMySQL();
        new Sesion();
    }

    /*
     * Metodo que obtiene series para una grafica de pie a partir de una
     * consulta SQL
     */
    public function seriesGraficaPieAdmin2() {
        $sql  = " SELECT l.clave AS muestra1, SUM(i.cantidad) AS Total,ROUND(( SUM(i.cantidad) / t.total * 100),2) AS muestra2 FROM inv_item AS i, inv_almacenes as l, ";
        $sql .= " (SELECT SUM(cantidad) AS total FROM inv_item WHERE status=1) AS t WHERE i.status=1 AND i.almacen=l.id GROUP BY i.almacen ";
        $this->datosG = new DataGrafica( $sql , 'pie' );
        return $this->datosG->datosSeriesGraficaPastel();
    }

    public function clientesPorMes() {
        $sql  = " SELECT COUNT( * ) AS muestra2 , CONCAT( SUBSTR(r.alta,1,7) , ' (' , COUNT( * ) , ')' ) AS muestra1 ";
        $sql .= " FROM reg_altaRegistro AS r LEFT JOIN reg_validacionSolicitud AS v ON v.idSolicitud=r.id WHERE ";
        $sql .= " v.validacion=1 AND r.status=1 GROUP BY SUBSTR(r.alta,1,7) ";
        $sql .= " ORDER BY SUBSTR(alta,1,10) DESC LIMIT 3 ";
        $this->datosG = new DataGrafica( $sql , 'pie' );
        return $this->datosG->datosSeriesGraficaPastel();
    }
    
    public function proceso() {
        $perfil  = $_SESSION[ 'perfil' ];
        $usuario = $_SESSION[ 'idUsuario' ];
        $avance  = 0;

        if( $perfil == '2' ) {
            // Paso 1
            $sql1 = " SELECT COUNT( * ) AS t FROM reg_altaRegistro WHERE usuario='".$usuario."' AND status=1 ";
            $rs1  = $this->dbConn->ejecutaComando( $sql1 );
            $avance = $avance + ( ( $rs1->fields[ 't' ] >= 1 ) ? 25 : 0 );

            // Paso 2
            $sql21 = " SELECT COUNT( * ) AS t FROM reg_datosContrato WHERE idSolicitud=( SELECT id FROM reg_altaRegistro WHERE usuario='".$usuario."' AND status=1  ) ";
            $rs21  = $this->dbConn->ejecutaComando( $sql21 );
            $paso21 = $rs21->fields[ 't' ];
            $sql22 = " SELECT COUNT( * ) AS t FROM reg_datosContrato WHERE idSolicitud=( SELECT id FROM reg_altaRegistro WHERE usuario='".$usuario."' AND status=1  ) ";
            $rs22  = $this->dbConn->ejecutaComando( $sql22 );
            $paso22 = $rs22->fields[ 't' ];
            $sql23 = " SELECT COUNT( * ) AS t FROM reg_datosContrato WHERE idSolicitud=( SELECT id FROM reg_altaRegistro WHERE usuario='".$usuario."' AND status=1  ) ";
            $rs23  = $this->dbConn->ejecutaComando( $sql23 );
            $paso23 = $rs23->fields[ 't' ];
            $totP2 = $paso21 + $paso22 + $paso23;
            $avance = $avance + ( ( $totP2 == 3 ) ? 25 : 0 );
            
            // Paso 3
            $sql3 = " SELECT COUNT( * ) AS t FROM reg_digitalizados WHERE idRegistro=( SELECT id FROM reg_altaRegistro WHERE usuario='".$usuario."' AND status=1 ) ";
            $rs3  = $this->dbConn->ejecutaComando( $sql3 );
            $avance = $avance + ( ( $rs3->fields[ 't' ] >= 1 ) ? 25 : 0 );
            
            // Paso 4
            $sql4 = " SELECT COUNT( * ) AS t FROM reg_digitalizados_certificado WHERE isSolicitud=( SELECT id FROM reg_altaRegistro WHERE usuario='".$usuario."' AND status=1 ) ";
            $rs4  = $this->dbConn->ejecutaComando( $sql4 );
            $avance = $avance + ( ( $rs4->fields[ 't' ] >= 1 ) ? 25 : 0 );
        }

        return $avance;
    }

}




