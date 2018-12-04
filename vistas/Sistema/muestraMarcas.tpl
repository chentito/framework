
<fieldset class="ui-widget ui-widget-content">
    <legend>Uso de marcas:</legend>
    <form name="formularioUsoMarcasPorUsuario" id="formularioUsoMarcasPorUsuario" method="POST" action="#">
        <input type="hidden" name="marcasUsarUsuarioId" id="marcasUsarUsuarioId" value="{$idUsuario}" />
        <table width="100%">
            <tr>                
                <td>ID Usuario:</td>
                <td>{$idUsuario}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    {$html}
                </td>
            </tr>
        </table>
    </form>
</fieldset>
