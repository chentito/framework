
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

<form id="listadoRegistros_form" name="listadoRegistros_form">
    <fieldset class="ui-widget ui-widget-content">
        <legend><b>REGISTROS GENERADOS</b></legend>
        <center><button id="listadoRegistros_btnEliminar" name="listadoRegistros_btnEliminar">Eliminar Registro</button></center>
        <br />
        <table id="tableListadoRegistros" class="display" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Nombre Comercial</th>
                    <th>Nombre Fiscal</th>
                    <th>RFC</th>
                    <th>Fecha Alta</th>                    
                </tr>
            </thead>
            <tbody>                
            </tbody>
        </table>
    </fieldset>

    <br />
</form>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
