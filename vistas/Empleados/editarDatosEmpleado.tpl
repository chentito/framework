<!-- Estilos -->
{foreach from=$estilos item=estilo}
    <link rel="stylesheet" type="text/css" media="screen" href="{$estilo}" />
{/foreach}

<!-- Scripts -->
{foreach from=$scripts item=script}
    <script type="text/javascript" src="{$script}" ></script>
{/foreach}

<!-- Contenido -->
<fieldset class="ui-widget ui-widget-content">
    <form name="editaEmpleado_form" id="editaEmpleado_form">
    <table width="100%">
    	<tr>
        <td align="center" width="47%" height="100px" colspan="4">
        <img id="imgEmpleado" src="{$urlImagen}" width="160px" height="180px" />
        </td>
        <td>
        <table width="100%">
        <tr>
        <td class="titulos">{$txtCargaIndIDEmpleado}:</td>
        <td><input type="text" id="idEmpleado_edita" name="idEmpleado_edita" value="{$idEmpleado}" readonly="readonly" size="15" /><input type="hidden" id="id_edita" name="id_edita" value="{$id}" /></td>        
        </tr>
        <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="titulos">{$txtCargaIndNombreEmpleados}:</td>
        <td><input type="text" id="nombreEmpleado_edita" name="nombreEmpleado_edita" value="{$nombreEmpleado}" size="30" /></td>
        </tr>
        <tr>
        <td class="titulos">{$txtCargaIndApaternoEmpleados}:</td>
        <td><input type="text" id="apellidoPaternoEmp_edita" name="apellidoPaternoEmp_edita" value="{$apellidoPaterno}" size="45" /></td>
        </tr>
        <tr>
        <td class="titulos">{$txtCargaIndAmaternoEmpleados}:</td>
        <td><input type="text" id="apellidoMaternoEmp_edita" name="apellidoMaternoEmp_edita" value="{$apellidoMaterno}" size="45" /></td>
        </tr>
        <tr>
        <td class="titulos">{$txtCargaIndEmail}:</td>
        <td><input type="text" id="emailEmp_edita" name="emailEmp_edita" value="{$email}" size="45" /></td>
        </tr>        
        </table>
	</td>
        </tr>        
        <tr>
        <td colspan="6">
        <table width="100%">
        <tr>
        <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndNss}:</td>
        <td width="16%"><input type="text" id="NSSEmp_edita" name="NSSEmp_edita" value="{$NSS}" size="15" /></td>
        <td class="titulos" width="17%">{$txtCargaIndFechaNacimiento}:</td>
        <td width="16%"><input type="text" id="fechaNacimientoEmp_edita" name="fechaNacimientoEmp_edita" value="{$fechaNacimiento}" size="12" /></td>
        <td class="titulos" width="17%">{$txtCargaIndLugarNacimiento}:</td>
        <td width="16%"><input type="text" id="lugarNacimientoEmp_edita" name="lugarNacimientoEmp_edita" value="{$lugarNacimiento}" size="20" /></td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndEstadoCivil}:</td>
        <td width="16%"><input type="text" id="estadoCivilEmp_edita" name="estadoCivilEmp_edita" value="{$estadoCivil}" size="20" /></td>
        <td class="titulos" width="17%">{$txtCargaIndSexo}:</td>
        <td width="16%"><input type="hidden" id="sexoEmp_edita" name="sexoEmp_edita" value="{$sexo}" />{$cmbSexo}</td>
        <td class="titulos" width="17%">{$txtCargaIndCurp}:</td>
        <td width="16%"><input type="text" id="curpEmp_edita" name="curpEmp_edita" value="{$curp}" size="18" /></td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndRFC}:</td>
        <td width="16%"><input type="text" id="rfcEmp_edita" name="rfcEmp_edita" value="{$rfc}" size="15" /></td>
        <td class="titulos" width="17%">{$txtCargaIndCodigoPostal}:</td>
        <td width="16%"><input type="text" id="codigoPostalEmp_edita" name="codigoPostalEmp_edita" value="{$codigoPostal}" size="5" onchange="buscaDatosSepomexEdita(this.value);" /></td>
        <td class="titulos" width="17%">{$txtCargaIndCalle}:</td>
        <td width="16%"><input type="text" id="calleEmp_edita" name="calleEmp_edita" value="{$calle}" size="20" /></td>        
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndNoExterior}:</td>
        <td width="16%"><input type="text" id="noExteriorEmp_edita" name="noExteriorEmp_edita" value="{$noExterior}" size="10" /></td>
        <td class="titulos" width="17%">{$txtCargaIndNoInterior}:</td>
        <td width="16%"><input type="text" id="noInteriorEmp_edita" name="noInteriorEmp_edita" value="{$noInterior}" size="10" /></td>
        <td class="titulos" width="17%">{$txtCargaIndColonia}:</td>
        <td width="16%"><input type="hidden" id="coloniaEmp_edita" name="coloniaEmp_edita" value="{$colonia}" size="10" /><select id="altaEmpleadosInd_colonia" name="altaEmpleadosInd_colonia"><option value="{$colonia}">{$colonia}</option></select></td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndEstado}:</td>
        <td width="16%"><input type="text" id="estadoEmp_edita" name="estadoEmp_edita" value="{$estado}" size="20" readonly="readonly" /></td>
        <td class="titulos" width="17%">{$txtCargaIndLocalidad}:</td>
        <td width="16%"><input type="text" id="localidadEmp_edita" name="localidadEmp_edita" value="{$localidad}" size="20" readonly="readonly" /></td>
        <td class="titulos" width="17%">{$txtCargaIndMunicipio}:</td>
        <td width="16%"><input type="text" id="municipioEmp_edita" name="municipioEmp_edita" value="{$municipio}" size="20" readonly="readonly" /></td>        
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndDepto}:</td>
        <td width="16%"><input type="hidden" id="departamentoEmp_edita" name="departamentoEmp_edita" value="{$departamento}" />{$cmbDepto}</td>
        <td class="titulos" width="17%">{$txtCargaIndPuesto}:</td>
        <td width="16%"><input type="text" id="puestoEmp_edita" name="puestoEmp_edita" value="{$puesto}" size="15" /></td>
        <td class="titulos" width="17%">Cliente:</td>
        <td width="16%">{$cliente}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndRuta}:</td>
        <td width="16%"><input type="text" id="rutaEmp_edita" name="rutaEmp_edita" value="{$ruta}" size="20" /></td>
        <td class="titulos" width="17%">{$txtCargaIndBanco}:</td>
        <td width="16%"><input type="text" id="bancoEmp_edita" name="bancoEmp_edita" value="{$banco}" size="20" /></td>
        <td class="titulos" width="17%">{$txtCargaIndCuenta}:</td>
        <td width="16%"><input type="text" id="cuentaEmp_edita" name="cuentaEmp_edita" value="{$cuenta}" size="20" /></td>
        </tr>
        <tr>
	<td class="titulos" width="17%">{$txtCargaIndUsuario}</td>
        <td width="16%"><input type="text" id="usuarioEmp_edita" name="usuarioEmp_edita" value="{$sisUsuario}" maxlength="30" /></td>
        <td class="titulos" width="17%">{$txtCargaIndPass}</td>
        <td width="16%"><input type="password" id="passEmp_edita" name="passEmp_edita" value="{$sisPass}" maxlength="32" /></td>
        <td class="titulos" width="17%">Status:</td>
        <td width="16%">{$status}</td>
        </tr>
        </table>
        </td>
        </tr>
    </table>
    <!--iframe width="0" height="0" frameborder="0" id="altaEmpleados_iframeEnvioMuestraDetalle" name="altaEmpleados_iframeEnvioMuestraDetalle"></iframe-->
    </form>
</fieldset>
<br />
<!-- Contenido -->

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
