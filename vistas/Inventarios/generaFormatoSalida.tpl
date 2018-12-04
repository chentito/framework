
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
    <form method="POST" id="valeSalida_FORM" name="valeSalida_FORM" >
        <legend><b>Detalle Vale de Salida:</b></legend>
        <table width="100%" cellspacing="1" cellpadding="1" >
            <tr>
                <td width="40%">No. Pedido:</td>
                <td width="60%">
                    <input type="text" name="valeSalida_noPedido" id="valeSalida_noPedido" />
                    <input type="hidden" name="valeSalida_idty" id="valeSalida_idty" value="{$idty}" />
                </td>
            </tr>
            <tr>
                <td>Motivo Salida:</td>
                <td><input type="text" name="valeSalida_motivoSalida" id="valeSalida_motivoSalida" /></td>
            </tr>
            <tr>
                <td>Nombre de quien recoge:</td>
                <td><input type="text" name="valeSalida_nombreRecoge" id="valeSalida_nombreRecoge" /></td>
            </tr>
            <tr>
                <td>Nombre de quien recibe:</td>
                <td><input type="text" name="valeSalida_nombreRecibe" id="valeSalida_nombreRecibe" /></td>
            </tr>
            <tr>
                <td>Nombre guardia:</td>
                <td><input type="text" name="valeSalida_nombreGuardia" id="valeSalida_nombreGuardia" /></td>
            </tr>
        </table>
    </form>
</fieldset>

