
<!-- Estilos -->
{foreach from=$estilos item=estilo}
    <link rel="stylesheet" type="text/css" media="screen" href="{$estilo}" />
{/foreach}

<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

{if $breadcrumb == true}
    <div class="breadCrumbHolder module">
        <div id="breadCrumbContainer" class="breadCrumb">
            <ul>
                <li><div>Home</div></li>
                {foreach from=$breadcrumbElementos item=elemento}
                    <li>{$elemento}</li>
                {/foreach}
            </ul>
        </div>
    </div>
{/if}

<div class="ui-widget">
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: 0 .7em; height: 100px">
        
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; "></span>
            <strong>Paso 2</strong> &nbsp; &nbsp; Editar los siguientes recuadros:
            <ul>
                <li>Autorizaci&oacute;n de domiciliaci&oacute;n</li>
                <li>Autorizaci&oacute;n de reporte de cr&eacute;dito</li>
                <li>Solicitud Curso Virtual</li>
                <li>Contrato</li>
            </ul>
            Al finalizar descargar, imprimir y firmar por el representante legal. Pase al siguiente M&oacute;dulo "Digitalizacion de Documentos"
    </div>
</div>

<br />

{$contenidoSeccion}

<fieldset class="ui-widget ui-widget-content">
        <table width="100%" cellspacing="4" cellpadding="4">
            <tr>
                <td width="40%"><b>RAZ&Oacute;N SOCIAL/RFC:</b></td>
            </tr>
            <tr>
                <td width="40%">
                    <input type="text" placeholder="Busca por RFC / Raz&oacute;n Social" id="descargaFormatos_idRegistro" name="descargaFormatos_idRegistro" value="" style="width: 80%" />
                    <button id="descargaFormatos_eliminaBusquedaBoton" name="descargaFormatos_eliminaBusquedaBoton">Eliminar</button>
                    <input type="hidden" id="descargaFormatos_idRegistroID" name="descargaFormatos_idRegistroID" />
                    <input type="hidden" id="descargaFormatos_idSistema" name="descargaFormatos_idSistema" />
                    <input type="hidden" id="descargaFormatos_idGiro" name="descargaFormatos_idGiro" />
                    <input type="hidden" id="descargaFormatos_idGiroTexto" name="descargaFormatos_idGiroTexto" />
                </td>
                <td colspan="4" align="center"></td>
            </tr>
        </table>
        <br />        
        <center>
            <table width="90%" class="ui-widget ui-corner-all ui-tabs-panel">
                <tr style="height: 80px">
                    <td id="btn_DescargaSolicitud" name="btn_DescargaSolicitud" width="20%" style="cursor: pointer" class="ui-widget ui-widget-content" align="center">Descarga Solicitud</td>
                    <td id="btn_DescargaAutDomiciliacion" name="btn_DescargaAutDomiciliacion" width="20%" style="cursor: pointer" class="ui-widget ui-widget-content" align="center">Descarga Autorizaci&oacute;n de Domiciliaci&oacute;n</td>
                    <!--td id="btn_DescargaAutRepCredito" name="btn_DescargaAutRepCredito" width="20%" style="cursor: pointer" class="ui-widget ui-widget-content" align="center">Descarga Autorizaci&oacute;n de Reporte de Cr&eacute;dito</td-->
                    <td id="btn_DescargaRefComerciales" name="btn_DescargaRefComerciales" width="20%" style="cursor: pointer" class="ui-widget ui-widget-content" align="center">Descarga Solicitud Curso Virtual</td>
                    <td id="btn_DescargaContrato" name="btn_DescargaContrato" width="20%" style="cursor: pointer" class="ui-widget ui-widget-content" align="center">Contrato</td>
                    <!--td id="btn_DescargaContratoImpart" name="btn_DescargaContratoImpart" width="16.6%" style="cursor: pointer" class="ui-widget ui-widget-content" align="center">Contrato Inpart</td-->
                </tr>
                <tr id="descargaFormatos_edicionDatos_contenedor" name="descargaFormatos_edicionDatos_contenedor" class="ui-widget ui-widget-content">
                    <td align="right"></td>
                    <td align="right">Editar:&nbsp;<button>Edita Formato</button></td>
                    <!--td align="right"><button>Edita Formato</button></td-->
                    <td align="right">* S&oacute;lo para AudaClaimsGold, si es proveedor de refacciones no es necesario realizar el pago. <br>Editar:&nbsp;<button>Edita Formato</button></td>
                    <td align="right">Editar:&nbsp;<button>Edita Formato</button></td>
                    <!--td align="right"><button>Edita Formato</button></td-->
                </tr>
            </table>
        </center>
        
        <div class="ui-widget">
            <div class="ui-state-error ui-corner-all" style="padding: 0 .7em; text-align: center">
                <center>Si tiene alguna duda favor de enviar un correo a <a href="mailto:documentosax@audatex.com.mx">documentosax@audatex.com.mx</a></center>
            </div>
        </div>
</fieldset>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
