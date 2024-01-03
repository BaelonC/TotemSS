<?php
/* Smarty version 4.3.0, created on 2022-12-13 11:41:30
  from '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/acceso.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6398b94ae354d4_09476312',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '471a6d723186ce94056c403d8fa8ae4a0460f101' => 
    array (
      0 => '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/acceso.tpl',
      1 => 1670952981,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6398b94ae354d4_09476312 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="es">
        <head>
                <meta charset="utf-8" />
                 <title>totem</title>
                <meta name="generator" content="Geany 1.38" />
                <link href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/css/inicio_totem.css" rel="stylesheet"  type="text/css">                
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/js/jquery-3.6.1.js"><?php echo '</script'; ?>
>
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/js/LibCore.js"><?php echo '</script'; ?>
>
                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
/js/pistola.js"><?php echo '</script'; ?>
> 
        </head>
        <body onload="init('<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
','barra')">
            
            <div>
            <div id="recepcion" class="contenedor-recepcion">
                <div id="establecimiento" class="establecimiento">
                           <?php echo $_smarty_tpl->tpl_vars['establecimiento']->value;?>

                </div>
                <div id="ayuda" class="ayuda">
                          <?php echo $_smarty_tpl->tpl_vars['ayuda']->value;?>

                </div> 
           
                <div id="otro_medio" class="otro"> 
                        <input type="submit" id="rut" name="rut" value="<?php echo $_smarty_tpl->tpl_vars['otro']->value;?>
"/>      
                </div> 
            
            
            
            </div>                  
                <input type="hidden" id="barra" name="barra" value="">
            
             </div> 
        </body>
 
</html>
<?php }
}
