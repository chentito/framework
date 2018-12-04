
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

<form id="registro_cursosDisponibles_form" name="registro_cursosDisponibles_form">
    <fieldset class="ui-widget ui-widget-content">
        <legend><b>CURSOS DISPONIBLES</b></legend>
        <center><button id="cursosDisponibles_btnEliminar" name="cursosDisponibles_btnEliminar">Eliminar Curso</button></center>
        <br />
        <table id="tableCursosDisponibles" class="display" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre Curso</th>
                    <th>Descripci&oacute;n Curso</th>
                    <th>Costo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Fecha Publicaci&oacute;n</th>
                    <th>Banco</th>
                    <th>Titular</th>
                    <th>ConvenioCIE</th>
                    <th>Cuenta</th>
                    <th>CLABE</th>
                    <th>ID</th>
                </tr>
            </thead>
            <tbody>                
            </tbody>
        </table>
    </fieldset>

    <br />
</form>

{if $cierraL == true }
    {literal}
        <script type="text/javascript">$("#loading-gral-sitio").dialog("close");</script>
    {/literal}
{/if}
