<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

<form id="formDatosFormatoContrato" name="formDatosFormatoContrato" method="post">
    <table width="100%" class="ui-widget ui-widget-content">    
        <input type="hidden" id="formDescargaFormatos_idSolicitud" name="formDescargaFormatos_idSolicitud" value="{$idSolicitud}">
        <input type="hidden" id="formDescargaFormatos_tipo" name="formDescargaFormatos_tipo" value="4">
        <tr>
            <td>Representante Legal:</td>
            <td>Nombre Comercial:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$clienteRepresentanteLegal}" id="formContratos_representanteLegal" name="formContratos_representanteLegal" style="width: 85%" /></td>
            <td><input type="text" value="{$clienteNombreComercial}" id="formContratos_nombreComercial" name="formContratos_nombreComercial" style="width: 85%" /></td>
        </tr>
        <tr>
            <td>Fecha Firma Contrato:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$anio}-{$mes}-{$dia}" id="formContrato_fechaFirmaContrato" name="formContrato_fechaFirmaContrato" /></td>
        </tr>
    </table>
</form>
