<?php
/*
 * Modelo para el funcionamiento del modulo sistema, para la configuracion del mismo
 * asi como para la asignacion de privilegios y de nuevos usuarios de acceso
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015
 */
if( !defined( "_FRMWORMEXAGON_" ) ){die("No se permite el acceso directo a este archivo");}

/*
 * Funcionalidades del Sistema
 */
include_once _DIRPATH_ . '/sistema/Datos/classConMySQL.php';
include_once _DIRPATH_ . '/sistema/Datos/DataGrid.php';
include_once _DIRPATH_ . '/sistema/Autenticacion/Sesion.php';
include_once _DIRPATH_ . '/sistema/Librerias/Mail/Mail.php';
include_once _DIRPATH_ . '/sistema/Registros/Acciones.php';

class MSistema {

    /*
     * Atributo que contiene la instancia de la base de datos
     */
    protected $dbCon = null;

    public function __construct(){
        new Sesion();
        $this->dbCon = new classConMySQL();
    }

    /*
     * Metodo que obtiene el listado de accesos al sistema
     */
    public function accesos_Datos(){
        $columnas = array(
            'Usuario'       => array('name'=>'usuario','index'=>'usuario','width'=>90,'align'=>'center','editable'=>false,'editrules'=>'{required:true}'),
            'Navegador'     => array('name'=>'navegador','index'=>'navegador','width'=>330,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Ip'            => array('name'=>'ip','index'=>'ip','width'=>80,'align'=>'center','editable'=>false,'editrules'=>'{required:true}'),
            'Fecha Entrada' => array('name'=>'fechaEntrada','index'=>'fechaEntrada','width'=>100,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'Fecha Salida'  => array('name'=>'fechaSalida','index'=>'fechaSalida','width'=>100,'align'=>'center','editable'=>false,'editrules'=>'{required:true}' ),
            'ID Proceso'    => array('name'=>'procid','index'=>'procid','width'=>60,'align'=>'center','editable'=>false,'editrules'=>'{required:true}')
        );

        return $columnas;
    }

    /*
     * Metodo que obtiene el listado de usuarios del sistema
     */
    public function usuarios_Datos(){
        $columnas = array(
            'Nombre' => array('name'=>'nombre','index'=>'nombre','width'=>210,'align'=>'center','editable'=>true,'editrules'=>'{required:true}'),
            'Usuario' => array('name'=>'usuario','index'=>'usuario','width'=>130,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Password' => array('name'=>'contrasena','index'=>'contrasena','width'=>60,'align'=>'center','editable'=>true,'editrules'=>'{required:false}','editoptions'=>'{defaultValue:""}'),
            'Email' => array('name'=>'email','index'=>'email','width'=>160,'align'=>'center','editable'=>true,'editrules'=>'{required:true,custom:true,custom_func:validaEmail}' ),
            //'Edad' => array('name'=>'edad','index'=>'edad','width'=>30,'align'=>'center','editable'=>true,'editrules'=>'{required:true}' ),
            'Perfil' => array('name'=>'perfil','index'=>'perfil','width'=>110,'align'=>'center','editable'=>true,'editrules'=>'{required:true}','editrules'=>'{required:true}','editoptions'=>'{value:"'.$this->selectPerfiles().'"}','edittype'=>'select'),
            'Opciones' => array( 'name'=>'opt','index'=>'opt','width'=>50,'align'=>'center' , 'sortable'=>false ),
            'Status' => array('name'=>'status','index'=>'status','width'=>40,'align'=>'center','editable'=>true,'editrules'=>'{required:true}','editoptions'=>'{value:"1:Activo;0:Inactivo"}','edittype'=>'select')
        );

        return $columnas;
    }


    /*
     * Metodo para generar select perfiles para grid usuarios
     */

    function selectPerfiles(){
        $sql = " SELECT id, nombrePerfil FROM sis_perfiles WHERE status = '1' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rsDatos  = $this->dbCon->ejecutaComando( $sql );
        $texto = ":-- Seleccione una opcion --;";
        while (!$rsDatos->EOF){
            $texto .= $rsDatos->fields['id'].":".$rsDatos->fields['nombrePerfil'].";";
            $rsDatos->MoveNext();
        }
	$texto .= "";
	return rtrim($texto,";");
    }


    /*
     * Metodo que hace la consulta al listado de accesos al sistema
     */
    public function datosGridListadoAccesos(){
        $sql = " SELECT id, usuario, navegador, ip, fechaEntrada, fechaSalida, procid FROM sis_accesos WHERE 1 ";
        $grid = new DataGrid( $sql );
        echo $grid->datosXML;
    }

    /*
     * Metodo que agrega las opciones adicionales en la configuracion del usuario
     */
    public function opcionesGridListadoUsuarios() {
        $html  = '<div style="display-inline">';
        $html .= '&nbsp;<span id="asignacionMarcasPorUsuario" name="asignacionMarcasPorUsuario" onclick="asignarMarcasPorUsuario()" class="ui-icon ui-icon-calculator" title="Ver Lote" style="cursor: pointer;display: inline-block"></span>';
        $html .= '</div>';
        return $html;
    }

    /*
     * Metodo que hace la consulta al listado de usuarios del sistema
     */
    public function datosGridListadoUsuarios(){
        //$sql = " SELECT id, nombre, usuario, contrasena, email, edad, perfil, status FROM sis_usuarios WHERE 1 ";
	$sql = " SELECT U.id, U.nombre, U.usuario, IF( U.contrasena <> '', '', U.contrasena ) AS contrasena, U.email, P.nombrePerfil, '".$this->opcionesGridListadoUsuarios()."' AS opt, IF(U.status=1,'Activo','Inactivo') AS status FROM sis_usuarios AS U, sis_perfiles as P WHERE U.perfil = P.id ";
        $grid = new DataGrid( $sql );
        echo $grid->datosXML;
    }

    /* Metodo que agrega un usuario */
    public function agregaUsuario() {
        $sql  = " INSERT INTO sis_usuarios(nombre, usuario, contrasena, email, edad, perfil, fechaAlta, status) ";
        $sql .= " VALUES( '".$_POST['nombre']."' , '".$_POST['usuario']."' , '".md5( $_POST['contrasena'] ) ."' , '".$_POST['email']."' , '0' , '".$_POST["perfil"]."' , '".date( 'Y-m-d H:i:s' )."' , '".$_POST['status']."' ) ";
        $rs   = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){ return true; }
        else{ return false; }
    }

    /* Metodo que edita un usuario */
    public function editaUsuario() {
	$strSQL = "";
        if($_POST['contrasena'] == ""){
            $strSQL .= "";
        }elseif($_POST['contrasena'] != ""){
            $strSQL .= "contrasena='".$_POST['contrasena']."',";
        }

        $sql  = " UPDATE sis_usuarios SET nombre='".$_POST['nombre']."', usuario='".$_POST['usuario']."', ".$strSQL;
        $sql .= " email='".$_POST['email']."',status='".$_POST['status']."', edad='".$_POST["edad"]."', perfil='".$_POST["perfil"]."' WHERE id='".$_POST['id']."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){ return true; }
        else{ return false; }
    }

    /* Metodo que elimina usuario */
    public function eliminaUsuario() {
        $sql = " UPDATE sis_usuarios SET status=3 WHERE id='".$_POST['id']."' ";
        $rsp = $this->dbCon->ejecutaComando($sql);

        if( $rsp ){ return true; }
        else{ return false; }
    }

    /*
     * Metodo que obtiene la configuracion previamente guardada de
     * la cuenta SMTP
     */
    public function getSMTP(){
        new Acciones( _ACCIONMUESTRASMTPCONF_ );
        $sql = " SELECT * FROM sis_mailing WHERE id='1' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
        foreach( $rs AS $campos ){
            $datos[] = $campos;
        }
        return $datos;
    }

    /*
     * Metodo que guarda la configuracion SMTP capturada
     * por el usuario
     */
    public function setSMTP( $params ){
        $sql = " UPDATE mailing SET  WHERE id='1' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        if( $rs ){
                return true;
            }else{
                return false;
        }
    }

    /*
     * Metodo que realiza el envio de pruebas de la cuenta SMTP
     */
    public function testSMTP( $params ){
        $envio = new Mail( 'Prueba de Envio' , $params['sistema_configSMTP_enviarPruebaA'] , 'envioPruebaSMTP' , $params );
        return $envio->estadoEnvio;
    }

    /*
     * Metodo que regresa el listado de privilegios disponibles dentro del sistema
     */
    public function privilegiosSistema(){
        $sql = " SELECT id,nombre FROM sis_menu WHERE nivel=0 AND status=1 ";
        $rs = $this->dbCon->ejecutaComando( $sql );
        $opciones = array();
        $tmp = array();

        while( !$rs->EOF ) {
            $sql2 = " SELECT id,nombre,nivel,tipo FROM sis_menu WHERE nivel<>0 AND status=1 ";
            $rs2  = $this->dbCon->ejecutaComando( $sql2 );


            while( !$rs2->EOF ) {

                $rs2->MoveNext();
            }

            $rs->MoveNext();
        }

    }

    /*
     * Metodo que regresa el listado de elementos del menu por nivel
     */
    public function getElementosMenu($nivel){
        new Acciones( _ACCIONMUESTRAPERFILES_ );
        $sql = " SELECT id, nombre, nivel, seccion, tipo FROM sis_menu WHERE status = '1' AND version = '1' AND nivel = '".$nivel."' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
        foreach( $rs AS $campos ){
            $datos[] = $campos;
        }
        return $datos;

    }

    /*
     * Metodo que regresa el listado de elementos menu por seccion
     */
    public function getElementosMenuSeccion($seccion){
        //new Acciones( _ACCIONMUESTRAPERFILES_ );
        $sql = " SELECT id, nombre, nivel, seccion, tipo, rangoInicial, rangoFinal FROM sis_menu WHERE status = '1' AND version = '1' AND seccion = '".$seccion."' AND nivel > '0' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
        foreach( $rs AS $campos ){
            $datos[] = $campos;
        }
        return $datos;

    }

    /*
     * Metodo que regresa el listado de elementos menu por seccion para nivel 2
     */
    public function getElementosMenuSeccionNivel2($seccion){
        //new Acciones( _ACCIONMUESTRAPERFILES_ );
        $sql = " SELECT id, nombre, nivel, seccion, tipo, rangoInicial, rangoFinal FROM sis_menu WHERE status = '1' AND version = '1' AND seccion = '".$seccion."' AND nivel = '2' AND tipo = '2' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
        foreach( $rs AS $campos ){
            $datos[] = $campos;
        }
        return $datos;

    }

    /*
     * Metodo que regresa el listado de elementos perfiles
     */
    public function getElementosPerfiles(){
        //new Acciones( _ACCIONMUESTRAPERFILES_ );
        $sql = " SELECT id, nombrePerfil, permisos FROM sis_perfiles WHERE status = '1' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $datos = array();
        foreach( $rs AS $campos ){
            $datos[] = $campos;
        }
        return $datos;

    }

    /*
     * Metodo que obtiene la informacion correspondiente para
     * el perfil seleccionado
     */
    public function getDatosPerfil($params){
        //new Acciones( _ACCIONMUESTRASMTPCONF_ );
        $sql = " SELECT permisos FROM sis_perfiles WHERE id = '".$params["perfil"]."' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $permisos = "";
        if($rs){
            $permisos = $rs->fields['permisos'];
        }
        return $permisos;
    }

    public function setPermisosPerfil($params){
        //Todos los modulos sabemos que son secciones de ultimo nivel
        $arrPermisos = array();
        $valorPermisos = "";
        //Buscamos permisos para el perfil seleccionado
        $sqlBuscaPermisos = " SELECT permisos FROM sis_perfiles WHERE id = '".$params["idPerfil"]."' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rsBuscaPermisos  = $this->dbCon->ejecutaComando( $sqlBuscaPermisos );
        $permisos = "";
        if($rsBuscaPermisos){
            $permisos = $rsBuscaPermisos->fields['permisos'];
        }

        if($permisos != ""){
	     //Existen datos
            $arrPermisos = unserialize($permisos);
            //Verificamos status de checkbox
            if($params["statusChkBox"] == "1"){
                //Agregamos
                //Verificamos el modulo enviado quienes son sus padres
                $seccion = $this->buscaPadresModulo($params["modulo"]);
                //Obtenemos las secciones padres de este modulo
                $sqlSeccionPadre = " SELECT id FROM sis_menu WHERE status = '1' AND tipo = '1' AND seccion = '".$seccion["seccion"]."' AND orden <= '".$seccion["orden"]."' ";
                $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
                $rsSeccionPadre = $this->dbCon->ejecutaComando( $sqlSeccionPadre );
                while (!$rsSeccionPadre->EOF){
                    //Conforme vamos encontrando los padres en caso de no existir en el array los vamos agregando
                    if(in_array($rsSeccionPadre->fields['id'],$arrPermisos)){
                        //Se encontro

                    }else{
                        //No se encontro, entonces lo agregamos
                        $arrPermisos[] = $rsSeccionPadre->fields['id'];
                    }
                    $rsSeccionPadre->MoveNext();
                }
                //Agregamos modulo seleccionado en array
                $arrPermisos[] = $params["modulo"];
                $valorPermisos = serialize($arrPermisos);
                $statusUpdate = $this->guardaPermisosPerfil($valorPermisos, $params["idPerfil"]);
            }elseif($params["statusChkBox"] == "0"){
                //Borramos elemento del array
                $clave = array_search($params["modulo"], $arrPermisos);
                //borramos elemento arreglo
                unset($arrPermisos[$clave]);
                //reorganizamos indices arreglo
                $arrPermisos = array_values($arrPermisos);
                //Verificamos si dentro del array existen elementos hijos del mismo padre, si existen generamos bandera para no eliminar de arreglo a elementos padre solo al hijo
                //en caso de no existir eliminamos de arreglo a elementros padre
                $banderaElemenMismoNivel = $this->buscaElemMismoNivel($params["modulo"],$arrPermisos);
                if($banderaElemenMismoNivel){
                    //Ya no eliminamos elementos padre

                }else{
                    //Eliminamos elementos padre
                    $seccion = $this->buscaPadresModulo($params["modulo"]);
                    $sqlSeccionPadre = " SELECT id FROM sis_menu WHERE status = '1' AND tipo = '1' AND seccion = '".$seccion["seccion"]."' ";
                    $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
                    $rsSeccionPadre = $this->dbCon->ejecutaComando( $sqlSeccionPadre );
                    while (!$rsSeccionPadre->EOF){
                        //Vamos buscando elementos en array en caso de encontrarlos los eliminamos
                        $clave = array_search($rsSeccionPadre->fields['id'], $arrPermisos);
			if ($clave != NULL || $clave !== FALSE) {
			    //borramos elemento arreglo
                            unset($arrPermisos[$clave]);
                        }
                        $rsSeccionPadre->MoveNext();
                    }
		    //reorganizamos indices arreglo
		    $arrPermisos = array_values($arrPermisos);
                }

                //verificamos longitud del arreglo, si es 0 guardamos vacio en campo permisos en otro caso guardamos arreglo resultante
                $tamArr = count($arrPermisos);
                if($tamArr == 0){ $valorPermisos = ""; }
                else{ $valorPermisos = serialize($arrPermisos); }
                $statusUpdate = $this->guardaPermisosPerfil($valorPermisos, $params["idPerfil"]);
            }
        }else{
            //No existen datos, entonces generamos el arreglo con el permiso seleccionado
            //Verificamos el modulo enviado quienes son sus padres
            $seccion = $this->buscaPadresModulo($params["modulo"]);
            //Buscamos todos los ID padre y los ingresamos a string de permisos
            $sqlSeccionPadre = " SELECT id FROM sis_menu WHERE status = '1' AND tipo = '1' AND seccion = '".$seccion["seccion"]."' AND orden <= '".$seccion["orden"]."' ";
            $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
            $rsSeccionPadre = $this->dbCon->ejecutaComando( $sqlSeccionPadre );
            while (!$rsSeccionPadre->EOF){
                $arrPermisos[] = $rsSeccionPadre->fields['id'];
                $rsSeccionPadre->MoveNext();
            }

            $arrPermisos[] = $params["modulo"];
            $valorPermisos = serialize($arrPermisos);
            $statusUpdate = $this->guardaPermisosPerfil($valorPermisos, $params["idPerfil"]);
        }

        return $statusUpdate;

    }

    /*
     * Metodo que guardar string permisos en perfil
     *
     */
    public function guardaPermisosPerfil($strPermisos,$idPerfil){
        //Actualizamos en BD los permisos
        $sqlUpdate = " UPDATE sis_perfiles SET permisos = '".$strPermisos."' WHERE id = '".$idPerfil."' ";
        $rsUpdate  = $this->dbCon->ejecutaComando( $sqlUpdate );
        if( $rsUpdate ){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Metodo que buscar padres del modulo seleccionado
     *
     */
    public function buscaPadresModulo($modulo){
	$datosSeccion = array();
        $sqlSeccion = " SELECT seccion, orden FROM sis_menu WHERE id = '".$modulo."' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rsSeccion = $this->dbCon->ejecutaComando( $sqlSeccion );
        $seccion = "";
        if($rsSeccion){
            $datosSeccion["seccion"] = $rsSeccion->fields['seccion'];
            $datosSeccion["orden"] = $rsSeccion->fields['orden'];
        }
        return $datosSeccion;
    }

    /*
     * Metodo que busca elementos del mismo nivel
     *
     */
    public function buscaElemMismoNivel($modulo,$arrPermisos){
        $seccion = $this->buscaPadresModulo($modulo);
        $bandera = false;

        $sqlNivelCero = " SELECT rangoInicial, rangoFinal FROM sis_menu WHERE seccion = '".$seccion["seccion"]."' AND nivel = '0' AND tipo = '1' AND status = '1' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rsNivelCero = $this->dbCon->ejecutaComando( $sqlNivelCero );
        if($rsNivelCero){
            $rangoInicial = $rsNivelCero->fields['rangoInicial'];
            $rangoFinal = $rsNivelCero->fields['rangoFinal'];
        }

        //Obtenemos elementos de todo el nivel
        $sqlElemMismoNivel = " SELECT id, ruta FROM sis_menu WHERE seccion = '".$seccion["seccion"]."' AND status = '1' AND rangoInicial > '".$rangoInicial."' ";
        $sqlElemMismoNivel .= " AND rangoFinal <= '".$rangoFinal."' ";
        $this->dbCon->fetchMode( ADODB_FETCH_ASSOC );
        $rsElemMismoNivel = $this->dbCon->ejecutaComando( $sqlElemMismoNivel );
        while (!$rsElemMismoNivel->EOF){
	    if($rsElemMismoNivel->fields['ruta'] != ""){
            if(in_array($rsElemMismoNivel->fields['id'],$arrPermisos)){
                //Con uno que exista indica que ya no podriamos eliminar elementos padre
                $bandera = true;
            }
	    }
            $rsElemMismoNivel->MoveNext();
        }

        return $bandera;
    }

    /*
     * Metodo que guarda el nuevo perfil
     * ingresado
     */
    public function setNuevoPerfil($params){
        $sqlInsert  = " INSERT INTO sis_perfiles(nombrePerfil,permisos,fechaAlta,fechaModifica,status) ";
        $sqlInsert .= " VALUES ('".$params["nombrePerfil"]."','','".date("Y-m-d G:i:s")."','".date("Y-m-d G:i:s")."','1') ";

        $rsInsert  = $this->dbCon->ejecutaComando( $sqlInsert );
        if( $rsInsert ){
            return mysql_insert_id();
        }else{
            return false;
        }
    }

    /****************************************************
     *
     *         Valores Predefinidos
     *
     ****************************************************/

    /* Arreglo que contiene la estructura de datos del grid de valores predefinidos */
    public function predefinidos_Datos() {
        $registros = array();
        $registro  = array();
        $sql       = " SELECT p.clave, p.descripcion, p.valor, m.nombre AS modulo FROM sis_predefinidos AS p , sis_modulos AS m  WHERE p.modulo=m.id ORDER BY m.id ASC ";
        $rs        = $this->dbCon->ejecutaComando( $sql );

        while( !$rs->EOF ) {
            $registro['clave']       = ( $rs->fields['clave'] );
            $registro['descripcion'] = utf8_encode( $rs->fields['descripcion'] );
            $registro['valor']       = ( $rs->fields['valor'] );
            $registro['modulo']      = ( $rs->fields['modulo'] );
            $registros[] = $registro;
            $rs->MoveNext();
        }

        return $registros;
    }

    /* Metodo que guarda todos los datos predefinidos */
    public function guardaPredefinidos() {
        $datos = $_GET;
        $cont   = 0;

        foreach( $datos AS $llave=>$valor ){
            $sql = " UPDATE sis_predefinidos SET valor='".$valor."' WHERE clave='".$llave."' ";
            $rs  = $this->dbCon->ejecutaComando( $sql );
            if( $rs ){$cont = $cont + 0;}
            else{ $cont ++; }
        }

        return $cont;
    }

    /*
     * Verifica si hay elementos a mostrar
     */
    public function verificaLayoutCant( $fi , $ff ) {
        $sql = " SELECT COUNT(*) AS t FROM reg_altaRegistro WHERE alta BETWEEN '".$fi." 00:00:00' AND '".$ff." 23:59:59' AND status=1 ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        if( $rs->fields[ 't' ] > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Descarga layout
     */
    public function verificaLayout( $fi , $ff ) {
        $sql = " SELECT COUNT(*) AS t FROM reg_altaRegistro WHERE alta BETWEEN '".$fi." 00:00:00' AND '".$ff." 23:59:59' AND status=1 ";

        $rs  = $this->dbCon->ejecutaComando( $sql );
        if( $rs->fields[ 't' ] > 0 ) {
            $rows = $this->datosLayout($fi, $ff);
            $html = '<table>';
            foreach( $rows AS $row ) {
                $html .= '<tr>';
                for( $i = 0 ; $i <= 36 ; $i ++ ) {
                    $html .= '<td>' . $row[ $i ] . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</table>';

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=layout.xls");  //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            echo $html;
        } else {
            return false;
        }
    }

    public function datosLayout( $fi , $ff ) {
        $sql   = " SELECT r.noClienteAudatex AS noCliente, r.nombreFiscal AS nombreFiscal, r.nombreComercial AS nombreComercial, r.calleComercial AS address1, r.coloniaComercial AS address2, ";
        $sql  .= " r.sistema AS sistema, r.rfcFiscal AS rfcFiscal, r.telefonoComercial AS telefonoComercial, r.correoContactoComercial AS correoContactoComercial, ";
        $sql  .= " d.banco AS banco, d.terminacion AS terminacion, d.clabe AS clabe, r.ciudadFiscal AS city, r.entidadFiscal AS state, r.cpComercial AS postalCode, ";
        $sql  .= " r.calleFiscal AS shipAddress1, r.coloniaFiscal AS shipAddress2, r.ciudadFiscal AS shipCity, r.entidadFiscal AS shipState, ";
        $sql  .= " r.cpFiscal AS shipPostal, r.paisFiscal AS shipCountry, d.sucursal AS sucursal, d.banco AS banco, r.regimenFiscal AS regimenFiscal, r.metodoPago AS metodoPago ";
        $sql  .= " FROM reg_altaRegistro AS r LEFT JOIN reg_datosDocimiliacion AS d ON r.id=d.idSolicitud ";
        $sql  .= " WHERE r.alta BETWEEN '".$fi." 00:00:00' AND '".$ff." 23:59:59' AND r.status=1 ";
        $sql  .= " AND r.id IN ( SELECT idSolicitud FROM reg_validacionSolicitud WHERE validacion=1 )";
        $rs    = $this->dbCon->ejecutaComando( $sql );
        $datos = array();

        $datos[] = array(
            'ORGANIZATION NAME (Razón Social)'                 , //0
            'NAME PRONUNCIATION (Nombre Comercial)'            , //1
            'COSTUMER CATEGORY'                                , //2
            'ACCOUNT NUMBER (Codigo de Cliente)'               , //3
            'LOB'                                              , //4
            'ADDRESS1 (CALLE Y NUMERO)'                        , //5
            'ADDRESS2 (COLONIA)'                               , //6
            'CITY'                                             , //7
            'STATE'                                            , //8
            'POSTAL CODE'                                      , //9
            'ZONA'                                             , //10
            'Country'                                          , //11
            'Ship Address1'                                    , //12
            'Ship Address2'                                    , //13
            'Ship City'                                        , //14
            'Ship State'                                       , //15
            'Ship Postal'                                      , //16
            'Ship Country'                                     , //17
            'TAXPAYER ID (RFC)'                                , //18
            'PHONE NUMBER'                                     , //19
            'EMAIL ADDRESSES'                                  , //20
            'PAYMENT'                                          , //21
            'BANK NAME'                                        , //22
            'BAN ACCOUNT NUMBER'                               , //23
            'MAPPING NUMBER'                                   , //24
            'MAPPING NAME'                                     , //25
            'PAYMENT METHOD'                                   , //26
            'BANK NAME (Nombre del Banco)'                     , //27
            'BANK NUMBER (Registro de Bancos)'                 , //28
            'BRANCH NAME (Nombre Sucursal)'                    , //29
            'BRANCH NUMBER (Numero de Sucursal)'               , //30
            'BRANCH TYPE'                                      , //31
            'ACCOUNT NUMBER (Cuenta Clave a 18 dígitos)'       , //32
            'Credit Number'                                    , //33
            'CC Expiration Date'                               , //34
            'Card Brand'                                       , //35
            'Regimen Fiscal'                                     //36
        );

        while( !$rs->EOF ) {
            $edo     = $this->detalleEstado( $rs->fields[ 'state' ] );
            $edo2    = $this->detalleEstado( $rs->fields[ 'shipState' ] );
            $metodo  = $this->detalleMetodoPago( 3 );
            
            $sistema1 = ( $rs->fields[ 'sistema' ] == '1' ) ? '40.1' : '40';
            $sistema2 = ( $rs->fields[ 'sistema' ] == '1' ) ? 'TALLER INPART' : 'TALLER';
            
            $datos[] = array (
                $rs->fields[ 'nombreFiscal' ]               , //0
                $rs->fields[ 'nombreComercial' ]            , //1
                'Body Shop (non US)'                        , //2
                $rs->fields[ 'noCliente' ]                  , //3
                'CRS_MX'                                    , //4
                $rs->fields[ 'address1' ]                   , //5
                $rs->fields[ 'address2' ]                   , //6
                $rs->fields[ 'city' ]                       , //7
                $edo[ 'nombre' ]                            , //8
                '\''.str_pad( $rs->fields[ 'postalCode' ] , 6 , '0' , STR_PAD_LEFT ) , //9
                $edo[ 'zona' ]                              , //10
                'MX'                                        , //11
                $rs->fields[ 'shipAddress1' ]               , //12
                $rs->fields[ 'shipAddress2' ]               , //13
                $rs->fields[ 'shipCity' ]                   , //14
                $edo2[ 'nombre' ]                           , //15
                '\''.str_pad( $rs->fields[ 'shipPostal' ] , 6 , '0' , STR_PAD_LEFT )                 , //16
                $rs->fields[ 'shipCountry' ]                , //17
                $rs->fields[ 'rfcFiscal' ]                  , //18
                str_replace( ' ' , '' , $rs->fields[ 'telefonoComercial' ] ) , //19
                $rs->fields[ 'correoContactoComercial' ]    , //20
                $metodo[ 'metodo' ]                         , //21
                #$this->nombreBanco( $rs->fields[ 'banco' ] ), //22
                #$rs->fields[ 'terminacion' ]                , //23
                ''                                          , //22
                ''                                          , //23
                $sistema1                                   , //24
                $sistema2                                   , //25
                $metodo[ 'id' ]                             , //26
                $this->nombreBanco( $rs->fields[ 'banco' ] ), //27
                $rs->fields[ 'banco' ]                      , //28
                $rs->fields[ 'sucursal' ]                   , //29
                $rs->fields[ 'sucursal' ]                   , //30
                'Other'                                     , //31
                '\''.$rs->fields[ 'clabe' ]                 , //32
                ''                                          , //33
                ''                                          , //34
                ''                                          , //35
                '601'                                         //36
            );

            $rs->MoveNext();
        }
        trigger_error(serialize($datos));
        return $datos;
    }

    private function detalleEstado( $id ) {
        $sql = " SELECT estado, zona FROM reg_catalogoEstados WHERE id='".$id."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $edo = array();

        while( !$rs->EOF ) {
            $edo[ 'nombre' ] = $rs->fields[ 'estado' ];
            $edo[ 'zona' ]   = $rs->fields[ 'zona' ];
            $rs->MoveNext();
        }

        return $edo;
    }

    private function nombreBanco( $id ) {
        $sql    = " SELECT banco FROM reg_catalogoBancos WHERE clave='".$id."' ";
        $rs     = $this->dbCon->ejecutaComando( $sql );
        $nombre = '';

        while( !$rs->EOF ) {
            $nombre = $rs->fields[ 'banco' ];
            $rs->MoveNext();
        }

        return $nombre;
    }

    private function detalleMetodoPago( $id ) {
        $sql = " SELECT id, metodoPago FROM reg_catalogoMetodoPago WHERE id='".$id."' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        $met = array();

        while( !$rs->EOF ) {
            $met[ 'id' ]     = $rs->fields[ 'id' ];
            $met[ 'metodo' ] = $rs->fields[ 'metodoPago' ];
            $rs->MoveNext();
        }

        return $met;
    }


    public function verificaUsuarioCaptura( $email ) {
        $sql = " SELECT COUNT(*) AS t FROM sis_usuarios WHERE email='".$email."' AND perfil=2 AND status=1 ";
        $rs  = $this->dbCon->ejecutaComando( $sql );
        return $rs->fields[ 't' ];
    }

    public function enviaDatosAccesoUsuarioCaptura( $params ) {
        if( $this->altaUsuarioAccesoCaptura( $params ) ) {
            $envio = new Mail( 'Acceso Plataforma Provisioning' , $params[ 'email' ] , 'enviaDatosAccesoCaptura' , $params );
        }
        return $envio->estadoEnvio;
    }

    private function altaUsuarioAccesoCaptura( $params ) {
        $sql  = " INSERT INTO sis_usuarios (nombre, usuario, contrasena, email, edad, perfil, fechaAlta, status) ";
        $sql .= " VALUES ( '" . addslashes( $params[ 'nombre' ] ) . "' , '" . addslashes( $params[ 'usuario' ] ) . "' , '" . md5( $params[ 'contrasena' ] ) . "', ";
        $sql .= " '".$params[ 'email' ]."', 0, 2, '".date( 'Y-m-d H:i:s' )."', 1) ";
        return $this->dbCon->ejecutaComando( $sql );
    }


    public function actualizaUsuarioAccesoCaptura( $params ) {
        $passUpdate = strlen( $params[ 'contrasena' ] ) > 20 ? $params[ 'contrasena' ] : md5( $params[ 'contrasena' ] ) ;
        $sql  = " UPDATE sis_usuarios SET nombre='".$params[ 'nombre' ]."', usuario='".$params[ 'usuario' ]."', ";
        $sql .= " contrasena='".$passUpdate."', email='".$params[ 'email' ]."' WHERE id='".$params[ 'id' ]."' ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        
        if( $rs ){ return true; }
        else{ return false; }
    }


    public function listadoUsuariosCaptura() {
        $sql  = " SELECT * FROM sis_usuarios WHERE perfil=2 AND status=1 ";
        $rs   = $this->dbCon->ejecutaComando( $sql );
        $usrs = array();

        while( !$rs->EOF ) {
            $usrs[] = array(
                'id'         => $rs->fields[ 'id' ],
                'nombre'     => $rs->fields[ 'nombre' ],
                'usuario'    => $rs->fields[ 'usuario' ],
                'contrasena' => $rs->fields[ 'contrasena' ],
                'email'      => $rs->fields[ 'email' ]
            );
            $rs->MoveNext();
        }

        return json_encode( $usrs );
    }


    public function eliminaUsuarioCaptura( $id ) {
        $sql = " UPDATE sis_usuarios SET status=0 WHERE id='" . $id . "' ";
        $rs  = $this->dbCon->ejecutaComando( $sql );

        if( $rs ){ return true; }
        else{ return false; }
    }

}











