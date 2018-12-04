<?php
/*
 * Clase que valida privilegios de Universe Promerc
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Enero 2016
 */
if( !defined( "_SESIONACTIVA_" ) ){die("No se permite el acceso directo a este arcchivo");}

class Privilegios{

    /* Id de la seccion a la que se intenta accesar */
    public $seccionID;
    /* Id del usuario logeado */
    public $userID;
    /* Id del grupo al que pertenece el usuario */
    public $groupID;
    
    /*
     * Contendra la instancia de conexion a BD
     */
    protected $dbConn = null;
    
    /*
     * Contructor de la clase
     */
    public function __construct() {
        $this->dbCon = new classConMySQL();
    }        

    /* Verifica privilegios del usuario logeado cuando se intenta
     * accesar a alguna seccion del sistema
     */
    public function verificaPrivilegio($seccion,$grupo){
        $this->seccionID = $seccion;
        $this->groupID = $grupo;

        if($this->groupID == "0")return true;

        $sql = " SELECT permisos FROM sis_perfiles WHERE id = '".$this->groupID."' ";
        $rs = $this->dbCon->ejecutaComando( $sql );

        if( $rs && !$rs->EOF ){
                $seccionesPermitidas = unserialize($rs->fields["permisos"]);
                if( in_array( $this->seccionID , $seccionesPermitidas ) ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
        }
    }

    /* Verifica privilegios de un usuario para cada seccion y despliega en el menu 
     * solo las opciones permitidas desde el modulo de privilegios
     */
    public function verificaPrivilegioMenuAcceso($grupo){
        $this->groupID = $grupo;
        $seccionesPermitidas = array();
        if( $this->groupID == "0" ){
            $sql = " SELECT id FROM sis_menu WHERE status = 1 ";
            $rs = $this->dbCon->ejecutaComando( $sql );
            while(!$rs->EOF){
                $seccionesPermitidas[] = $rs->fields["id"];
                $rs->MoveNext();
            }
        }else{
            $sql = " SELECT permisos FROM sis_perfiles WHERE id = '".$this->groupID."' AND status = '1' ";
            $rs = $this->dbCon->ejecutaComando( $sql );
            if($rs && !$rs->EOF){
                $seccionesPermitidas = unserialize($rs->fields["permisos"]);
            }
        }

        return $seccionesPermitidas;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /* Funcion que pinta dialog indicando que no se tienen accesos a la
     * seccion que se intenta abrir
     */
    public function modalPrivilegios($seccion){
        $grupo = (isset($_SESSION["s_grupo"])) ? $_SESSION["s_grupo"] : "0" ;
        if($this->verificaPrivilegio($seccion, $grupo)){
            /* Acceso permitido */
        }else{
            //new LogAccess($seccion,"Intento de acceso sin privilegios");
            /* Aviso de acceso no permitido */
            $js  = '<script type="text/javascript">';
            $js .= 'function muestraDialogErrorPrivilegios(){';
            $js .= 'var mensaje = "<br>No tiene privilegios para accesar a esta secci&oacute;n, consulte al administrador del sistema.";';
            $js .= '$("body").append("<div title=\"Control de Acceso\" id=\"muestraMensajePrivilegiosNoPermitidos\"><center>"+mensaje+"</center></div>");';
            $js .= '$("#muestraMensajePrivilegiosNoPermitidos").dialog({';
            $js .= 'modal:true,draggable:false,closeOnEscape:false,resizable:false,';
            $js .= 'buttons:{"Aceptar":function(){';
            $js .= '$("#muestraMensajePrivilegiosNoPermitidos").dialog("destroy");';
            $js .= '$("#muestraMensajePrivilegiosNoPermitidos").remove();';
            $js .= 'var tabindex = $("#tabs").tabs("option","selected");';
            $js .= '$("#tabs").tabs("remove", tabindex);';
            $js .= '}';
            $js .= '}';
            $js .= '}).parent(".ui-dialog").find(".ui-dialog-titlebar-close").hide();';
            $js .= '}';
            $js .= 'muestraDialogErrorPrivilegios();';
            $js .= '</script>';
            echo $js;
        }
    }

    /* Funcion que pinta dialog indicando que no se tienen accesos a la
     * seccion que se intenta abrir para version mobile
     */
    public function modalPrivilegiosMobile($seccion){
        $grupo = (isset($_SESSION["s_grupo"])) ? $_SESSION["s_grupo"] : "0" ;
        if($this->verificaPrivilegio($seccion, $grupo)){
            /* Acceso permitido */
        }else{
            /* Aviso de acceso no permitido */
            $js  = '<script type="text/javascript">';
            $js .= '$(document).ready(function(){';
            $js .= '$.mobile.changePage( "#mensajeSinPrivilegios", { role: "dialog" } );';
            $js .= '});';
            $js .= '</script>';
            echo $js;
        }
    }
    
    

}

?>