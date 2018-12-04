
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

<br />

<form id="certificacion_digitalizacion_form" name="certificacion_digitalizacion_form" method="post" enctype="multipart/form-data" action="../../Capacitacion/uploadFiles/" target="capacitacion_Digitalizacion_iframeTarget" >
    <fieldset class="ui-widget ui-widget-content">
        <table width="100%" cellspacing="4" cellpadding="4">
            <tr>
                <td width="40%" colspan="5"><b>RAZ&Oacute;N SOCIAL/RFC:</b></td>
            </tr>
            <tr>
                <td colspan="4" width="40%">
                    <input type="text" id="capacitacion_Digitalizacion_idRegistro" name="capacitacion_Digitalizacion_idRegistro" value="" style="width: 60%" placeholder="Busca por RFC / Raz&oacute;n Social"/>
                    <button id="capacitacion_Digitalizacion_eliminaBusquedaBoton" name="capacitacion_Digitalizacion_eliminaBusquedaBoton">Eliminar</button>
                    <input type="hidden" id="capacitacion_Digitalizacion_idRegistroID" name="capacitacion_Digitalizacion_idRegistroID" value="" />
                    <input type="hidden" id="capacitacion_Digitalizacion_tipoMovimiento" name="capacitacion_Digitalizacion_tipoMovimiento" value="alta" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td width="33%">CERTIFICADO</td>
                <td></td>
                <td width="33%">COMPROBANTE DE PAGO</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td align="left">
                    <input type="file" id="capacitacion_Digitalizacion_certificado" name="capacitacion_Digitalizacion_certificado" class="ui-widget ui-widget-content" accept="application/pdf" />
                    <span id="capacitacion_Digitalizacion_certificado_container" style="display: none">
                        <button value="certificado" id="capacitacion_Digitalizacion_certificado_containerBoton" class="descargaDocumentoCert" >Descarga</button>
                    </span>
                </td>
                <td></td>
                <td align="left">
                    <input type="file" id="capacitacion_Digitalizacion_comprobantePago" name="capacitacion_Digitalizacion_comprobantePago" accept="application/pdf" />
                    <span id="capacitacion_Digitalizacion_comprobantePago_container" style="display: none">
                        <button value="comprobantePago" id="capacitacion_Digitalizacion_comprobantePago_containerBoton" class="descargaDocumentoCert" >Descarga</button>
                    </span>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" align="center"><button id="capacitacion_Digitalizacion_guardaDocumentos" name="capacitacion_Digitalizacion_guardaDocumentos">Guardar Documentos</button></td>
            </tr>
            <tr>
                <td colspan="5"><br /></td>
            </tr>
            {if $esAdmin==true }
            <tr>
                <td colspan="6" id="capacitacion_Digitalizacion_ValidacionContenedor">
                    <fieldset class="ui-widget ui-widget-content">
                        <legend><b>Validaci&oacute;n</b></legend>
                        <table width="100%">
                            <tr>
                                <td align="center" width="50%"><button id="capacitacion_Digitalizacion_btnValidacion_Certificado" name="capacitacion_Digitalizacion_btnValidacion_Certificado">Validar Certificado</button></td>
                                <td align="center" width="50%"><button id="capacitacion_Digitalizacion_btnValidacion_Comprobante" name="capacitacion_Digitalizacion_btnValidacion_Comprobante">Validar Comprobante</button></td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            {/if}
        </table>
    </fieldset>
    <iframe frameborder="0" id="capacitacion_Digitalizacion_iframeTarget" name="capacitacion_Digitalizacion_iframeTarget" width="0" height="0" ></iframe>
    
    <div class="ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em; text-align: center">
            <center>Si tiene alguna duda favor de enviar un correo a <a href="mailto:documentosax@audatex.com.mx">documentosax@audatex.com.mx</a></center>
        </div>
    </div>
    
</form>


{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

