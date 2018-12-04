<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

<input type="hidden" id="validacionSolicitud_idSolicitud" name="validacionSolicitud_idSolicitud" value="{$idSolicitud}" />
<table width="100%" height="100%" >
    <tr height="50%">
        <td width="50%" class="ui-widget ui-widget-content descargaSolicitud" style="cursor:pointer; text-align: center">
            <p>Solicitud</p>
        </td>
        <td width="50%" class="ui-widget ui-widget-content descargaReporteCrediticio" style="cursor:pointer; text-align: center">
            <p>Reporte Crediticio</p>
        </td>
    </tr>
    <tr>
        <td class="ui-widget ui-widget-content descargaReferenciasComerciales" style="cursor:pointer; text-align: center">
            <p>Referencias Comerciales</p>
        </td>
        <td class="ui-widget ui-widget-content descargaDomiciliacion" style="cursor:pointer; text-align: center">
            <p>Domiciliacion</p>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2">No. Cliente: &nbsp;<input type="text" id="validaSolicitud_noClienteAudatex" name="validaSolicitud_noClienteAudatex" maxlength="50" /></td>
    </tr>
</table>
