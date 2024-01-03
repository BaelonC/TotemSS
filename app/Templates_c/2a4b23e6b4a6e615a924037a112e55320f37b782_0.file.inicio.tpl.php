<?php
/* Smarty version 4.3.0, created on 2023-10-12 06:29:13
  from '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/inicio.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6527d889e893a5_97581246',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a4b23e6b4a6e615a924037a112e55320f37b782' => 
    array (
      0 => '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/inicio.tpl',
      1 => 1697109416,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6527d889e893a5_97581246 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="es">
        <head>
                <meta charset="utf-8" />
                 <title>totem</title>
                <meta name="generator" content="Geany 1.38" />
                <link href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/css/inicio_totem.css" rel="stylesheet"  type="text/css"> 
                <link href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/jquery-ui-1.13.2.custom/jquery-ui.css" rel="stylesheet"  type="text/css">
                <link href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/bootstrap/dist/css/bootstrap.css" rel="stylesheet"  type="text/css">
                <link href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/bootstrap/icons/font/bootstrap-icons.css" rel="stylesheet"  type="text/css">
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/js/jquery-3.6.1.js"><?php echo '</script'; ?>
>
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/jquery-ui-1.13.2.custom/external/jquery/jquery.js"><?php echo '</script'; ?>
>
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/jquery-ui-1.13.2.custom/jquery-ui.js"><?php echo '</script'; ?>
>
                <!--
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/js/LibCore.js"><?php echo '</script'; ?>
>
                -->
                <?php echo '<script'; ?>
 type="module" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/js/pistola.js"><?php echo '</script'; ?>
> 
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/js/LogicaGui.js"><?php echo '</script'; ?>
> 
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/bootstrap/dist/js/bootstrap.js"><?php echo '</script'; ?>
> 
                <?php echo '<script'; ?>
 type="text/javascript">
                   _UrlBase ='<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
';
                   _host = '<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
';                    
                <?php echo '</script'; ?>
>
        </head>
        <body id="main">
            
            <div id="inicio">
                <p>Bienvenido a Totem <?php echo $_smarty_tpl->tpl_vars['host']->value;?>
</p>
            </div>
                
        </body>
 
</html>

<?php }
}
