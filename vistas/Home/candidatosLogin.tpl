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
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
    <section class="container">
        <div class="login">
            <h1>{$tituloacceso}</h1>
            <form id="cliente_login_form" method="post" action="#">
                <p><input type="text" name="candidato_login_usr" id="candidato_login_usr" value="" placeholder="{$inputUsuario}"></p>
                <p><input type="password" name="candidato_login_passwd" id="candidato_login_passwd" value="" placeholder="{$inputPasswd}"></p>
                <p class="remember_me">
                <label>
                    <input type="checkbox" name="candidato_login_remember_me" id="candidato_login_remember_me">
                    {$recordarme}
                </label>
                </p>
                <p class="submit"><input type="submit" name="commit" value="{$botonEntrar}" onclick="return verificaLogin();"></p>
            </form>
        </div>
        <div class="login-help">
            <p>{$olvidaPasswd} <a href="{$path}/Home/recupera/">{$linkRestablece}</a>.</p>
        </div>
    </section>
    <section class="about">
        {$poweredBy}<br />
        <image src="{$path}/assets/imgs/powered.png" width="100" >
    </section>
    <input type="hidden" id="absolutePathSite" name="absolutePathSite" value="{$path}" >
    <!-- Uso local -->
    <script src="{$path}/vistas/Home/js/candidatosLogin.js"></script>
    <section class="about">
        <a class="acceso_rapido" href="/Home/login/">ADMIN</a> - 
        <a class="acceso_rapido" href="/Home/empleadosLogin/">EMPLEADOS</a> - 
        <a class="acceso_rapido" href="/Home/candidatosLogin/">CANDIDATOS</a> - 
        <a class="acceso_rapido" href="/Home/clientesLogin/">CLIENTES</a>
    </section>
</body>
</html>

