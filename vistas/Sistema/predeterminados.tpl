
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
<form id="predeterminados_form" name="predeterminados_form">
    <table width="100%" class="ui-widget ui-widget-content">
        <tr>
            <th width="15%">CLAVE</th>
            <th width="50%">DESCRIPCION</th>
            <th width="15%">VALOR</th>
            <th width="20%">SECCION</th>
        </tr>
        {foreach $registros as $registro}
        <tr>
            <td align="center">{$registro.clave}</td>
            <td>{$registro.descripcion}</td>
            <td align="center"><input type="text" id="{$registro.clave}" name="{$registro.clave}" value="{$registro.valor}" /></td>
            <td align="center">{$registro.modulo}</td>
        </tr>
        {/foreach}
        <tr>
            <td colspan="4" align="center"><button id="predeterminados_guardaInfo">Guardar datos predefinidos</button></td>
        </tr>
    </table>
</form>
<!-- Contenido -->

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

