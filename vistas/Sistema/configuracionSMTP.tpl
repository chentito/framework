
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
    <legend>{$legend}</legend>
    <form id="sistema_formConfig" name="sistema_formConfig">
        <table width="100%">
            <tr>
                <td>{$servidor}</td>
                <td><input type="text" value="{$servidorValue}" id="sistema_configSMTP_servidor" name="sistema_configSMTP_servidor" maxlength="100" /></td>
                <td>{$usuario}</td>
                <td><input type="text" value="{$usuarioValue}" id="sistema_configSMTP_usuario" name="sistema_configSMTP_usuario" maxlength="100" /></td>
                <td>{$passwd}</td>
                <td><input type="password" value="{$passwdValue}" id="sistema_configSMTP_passwd" name="sistema_configSMTP_passwd" maxlength="100" /></td>
            </tr>
            <tr>
                <td>{$puerto}</td>
                <td><input type="text" value="{$puertoValue}" id="sistema_configSMTP_puerto" name="sistema_configSMTP_puerto" maxlength="6" /></td>
                <td>{$seguridad}</td>
                <td>
                    <select id="sistema_configSMTP_seguridad" name="sistema_configSMTP_seguridad">
                        <option value="">Ninguna</option>
                        <option value="STARTTLS">STARTTLS</option>
                        <option value="SSL/TLS">SSL/TLS</option>
                    </select>
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>{$de}</td>
                <td><input type="text" value="{$deValue}" id="sistema_configSMTP_de" name="sistema_configSMTP_de" maxlength="100" /></td>
                <td>{$deNombre}</td>
                <td><input type="text" value="{$deNombreValue}" id="sistema_configSMTP_deNombre" name="sistema_configSMTP_deNombre" maxlength="100" /></td>
                <td>{$copiaA}</td>
                <td><input type="text" value="{$copiaAValue}" id="sistema_configSMTP_copia" name="sistema_configSMTP_copia" maxlength="100" /></td>
            </tr>
            <tr></tr>
            <tr>
                <td colspan="3" align="center"><button id="sistema_configSMTP_btnGuarda">{$guardaConf}</button></td>
                <td colspan="3" align="center"><button id="sistema_configSMTP_btnPrueba">{$pruebaConf}</button></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="3" align="center">
                    <div id="sistema_configSMTP_contenedorPrueba" >
                        {$enviaPrueba} <input type="text" id="sistema_configSMTP_enviarPruebaA" name="sistema_configSMTP_enviarPruebaA" value="" />&nbsp;&nbsp;
                        <button id="sistema_configSMTP_pruebaEnvia">{$enviarBtn}</button>&nbsp;
                        <button id="sistema_configSMTP_pruebaCancela">{$cancelaBtn}</button>
                    </div>
                    <div id="sistema_configSMTP_contenedorPruebaEnviando">
                        {$enviandoTexto}<br />
                        <img src="{$path}/assets/imgs/ajax-loader.gif" />
                    </div>
                </td>
            </tr>
            <input type="hidden" id="sistema_configSMTP_testing" name="sistema_configSMTP_testing" value="{$testing}" />
        </table>
    </form>
</fieldset>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
