
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
    <legend><b>Enviar acceso:</b></legend>
    <table width="100%">
        <tr>
            <td width="20%">Destinatario:</td>
            <td>Email:</td>
            <td><input type="text" maxlength="100" name="envioCredenciales_email" id="envioCredenciales_email" size="50" /></td>
            <td>Nombre:</td>
            <td><input type="text" maxlength="100" name="envioCredenciales_nombre" id="envioCredenciales_nombre" size="50" /></td>
        </tr>
        <tr>
            <td><button id="envioCredenciales_btnGeneraDatos" name="envioCredenciales_btnGeneraDatos">Generar Usuario/Contrase&ntilde;a</button></td>
            <td>Usuario:</td>
            <td><input type="text" maxlength="20" name="envioCredenciales_usuario" id="envioCredenciales_usuario" /></td>
            <td>Contrase&ntilde;a:</td>
            <td><input type="text" maxlength="20" name="envioCredenciales_password" id="envioCredenciales_password" /></td>
        </tr>
        <tr>
            <td colspan="5" align="center"><button id="envioCredenciales_btnEnviarMensaje" name="envioCredenciales_btnEnviarMensaje">Enviar Accesos</button></td>
        </tr>
    </table>
</fieldset>


<br />


<fieldset class="ui-widget ui-widget-content">
    <legend><b>Usuarios:</b></legend>
    <table width="100%">
        <tr class="ui-widget ui-widget-header">
            <th width="20%">Nombre</th>
            <th width="20%">Usuario</th>
            <th width="20%">Contrase&ntilde;a</th>
            <th width="20%">Correo</th>
            <th width="20%">Opciones</th>
        </tr>
    </table>
    <table width="100%" id="envioCredenciales_contenedorUsuarios" name="envioCredenciales_contenedorUsuarios">
    </table>
</fieldset>


{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

