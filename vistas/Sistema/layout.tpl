
<!-- Estilos -->
{foreach from=$estilos item=estilo}
    <link rel="stylesheet" type="text/css" media="screen" href="{$estilo}" />
{/foreach}

<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

<br />
<fieldset class="ui-widget ui-widget-content">
    <legend><b>Exportar Layout:</b></legend>
    <form id="exportaLayout_form" name="exportaLayout_form">
        <table width="100%">
            <tr>
                <td>Seleccione:</td>
                <td>Fecha Inicial:</td>
                <td><input readonly="readonly" id="exportaLayout_fechaInicial" name="exportaLayout_fechaInicial" /></td>
                <td>Fecha Final:</td>
                <td><input readonly="readonly" id="exportaLayout_fechaFinal" name="exportaLayout_fechaFinal" /></td>
                <td width="50%"><button id="exportaLayout_btnExportar" name="exportaLayout_btnExportar">Exportar</button></td>
                <td></td>
            </tr>
        </table>
    </form>
</fieldset>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
