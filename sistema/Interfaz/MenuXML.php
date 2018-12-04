<?php
/*
 * Clase que genera la estructura XML del menu dentro de jqgrid tree
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este arcchivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Privilegios.php';

class MenuXML {
    
    /*
     * Contendra la instancia de conexion a BD
     */
    protected $dbConn = null;
    
    /*
     * Contructor de la clase
     */
    public function __construct() {
	new Sesion();
        $this->dbCon = new classConMySQL();
    }

    /*
     * Rutina que genera la estructura XML
     */
    public function xml(){
        $sql = " SELECT * FROM sis_menu WHERE status=1 ORDER BY peso ASC, seccion ASC, orden ASC";
        $rs = $this->dbCon->ejecutaComando( $sql );

        /* Se inicia la estructura XML */
        $xml = new DOMDocument("1.0","UTF-8");
        $menu = $xml->createElement("rows");
        $xml->appendChild($menu);
        $page = $xml->createElement("page","1");
        $menu->appendChild($page);
        $total = $xml->createElement("total","1");
        $menu->appendChild($total);
        $records = $xml->createElement("records","1");
        $menu->appendChild($records);

	$grupoAcceso = (isset($_SESSION["perfil"])) ? $_SESSION["perfil"] : "0" ;
        $privilegios = new Privilegios();
        $secciones   = $privilegios->verificaPrivilegioMenuAcceso($grupoAcceso);

        while( !$rs->EOF ){
	    if( in_array( $rs->fields["id"] , $secciones ) ){

	    //antes de mostrar elemento menu verificamos si tiene hijos con privilegios
            if($grupoAcceso != "0"){
                    $sqlHijosSubsecciones = " SELECT * FROM sis_menu WHERE status = '1' AND seccion = '".$rs->fields["seccion"]."' AND nivel > '0'  AND rangoInicial >= '".$rs->fields["rangoInicial"]."' AND rangoFinal <= '".$rs->fields["rangoFinal"]."' ";
                    $rsHijosSubsecciones = $this->dbCon->ejecutaComando( $sqlHijosSubsecciones );
                    $banderaMostrar = false;
                    while($rsHijosSubsecciones && !$rsHijosSubsecciones->EOF){
                        if($rsHijosSubsecciones->fields["tipo"] == 1){
                            //el hijo seleccionado es padre de mas hijos, entonces realizamos query para ver si tiene hijos
                            $sqlHijosSubSeccionHijos = " SELECT * FROM sis_menu WHERE status = '1' AND seccion = '".$rs->fields["seccion"]."' AND nivel = '2' AND rangoInicial >= '".$rsHijosSubsecciones->fields["rangoInicial"]."' AND rangoFinal <= '".$rsHijosSubsecciones->fields["rangoFinal"]."' ";
                            $rsHijosSubSeccionHijos = $this->dbCon->ejecutaComando( $sqlHijosSubSeccionHijos );
                            while($rsHijosSubSeccionHijos && !$rsHijosSubSeccionHijos->EOF){
                                $privilegioSubSeccionHijos = $privilegios->verificaPrivilegio($rsHijosSubSeccionHijos->fields["id"],$grupoAcceso);
                                if($privilegioSubSeccionHijos) {$banderaMostrar = true;}
                                $rsHijosSubSeccionHijos->MoveNext();
                            }
                        }else{
                            //el hijo seleccionado no es padre
                            $privilegioSubSeccion = $privilegios->verificaPrivilegio($rsHijosSubsecciones->fields["id"],$grupoAcceso);
                            if($privilegioSubSeccion) {$banderaMostrar = true;}
                            //else $banderaMostrar = false;
                        }
                        $rsHijosSubsecciones->MoveNext();
                    }
            }else{ //fin if grupoAcceso != 0
                    $banderaMostrar = true;
            }
            //fin antes de mostrar elemento menu verificamos si tiene hijos con privilegios

	    if($banderaMostrar == true){
            /* Se genera el nodo principal por cada elemento del menu */
            $seccion = $xml->createElement( "row" );
            $menu->appendChild( $seccion );
            /* Identificador del nodo */
            $idty = $xml->createElement( "cell" , $rs->fields["rangoInicial"] );
            $seccion->appendChild( $idty );
            /* Nombre de la seccion */
            $nombre = $xml->createElement( "cell" , $rs->fields["nombre"] );
            $seccion->appendChild($nombre);
            /* Ruta de la seccion */
            if( strlen( $rs->fields["ruta"] ) > 0 ){$ruta = $xml->createElement( "cell" , $rs->fields["ruta"] );}
            else {$ruta = $xml->createElement( "cell" );}
            $seccion->appendChild($ruta);
            /* Nivel */
            $nivel = $xml->createElement( "cell" , $rs->fields["nivel"] );
            $seccion->appendChild($nivel);
            /* Rango Inicial */
            $rInicial = $xml->createElement( "cell" , $rs->fields["rangoInicial"] );
            $seccion->appendChild($rInicial);
            /* Rango Final */
            $rFinal = $xml->createElement( "cell" , $rs->fields["rangoFinal"] );
            $seccion->appendChild($rFinal);
            if( $rs->fields["tipo"] == 1 ){
                /* Identificador para nodos padres */
                $b1 = "false";
                $b2 = "false";
            }elseif( $rs->fields["tipo"] == 2 ){
                /* Identificador para nodos hijos */
                $b1 = "true";
                $b2 = "true";
            }
            /* bandera 1 */
            $bandera1 = $xml->createElement( "cell" , $b1 );
            $seccion->appendChild( $bandera1 );
            /* bandera 2 */
            $bandera2 = $xml->createElement( "cell" , $b2 );
            $seccion->appendChild( $bandera2 );
	    } //fin if bandera mostrar
            }// fin if in_array
            $rs->MoveNext();
        }

        return $xml->saveXML();
    }
 

}
