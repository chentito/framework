<fieldset class="ui-widget ui-widget-content">
    <legend><b>Autorizar traslado</b></legend>
    <table width="100%">
        <tr>
            <td width="20%">Origen:</td>
            <td width="20%">{$origen}</td>
            <td width="60%" rowspan="4">
                Comentarios:<br>
                <textarea cols="50" id="observacionesTrasladoAplicar" name="observacionesTrasladoAplicar">{$comentarios}</textarea>
                <input type="hidden" id="idTrasladoAplicar" name="idTrasladoAplicar" value="{$idTraslado}" />
            </td>
        </tr>
        <tr>
            <td>Destino:</td>
            <td>{$destino}</td>
        </tr>
        <tr>
            <td>Layout/SKU:</td>
            <td>{$layout}</td>
        </tr>        
        <tr>
            <td>Elementos a trasladar:</td>
            <td>{$total}</td>
        </tr>        
    </table>
</fieldset>
