<form id="formDatosFormatoReporteCrediticio" name="formDatosFormatoReporteCrediticio" method="post">
    <table width="100%" class="ui-widget ui-widget-content">    
        <input type="hidden" id="formDescargaFormatos_idSolicitud" name="formDescargaFormatos_idSolicitud" value="{$idSolicitud}">
        <input type="hidden" id="formDescargaFormatos_tipo" name="formDescargaFormatos_tipo" value="3">
        <tr>
            <td>Cliente:</td>
            <td>RFC:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$cliente}" id="formReporteCrediticio_nombre" name="formReporteCrediticio_nombre" style="width: 85%" /></td>
            <td><input type="text" value="{$rfc}" id="formReporteCrediticio_rfc" name="formReporteCrediticio_rfc" style="width: 40%" /></td>
        </tr>
        <tr>
            <td>Domicilio y tel&eacute;fono:</td>
            <td>Solicitante:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$domicilioTelefono}" id="formReporteCrediticio_domYtel" name="formReporteCrediticio_domYtel" style="width: 85%" /></td>
            <td><input type="text" value="{$solicitante}" id="formReporteCrediticio_solicitante" name="formReporteCrediticio_solicitante" style="width: 85%" /></td>
        </tr>
        <tr>
            <td>Fecha Consulta:</td>
            <td>Folio Consulta:</td>
        </tr>
        <tr>
            <td><input type="text" value="{$fechaConsulta}" id="formReporteCrediticio_fechaConsulta" name="formReporteCrediticio_fechaConsulta" style="width: 85%" /></td>
            <td><input type="text" value="{$folioConsulta}" id="formReporteCrediticio_folioConsulta" name="formReporteCrediticio_folioConsulta" style="width: 40%" /></td>
        </tr>    
    </table>
</form>
