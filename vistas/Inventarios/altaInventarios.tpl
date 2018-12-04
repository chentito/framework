
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
    <legend>{$indicaciones}</legend>
    <form method="POST" enctype="multipart/form-data" action="/Inventarios/procesaAltaInventarios/" target="altaInventarios_iframeEnvio" id="altaInventarios_Formulario">
        <table width="100%">
            <tr>
                <td align="center">{$seleccioneAlmacen}&nbsp;&nbsp;{$cmbAlmacenes}</td>
                <td align="center">{$seleccioneCliente}&nbsp;&nbsp;{$cmbClientes}</td>
            </tr>
        </table>
        <fieldset class="ui-widget ui-widget-content" id="altaInventarios_MetodoEntradaMasiva">
            <legend>{$textoCargaMasiva} &nbsp;&nbsp;<input type="checkbox" checked id="altaInventarios_seleccionaEntradaMasiva" name="altaInventarios_seleccionaEntradaMasiva" onclick="seleccionaCargaMasiva( this );" /></legend>
            <div id="contenedorCargaMasiva">
                <table width="100%">
                    <tr>
                        <td colspan="2">{$seleccioneLayout}&nbsp;&nbsp;
                            <input type="file" id="altaInventarios_LayoutAdjuntar" name="altaInventarios_LayoutAdjuntar" accept=".xls" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button id="altaInventarios_botonAdjuntaLayout" onclick="return procesaAltaMasivaLayout();">{$textoBotonAltaLayout}</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {$gridTemporal}
                        </td>
                    </tr>
                </table>
            </div>
        </fieldset>
	</form>
        <br />
	<form method="POST" enctype="multipart/form-data" action="/Inventarios/procesaAltaInventariosIndiv/" target="altaInventarios_iframeEnvio" id="inventarioIndividual" name="inventarioIndividual">
        <fieldset class="ui-widget ui-widget-content" id="altaInventarios_MetodoEntradaIndividual" name="altaInventarios_MetodoEntradaIndividual">
            <legend>{$textoCargaIndividual} &nbsp;&nbsp;<input type="checkbox" id="altaInventarios_seleccionaEntradaIndividual" name="altaInventarios_seleccionaEntradaIndividual" onclick="seleccionaCargaIndividual( this );" /></legend>
            <div id="contenedorCargaIndividual" style="display: none">
                <table width="100%">
                    <tr>
                        <td>{$txtCargaIndNombre}</td>
                        <td><input type="text" id="altaInventariosInd_nombre" name="altaInventariosInd_nombre" maxlength="100" /></td>
                        <td>{$txtCargaIndDescripcion}</td>
                        <td><input type="text" id="altaInventariosInd_descripcion" name="altaInventariosInd_descripcion" maxlength="250" /></td>
                        <td>{$txtCargaIndMarca}</td>
                        <td>{$cmbClientes}</td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndSerie}</td>
                        <td><input type="text" id="altaInventariosInd_serie" name="altaInventariosInd_serie" maxlength="100" /></td>
                        <td>{$txtCargaIndIMEI}</td>
                        <td><input type="text" id="altaInventariosInd_imei" name="altaInventariosInd_imei" maxlength="100" /></td>
                        <td>{$txtCargaIndResponsable}</td>
                        <td><input type="text" id="altaInventariosInd_responsable" name="altaInventariosInd_responsable" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndEstado}</td>
                        <td><input type="text" id="altaInventariosInd_estado" name="altaInventariosInd_estado" maxlength="100" /></td>
                        <td>{$txtCargaIndCantidad}</td>
                        <td><input type="text" id="altaInventariosInd_cantidad" name="altaInventariosInd_cantidad" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndSKU}</td>
                        <td><input type="text" id="altaInventariosInd_sku" name="altaInventariosInd_sku" maxlength="200" /></td>
                        <td>{$txtCargaIndModelo}</td>
                        <td><input type="text" id="altaInventariosInd_modelo" name="altaInventariosInd_modelo" maxlength="200" /></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndTalla}</td>
                        <td><input type="text" id="altaInventariosInd_talla" name="altaInventariosInd_talla" maxlength="100" /></td>
                        <td>{$txtCargaIndPeso}</td>
                        <td><input type="text" id="altaInventariosInd_peso" name="altaInventariosInd_peso" maxlength="100" /></td>
                        <td>{$txtCargaIndUPeso}</td>
                        <td>{$cmbUnidadPeso}</td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndCapacidad}</td>
                        <td><input type="text" id="altaInventariosInd_capacidad" name="altaInventariosInd_capacidad" maxlength="100" /></td>
                        <td>{$txtCargaIndCosto}</td>
                        <td><input type="text" id="altaInventariosInd_costo" name="altaInventariosInd_costo" /></td>
                        <td>{$txtCargaIndMoneda}</td>
                        <td><input type="text" id="altaInventariosInd_moneda" name="altaInventariosInd_moneda" maxlength="20" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndUMedida}</td>
                        <td>{$cmbuMedida}</td>
                        <td>{$txtCargaIndAlto}</td>
                        <td><input type="text" id="altaInventariosInd_alto" name="altaInventariosInd_alto" maxlength="100" /></td>
                        <td>{$txtCargaIndAncho}</td>
                        <td><input type="text" id="altaInventariosInd_ancho" name="altaInventariosInd_ancho" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndLargo}</td>
                        <td><input type="text" id="altaInventariosInd_largo" name="altaInventariosInd_largo" maxlength="100" /></td>
                        <td>{$txtCargaIndSabor}</td>
                        <td><input type="text" id="altaInventariosInd_sabor" name="altaInventariosInd_sabor" maxlength="100" /></td>
                        <td>{$txtCargaIndColor}</td>
                        <td><input type="text" id="altaInventariosInd_color" name="altaInventariosInd_color" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndEmpaque}</td>
                        <td><input type="text" id="altaInventariosInd_empaque" name="altaInventariosInd_empaque" maxlength="100" /></td>
                        <td>{$txtCargaIndRack}</td>
                        <td><input type="text" id="altaInventariosInd_rack" name="altaInventariosInd_rack" maxlength="100" /></td>
                        <td>{$txtCargaIndPRack}</td>
                        <td><input type="text" id="altaInventariosInd_posRack" name="altaInventariosInd_posRack" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndTamano}</td>
                        <td><input type="text" id="altaInventariosInd_tamano" name="altaInventariosInd_tamano" maxlength="100" /></td>
                        <td>{$txtCargaFechaIngreso}</td>
                        <td><input type="text" readonly="readonly" id="altaInventariosInd_fechaIngreso" name="altaInventariosInd_fechaIngreso" /></td>
                        <td>{$seleccioneImagen}</td>
                        <td><input type="file" id="altaInventarios_ImagenAdjuntar" name="altaInventarios_ImagenAdjuntar" accept=".jpg" /></td>                        
                    </tr>
                    <input type="hidden" id="altaInventariosInd_rutaFinalImg" name="altaInventariosInd_rutaFinalImg" /><input type="hidden" id="altaInventarios_comboAlmacenes1" name="altaInventarios_comboAlmacenes1" /><input type="hidden" id="altaInventarios_comboClientes1" name="altaInventarios_comboClientes1" />
                    <!--tr>
                        <td colspan="6">
                            <fieldset class="ui-widget ui-widget-content" >
                                <legend>Lotes:</legend>
                                <table width="100%" class="input_fields_wrap">
                                    <tr>
                                        <td>Serie:</td>
                                        <td><input type="text" id="altaInventariosIndLote_serie[]" name="altaInventariosIndLote_serie[]" maxlength="200" /></td>
                                        <td>Estado:</td>
                                        <td><input type="text" id="altaInventariosIndLote_estado[]" name="altaInventariosIndLote_estado[]" maxlength="200" /></td>
                                        <td><button id="altaInventariosIndBotonMasLote">Mas</button></td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr-->
		    <tr>
                        <td align="center" colspan="6">
                            <button id="altaInventarios_botonGuardaItemLote">{$txtBotonGuardaItemLote}</button>
                        </td>
                    </tr>
                </table>
            </div>
        </fieldset>
        </form>
    <iframe width="0" height="0" frameborder="0" id="altaInventarios_iframeEnvio" name="altaInventarios_iframeEnvio"></iframe>
</fieldset>
        
<br />


{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

