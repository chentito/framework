
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
<!-- ComboPerfiles -->
<table border="0" width="40%" border="0" align="center" id="tablaPerfiles" name="tablaPerfiles" >
    <tr align="center">
        <td>
            <select id='comboPerfil' name='comboPerfil' onchange='buscaInformacionPerfil()'>
                <option value=''>-- Seleccione una opci&oacute;n --</option>
		<option value='sistema_agregarPerfil'><button id="sistema_agregarPerfil">------ {$agregarPerfil} ------</button></option>
                {foreach name=comboPerfiles item=elemento from=$datosPerfiles}  
                    {foreach key=key item=item from=$elemento}
                    {/foreach}
                    <option value='{$elemento.id}'>{$elemento.nombrePerfil}</option>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td height="50px" align="center">
            <div id="nuevoPerfil" name="nuevoPerfil" style="display: none"><br />{$nombrePerfil}<input type="text" id="nombrePerfil" name="nombrePerfil" />&nbsp;&nbsp;&nbsp;&nbsp;<button id="sistema_guardarPerfil">{$guardarPerfil}</button><input type="hidden" id="idPerfil" name="idPerfil" /></div>
        </td>
    </tr>
</table>
<!-- ComboPerfiles -->

<!-- Contenido -->
{$contenidoSeccion}
<!-- Contenido -->

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
