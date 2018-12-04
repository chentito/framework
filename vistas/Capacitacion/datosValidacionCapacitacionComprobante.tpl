
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
        <legend><b>Validaci&oacute;n Comprobante Pago</b></legend>
        <table width="100%">
            <tr>
                <td width="50%">Usuario Curso:</td>
                <td width="50%">Contrase&ntilde;a Curso:</td>
            </tr>
            <tr>
                <td align="center"><input type="text" value="{$usuarioCurso}" id="capacitacion_Digitalizacion_DatosPieza_usuarioCurso" name="capacitacion_Digitalizacion_DatosPieza_usuarioCurso" maxlength="50" size="30" /></td>
                <td align="center"><input type="text" value="{$passwordCurso}" id="capacitacion_Digitalizacion_DatosPieza_contrasenaCurso" name="capacitacion_Digitalizacion_DatosPieza_contrasenaCurso" maxlength="50" size="30" /></td>
            </tr>
        </table>
    </form>
</fieldset>

