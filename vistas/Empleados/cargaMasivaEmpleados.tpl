
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

<fieldset class="ui-widget ui-widget-content">
    <legend>{$indicaciones}</legend>
    <form method="POST" enctype="multipart/form-data" action="/Empleados/procesaAltaEmpleados/" target="altaEmpleados_iframeEnvio" id="altaEmpleados_Formulario">
        <table width="100%">
            <tr>
                <td align="center">{$seleccioneCliente}&nbsp;&nbsp;{$cmbClientes}</td>
            </tr>
        </table>        
        <fieldset class="ui-widget ui-widget-content" id="altaEmpleados_MetodoEntradaMasiva">
            <legend>{$textoCargaMasivaEmpleados} &nbsp;&nbsp;</legend>
            <div id="contenedorCargaMasivaEmpleados">
                <table width="100%">
                    <tr>
                        <td colspan="2">{$seleccioneLayoutEmpleados}&nbsp;&nbsp;
                            <input type="file" id="altaEmpleados_LayoutAdjuntar" name="altaEmpleados_LayoutAdjuntar" accept=".csv" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button id="altaEmpleados_botonAdjuntaLayout" onclick="return procesaAltaMasivaLayoutEmpleados();">{$textoBotonAltaLayoutEmpleados}</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {$gridTemporalEmpleados}
                        </td>
                    </tr>
                </table>
            </div>
        </fieldset>        
	</form>
    <iframe width="0" height="0" frameborder="0" id="altaEmpleados_iframeEnvio" name="altaEmpleados_iframeEnvio"></iframe>
</fieldset>
        
<br />

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

