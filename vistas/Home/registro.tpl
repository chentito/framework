<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$tituloaccesotitle}</title>
    <!-- Estilos -->
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/jquery-ui-1.8.1.custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/ui_002.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/ui.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/{$tema}/panels.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/vistas/Home/css/login.css">
    <link rel="icon" media="screen" type="img/ico" href="{$path}/assets/imgs/favicon.ico">
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/Base.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/assets/css/BreadCrumb.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="{$path}/vistas/Registro/css/altaRegistro.css" />
    <!-- Uso general -->
    <script src="{$path}/assets/javascript/jquery-1.7.min.js"></script>
    <script src="{$path}/assets/javascript/generales.js"></script>
    <!-- Scripts -->
    <script type="text/javascript" src="{$path}/assets/javascript/jquery-1.7.min.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/jquery-ui-1.8.16.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/jquery-layout.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/grid.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/ui.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/jquery-jqgrid-3.7.2.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/generales.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/jquery.validate.min.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/additional-methods.min.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/jquery.maskedinput.js" ></script>
    <script type="text/javascript" src="{$path}/assets/javascript/jquery.jBreadCrumb.1.1.js"  ></script>
    <!--script type="text/javascript" src="{$path}/vistas/Registro/js/altaRegistro.js"  ></script-->
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    
</head>
<body>
    <section class="container" style="width: 90%; top: 20px">
        <div class="login" style="left: 10px; width: 90%">
            {include '../Registro/altaRegistro.tpl' }
        </div>        
    </section>
    <section class="about">
        {$poweredBy}<br />
        <image src="{$path}/assets/imgs/powered.png" width="100" >
    </section>
    <input type="hidden" id="absolutePathSite" name="absolutePathSite" value="{$path}" >
    <!-- Uso local -->
    <script src="{$path}/vistas/Home/js/login.js"></script>
    <section class="about">
        <a class="acceso_rapido" href="/Home/login/">ADMINISTRADOR</a>
    </section>
</body>
</html>
