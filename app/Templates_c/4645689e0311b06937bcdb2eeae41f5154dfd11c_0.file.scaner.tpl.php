<?php
/* Smarty version 4.3.0, created on 2023-03-01 12:09:29
  from '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/scaner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff94d9b4ab57_44109492',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4645689e0311b06937bcdb2eeae41f5154dfd11c' => 
    array (
      0 => '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/scaner.tpl',
      1 => 1677694165,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ff94d9b4ab57_44109492 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="scanner_recepcion" class="contenedor-recepcion">
<div id="scanner_establecimiento" class="establecimiento">
            <?php echo $_smarty_tpl->tpl_vars['nombre_establecimiento']->value;?>

    </div>
    <div id="ayuda" class="ayuda">
        <img src="<?php echo $_smarty_tpl->tpl_vars['rut_frente']->value;?>
" alt="Rut" width="40%" height="40%">
        <img src="<?php echo $_smarty_tpl->tpl_vars['rut_back']->value;?>
" alt="Rut" width="40%" height="40%">
    </div>
    <div id="otro_medio" class="otro"> 
        <button type="button" id="scanner_OtroIdentificador" class="btn btn-primary" >Registro Manual</button>
    </div> 
    <div id="mensajes-sistema" class="mensajes">
        
    </div>
</div>                  
<input type="hidden" id="scanner_barra" name="barra" value="">
            

 

<?php }
}
