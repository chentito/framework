
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
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: 0 .7em; height: 20px">
        
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; "></span>
            <strong>Paso 3</strong> &nbsp; &nbsp; Adjuntar los documentos firmados en formato PDF. Posterior a este paso se realizar la 
            validaci&oacute;n de sus documentos, en cuanto sean autorizados ser&aacute; notificado por correo electronico, junto con los pasos a seguir.
    </div>
</div>

<br />

<form id="registro_Digitalizacion_form" name="registro_Digitalizacion_form" method="post" enctype="multipart/form-data" action="../../Registro/uploadFiles/" target="registro_Digitalizacion_iframeTarget" >
    <fieldset class="ui-widget ui-widget-content">
        <table width="100%" cellspacing="4" cellpadding="4">
            <tr>
                <td width="40%" colspan="5"><b>RAZ&Oacute;N SOCIAL/RFC:</b></td>
            </tr>
            <tr>
                <td colspan="4" width="40%">
                    <input type="text" id="registro_Digitalizacion_idRegistro" name="registro_Digitalizacion_idRegistro" value="" style="width: 60%" placeholder="Busca por RFC / Raz&oacute;n Social"/>
                    <button id="registro_Digitalizacion_eliminaBusquedaBoton" name="registro_Digitalizacion_eliminaBusquedaBoton">Eliminar</button>
                    <input type="hidden" id="registro_Digitalizacion_idRegistroID" name="registro_Digitalizacion_idRegistroID" value="" />
                    <input type="hidden" id="registro_Digitalizacion_tipoMovimiento" name="registro_Digitalizacion_tipoMovimiento" value="alta" />
                </td>
                <td colspan="4" align="center">
                    <span id="registro_Digitalizacion_descargaMasiva_container" style="display: none">
                        <button id="registro_Digitalizacion_descargaZip">Descargar ZIP</button>&nbsp;&nbsp;&nbsp;
                        <button id="registro_Digitalizacion_descargaMegre">Descargar </button>&nbsp;&nbsp;&nbsp;
                        <button id="registro_Digitalizacion_descargaMegre_ver2">Formato 2</button>
                    </span>
                </td>
            </tr>
            <tr>
                <td width="33%">SOLICITUD DE REGISTRO (1 MB M&Aacute;XIMO)</td>
                <td></td>
                <td width="33%">AUTORIZACI&Oacute;N PARA DOMICILIACI&Oacute;N (1 MB M&Aacute;XIMO)</td>
                <td></td>
                <td width="33%">CONTRATO (4 MB M&Aacute;XIMO)</td>
            </tr>
            <tr>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_solicitud" name="registro_Digitalizacion_solicitud" class="ui-widget ui-widget-content" accept="application/pdf" />
                    <span id="registro_Digitalizacion_solicitud_container" style="display: none">
                        <button value="solicitudRegistro" id="registro_Digitalizacion_solicitud_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
                <td></td>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_autorizacionDomiciliacion" name="registro_Digitalizacion_autorizacionDomiciliacion" accept="application/pdf" />
                    <span id="registro_Digitalizacion_autorizacionDomiciliacion_container" style="display: none">
                        <button value="autorizacionDomiciliacion" id="registro_Digitalizacion_autorizacionDomiciliacion_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
                <td></td>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_contrato" name="registro_Digitalizacion_contrato" accept="application/pdf" />
                    <span id="registro_Digitalizacion_contrato_container" style="display: none">
                        <button value="contrato" id="registro_Digitalizacion_contrato_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
            </tr>
            <tr>
                <td>C&Eacute;DULA FISCAL (500 KB M&Aacute;XIMO)</td>
                <td></td>
                <td>ESTADO DE CUENTA (500 KB M&Aacute;XIMO)</td>
                <td></td>
                <td>COMPROBANTE DE DOMICILIO (500 KB M&Aacute;XIMO)</td>
            </tr>
            <tr>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_cedula" name="registro_Digitalizacion_cedula" accept="application/pdf" />
                    <span id="registro_Digitalizacion_cedula_container" style="display: none">
                        <button value="cedulaFiscal" id="registro_Digitalizacion_cedula_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
                <td></td>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_edoCta" name="registro_Digitalizacion_edoCta" accept="application/pdf" />
                    <span id="registro_Digitalizacion_edoCta_container" style="display: none">
                        <button value="edoCta" id="registro_Digitalizacion_edoCta_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
                <td></td>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_comprobanteDom" name="registro_Digitalizacion_comprobanteDom" accept="application/pdf" />
                    <span id="registro_Digitalizacion_comprobanteDom_container" style="display: none">
                        <button value="comprobanteDomicilio" id="registro_Digitalizacion_comprobanteDom_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
            </tr>
            <tr>
                <td>ACTA CONSTITUTIVA (S&oacute;lo la primer hoja, 4 MB M&Aacute;XIMO)</td>
                <td></td>
                <td>PODER NOTARIAL (S&oacute;lo la hoja donde viene el nombre del representante legal, 4 MB M&Aacute;XIMO)</td>
                <td></td>
                <td>IDENTIFICACION (500 KB M&Aacute;XIMO)</td>
            </tr>
            <tr>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_actaCons" name="registro_Digitalizacion_actaCons" accept="application/pdf" />
                    <span id="registro_Digitalizacion_actaCons_container" style="display: none">
                        <button value="actaConstitutiva" id="registro_Digitalizacion_actaCons_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
                <td></td>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_poderNotarial" name="registro_Digitalizacion_poderNotarial" accept="application/pdf" />
                    <span id="registro_Digitalizacion_poderNotarial_container" style="display: none">
                        <button value="poderNotarial" id="registro_Digitalizacion_poderNotarial_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
                <td></td>
                <td align="left">
                    <input type="file" id="registro_Digitalizacion_identificacion" name="registro_Digitalizacion_identificacion" accept="application/pdf" />
                    <span id="registro_Digitalizacion_identificacion_container" style="display: none">
                        <button value="identificacion" id="registro_Digitalizacion_identificacion_containerBoton" class="descargaDocumento" >Descarga</button>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="6" align="center"><button id="registro_Digitalizacion_btnGuarda" name="registro_Digitalizacion_btnGuarda">Guardar Documentos</button></td>
            </tr>
        </table>
    </fieldset>
    <iframe frameborder="0" id="registro_Digitalizacion_iframeTarget" name="registro_Digitalizacion_iframeTarget" width="0" height="0" ></iframe>
    
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
