
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
<!--table width="100%">
        <tr>
            <td width="50%" colspan="2" align="center">{$txtSelAlmaSalida}</td>
            <td width="50%" colspan="2" align="center">{$txtSelAlmaEntrada}</td>
        </tr>
        <tr>
            <td width="50%" colspan="2" align="center">{$comboAlmaSalida}</td>
            <td width="50%" colspan="2" align="center">{$comboAlmaEntrada}</td>            
        </tr>
</table>
<br /-->

<fieldset class="ui-widget ui-widget-content">
    <legend>{$tituloMovAlmacenes}</legend>
    <table width="100%">       
        <tr>
            <td width="50%" colspan="2" align="center">{$txtSelAlmaSalida}</td>
            <td width="50%" colspan="2" align="center">{$txtSelAlmaEntrada}</td>            
        </tr>
        <tr>
            <td width="50%" colspan="2" align="center">{$comboAlmaSalida}</td>
            <td width="50%" colspan="2" align="center">{$comboAlmaEntrada}</td>            
        </tr>
        <tr>
            <td width="25%">{$txtSeleccioneLoteLayout}</td>
            <td width="75%" colspan="3" align="left">{$comboLayoutsLotes}</td>
        </tr>
        <tr>
            <td colspan="4" align="center"><button id="movInventarios_botonTraspaso">{$txtRealizaTraspaso}</button></td>
        </tr>
    </table>    
</fieldset>

<br />

<!--fieldset class="ui-widget ui-widget-content">
    <legend>{$tituloMovIndAlmacenes}</legend>
    <table width="100%">
        <tr>
            <td width="25%">{$txtBusquedaSKU}</td>
            <td width="25%" align="left">
                <input type="text" id="movInventarios_busquedaSKU" name="movInventarios_busquedaSKU" maxlength="100" />
                <input type="hidden" id="movInventarios_busquedaSKUhidden" name="movInventarios_busquedaSKUhidden" maxlength="100" />
            </td>
            <td width="25%">{$txtBusquedaSKUPiezas}</td>
            <td width="25%"><input type="text" id="movInventarios_busquedaSKUPiezas" name="movInventarios_busquedaSKUPiezas" value="1" /></td>
        </tr>
        <tr>
            <td colspan="4" align="center"><button id="movInventarios_botonTraspasoInd">{$txtRealizaTraspasoInd}</button></td>
        </tr>
    </table>
</fieldset-->

<fieldset class="ui-widget ui-widget-content">
    <legend>{$tituloMovIndAlmacenes}</legend>
    <table width="100%">
        <tr>
            <td width="25%">{$txtBusquedaSKU}</td>
            <td width="25%" align="left">
                <input type="text" id="movInventariosInd_skuMover" name="movInventariosInd_skuMover" maxlength="100" />                
            </td>
            <td width="25%"><button id="movInventariosInd_BuscarSKU" name="movInventariosInd_BuscarSKU">Buscar SKU</button></td>
            <td width="25%"></td>
        </tr>
        <tr>
            <td colspan="4">
                <div id="nomInventariosInd_detalleSKUBuscado"></div>
            </td>
        </tr>
    </table>
</fieldset>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

