
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
    <form method="POST" enctype="multipart/form-data" action="/Empleados/procesaAltaEmpleados/" target="altaEmpleados_iframeEnvio" id="altaEmpleados_Formulario">
        <table width="100%">
            <tr>                
                <td align="center">{$seleccioneCliente}&nbsp;&nbsp;{$cmbClientes}</td>
            </tr>
        </table>        
        <fieldset class="ui-widget ui-widget-content" id="altaEmpleados_MetodoEntradaMasiva">
            <legend>{$textoCargaMasivaEmpleados} &nbsp;&nbsp;<input type="checkbox" checked id="altaEmpleados_seleccionaEntradaMasiva" name="altaEmpleados_seleccionaEntradaMasiva" onclick="seleccionaCargaMasivaEmpleados( this );" /></legend>
            <div id="contenedorCargaMasivaEmpleados">
                <table width="100%">
                    <tr>
                        <td colspan="2">{$seleccioneLayoutEmpleados}&nbsp;&nbsp;
                            <input type="file" id="altaEmpleados_LayoutAdjuntar" name="altaEmpleados_LayoutAdjuntar" accept=".csv,.xls" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button id="altaEmpleados_botonAdjuntaLayout" onclick="return procesaAltaMasivaLayoutEmpleados();">{$textoBotonAltaLayoutEmpleados}</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {$gridTemporalEmpleados}
                        </td>
                    </tr>
                </table>
            </div>
        </fieldset>        
	</form>
        <br />
	<form method="POST" enctype="multipart/form-data" action="/Empleados/procesaAltaEmpleadosIndiv/" target="altaEmpleados_iframeEnvio" id="empleadosIndividual" name="empleadosIndividual">
        <fieldset class="ui-widget ui-widget-content" id="altaEmpleados_MetodoEntradaIndividual" name="altaEmpleados_MetodoEntradaIndividual">
            <legend>{$textoCargaIndividualEmpleados} &nbsp;&nbsp;<input type="checkbox" id="altaEmpleados_seleccionaEntradaIndividual" name="altaEmpleados_seleccionaEntradaIndividual" onclick="seleccionaCargaIndividualEmpleados( this );" /></legend>
            <div id="contenedorCargaIndividualEmpleados" style="display: none">
                <table width="100%">
                    <tr>
                        <td>{$txtCargaIndIDEmpleado}</td>
                        <td colspan="5"><input type="text" id="altaEmpleadosInd_idEmpleado" name="altaEmpleadosInd_idEmpleado" maxlength="15" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndNombreEmpleados}</td>
                        <td><input type="text" id="altaEmpleadosInd_nombre" name="altaEmpleadosInd_nombre" maxlength="150" /></td>
                        <td>{$txtCargaIndApaternoEmpleados}</td>
                        <td><input type="text" id="altaEmpleadosInd_aPaterno" name="altaEmpleadosInd_aPaterno" maxlength="100" /></td>
                        <td>{$txtCargaIndAmaternoEmpleados}</td>
                        <td><input type="text" id="altaEmpleadosInd_aMaterno" name="altaEmpleadosInd_aMaterno" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndEmail}</td>
                        <td><input type="text" id="altaEmpleadosInd_email" name="altaEmpleadosInd_email" maxlength="100" /></td>
                        <td>{$txtCargaIndNss}</td>
                        <td><input type="text" id="altaEmpleadosInd_nss" name="altaEmpleadosInd_nss" maxlength="15" /></td>
                        <td>{$txtCargaIndFechaNacimiento}</td>
                        <td><input type="text" id="altaEmpleadosInd_fechaNacimiento" name="altaEmpleadosInd_fechaNacimiento" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndLugarNacimiento}</td>
                        <td><input type="text" id="altaEmpleadosInd_lugarNacimiento" name="altaEmpleadosInd_lugarNacimiento" maxlength="50" /></td>
                        <td>{$txtCargaIndEstadoCivil}</td>
                        <td><input type="text" id="altaEmpleadosInd_estadoCivil" name="altaEmpleadosInd_estadoCivil" maxlength="50" /></td>
                        <td>{$txtCargaIndSexo}</td>
                        <td>{$cmbSexo}</td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndCurp}</td>
                        <td><input type="text" id="altaEmpleadosInd_curp" name="altaEmpleadosInd_curp" maxlength="18" /></td>
                        <td>{$txtCargaIndRFC}</td>
                        <td><input type="text" id="altaEmpleadosInd_rfc" name="altaEmpleadosInd_rfc" maxlength="13" /></td>
                        <td>{$txtCargaIndCodigoPostal}</td>
                        <td><input type="text" id="altaEmpleadosInd_codigoPostal" name="altaEmpleadosInd_codigoPostal" maxlength="5" onchange="buscaDatosSepomex(this.value);" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndCalle}</td>
                        <td><input type="text" id="altaEmpleadosInd_calle" name="altaEmpleadosInd_calle" maxlength="200" /></td>                                                
                        <td>{$txtCargaIndNoExterior}</td>
                        <td><input type="text" id="altaEmpleadosInd_noExterior" name="altaEmpleadosInd_noExterior" maxlength="20" /></td>
                        <td>{$txtCargaIndNoInterior}</td>
                        <td><input type="text" id="altaEmpleadosInd_noInterior" name="altaEmpleadosInd_noInterior" maxlength="20" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndColonia}</td>
                        <td><select id="altaEmpleadosInd_colonia" name="altaEmpleadosInd_colonia"><option value="">-</option></select></td>
                        <td>{$txtCargaIndEstado}</td>
                        <td><input type="text" id="altaEmpleadosInd_estado" name="altaEmpleadosInd_estado" maxlength="100" readonly="readonly" /></td>
                        <td>{$txtCargaIndLocalidad}</td>
                        <td><input type="text" id="altaEmpleadosInd_localidad" name="altaEmpleadosInd_localidad" maxlength="100" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndMunicipio}</td>
                        <td><input type="text" id="altaEmpleadosInd_municipio" name="altaEmpleadosInd_municipio" maxlength="150" readonly="readonly" /></td>
                        <td>{$txtCargaIndDepto}</td>
                        <td>{$cmbDepto}</td>
                        <td>{$txtCargaIndPuesto}</td>
                        <td><input type="text" id="altaEmpleadosInd_puesto" name="altaEmpleadosInd_puesto" maxlength="200" /></td>
                    </tr>
                    <tr>
                        <td>{$txtCargaIndRuta}</td>
                        <td><input type="text" id="altaEmpleadosInd_ruta" name="altaEmpleadosInd_ruta" maxlength="100" /></td>
                        <td>{$txtCargaIndBanco}</td>
                        <td><input type="text" id="altaEmpleadosInd_banco" name="altaEmpleadosInd_banco" maxlength="50" /></td>
                        <td>{$txtCargaIndCuenta}</td>
                        <td><input type="text" id="altaEmpleadosInd_cuenta" name="altaEmpleadosInd_cuenta" maxlength="50" /></td>
                    </tr>
		    <tr>
                        <td>{$txtCargaIndUsuario}</td>
                        <td><input type="text" id="altaEmpleadosInd_usuario" name="altaEmpleadosInd_usuario" maxlength="30" /></td>
                        <td>{$txtCargaIndPass}</td>
                        <td><input type="password" id="altaEmpleadosInd_pass" name="altaEmpleadosInd_pass" maxlength="32" /></td>
                        <td>{$seleccioneImagenEmpleado}</td>
                        <td><input type="file" id="altaEmpleados_ImagenAdjuntar" name="altaEmpleados_ImagenAdjuntar" accept=".jpg" /><input type="hidden" id="altaEmpleadosInd_rutaFinalImg" name="altaEmpleadosInd_rutaFinalImg" /><input type="hidden" id="altaEmpleados_comboClientes1" name="altaEmpleados_comboClientes1" /></td>
                    </tr>
                    <tr>
                        <td align="center" colspan="6">
                            <button id="altaEmpleados_botonGuardaEmpleado">{$txtBotonGuardaEmpleado}</button>
                        </td>
                    </tr>
                </table>
            </div>
        </fieldset>
        </form>
    <iframe width="0" height="0" frameborder="0" id="altaEmpleados_iframeEnvio" name="altaEmpleados_iframeEnvio"></iframe>
</fieldset>
        
<br />


{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}

