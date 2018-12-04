<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es"> <!--<![endif]-->
    <head>
        <title>{$titulo}</title>
        <!-- Estilos -->
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/jquery-ui-1.8.1.custom.css" />
        <!--link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/jquery-ui-1.9.2.custom.css" /-->
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/ui_002.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/ui.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/panels.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/Base.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/BreadCrumb.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/buttons/1.4.0/css/buttons.dataTables.min.css" />
        
        {literal}
        <style type="text/css">
            .ui-dialog-buttonpane { text-align: center; }
            html, body { margin: 0; padding: 0; overflow: hidden; font-size: 75%; font-family: Arial,Helvetica; }
        </style>
        {/literal}
        <!-- Scripts -->
        <script type="text/javascript" src="{$path}/assets/javascript/jquery-1.7.min.js" ></script>
        <!--script type="text/javascript" src="{$path}/assets/javascript/jquery-1.8.3.js" ></script-->
        <script type="text/javascript" src="{$path}/assets/javascript/jquery-ui-1.8.16.js" ></script>
        <!--script type="text/javascript" src="{$path}/assets/javascript/jquery-ui-1.9.2.custom.min.js" ></script-->
        <script type="text/javascript" src="{$path}/assets/javascript/jquery-layout.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/grid.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/ui.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/jquery-jqgrid-3.7.2.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/generales.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/patrones.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/jquery.easing.1.3.js"  ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/jquery.jBreadCrumb.1.1.js"  ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/jquery.validate.min.js?10" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/additional-methods.min.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/jquery.maskedinput.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/jquery.dataTables.js" ></script>
        <script type="text/javascript" src="{$path}/assets/buttons/1.4.0/js/dataTables.buttons.min.js" ></script>
        <script type="text/javascript" src="{$path}/assets/buttons/1.4.0/js/buttons.flash.min.js" ></script>        
        <script type="text/javascript" src="{$path}/assets/buttons/1.4.0/js/jszip.min.js" ></script>
        <script type="text/javascript" src="{$path}/assets/buttons/1.4.0/js/pdfmake.min.js" ></script>
        <script type="text/javascript" src="{$path}/assets/buttons/1.4.0/js/vfs_fonts.js" ></script>
        <script type="text/javascript" src="{$path}/assets/buttons/1.4.0/js/buttons.html5.min.js" ></script>
        <script type="text/javascript" src="{$path}/assets/buttons/1.4.0/js/buttons.print.min.js" ></script>
        <!-- Uso solo del modulo -->
        <script type="text/javascript" src="{$path}/vistas/Home/js/home.js" ></script>
        
        <script type="text/javascript" src="{$path}/assets/javascript/graficas/highcharts.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/graficas/highcharts-3d.js" ></script>
        <script type="text/javascript" src="{$path}/assets/javascript/graficas/exporting.js" ></script>
        
        {literal}<script>preload(["{/literal}{$path}{literal}/assets/imgs/img_logo.jpg","{/literal}{$path}{literal}/assets/imgs/ajax-loader.gif"]);</script>{/literal}
        
    </head>
    <body>
        
        <div id="inicializaSistema" style="position:absolute;width:100%; height:100%; background-color:#fff; z-index:100000; ">
            <table width="100%" height="100%">
                <tr><td align="center" valign="middle"><img src="{$path}/assets/imgs/ajax-loader.gif" alt="Cargando, espere por favor" /></td></tr>
            </table>
        </div>

        <!-- Panel superior -->    
        <div class="ui-layout-north ui-widget-header" style="text-align: right; font-weight: bold; font-style: italic; padding: 4px;">
            {$bienvenida} {$nombreUsuario}&nbsp;&nbsp;[{$rolUsuario}]&nbsp;&nbsp;[<a id="home_salir_header">{$salirHeader}</a>]
        </div>

        <!-- Panel izquierdo (Menu) -->
        <div id="LeftPane" class="ui-layout-west ui-widget ui-widget-content" style="overflow: hidden;">
            <!-- Logotipo -->
            <div id="home_logotipo" style="top: 0px; position: absolute; width: 100%; text-align: center">
                <img src='{$path}/assets/imgs/img_logo.jpg' width="200" height="*" />
            </div>

            <!-- Menu -->
            <div style="overflow: auto; top: 63px; bottom: 100px; left: 1px; position: absolute; overflow-x: hidden; width: 99%; ">
                <table id="home_grid_menu" style="height: 90%"></table>
            </div>

            <!-- Boton logout -->
            <div style="bottom: 70px; position: absolute; width: 100%; text-align: center">
                <button id="home_logout">Salir</button>
            </div>

            <!-- Powered -->
            <div style="bottom: 5px; position: absolute; width: 100%; text-align: center; font-style: italic">
                {$poweredBy}<br />
                <a href="http://www.mexagon.net" target="_blank"><img src="{$path}/assets/imgs/powered.png" width="100" height="38" /></a>
            </div>
        </div>

        <!-- Panel derecho (Contenido) -->
        <div id="RightPane" class="ui-layout-center ui-helper-reset ui-widget-content">
            <!-- Contenido principal -->
            <div id="tabs" class="jqgtabs" style="bottom: 5px">
                <ul>
                    <li><a href="/Dashboard/cargaDashboard/">Dashboard</a></li>
                </ul>
                <div id="tabs-1" style="font-size:12px;">
                    {$contenido}
                </div>
            </div>
        </div>

        <br />
        <br />
        <input type="hidden" id="absolutePathSite" name="absolutePathSite" value="{$path}" >
        <!-- Ocultos -->
        <div id="loading-gral-sitio" title="{$tituloCargando}"><center><p>{$cargando}<br /><img src="{$path}/assets/imgs/ajax-loader.gif" /></p></center></div>        
    </body>
</html>
