
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

<form method="POST" enctype="multipart/form-data" action="/Inventarios/guardaEdicionItemInventario/" target="editaInventarios_iframeEnvio" id="inventarioIndividualEdicion" name="inventarioIndividualEdicion">
<fieldset class="ui-widget ui-widget-content" >
    <legend>{$textoCargaIndividual}</legend>
    <div id="contenedorCargaIndividual" >
        <table width="100%">
            <tr>
                <td align="center">{$seleccioneAlmacen}&nbsp;&nbsp;{$cmbAlmacenes}</td>
                <td align="center">{$seleccioneCliente}&nbsp;&nbsp;{$cmbClientes}</td>
            </tr>
        </table>        
        <table width="100%">            
            <tr>
                <td>{$txtCargaIndNombre}</td>
                <td>
                    <input type="text" id="editaInventariosInd_nombre" name="editaInventariosInd_nombre" maxlength="100" value="{$valItemEdita_nombre}" />
                    <input type="hidden" id="editaInventariosInd_id" name="editaInventariosInd_id" value="{$valItemEdita_id}" />
                </td>
                <td>{$txtCargaIndDescripcion}</td>
                <td><input type="text" id="editaInventariosInd_descripcion" name="editaInventariosInd_descripcion" maxlength="250"value="{$valItemEdita_descripcion}"  /></td>
                <td>{$txtCargaIndMarca}</td>
                <td><input type="text" id="editaInventariosInd_marca" name="editaInventariosInd_marca" maxlength="100" value="{$valItemEdita_marca}" /></td>
            </tr>
            <tr>
                <td>{$txtCargaIndSerie}</td>
                <td><input type="text" id="editaInventariosInd_serie" name="editaInventariosInd_serie" maxlength="100" value="{$valItemEdita_serie}" /></td>
                <td>{$txtCargaIndIMEI}</td>
                <td><input type="text" id="editaInventariosInd_imei" name="editaInventariosInd_imei" maxlength="100" value="{$valItemEdita_imei}" /></td>
                <td>{$txtCargaIndResponsable}</td>
                <td><input type="text" id="editaInventariosInd_responsable" name="editaInventariosInd_responsable" maxlength="100" value="{$valItemEdita_responsable}"/></td>
            </tr>
            <tr>
                <td>{$txtCargaIndEstado}</td>
                <td><input type="text" id="editaInventariosInd_estado" name="editaInventariosInd_estado" maxlength="100" value="{$valItemEdita_estado}" /></td>
                <td>{$txtCargaIndSKU}</td>
                <td><input type="text" id="editaInventariosInd_sku" name="editaInventariosInd_sku" maxlength="200" value="{$valItemEdita_sku}" /></td>
                <td>{$txtCargaIndModelo}</td>
                <td><input type="text" id="editaInventariosInd_modelo" name="editaInventariosInd_modelo" maxlength="200" value="{$valItemEdita_modelo}" /></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>{$txtCargaIndTalla}</td>
                <td><input type="text" id="editaInventariosInd_talla" name="editaInventariosInd_talla" maxlength="100" value="{$valItemEdita_talla}" /></td>
                <td>{$txtCargaIndPeso}</td>
                <td><input type="text" id="editaInventariosInd_peso" name="editaInventariosInd_peso" maxlength="100" value="{$valItemEdita_peso}" /></td>
                <td>{$txtCargaIndUPeso}</td>
                <td>{$cmbUnidadPeso}</td>
            </tr>
            <tr>
                <td>{$txtCargaIndCapacidad}</td>
                <td><input type="text" id="editaInventariosInd_capacidad" name="editaInventariosInd_capacidad" maxlength="100" value="{$valItemEdita_capacidad}" /></td>
                <td>{$txtCargaIndCosto}</td>
                <td><input type="text" id="editaInventariosInd_costo" name="editaInventariosInd_costo" value="{$valItemEdita_costo}" /></td>
                <td>{$txtCargaIndMoneda}</td>
                <td><input type="text" id="editaInventariosInd_moneda" name="editaInventariosInd_moneda" maxlength="20" value="{$valItemEdita_moneda}" /></td>
            </tr>
            <tr>
                <td>{$txtCargaIndUMedida}</td>
                <td>{$cmbuMedida}</td>
                <td>{$txtCargaIndAlto}</td>
                <td><input type="text" id="editaInventariosInd_alto" name="editaInventariosInd_alto" maxlength="100" value="{$valItemEdita_alto}" /></td>
                <td>{$txtCargaIndAncho}</td>
                <td><input type="text" id="editaInventariosInd_ancho" name="editaInventariosInd_ancho" maxlength="100" value="{$valItemEdita_ancho}" /></td>
            </tr>
            <tr>
                <td>{$txtCargaIndLargo}</td>
                <td><input type="text" id="editaInventariosInd_largo" name="editaInventariosInd_largo" maxlength="100" value="{$valItemEdita_largo}" /></td>
                <td>{$txtCargaIndSabor}</td>
                <td><input type="text" id="editaInventariosInd_sabor" name="editaInventariosInd_sabor" maxlength="100" value="{$valItemEdita_sabor}" /></td>
                <td>{$txtCargaIndColor}</td>
                <td><input type="text" id="editaInventariosInd_color" name="editaInventariosInd_color" maxlength="100" value="{$valItemEdita_color}" /></td>
            </tr>
            <tr>
                <td>{$txtCargaIndRack}</td>
                <td><input type="text" id="editaInventariosInd_rack" name="editaInventariosInd_rack" maxlength="100" value="{$valItemEdita_rack}" /></td>
                <td>{$txtCargaIndPRack}</td>
                <td><input type="text" id="editaInventariosInd_posicionRack" name="editaInventariosInd_posicionRack" maxlength="100" value="{$valItemEdita_posicionRack}" /></td>
            </tr>
            <tr>
                <td>{$seleccioneImagen}</td>
                <td><input type="file" id="editaInventarios_ImagenAdjuntar" name="editaInventarios_ImagenAdjuntar" accept=".jpg" /></td>
                <td></td>
                <td><input type="hidden" id="editaInventariosInd_rutaFinalImg" name="editaInventariosInd_rutaFinalImg" /><input type="hidden" id="altaInventarios_comboAlmacenes1" name="altaInventarios_comboAlmacenes1" /><input type="hidden" id="altaInventarios_comboClientes1" name="altaInventarios_comboClientes1" /></td>
            </tr>
        </table>
    </div>
    <iframe width="0" height="0" frameborder="0" id="editaInventarios_iframeEnvio" name="editaInventarios_iframeEnvio"></iframe>
</fieldset>
</form>

{literal}
    <script>
        function cargaCombos(){
            $( '#altaInventarios_comboClientes' ).val( '{/literal}{$valItemEdita_cliente}{literal}' );
            $( '#altaInventarios_comboAlmacenes' ).val( '{/literal}{$valItemEdita_almacen}{literal}' );
            $( '#altaInventariosInd_unidadPeso' ).val( '{/literal}{$valItemEdita_unidadPeso}{literal}' );
            $( '#altaInventariosInd_uMedida' ).val( '{/literal}{$valItemEdita_unidadMedida}{literal}' );
        }
        cargaCombos();
    </script>
{/literal}
