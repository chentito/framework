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
    <table width="100%">
    	<tr>
        <td align="center" width="47%" height="100px" colspan="4">
        <img id="imgEmpleado" src="{$urlImagen}" width="160px" height="180px" />
        </td>
        <td>
        <table width="100%">
        <tr>
        <td class="titulos">{$txtCargaIndIDEmpleado}:</td>
        <td>{$idEmpleado}</td>        
        </tr>
        <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="titulos">{$txtCargaIndNombreEmpleados}:</td>
        <td>{$nombreEmpleado}</td>
        </tr>
        <tr>
        <td class="titulos">{$txtCargaIndApaternoEmpleados}:</td>
        <td>{$apellidoPaterno}</td>
        </tr>
        <tr>
        <td class="titulos">{$txtCargaIndAmaternoEmpleados}:</td>
        <td>{$apellidoMaterno}</td>
        </tr>
        <tr>
        <td class="titulos">{$txtCargaIndEmail}:</td>
        <td>{$email}</td>
        </tr>
        <tr>
        <td class="titulos">{$seleccioneImagenEmpleadoUpdate}</td>
        <td>
            <form method="POST" enctype="multipart/form-data" action="/Empleados/updateImagenEmpleado/" target="altaEmpleados_iframeEnvioMuestraDetalle" id="detalleEmpleadosIndividual" name="detalleEmpleadosIndividual">
                <input type="file" id="altaEmpleados_ImagenAdjuntarUpdate" name="altaEmpleados_ImagenAdjuntarUpdate" accept=".jpg" />
                <input type="hidden" id="altaEmpleadosInd_rutaFinalImgUpdate" name="altaEmpleadosInd_rutaFinalImgUpdate" />
                <input type="hidden" id="altaEmpleadosInd_cveEmpleadoUpdate" name="altaEmpleadosInd_cveEmpleadoUpdate" value="{$id}" />
            </form>
        </td>
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
        <td width="16%">{$NSS}</td>
        <td class="titulos" width="17%">{$txtCargaIndFechaNacimiento}:</td>
        <td width="16%">{$fechaNacimiento}</td>
        <td class="titulos" width="17%">{$txtCargaIndLugarNacimiento}:</td>
        <td width="16%">{$lugarNacimiento}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndEstadoCivil}:</td>
        <td width="16%">{$estadoCivil}</td>
        <td class="titulos" width="17%">{$txtCargaIndSexo}:</td>
        <td width="16%">{$sexo}</td>
        <td class="titulos" width="17%">{$txtCargaIndCurp}:</td>
        <td width="16%">{$curp}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndRFC}:</td>
        <td width="16%">{$rfc}</td>
        <td class="titulos" width="17%">{$txtCargaIndCalle}:</td>
        <td width="16%">{$calle}</td>
        <td class="titulos" width="17%">{$txtCargaIndNoExterior}:</td>
        <td width="16%">{$noExterior}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndNoInterior}:</td>
        <td width="16%">{$noInterior}</td>
        <td class="titulos" width="17%">{$txtCargaIndColonia}:</td>
        <td width="16%">{$colonia}</td>
        <td class="titulos" width="17%">{$txtCargaIndEstado}:</td>
        <td width="16%">{$estado}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndLocalidad}:</td>
        <td width="16%">{$localidad}</td>
        <td class="titulos" width="17%">{$txtCargaIndMunicipio}:</td>
        <td width="16%">{$municipio}</td>
        <td class="titulos" width="17%">{$txtCargaIndCodigoPostal}:</td>
        <td width="16%">{$codigoPostal}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndDepto}:</td>
        <td width="16%">{$departamento}</td>
        <td class="titulos" width="17%">{$txtCargaIndPuesto}:</td>
        <td width="16%">{$puesto}</td>
        <td class="titulos" width="17%">Cliente:</td>
        <td width="16%">{$cliente}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">{$txtCargaIndRuta}:</td>
        <td width="16%">{$ruta}</td>
        <td class="titulos" width="17%">{$txtCargaIndBanco}:</td>
        <td width="16%">{$banco}</td>
        <td class="titulos" width="17%">{$txtCargaIndCuenta}:</td>
        <td width="16%">{$cuenta}</td>
        </tr>
        <tr>
        <td class="titulos" width="17%">Status:</td>
        <td colspan="5">{$status}</td>
        </tr>
        </table>
        </td>
        </tr>
    </table>
    <iframe width="0" height="0" frameborder="0" id="altaEmpleados_iframeEnvioMuestraDetalle" name="altaEmpleados_iframeEnvioMuestraDetalle"></iframe>
</fieldset>
<br />
<!-- Contenido -->

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
