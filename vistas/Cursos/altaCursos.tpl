
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

<form id="registro_altaCursos_form" name="registro_altaCursos_form">
    <fieldset class="ui-widget ui-widget-content">
        <legend><b>INFORMACION CURSO</b></legend>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4">Nombre Curso:</td>
            </tr>
            <tr>
                <td colspan="4"><input type="text" id="registro_altaCursos_nombreCurso" name="registro_altaCursos_nombreCurso" style="width: 50%" /></td>
            </tr>
            <tr>
                <td colspan="4">Descripci&oacute;n Curso:</td>
            </tr>
            <tr>
                <td colspan="4"><textarea id="registro_altaCursos_descripcionCurso" name="registro_altaCursos_descripcionCurso" rows="4" cols="100" style="width: 55%; resize:none"  ></textarea></td>
            </tr>
            <tr>
                <td width="25%">Costo Curso:</td>
                <td width="25%">Fecha Publicaci&oacute;n Curso:</td>
                <td width="25%">Fecha Inicio Curso:</td>
                <td width="25%">Fecha Fin Curso:</td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaCursos_costoCurso" name="registro_altaCursos_costoCurso" style="width: 90%" onkeypress="return numeros(event)"  /></td>
                <td><input type="text" id="registro_altaCursos_fechaPublicacionCurso" name="registro_altaCursos_fechaPublicacionCurso" style="width: 90%" /></td>
                <td><input type="text" id="registro_altaCursos_fechaInicioCurso" name="registro_altaCursos_fechaInicioCurso" style="width: 90%" /></td>
                <td><input type="text" id="registro_altaCursos_fechaFinCurso" name="registro_altaCursos_fechaFinCurso" style="width: 90%" /></td>
            </tr>
        </table>
    </fieldset>

    <br />

    <fieldset class="ui-widget ui-widget-content">
        <legend><b>DATOS BANCARIOS</b></legend>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>Banco:</td>
                <td colspan="2">Titular:</td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaCursos_datosBancarios_banco" name="registro_altaCursos_datosBancarios_banco" style="width: 70%" /></td>
                <td colspan="2"><input type="text" id="registro_altaCursos_datosBancarios_titular" name="registro_altaCursos_datosBancarios_titular" style="width: 90%" /></td>
            </tr>
            <tr>
                <td width="33%">Convenio CIE:</td>
                <td width="33%">Cuenta:</td>
                <td width="33%">CLABE:</td>
            </tr>
            <tr>
                <td><input type="text" id="registro_altaCursos_datosBancarios_convenioCIE" name="registro_altaCursos_datosBancarios_convenioCIE" style="width: 90%" /></td>
                <td><input type="text" id="registro_altaCursos_datosBancarios_Cuenta" name="registro_altaCursos_datosBancarios_Cuenta" style="width: 90%" /></td>
                <td><input type="text" id="registro_altaCursos_datosBancarios_CLABE" name="registro_altaCursos_datosBancarios_CLABE" style="width: 90%" /></td>
            </tr>
        </table>
    </fieldset>

    <br />          

    <center><button id="registro_altaCursos_btnGuardar" name="registro_altaCursos_btnGuardar">Guardar Curso</button></center>
</form>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
