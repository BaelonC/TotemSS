<?php
/* Smarty version 4.3.0, created on 2023-01-25 09:29:43
  from '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/scaner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63d14ae79290e3_29134958',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c243e4c991a337d9b39cffe1c39419c84152bf0' => 
    array (
      0 => '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/scaner.tpl',
      1 => 1674655891,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63d14ae79290e3_29134958 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="recepcion" class="contenedor-recepcion">
<div id="establecimiento" class="establecimiento">
            <?php echo $_smarty_tpl->tpl_vars['nombre_establecimiento']->value;?>

    </div>
    <div id="ayuda" class="ayuda">
        <img src="<?php echo $_smarty_tpl->tpl_vars['rut_frente']->value;?>
" alt="Rut" width="40%" height="40%">
        <img src="<?php echo $_smarty_tpl->tpl_vars['rut_back']->value;?>
" alt="Rut" width="40%" height="40%">
    </div>
    <div id="otro_medio" class="otro"> 
        <button type="button" id="OtroIdentificador" class="btn btn-primary" onclick="getRegistroManual('<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
')">Registro Manual</button>
    </div>         
</div>                  
<input type="hidden" id="barra" name="barra" value="">
            

 

<?php }
}
