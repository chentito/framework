
<!-- Estilos -->
{foreach from=$estilos item=estilo}
    <link rel="stylesheet" type="text/css" media="screen" href="{$estilo}" />
{/foreach}

<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

<fieldset class="ui-widget ui-widget-content">
    <form method="post" id="capacitacion_Digitalizacion_DatosPieza_form" name="capacitacion_Digitalizacion_DatosPieza_form">
        <input type="hidden" id="capacitacion_Digitalizacion_DatosPieza_idReg" name="capacitacion_Digitalizacion_DatosPieza_idReg" value="{$idReg}" />
        <legend><b>Validaci&oacute;n Certificado</b></legend>
        <table width="100%">
            <tr>
                <td width="50%">Terminal ID:</td>
                <td width="50%">Company Code:</td>
            </tr>
            <tr>
                <td align="center"><input type="text" value="{$terminalID}" id="capacitacion_Digitalizacion_DatosPieza_terminalID" name="capacitacion_Digitalizacion_DatosPieza_terminalID" maxlength="50" size="30" /></td>
                <td align="center"><input type="text" value="{$companyCode}" id="capacitacion_Digitalizacion_DatosPieza_companyCode" name="capacitacion_Digitalizacion_DatosPieza_companyCode" maxlength="50" size="30" /></td>
            </tr>
            <tr>
                <td>Usuario Inpart:</td>
                <td>Contrase&ntilde;a Inpart:</td>
            </tr>
            <tr>
                <td align="center"><input type="text" value="{$usuarioInpart}" id="capacitacion_Digitalizacion_DatosPieza_usuarioInpart" name="capacitacion_Digitalizacion_DatosPieza_usuarioInpart" maxlength="50" size="30" /></td>
                <td align="center"><input type="text" value="{$passwordInpart}" id="capacitacion_Digitalizacion_DatosPieza_contrasenaInpart" name="capacitacion_Digitalizacion_DatosPieza_contrasenaInpart" maxlength="50" size="30" /></td>
            </tr>
            <tr>
                <td>Usuario Audaclaims Gold:</td>
                <td>Contrase&ntilde;a Audaclaims Gold:</td>
            </tr>
            <tr>
                <td align="center"><input type="text" value="{$usuario}" id="capacitacion_Digitalizacion_DatosPieza_usuarioAudaclaims" name="capacitacion_Digitalizacion_DatosPieza_usuarioAudaclaims" maxlength="50" size="30" /></td>
                <td align="center"><input type="text" value="{$password}" id="capacitacion_Digitalizacion_DatosPieza_contrasenaAudaclaims" name="capacitacion_Digitalizacion_DatosPieza_contrasenaAudaclaims" maxlength="50" size="30" /></td>
            </tr>
        </table>
    </form>
</fieldset>

