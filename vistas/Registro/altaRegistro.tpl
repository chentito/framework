
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

<div class="ui-widget">
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: 0 .7em; height: 15px">
        
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; "></span>
            <strong>Paso 1</strong> &nbsp; &nbsp; Alta de Registro. Una vez guardado el registro pase al siguiente m&oacute;dulo "Descarga de Formatos"
       
    </div>
</div>

<br />

<form id="registro_altaRegistro_form" name="registro_altaRegistro_form" accept-charset="utf-8">
    <fieldset class="ui-widget ui-widget-content">
        <legend><b>DIRECCION COMERCIAL</b></legend>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2">Nombre Comercial:<input type="hidden" id="registro_altaRegistro_id" name="registro_altaRegistro_id" value="{$idRegistro}" /><input type="hidden" id="registro_altaRegistro_accion" name="registro_altaRegistro_accion" value="{$accionRegistro}" /></td>
                <td>Pais:</td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" id="registro_altaRegistro_Comercial_nombreComercial" name="registro_altaRegistro_Comercial_nombreComercial" style="width: 95%" class="mayusuculas" value="{$nombreComercial}" /></td>
                <td>
                    <select id="registro_altaRegistro_Comercial_pais" name="registro_altaRegistro_Comercial_pais" style="width: 90%;">
                        {foreach key=key item=item from=$paisesCatalogo}
                            {if $item.id==$paisComercial }
                                {assign var=v value=true}
                            {else}
                                {assign var=v value=false}
                            {/if}
                            <option value="{$item.id}" {if $v} selected="selected"{/if}>{$item.nombre}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <td width="33%">Calle y n&uacute;mero exterior e interior:</td>
                <td width="33%">Colonia:</td>
                <td width="33%">Delegaci&oacute;n/Municipio:</td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaRegistro_Comercial_calle" name="registro_altaRegistro_Comercial_calle" style="width: 90%" class="mayusuculas" value="{$calleComercial}" /></td>
                <td><input type="text" id="registro_altaRegistro_Comercial_colonia" name="registro_altaRegistro_Comercial_colonia" style="width: 90%" class="mayusuculas" value="{$coloniaComercial}" /></td>
                <td><input type="text" id="registro_altaRegistro_Comercial_delegacion" name="registro_altaRegistro_Comercial_delegacion" style="width: 90%" class="mayusuculas" value="{$delegacionComercial}" /></td>
            </tr>
            <tr>
                <td>Ciudad/Poblaci&oacute;n:</td>
                <td><table width="100%"><tr><td width="50%">Entidad Federativa:</td><td width="50%">CP:</td></tr></table></td>
                <td><table width="100%"><tr><td width="50%">Tel&eacute;fono (incluir lada):</td><td width="50%">Fax:</td></tr></table></td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaRegistro_Comercial_ciudad" name="registro_altaRegistro_Comercial_ciudad" style="width: 90%" class="mayusuculas" value="{$ciudadComercial}" /></td>
                <td><table width="100%">
                        <tr>
                            <td width="50%">
                                <!--input type="text" id="registro_altaRegistro_Comercial_estado" name="registro_altaRegistro_Comercial_estado" style="width: 85%" class="mayusuculas" value="{$entidadComercial}" /-->
                                <select id="registro_altaRegistro_Comercial_estado" name="registro_altaRegistro_Comercial_estado" style="width: 90%;">
                                    {foreach key=key item=item from=$estadosCatalogo}
                                        {if $item.nombre == $entidadComercial }
                                            {assign var=v value=true}
                                        {else}
                                            {assign var=v value=false}
                                        {/if}
                                        <option value="{$item.id}" {if $v} selected="selected"{/if}>{$item.nombre}</option>
                                    {/foreach}
                                </select>
                            </td>
                            <td width="50%">
                                <input type="text" id="registro_altaRegistro_Comercial_CP" name="registro_altaRegistro_Comercial_CP" style="width: 30%" value="{$cpComercial}" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td><table width="100%"><tr><td width="50%"><input type="text" id="registro_altaRegistro_Comercial_telefono" name="registro_altaRegistro_Comercial_telefono" style="width: 85%" class="mayusuculas" value="{$telefonoComercial}" maxlength="15" onkeypress="return isNumberKey(event)"/></td><td width="50%"><input type="text" id="registro_altaRegistro_Comercial_fax" name="registro_altaRegistro_Comercial_fax" style="width: 85%" value="{$faxComercial}" onkeypress="return isNumberKey(event)"/></td></tr></table></td>
            </tr>
        </table>
    </fieldset>

    <br />

    <fieldset class="ui-widget ui-widget-content">
        <legend><b>DATOS FISCALES</b></legend>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2">Nombre Fiscal:</td>
                <td>RFC:</td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" id="registro_altaRegistro_Fiscal_nombreFiscal" name="registro_altaRegistro_Fiscal_nombreFiscal" style="width: 90%" class="mayusuculas" value="{$nombreFiscal}" /></td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_rfc" name="registro_altaRegistro_Fiscal_rfc" style="width: 35%" maxlenght="13" class="mayusuculas" value="{$rfcFiscal}" /></td>
            </tr>
            <tr>
                <td width="33%">Calle y n&uacute;mero exterior e interior:</td>
                <td width="33%">Colonia:</td>
                <td width="33%">Delegaci&oacute;n / Municipio:</td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaRegistro_Fiscal_calle" name="registro_altaRegistro_Fiscal_calle" style="width: 90%" class="mayusuculas" value="{$calleFiscal}" /></td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_colonia" name="registro_altaRegistro_Fiscal_colonia" style="width: 90%" class="mayusuculas" value="{$coloniaFiscal}" /></td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_delegacion" name="registro_altaRegistro_Fiscal_delegacion" style="width: 90%" class="mayusuculas" value="{$delegacionFiscal}" /></td>
            </tr>
            <tr>
                <td>Ciudad/Poblaci&oacute;n:</td>
                <td><table width="100%"><tr><td width="50%">Entidad Federativa:</td><td width="50%">CP:</td></tr></table></td>
                <td><table width="100%"><tr><td width="50%">Tel&eacute;fono (incluir lada):</td><td width="50%">Fax:</td></tr></table></td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaRegistro_Fiscal_ciudad" name="registro_altaRegistro_Fiscal_ciudad" style="width: 90%" class="mayusuculas" value="{$ciudadFiscal}" /></td>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <!--input type="text" id="registro_altaRegistro_Fiscal_pais" name="registro_altaRegistro_Fiscal_pais" style="width: 85%" class="mayusuculas" value="{$entidadFiscal}" /-->
                                <select id="registro_altaRegistro_Fiscal_estado" name="registro_altaRegistro_Fiscal_estado" style="width: 90%;">
                                    {foreach key=key item=item from=$estadosCatalogoFis}
                                        {if $item.nombre == $entidadFiscal }
                                            {assign var=v value=true}
                                        {else}
                                            {assign var=v value=false}
                                        {/if}
                                        <option value="{$item.id}" {if $v} selected="selected"{/if}>{$item.nombre}</option>
                                    {/foreach}
                                </select>
                            </td>
                            <td width="50%">
                                <input type="text" id="registro_altaRegistro_Fiscal_CP" name="registro_altaRegistro_Fiscal_CP" style="width: 30%" class="mayusuculas" value="{$cpFiscal}" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td><table width="100%"><tr><td width="50%"><input type="text" id="registro_altaRegistro_Fiscal_telefono" name="registro_altaRegistro_Fiscal_telefono" style="width: 85%" class="mayusuculas" value="{$telefonoFiscal}" maxlength="15" onkeypress="return isNumberKey(event)"/></td><td width="50%"><input type="text" id="registro_altaRegistro_Fiscal_fax" name="registro_altaRegistro_Fiscal_fax" style="width: 85%" class="mayusuculas" value="{$faxFiscal}" onkeypress="return isNumberKey(event)"/></td></tr></table></td>
            </tr>
            <tr>
                <td>El local que ocupa es:</td>
                <td>Contacto comercial:</td>
                <td>Contacto de cuentas por pagar:</td>
            </tr>
            <tr>
                <td>
                    <select id="registro_altaRegistro_Fiscal_lugarOcupa" name="registro_altaRegistro_Fiscal_lugarOcupa" >
                        {foreach key=key item=item from=$localCatalogos}
                            {if $local == $item.id }
                                <option value="{$item.id}" selected="selected">{$item.texto}</option>
                            {else}
                                <option value="{$item.id}">{$item.texto}</option>
                            {/if}
                        {/foreach}
                    </select>
                </td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_contactoComercial" name="registro_altaRegistro_Fiscal_contactoComercial" style="width: 90%" class="mayusuculas" value="{$contactoComercial}" /></td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_contactoCuentasPagar" name="registro_altaRegistro_Fiscal_contactoCuentasPagar" style="width: 90%" class="mayusuculas" value="{$contactoCuentasPagar}" /></td>
            </tr>
            <tr>
                <td>Antiguedad en domicilio:</td>
                <td>Correo de contacto comercial:</td>
                <td>Correo contacto de cuentas por pagar:</td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaRegistro_Fiscal_antiguedadDomicilio" name="registro_altaRegistro_Fiscal_antiguedadDomicilio" style="width: 90%" class="mayusuculas" value="{$antiguedadDomicilio}" /></td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_correoContactoComercial" name="registro_altaRegistro_Fiscal_correoContactoComercial" style="width: 90%" class="mayusuculas" value="{$correoContactoComercial}" /></td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_correoContactoCuentasPagar" name="registro_altaRegistro_Fiscal_correoContactoCuentasPagar" style="width: 90%" class="mayusuculas" value="{$correoContactoCuentasPagar}" /></td>
            </tr>
            <tr>
                <td>Pa&iacute;s:</td>
                <td>Tel&eacute;fono (incluir lada) contacto comercial:</td>
                <td>Tel&eacute;fono (incluir lada) contacto de cuentas por pagar:</td>
            </tr>
            <tr>
                <td>
                    <select id="registro_altaRegistro_Fiscal_pais" name="registro_altaRegistro_Fiscal_pais" style="width: 90%;">
                        {foreach key=key item=item from=$paisesCatalogoFis}
                            {if $item.id == $paisFiscal }
                                {assign var=v value=true}
                            {else}
                                {assign var=v value=false}
                            {/if}
                            <option value="{$item.id}" {if $v} selected="selected"{/if}>{$item.nombre}</option>
                        {/foreach}
                    </select>
                </td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_telefonoContactoComercial" name="registro_altaRegistro_Fiscal_telefonoContactoComercial" style="width: 90%" class="mayusuculas" value="{$telefonoContactoComercial}" maxlength="15" onkeypress="return isNumberKey(event)"/></td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_telefonoContactoCuentasPagar" name="registro_altaRegistro_Fiscal_telefonoContactoCuentasPagar" style="width: 90%" class="mayusuculas" value="{$telefonoContactoCuestasPagar}" maxlength="15" onkeypress="return isNumberKey(event)"/></td>
            </tr>
            <tr>
                <td colspan="2">Tipo de Cliente:</td>
                <td>Representante Legal:</td>
            </tr>
            <tr>
                <td colspan="2">
                    <select id="registro_altaRegistro_Fiscal_regimenFiscal" name="registro_altaRegistro_Fiscal_regimenFiscal" style="width: 90%;">
                        {foreach key=key item=item from=$regimenesFiscales}
                            {if $item.id == $regimenFiscal }
                                {assign var=v value=true}
                            {else}
                                {assign var=v value=false}
                            {/if}
                            <option value="{$item.id}" {if $v} selected="selected"{/if}>{$item.nombre}</option>
                        {/foreach}
                    </select>
                </td>
                <td><input type="text" id="registro_altaRegistro_Fiscal_representanteLegal" name="registro_altaRegistro_Fiscal_representanteLegal" maxlength="100" style="width: 90%;" value="{$representanteLegal}" /></td>
            </tr>
        </table>
    </fieldset>

    <br />

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%" valign="top">
                <fieldset class="ui-widget ui-widget-content">
                    <legend><b>COMUNICACI&Oacute;N</b></legend>
                    Aseguradoras (Para seleccionar m&aacute;s de una opci&oacute;n Ctrl+Clic):<br />
                    <select multiple="multiple" id="registro_altaRegistro_aseguradoras[]" name="registro_altaRegistro_aseguradoras[]" style="width: 90%; height: 170px">
                        {foreach key=key item=item from=$aseguradorasCatalogo}
                            {if in_array( $item.nombre , $aseguradoras ) }
                                    <option value="{$item.id}" selected="selected" >{$item.nombre}</option>
                                {else}
                                    <option value="{$item.id}" >{$item.nombre}</option>
                            {/if}
                        {/foreach}
                    </select>
                </fieldset>
            </td>
            <td width="50%" valign="top">
                <fieldset class="ui-widget ui-widget-content">
                    <legend><b>SISTEMAS</b></legend>
                    <table width="100%">
                        <tr>
                            <td width="15%">AudaClaims Gold</td>
                            <td width="35%" align="left"><input type="radio" id="registro_altaRegistro_usaInpart_usaAudaClaims" name="registro_altaRegistro_usaInpart_usaAudaClaims" value="1" checked="checked" /></td>
                            <td width="15%">Inpart</td>
                            <td width="35%" align="left"><input type="radio" id="registro_altaRegistro_usaInpart_usaAudaClaims" name="registro_altaRegistro_usaInpart_usaAudaClaims" value="2" /></td>
                        </tr>
                    </table>
                </fieldset>
                <br />
                <fieldset class="ui-widget ui-widget-content">
                    <table width="100%">
                        <!--tr>
                            <td colspan="3">Giros de Negocio:</td>
                        </tr-->
                        <tr>
                            <td width="33%">
                                Giros de Negocio:&nbsp;
                                <select id="registro_altaRegistro_giroNegocio" name="registro_altaRegistro_giroNegocio" style="width: 90%;">
                                    {foreach key=key item=item from=$girosNegocio}
                                        <option value="{$item.id}" >{$item.nombre}</option>
                                    {/foreach}
                                </select>
                            </td>
                            <td width="33%">
                                <span style="visibility: hidden" id="contenedorFabricante" name="contenedorFabricante">
                                    Fabricante: &nbsp;<!--input type="text" id="registro_altaRegistro_giroNegocio_fabricante" name="registro_altaRegistro_giroNegocio_fabricante" maxlength="50" /-->
                                    <select id="registro_altaRegistro_giroNegocio_fabricante" name="registro_altaRegistro_giroNegocio_fabricante" >
                                        {foreach key=key item=item from=$fabricantes}
                                            <option value="{$item.id}" >{$item.nombre}</option>
                                        {/foreach}
                                    </select>
                                </span>
                            </td>
                            <td width="33%">
                                <span style="visibility: hidden" id="contenedorIDAgencia" name="contenedorIDAgencia">
                                    ID de Concesario: &nbsp;
                                    <input maxlength="100" id="registro_altaRegistro_giroNegocio_fabricante_idConc" name="registro_altaRegistro_giroNegocio_fabricante_idConc" value="{$giroTexto}" />
                                </span>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <br />
                
            </td>
        </tr>
    </table>

    <br />

    <fieldset class="ui-widget ui-widget-content">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
               <td width="33%" align="center">Usted ya utiliza el sistema?</td>
               <td width="33%" align="center">Cu&aacute;l es su c&oacute;digo de cliente?</td>
               <td width="33%" align="center">Por qu&eacute; requiere esta alta?</td>
            </tr>
            <tr>
                <td align="center">
                    Si <input type="radio" name="registro_altaRegistro_UsaSistema" id="registro_altaRegistro_UsaSistema" value="Si" />
                    &nbsp;&nbsp;&nbsp;
                    No <input type="radio" name="registro_altaRegistro_UsaSistema" id="registro_altaRegistro_UsaSistema" value="No" checked="checked" />
                </td>
                <td align="center">
                    <input type="text" name="registro_altaRegistro_noClienteAudatex" id="registro_altaRegistro_noClienteAudatex" value="{$noClienteAudatex}" />
                </td>
                <td align="center">
                    <table width="100%">
                        <tr>
                            <td align="left">Alta <input type="radio" name="registro_altaRegistro_motivoAlta" id="registro_altaRegistro_motivoAlta" value="Actualizacion" checked="checked" /></td>
                            <td align="left">Cambio Raz&oacute;n Social <input type="radio" name="registro_altaRegistro_motivoAlta" id="registro_altaRegistro_motivoAlta" value="Cambio Razon Social" /></td>
                            <td align="left">Nueva Sucursal <input type="radio" name="registro_altaRegistro_motivoAlta" id="registro_altaRegistro_motivoAlta" value="Nueva Sucursal" /><br />De un CDR ya trabajado.</td>
                        </tr>
                    </table>
                </td>
           </tr>
           <tr>
               <td colspan="3" align="center">Usted ya cuenta con CERTIFICADO de AUDACLAIMS GOLD ?</td>
           </tr>
           <tr>
               <td colspan="3" align="center">
                   Si <input type="radio" name="registro_altaRegistro_certAudaclaims" id="registro_altaRegistro_certAudaclaims" value="Si" />
                    &nbsp;&nbsp;&nbsp;
                    No <input type="radio" name="registro_altaRegistro_certAudaclaims" id="registro_altaRegistro_certAudaclaims" value="No" checked="checked" />
               </td>
           </tr>
        </table>
    </fieldset>

    <br />

    <center><button id="registro_altaRegistro_btnGuardar" name="registro_altaRegistro_btnGuardar">Guardar Registro</button></center>
    
    <br />
    
    <div class="ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em; text-align: center">
            <center>Si tiene alguna duda favor de enviar un correo a <a href="mailto:documentosax@audatex.com.mx">documentosax@audatex.com.mx</a></center>
        </div>
    </div>
    
</form>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
