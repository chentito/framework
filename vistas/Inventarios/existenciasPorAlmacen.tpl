
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

<!-- Contenido -->
<!--fieldset class="ui-widget ui-widget-content">
    <legend>Alta de Existencias</legend>
    <table width="100%">
        <tr>
            <td>{$txtSelCli}</td>
            <td>{$comboSelClientes}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>{$txtSelSKU}</td>
            <td>
                <input type="text" name="existencias_busquedaSKU" id="existencias_busquedaSKU" />
                <input type="hidden" name="existencias_busquedaSKUhidden" id="existencias_busquedaSKUhidden" />
            </td>
            <td>{$txtSelAlmacen}</td>
            <td>{$comboSelAlmacen}</td>
            <td>{$txtCantSurtir}</td>
            <td><input type="text" name="existencias_cantidad" id="existencias_cantidad" maxlength="100" /></td>
        </tr>
        <tr>
            <td colspan="6" align="center"><button id="existencias_btnAgrega">{$txtAgregaExistencias}</button></td>
        </tr>
    </table>
</fieldset-->
        
<!-- Contenido -->
<fieldset class="ui-widget ui-widget-content">
    <legend>Alta de Existencias</legend>
    <table width="100%">
        <tr>
            <td width="25%">{$txtSelSKU}</td>
            <td width="25%"><input type="text" value="" id="nvoExistencias_skuSurtir" name="nvoExistencias_skuSurtir" /></td>
            <td width="25%"></td>
            <td width="25%"><button id="btnNew_agregaExistencias">Buscar Registro</button></td>            
        </tr>
        <tr>
            <td colspan="4">
                <div id="nvoSurtidoContenedor" name="nvoSurtidoContenedor">
                    
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

