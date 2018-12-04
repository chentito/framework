<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-10-17 18:47:24
         compiled from "C:\htdocs\vistas\Home\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:318065315bc7641ec488f3-61954462%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1de78f617910a7a93aa3e14bb922d99d32c71e5' => 
    array (
      0 => 'C:\\htdocs\\vistas\\Home\\login.tpl',
      1 => 1539802042,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '318065315bc7641ec488f3-61954462',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5bc7641ec953c0_35538792',
  'variables' => 
  array (
    'estilos' => 0,
    'estilo' => 0,
    'scripts' => 0,
    'script' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5bc7641ec953c0_35538792')) {function content_5bc7641ec953c0_35538792($_smarty_tpl) {?><html>
    <head>
        <!-- Estilos -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css'>
        <?php  $_smarty_tpl->tpl_vars['estilo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['estilo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['estilos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['estilo']->key => $_smarty_tpl->tpl_vars['estilo']->value) {
$_smarty_tpl->tpl_vars['estilo']->_loop = true;
?>
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $_smarty_tpl->tpl_vars['estilo']->value;?>
" />
        <?php } ?>

        <!-- Scripts -->
        <?php echo '<script'; ?>
 src="//code.jquery.com/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"><?php echo '</script'; ?>
>
        <?php  $_smarty_tpl->tpl_vars['script'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['script']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['scripts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['script']->key => $_smarty_tpl->tpl_vars['script']->value) {
$_smarty_tpl->tpl_vars['script']->_loop = true;
?>
            <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('_URL_');?>
/<?php echo $_smarty_tpl->tpl_vars['script']->value;?>
" ><?php echo '</script'; ?>
>
        <?php } ?>
        
        <title><?php echo @constant('_LOGINTITULODEACCESO_');?>
</title>
    </head>
    <body>
        <div class="container">    
            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo @constant('_LOGINMSGBIENVENIDA_');?>
</div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="loginForm" class="form-horizontal" role="form">
                            <input type="hidden" id="absolutePathSite" name="absolutePathSite" value="<?php echo @constant('_URL_');?>
" />
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="home_login_usr" type="text" class="form-control" name="home_login_usr" value="" placeholder="<?php echo @constant('_LOGINMSGPLACEHOLDERUSUARIO_');?>
">
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="home_login_passwd" type="password" class="form-control" name="home_login_passwd" placeholder="<?php echo @constant('_LOGINMSGPLACEHOLDERPASSWD_');?>
">
                            </div>

                            <div class="input-group">
                                <div class="checkbox">
                                    <label>
                                        <input id="home_login_remember_me" type="checkbox" name="home_login_remember_me" value="1"> <?php echo @constant('_LOGINMSGTEXTORECORDARDATOS_');?>

                                    </label>
                                </div>
                            </div>

                            <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                <div class="col-sm-12 controls">
                                  <button type="button" id="btn-login" name="btn-login" class="btn btn-primary btn-sm" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php echo @constant('_LOGINMSGTEXTOLOADING_');?>
"><?php echo @constant('_LOGINMSGTEXTOBTNACCESO_');?>
</button>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%; text-align: center" >
                                        <?php echo @constant('_LOGINMSGOLVIDACONTRASENA_');?>

                                        <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                            <?php echo @constant('_LOGINMSGLINKRECUPERACONT_');?>

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
<?php }} ?>
