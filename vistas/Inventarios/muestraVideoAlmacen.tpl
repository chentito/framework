
<!-- Estilos -->
{foreach from=$estilos item=estilo}
    <link rel="stylesheet" type="text/css" media="screen" href="{$estilo}" />
{/foreach}

<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

<!-- Contenido -->
<fieldset class="ui-widget ui-widget-content">
    <table width="100%">
        <tr>
            <td>URL:</td>
            <td>{$path}</td>
            <td>Usuario:</td>
            <td>{$usuario}</td>
            <td>Contrase&ntilde;a:</td>
            <td>{$contrasena}</td>
        </tr>
    </table>
</fieldset>
<br />
<iframe src="{$path}" frameborder="0" width="100%" height="400"></iframe>
<br />
<!-- Contenido -->

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

