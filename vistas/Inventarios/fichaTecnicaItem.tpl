
<!-- Estilos -->
{foreach from=$estilos item=estilo}
    <link rel="stylesheet" type="text/css" media="screen" href="{$estilo}" />
{/foreach}

<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

<fieldset class="ui-widget ui-widget-content">
    <table width="100%">
        <tr>
            <td width="47%" align="center">
                <img id="imgItem" src="{$urlImagen}" width="160px" height="180px" />                
            </td>
            <td width="53%" >
                <table width="100%">
                    <tr>
                        <td class="titulos">Nombre:</td>
                        <td>{$nombre}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Descripcion:</td>
                        <td>{$descripcion}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Marca:</td>
                        <td>{$marca}</td>
                    </tr>
                    <tr>
                        <td class="titulos">SKU:</td>
                        <td>{$sku}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Modelo:</td>
                        <td>{$modelo}</td>
                    </tr>
                    <tr>
                        <td class="titulos">IMEI:</td>
                        <td>{$imei}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Seleccione Im&aacute;gen:</td>
                        <td>
                            <form method="post" enctype="multipart/form-data" target="iframeOcultoImagenFichaTecnica" action="/Inventarios/uploadImagenItem/" id="formImgItemFichaTecnica" name="formImgItemFichaTecnica">
                                <table>
                                    <tr>
                                        <td>
                                            <input type="file" id="imagenItenFichaTecnica" name="imagenItenFichaTecnica" accept="image/*" />
                                            <input type="hidden" id="idImagenItemFichaTecnica" name="idImagenItemFichaTecnica" value="{$idty}" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <iframe id="iframeOcultoImagenFichaTecnica" name="iframeOcultoImagenFichaTecnica" width="0" height="0" frameborder="0"></iframe>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%">
                    <tr>
                        <td width="17%" class="titulos">Cantidad:</td>
                        <td width="16%">{$cantidad}</td>
                        <td width="17%" class="titulos">Talla</td>
                        <td width="16%">{$talla}</td>
                        <td width="17%" class="titulos">Peso:</td>
                        <td width="16%">{$peso}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Unidad Peso:</td>
                        <td>{$unidadPeso}</td>
                        <td class="titulos">Capacidad:</td>
                        <td>{$capacidad}</td>
                        <td class="titulos">Costo:</td>
                        <td>{$costo}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Moneda:</td>
                        <td>{$moneda}</td>
                        <td class="titulos">U.Medida:</td>
                        <td>{$unidadMedida}</td>
                        <td class="titulos">Alto:</td>
                        <td>{$alto}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Ancho:</td>
                        <td>{$largo}</td>
                        <td class="titulos">Sabor:</td>
                        <td>{$sabor}</td>
                        <td class="titulos">Largo</td>
                        <td>{$largo}</td>
                    </tr>
                    <tr>
                        <td class="titulos"></td>
                        <td></td>
                        <td class="titulos"></td>
                        <td></td>
                        <td class="titulos"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="titulos">Color:</td>
                        <td>{$color}</td>
                        <td class="titulos">Rack:</td>
                        <td>{$rack}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="titulos">Posici&oacute;n:</td>
                        <td>{$posicionRack}</td>
                        <td class="titulos">Almac&eacute;n:</td>
                        <td>{$almacen}</td>
                        <td class="titulos">Fecha Ingreso:</td>
                        <td>{$fechaIngreso}</td>
                    </tr>
                    <tr>
                        <td class="titulos">Resurtido:</td>
                        <td>N/A</td>
                        <td class="titulos">Cliente:</td>
                        <td>{$cliente}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="titulos">Almacenamiento:</td>
                        <td>{$almacenamiento}</td>
                        <td class="titulos"></td>
                        <td></td>
                        <td class="titulos"></td>
                        <td></td>
                    </tr>
                </table>
            </td>            
        </tr>
        
    </table>
</fieldset>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
