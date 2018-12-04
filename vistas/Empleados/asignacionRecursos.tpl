
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
<fieldset class="ui-widget ui-widget-content">
    <legend>{$encabezadoAsignacionR}</legend>
    <table width="100%">
        <tr>
            <td>{$txtSelCliente}</td>
            <td>{$comboListadoClientes}</td>
            <td>{$seleccionaEmpleado}</td>
            <td>
                <input type="text" id="asignaRecurso_seleccionaEmpleado" name="asignaRecurso_seleccionaEmpleado" />
                <input type="hidden" id="asignaRecurso_seleccionaEmpleadoHidden" name="asignaRecurso_seleccionaEmpleadoHidden" />
            </td>
            <td>{$seleccionaItem}</td>
            <td>
                <input type="text" id="asignaRecurso_seleccionaItem" name="asignaRecurso_seleccionaItem" />
                <input type="hidden" id="asignaRecurso_seleccionaItemHidden" name="asignaRecurso_seleccionaItemHidden" />
            </td>
        </tr>
        <tr>
            <td>{$fechaInicial}</td>
            <td>
                <input type="text" value="{$fechaActual}" id="asignaRecurso_fechaInicioAsigna" name="asignaRecurso_fechaInicioAsigna" readonly />
                &nbsp;&nbsp;&nbsp;
                Indefinido?
                <input type="checkbox" id="asignaRecurso_tiempoIndefinido" />
            </td>
            <td>{$fechaFinal}</td>
            <td><input type="text" id="asignaRecurso_fechaFinAsigna" name="asignaRecurso_fechaFinAsigna" readonly /></td>
        </tr>
        <tr>
            <td colspan="6" align="center"><button id="asignaRecurso_guardaAsignacion">{$btnGuardaAsignacion}</button></td>
        </tr>
    </table>
</fieldset>
<br />
<fieldset class="ui-widget ui-widget-content">
    <legend>{$tituloAsignaciones}</legend>
    {$gridAsignaciones}
</fieldset>
<!-- Contenido -->

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

