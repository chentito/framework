<form id="formDatosFormatoReferenciasComerciales" name="formDatosFormatoReferenciasComerciales" method="post">
    <table width="100%" class="ui-widget ui-widget-content">    
        <input type="hidden" id="formDescargaFormatos_idSolicitud" name="formDescargaFormatos_idSolicitud" value="{$idSolicitud}">
        <input type="hidden" id="formDescargaFormatos_tipo" name="formDescargaFormatos_tipo" value="2">
        <tr>
            <td>Nombre Participante:</td>
            <td>Apellido Paterno Participante:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$nombreParticipante}" id="formReferenciasComerciales_nombreParticipante" name="formReferenciasComerciales_nombreParticipante" style="width: 85%" /></td>
            <td><input type="text" value="{$aPaternoParticipante}" id="formReferenciasComerciales_aPaternoParticipante" name="formReferenciasComerciales_aPaternoParticipante" style="width: 85%" /></td>
        </tr>    
        <tr>
            <td>Apellido Materno Participante:</td>
            <td>Correo Participante:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$aMaternoParticipante}" id="formReferenciasComerciales_aMaternoParticipante" name="formReferenciasComerciales_aMaternoParticipante" style="width: 85%" /></td>
            <td><input type="text" value="{$correoParticipante}" id="formReferenciasComerciales_correoParticipante" name="formReferenciasComerciales_correoParticipante" style="width: 85%" /></td>
        </tr>  
        <tr>
            <td colspan="2" class="ui-widget ui-widget-header" align="center">Informaci&oacute;n llenada por Audatex</td>
        </tr>
        <tr>
            <td>Usuario:</td>
            <td>Contrase&ntilde;a:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$usuario}" id="formReferenciasComerciales_usuario" name="formReferenciasComerciales_usuario" style="width: 85%" {$esAdmin} /></td>
            <td><input type="text" value="{$password}" id="formReferenciasComerciales_contrasena" name="formReferenciasComerciales_contrasena" style="width: 85%" {$esAdmin} /></td>
        </tr>    
        <tr>
            <td>Terminal ID:</td>
            <td>Company Code:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$terminalID}" id="formReferenciasComerciales_terminalID" name="formReferenciasComerciales_terminalID" style="width: 85%" {$esAdmin} /></td>
            <td><input type="text" value="{$companyCode}" id="formReferenciasComerciales_companyCode" name="formReferenciasComerciales_companyCode" style="width: 85%" {$esAdmin} /></td>
        </tr>    
        <tr>
            <td>Usuario Inpart:</td>
            <td>Contrase&ntilde;a Inpart:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$usuarioInpart}" id="formReferenciasComerciales_usuarioInpart" name="formReferenciasComerciales_usuarioInpart" style="width: 85%" {$esAdmin} /></td>
            <td><input type="text" value="{$passwordInpart}" id="formReferenciasComerciales_contrasenaInpart" name="formReferenciasComerciales_contrasenaInpart" style="width: 85%" {$esAdmin} /></td>
        </tr>    
    </table>
</form>
