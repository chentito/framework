<form id="formDatosFormatoDomiciliacion" name="formDatosFormatoDomiciliacion" method="post">
    <table width="100%" class="ui-widget ui-widget-content">    
        <input type="hidden" id="formDescargaFormatos_idSolicitud" name="formDescargaFormatos_idSolicitud" value="{$idSolicitud}">
        <input type="hidden" id="formDescargaFormatos_tipo" name="formDescargaFormatos_tipo" value="1">
        <tr>
            <td>Cliente (Nombre Fiscal):</td>
            <td>Nombre Comercial:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$clienteNombreFiscal}" id="formDomiciliacion_nombreFiscal" name="formDomiciliacion_nombreFiscal" style="width: 85%" /></td>
            <td><input type="text" value="{$clienteNombreComercial}" id="formDomiciliacion_nombreComercial" name="formDomiciliacion_nombreComercial" style="width: 85%" /></td>
        </tr>
        <tr>
            <td>RFC:</td>
            <td>Representante/Titular Cuenta:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$rfc}" id="formDomiciliacion_rfc" name="formDomiciliacion_rfc" style="width: 40%" maxlength="13" /></td>
            <td><input type="text" value="{$titularCuenta}" id="formDomiciliacion_titularCuenta" name="formDomiciliacion_titularCuenta" style="width: 85%" /></td>
        </tr>
        <tr>
            <td>Banco:</td>
            <td>Terminacion cuenta:</td>
        </tr>
        <tr>
            <td>
                <select id="formDomiciliacion_banco" name="formDomiciliacion_banco">
                    {foreach key=key item=item from=$bancos}
                        {if $banco == $item.id }
                            <option value="{$item.id}" selected="selected">{$item.texto}</option>
                        {else}
                            <option value="{$item.id}">{$item.texto}</option>
                        {/if}
                    {/foreach}
                </select>
            </td>
            <td><input type="text" value="{$terminacionCuenta}" id="formDomiciliacion_terminacionCuenta" name="formDomiciliacion_terminacionCuenta" style="width: 20%" maxlength="4" /></td>
        </tr>
        <tr>
            <td>Sucursal:</td>
            <td>Clabe:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$sucursal}" id="formDomiciliacion_sucursal" name="formDomiciliacion_sucursal" style="width: 85%" /></td>
            <td><input type="text" value="{$clabe}" id="formDomiciliacion_clabe" name="formDomiciliacion_clabe" style="width: 85%" maxlength="18" /></td>
        </tr>
        <tr>
            <td>Representante Legal:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$representanteLegal}" id="formDomiciliacion_representanteLegal" name="formDomiciliacion_representanteLegal" style="width: 85%" /></td>
        </tr>
    </table>
</form>
