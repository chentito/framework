
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

<fieldset class="ui-widget ui-widget-content">
    <legend><b>Informaci&oacute;n Vale</b></legend>
    <form id="formDatosValeEntrada_Inventarios" name="formDatosValeEntrada_Inventarios">        
        <table width="100%">
            <tr>
                <td>Motivo del Movimiento</td>
                <td>{$comboMovimientos}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>No. Pedido:</td>
                <td><input type="text" id="valeEntradaSalida_noPedido" name="valeEntradaSalida_noPedido" maxlength="250" value="{$noPedido}" /></td>
                <td>Fecha Pedido:</td>
                <td><input type="text" id="valeEntradaSalida_fechaPedido" name="valeEntradaSalida_fechaPedido" readonly="readonly" value="{$fechaPedido}" /></td>
            </tr>
            <tr>
                <td>Nombre Solicitante</td>
                <td><input type="text" id="valeEntradaSalida_solicitante" name="valeEntradaSalida_solicitante" maxlength="100" value="{$solicitante}" /></td>
                <td>Nombre Autorizante</td>
                <td><input type="text" id="valeEntradaSalida_autorizante" name="valeEntradaSalida_autorizante" maxlength="100" value="{$autorizante}" /></td>
            </tr>
            <tr>
                <td>Nombre de quien recoge:</td>
                <td><input type="text" id="valeEntradaSalida_nombreRecoge" name="valeEntradaSalida_nombreRecoge" maxlength="100" value="{$nombreQuienRecoge}" /></td>
                <td>Nombre de quien recibe:</td>
                <td><input type="text" id="valeEntradaSalida_nombreRecibe" name="valeEntradaSalida_nombreRecibe" maxlength="100" value="{$nombreQuienRecibe}" /></td>
            </tr>
            <tr>
                <td>Nombre guardia:</td>
                <td><input type="text" id="valeEntradaSalida_nombreGuardia" name="valeEntradaSalida_nombreGuardia" maxlength="100" value="{$nombreGuardia}" /></td>
                <td>Fecha Movimiento:</td>
                <td><input type="text" id="valeEntradaSalida_fechaMovimiento" name="valeEntradaSalida_fechaMovimiento" readonly="readonly" value="{$fechaMovimiento}" /></td>
            </tr>
            <tr>
                <td>Observaciones</td>
                <td>
                    <textarea id="valeEntradaSalida_observaciones" name="valeEntradaSalida_observaciones" cols="40" rows="2">{$observaciones}</textarea>
                    <input type="hidden" id="valeEntradaSalida_IDMovimiento" name="valeEntradaSalida_IDMovimiento" value="{$idMov}" />
                    <input type="hidden" id="valeEntradaSalida_creado" name="valeEntradaSalida_creado" value="{$creado}" />
                </td>
                <td>Movimientos:</td>
                <td>
                    <select name="valeEntradaSalida_IDMovimientos[]" id="valeEntradaSalida_IDMovimientos[]" multiple="multiple" style="height: 80px; width: 90px" >
                        {foreach from=$todos key=k item=a}
                            {if @in_array($k, $selectMovs)}
                                {assign var=v value=true}
                            {else}
                                {assign var=v value=false}
                            {/if}
                            <option value="{$a}"{if $v} selected="selected"{/if}>{$k}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        </table>
    </form>
</fieldset>

    {literal}<script type="text/javascript">verificaTipoMovimiento();</script>{/literal}
                    
{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
