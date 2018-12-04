<?php
/**
 * Controlador del modulo de configuracion del sistema
 *
 * @Framework Mexagon
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2015
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
include_once _DIRPATH_ . '/modulos/Sistema/modelo/MSistema.php';

class Sistema extends Template {

    protected $dbCon = null;
    protected $modelo = null;

    /*
     * Constructor de clase
     */
    public function __construct() {
        new Sesion();
        parent::__construct();
        $this->modelo = new MSistema();
    }

    /*
     * Accion configuracion SMTP
     */
    public function configuracionSMTP(){
        $datos = $this->modelo->getSMTP();
        $this->muestraDato( 'scripts' , array('../../vistas/Sistema/js/configuracionSMTP.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'path' , _SITEPATH_ );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Configuraciones' , 'Configuraci&oacute;n SMTP' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->muestraDato( 'testing' , false );
        $this->muestraDato( 'legend' , _CONFSMTPLEGEND_ );
        $this->muestraDato( 'servidor' , _CONFSMTPNOMBRESERVER_ );
        $this->muestraDato( 'servidorValue' , $datos[0]['smtp'] );
        $this->muestraDato( 'usuario' , _CONFSMTPUSUARIO_ );
        $this->muestraDato( 'usuarioValue' , $datos[0]['usuario'] );
        $this->muestraDato( 'passwd' , _CONFSMTPPASSWD_ );
        $this->muestraDato( 'passwdValue' , $datos[0]['contrasena'] );
        $this->muestraDato( 'puerto' , _CONFSMTPPTO_ );
        $this->muestraDato( 'puertoValue' , $datos[0]['puerto'] );
        $this->muestraDato( 'seguridad' , _CONFSMTPSEGURIDAD_ );
        $this->muestraDato( 'seguridadValue' , $datos[0]['seguridad'] );
        $this->muestraDato( 'de' , _CONFSMTPDE_ );
        $this->muestraDato( 'deValue' , $datos[0]['de'] );
        $this->muestraDato( 'deNombre' , _CONFSMTPNOMBREDE_ );
        $this->muestraDato( 'deNombreValue' , $datos[0]['nombreDe'] );
        $this->muestraDato( 'copiaA' , _CONFSMTPCOPIAA_ );
        $this->muestraDato( 'copiaAValue' , $datos[0]['copia'] );
        $this->muestraDato( 'guardaConf' , _CONFSMTPGUARDACONFIG_ );
        $this->muestraDato( 'pruebaConf' , _CONFSMTPPRUEBACONFIG_ );
        $this->muestraDato( 'enviaPrueba' , _CONFSMTPENVIARPRUEBA_ );
        $this->muestraDato( 'enviarBtn' , _CONFSMTPENVIAPRUEBABTN_ );
        $this->muestraDato( 'cancelaBtn' , _CONFSMTPENVIAPRUEBACANCELA_ );
        $this->muestraDato( 'enviandoTexto' , _CONFSMTPENVIANDOTEXTO_ );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Accion que guarda la configuracion SMTP proporcionada
     * por el usuario
     */
    public function guardaSMTP( $params ){
        return $this->modelo->setSMTP( $params );
    }

    /*
     * Accion que recibe los parametros SMTP con la finalidad de hacer un
     * envio de prueba y verificar la correcta configuracion de la cuenta
     */
    public function testSMTP(){
        echo $this->modelo->testSMTP( $_POST );
    }

    /*
     * Accion Predeterminados
     */
    public function predeterminados(){
        $informacion = $this->modelo->predefinidos_Datos();
        $this->muestraDato( 'scripts' , array( '../../vistas/Sistema/js/predeterminados.js' ) );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , '' );
        $this->muestraDato( 'registros' , $informacion );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Configuraciones' , 'Predeterminados' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Accion que guarda los datos predeteminados
     */
    public function guardaPredeterminados() {
        return $this->modelo->guardaPredefinidos();
    }

    /*
     * Accion Usuarios
     */
    public function usuarios() {
	new Sesion();
        $columnas = $this->modelo->usuarios_Datos();
        $paths = array( 'principal' => '/Sistema/listadoUsuarios/' ,
                        'excel' => '/Utiles/generaExcel/' ,
                        'pdf' => '/Sistema/listadoUsuariosPDF/',
                        'elimina'   => '/Sistema/eliminaUsuario/' ,
                        'agrega'    => '/Sistema/agregaUsuario/' ,
                        'edita'     => '/Sistema/editaUsuario/');
        $grid = new JQGrid( 'ListadoUsuariosSistema' , 'Listado de Usuarios' , $columnas , $paths );
        $this->muestraDato( 'scripts' , array("../../vistas/Sistema/js/usuarios.js") );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Control de Acceso' , 'Usuarios' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    /*
     * Accion que carga la pantalla para mostrar marcas
     */
    public function muestraMarcas( $param ) {
        $marcas = $this->modelo->listadoMarcas();
        $marcasConfiguradas = explode( "|" , $this->modelo->obtieneMarcasPorUsuario( $param['id'] ) );

        $html  = '<table>';
        foreach( $marcas AS $marca ){
            $checado = ( in_array( $marca['id'] , $marcasConfiguradas ) ? 'checked="checked"' : '' );
            $html .= '<tr>'
                    . '<td>'.$marca['marca'].'</td>'
                    . '<td><input value="'.$marca['id'].'" type="checkbox" name="usoMarcaPorUsuario_'.$marca['id'].'" id="usoMarcaPorUsuario_'.$marca['id'].'" class="usoMarca"  ' . $checado .' /></td></tr>';
        }
        $html .= '</table>';

        $this->muestraDato( 'html'       , $html );
        $this->muestraDato( 'idUsuario'  , $param['id'] );
        $this->muestraDato( 'breadcrumb' , false );
        $this->muestraDato( 'cierraL'    , false );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Accion que guarda las marcas por usuario
     */
    public function guardaMarcaPorUsuario() {
        $param = $_GET;
        $response = $this->modelo->guardaMarcaPorUsuario( $param );
        echo $response;
    }

    /*
     * Accion Privilegios
     */
    public function perfiles() {
	$datosPerfiles = $this->modelo->getElementosPerfiles();

	$html = "";

	$datosMenuNivelCero = $this->modelo->getElementosMenu("0");
	$tamDatosMenuNivelCero = count($datosMenuNivelCero);

        for($i = 0; $i < $tamDatosMenuNivelCero; $i ++){
            if($datosMenuNivelCero[$i]["tipo"] == "1"){
                //Si es 1 es elemento menu
                $html .= '<fieldset class="ui-widget ui-widget-content">';
               //$html .= '<legend><input type="checkbox" name="option'.$datosMenuNivelCero[$i]["id"].'" id="option'.$datosMenuNivelCero[$i]["id"].'" value="'.$datosMenuNivelCero[$i]["id"].'" onclick="actualizaPermisos(this.value)">'.$datosMenuNivelCero[$i]["nombre"].'</legend>';
		$html .= '<legend>'.($datosMenuNivelCero[$i]["nombre"]).'</legend>';
                //Buscamos elementos para la seccion encontrada
                $datosMenuSecciones = $this->modelo->getElementosMenuSeccion($datosMenuNivelCero[$i]["seccion"]);
                $tamDatosMenuSecciones = count($datosMenuSecciones);
                for($j = 0; $j < $tamDatosMenuSecciones; $j ++){
                    if($datosMenuSecciones[$j]["tipo"] == "2" && $datosMenuSecciones[$j]["nivel"] == "1"){
                        //Mostramos checkbox
                        $html .= '<input type="checkbox" name="option'.$datosMenuSecciones[$j]["id"].'" id="option'.$datosMenuSecciones[$j]["id"].'" value="'.$datosMenuSecciones[$j]["id"].'" onclick="actualizaPermisos(this.value)"> '.$datosMenuSecciones[$j]["nombre"].'<br />';
                    }

		    if($datosMenuSecciones[$j]["tipo"] == "1" && $datosMenuSecciones[$j]["nivel"] == "1"){
                        //Es un fieldset
                        $html .= '<fieldset class="ui-widget ui-widget-content">';
                        //$html .= '<legend><input type="checkbox" name="option'.$datosMenuSecciones[$j]["id"].'" id="option'.$datosMenuSecciones[$j]["id"].'" value="'.$datosMenuSecciones[$j]["id"].'" onclick="actualizaPermisos(this.value)">'.$datosMenuSecciones[$j]["nombre"].'</legend>';
			$html .= '<legend>'.$datosMenuSecciones[$j]["nombre"].'</legend>';
			//Obtenemos elmentos nivel 2 y tipo 2
                        $datosMenuSeccionesNivel2 = $this->modelo->getElementosMenuSeccionNivel2($datosMenuSecciones[$j]["seccion"]);
                        $tamDatosMenuSeccionesNivel2 = count($datosMenuSeccionesNivel2);

                        for($k = 0; $k < $tamDatosMenuSeccionesNivel2; $k ++){
                            //Verificamos que este dentro del rango actual
                            if( $datosMenuSeccionesNivel2[$k]["rangoInicial"] >= $datosMenuSecciones[$j]["rangoInicial"] && $datosMenuSeccionesNivel2[$k]["rangoFinal"] <= $datosMenuSecciones[$j]["rangoFinal"] ){
                                $html .= '<input type="checkbox" name="option'.$datosMenuSeccionesNivel2[$k]["id"].'" id="option'.$datosMenuSeccionesNivel2[$k]["id"].'" value="'.$datosMenuSeccionesNivel2[$k]["id"].'" onclick="actualizaPermisos(this.value)"> '.$datosMenuSeccionesNivel2[$k]["nombre"].'<br />';
                            }
                        }
                        $html .= '</fieldset>';
                    }
                }
                $html .= '</fieldset>';
            }
        }

        $this->muestraDato( 'scripts' , array('../../vistas/Sistema/js/perfiles.js') );
        $this->muestraDato( 'estilos' , array() );
	$this->muestraDato( 'datosPerfiles' , $datosPerfiles );
	$this->muestraDato( 'nombrePerfil' , _NOMBREPERFIL_ );
	$this->muestraDato( 'agregarPerfil' , _CONTROLACCESOBOTONPERFIL_ );
	$this->muestraDato( 'guardarPerfil' , _CONTROLACCESOBOTONGUARDARPERFIL_ );
        $this->muestraDato( 'contenidoSeccion' , $html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Control de Acceso' , 'Perfiles' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * Accion Accesos
     */
    public function accesos(){
        new Sesion();
        $columnas = $this->modelo->accesos_Datos();
        $paths = array( 'principal' => '/Sistema/listadoAccesos/' , 'excel' => '/Sistema/listadoAccesosExcel/' , 'pdf' => '/Sistema/listadoAccesosPDF/' );
        $grid = new JQGrid( 'ControlAccesos' , 'Registro de Accesos' , $columnas , $paths );

        $this->muestraDato( 'scripts' , array() );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $grid->html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Control de Acceso' , 'Registro de Accesos' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    /*
     * Accion del listado de accesos
     */
    public function listadoAccesos(){
        $this->modelo->datosGridListadoAccesos();
    }

    /*
     * Accion que busca informacion para el perfil
     * seleccionado
     */
    public function buscaPerfil( $params ){
        $permisos = $this->modelo->getDatosPerfil( $params );
	$strPermisos = "";
	if($permisos != ""){
            $arrPermisos = unserialize($permisos);
            foreach($arrPermisos as $valor){
                $strPermisos .= $valor.",";
            }
	}

        echo rtrim($strPermisos,",");
    }

    /*
     * Accion que actualiza permisos para el perfil
     * seleccionado
     */
    public function actualizarPermisos( $params ){
        $status = $this->modelo->setPermisosPerfil( $params );

        echo $status;
    }

    /*
     * Accion que guarda nuevo perfil
     * en base de datos
     */
    public function guardarNuevoPerfil( $params ){
        $status = $this->modelo->setNuevoPerfil( $params );

        echo $status;
    }

    /*
     * Accion del listado de usuarios
     */
    public function listadoUsuarios(){
        $this->modelo->datosGridListadoUsuarios();
    }

    /*
     * Metodo que agrega la informacion de un nuevo usuario
     */
    public function agregaUsuario(){
        $this->modelo->agregaUsuario();
    }

    /*
     * Metodo qwe cambia los datos de un usuario
     */
    public function editaUsuario(){
        $this->modelo->editaUsuario();
    }

    /*
     * Metodo que elimina un usuario
     */
    public function eliminaUsuario(){
        $this->modelo->eliminaUsuario();
    }

    /*
     * CONFIGURACION PARA LA VALIDACION DE MARCAS
     */
    public function validacionMarcas() {
        $html = $this->modelo->validacionMarcas();
        $this->muestraDato( 'scripts' , array('../../vistas/Sistema/js/validacionMarcas.js') );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'contenidoSeccion' , $html );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Configuraciones' , 'Validaci&oacute;n de Marcas' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUIDefault();
    }

    /*
     * Guarda la configuracion de reglas
     */
    public function guardaReglasValidacion() {
        return $this->modelo->guardaReglasValidacion();
    }

    /*
     * Layout
     */
    public function layout() {
        $this->muestraDato( 'scripts' , array( '../../vistas/Sistema/js/layout.js' ) );
        $this->muestraDato( 'estilos' , array() );
        $this->muestraDato( 'breadcrumb' , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Exportar Informacion' , 'Layout' ) );
        $this->muestraDato( 'cierraL' , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    public function verificaLayoutCant( $params ) {
        echo $this->modelo->verificaLayoutCant( $params[ 'fi' ] , $params[ 'ff' ] );
    }

    public function verificaLayout( $params ) {
        echo $this->modelo->verificaLayout( $params[ 'fi' ] , $params[ 'ff' ] );
    }

    public function descargaLayout( $params ) {
        $datos = $this->modelo->datosLayout( $params[ 'fi' ] , $params[ 'ff' ] );

        $fp = fopen('php://memory', 'w');
        foreach ( $datos as $dato ) {
            fputcsv( $fp , $dato );
        }

        fseek( $fp , 0 );
        header( 'Content-Type: application/csv' );
        header( 'Content-Disposition: attachment; filename="layout.csv";' );
        fpassthru( $fp );
    }

    /*
     * Acceso clientes finales
*/  public function envioCredenciales() {
        $this->muestraDato( 'scripts'             , array( '../../vistas/Sistema/js/envioCredenciales.js?1' ) );
        $this->muestraDato( 'estilos'             , array() );
        $this->muestraDato( 'breadcrumb'          , true );
        $this->muestraDato( 'breadcrumbElementos' , array( 'Sistema' , 'Envio de Accesos' ) );
        $this->muestraDato( 'contenidoSeccion'    , "" );
        $this->muestraDato( 'cierraL'             , true );
        $this->cargaGUI( __CLASS__ . '/' . __FUNCTION__ . '.tpl' );
    }

    /*
     * ENvio de acceso a usuario
     */
    public function verificaEmailAcceso( $param ) {
        $total = $this->modelo->verificaUsuarioCaptura( $param[ 'email' ] );
        echo $total;
    }

    public function enviaDatosDeAcceso( $param ) {
        $params = array(
            'nombre'     => $param[ 'nombre' ],
            'email'      => $param[ 'correo' ],
            'usuario'    => $param[ 'usuario' ],
            'contrasena' => $param[ 'contrasena' ]
        );
        echo $this->modelo->enviaDatosAccesoUsuarioCaptura( $params );
    }

    public function listadoUsuariosAccesos() {
        echo $this->modelo->listadoUsuariosCaptura();
    }

    public function eliminaUsuarioCaptura( $params ) {
        $this->modelo->eliminaUsuarioCaptura( $params[ 'id' ] );
    }

    public function actualizaDatosUsuarioCaptura( $params ) {
        echo $this->modelo->actualizaUsuarioAccesoCaptura( $params );
    }

}




