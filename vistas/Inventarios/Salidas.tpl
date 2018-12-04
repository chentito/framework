
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

<!-- Contenido -->
<br />
<fieldset class="ui-widget ui-widget-content">
    <legend>Salidas de Inventario</legend>
    <table width="100%">
        <tr>
            <td width="25%">{$txtSelSKUSal}</td>
            <td width="25%"><input type="text" value="" id="salidasAlmacen_skuBaja" name="salidasAlmacen_skuBaja" /></td>
            <td width="25%"></td>
            <td width="25%"><button id="btnSaludas_buscaExistenciasParaDescontar">Buscar Registro</button></td>            
        </tr>
        <tr>
            <td colspan="4">
                <div id="opcionesSalidasContenedor" name="opcionesSalidasContenedor">
                    
                </div>
            </td>
        </tr>
    </table>
</fieldset>
<!-- Contenido -->

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
