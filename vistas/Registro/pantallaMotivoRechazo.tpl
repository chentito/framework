{literal}
    <script>$( '#cancelaSolicitudMotivoRechazo_adjunto' ).button();</script>
{/literal}
<form id="cancelaSolicitud_form" name="cancelaSolicitud_form" method="post" enctype="multipart/form-data" action="/Registro/guardaRechazoSolicitud/" target="hiddenRechazoSolicitudContainer">
    <input type="hidden" name="cancelaSolicitudMotivoRechazo_idSolicitud" id="cancelaSolicitudMotivoRechazo_idSolicitud" value="{$idSolicitud}" />
    <input type="hidden" name="cancelaSolicitudMotivoRechazo_val" id="cancelaSolicitudMotivoRechazo_val" value="0" />
    <table>
        <tr>
            <td valign="top">Motivo Rechazo:</td>
            <td><textarea id="cancelaSolicitudMotivoRechazo" name="cancelaSolicitudMotivoRechazo" rows="2" cols="40"></textarea></td>
        </tr>
        <tr>
            <td valign="top">Adjunto:</td>
            <td><input type="file" id="cancelaSolicitudMotivoRechazo_adjunto" name="cancelaSolicitudMotivoRechazo_adjunto" /></td>
        </tr>
    </table>
    <iframe width="0" height="0" frameborder="0" id="hiddenRechazoSolicitudContainer" name="hiddenRechazoSolicitudContainer"></iframe>
</form>
