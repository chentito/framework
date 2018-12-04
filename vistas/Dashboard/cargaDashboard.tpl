
<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

{literal}<script>{/literal}{$jsGrafica1}{literal}</script>{/literal}

<fieldset class="ui-widget ui-widget-content">
    <table width="100%" >
        <tr>
            <td width="100%">
                <fieldset class="ui-widget ui-widget-content">
                    <legend><b>Clientes por mes</b></legend>
                    <div style="height: 200px;" id="{$grafica1}"></div>
                </fieldset>
            </td>
        </tr>
        {if $esAdmin=="user" }
            <tr>
                <td width="100%">
                    <br />
                    <br />
                    <fieldset class="ui-widget ui-widget-content">
                        <legend><b>Avance:</b></legend>
                        <center>
                            <div id="progressbar"></div>
                            <table width="100%">
                                <tr>
                                    <td width="25%" align="center"><i><b>Alta de registro</b></i></td>
                                    <td width="25%" align="center"><i><b>Descarga de formatos</b></i></td>
                                    <td width="25%" align="center"><i><b>Digitalizaci&oacute;n de documentos</b></i></td>
                                    <td width="25%" align="center"><i><b>Carga de certificado</b></i></td>
                                </tr>
                            </table>
                        </center>
                    </fieldset>
                </td>
            </tr>
        {/if}
    </table>
    <input type="hidden" id="cargaDashboard_avance" name="cargaDashboard_avance" value="{$avance}" />
</fieldset>

{literal}
    <script>progressBar();</script>
{/literal}
