<html>
    <head>
        <!-- Estilos -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css'>
        {foreach from=$estilos item=estilo}
            <link rel="stylesheet" type="text/css" media="screen" href="{$estilo}" />
        {/foreach}

        <!-- Scripts -->
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        {foreach from=$scripts item=script}
            <script type="text/javascript" src="{$smarty.const._URL_}/{$script}" ></script>
        {/foreach}
        
        <title>{$smarty.const._LOGINTITULODEACCESO_}</title>
    </head>
    <body>
        <div class="container">    
            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">{$smarty.const._LOGINMSGBIENVENIDA_}</div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="loginForm" class="form-horizontal" role="form">
                            <input type="hidden" id="absolutePathSite" name="absolutePathSite" value="{$smarty.const._URL_}" />
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="home_login_usr" type="text" class="form-control" name="home_login_usr" value="" placeholder="{$smarty.const._LOGINMSGPLACEHOLDERUSUARIO_}">
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="home_login_passwd" type="password" class="form-control" name="home_login_passwd" placeholder="{$smarty.const._LOGINMSGPLACEHOLDERPASSWD_}">
                            </div>

                            <div class="input-group">
                                <div class="checkbox">
                                    <label>
                                        <input id="home_login_remember_me" type="checkbox" name="home_login_remember_me" value="1"> {$smarty.const._LOGINMSGTEXTORECORDARDATOS_}
                                    </label>
                                </div>
                            </div>

                            <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                <div class="col-sm-12 controls">
                                  <button type="button" id="btn-login" name="btn-login" class="btn btn-primary btn-sm" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {$smarty.const._LOGINMSGTEXTOLOADING_}">{$smarty.const._LOGINMSGTEXTOBTNACCESO_}</button>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%; text-align: center" >
                                        {$smarty.const._LOGINMSGOLVIDACONTRASENA_}
                                        <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                            {$smarty.const._LOGINMSGLINKRECUPERACONT_}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>     

                    </div>                     
                </div>  
            </div>
        </div>
    </body>
</html>
