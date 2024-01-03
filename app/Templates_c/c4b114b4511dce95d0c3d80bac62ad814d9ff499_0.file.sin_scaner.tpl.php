<?php
/* Smarty version 4.3.0, created on 2023-02-28 05:16:01
  from '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/sin_scaner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63fde2719818f0_08907793',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4b114b4511dce95d0c3d80bac62ad814d9ff499' => 
    array (
      0 => '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/sin_scaner.tpl',
      1 => 1677529782,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63fde2719818f0_08907793 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="sin_escaner_medio_alternativo" class="contenedor-docto-alternativo">
    <div id="sin_escaner_paises" class="pais">
        <select id="sin_escaner_lstpaises" class="form-select" >
            <option selected>País de Origen</option>
           <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['paises']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?> 
             <option id="sin_escaner_paises_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->getCodigo();?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->getDESCRIPCION();?>
</option>
           <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>              
        </select>
    </div>
    <div id="sin_escaner_tipo_documento" class="tipos">
        <select id="sin_escaner_TipDocto" class="form-select" >
            <option selected>T. docto. identificación</option>
           <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tipDctoIdentificacion']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?> 
             <option id="sin_escaner_paises_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->getCodigo();?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->getDESCRIPCION();?>
</option>
           <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>              
        </select>        
    </div>
    <div id="sin_escaner_val_tipo_documento" class="valtipo">        
        <input id="sin_escaner_valor_documento" type="text" value=""">
    </div>
    <div id="sin_escaner_teclado" class="teclado">
            <div id="sin_escaner_teclado_numerico" class="contenedor-teclado">
                <div id="sin_escaner_tecla1" class="tecla1"><button type="button" class="tecla1 btn btn-light" >1</button></div>
                <div id="sin_escaner_tecla2" class="tecla2"><button type="button" class="tecla2 btn btn-light" >2</button></div>
                <div id="sin_escaner_tecla3" class="tecla3"><button type="button" class="tecla3 btn btn-light" >3</button></div>
                <div id="sin_escaner_tecla4" class="tecla4"><button type="button" class="tecla4 btn btn-light" >4</button></div>
                <div id="sin_escaner_tecla5" class="tecla5"><button type="button" class="tecla5 btn btn-light" >5</button></div>
                <div id="sin_escaner_tecla6" class="tecla6"><button type="button" class="tecla6 btn btn-light" >6</button></div>
                <div id="sin_escaner_tecla7" class="tecla7"><button type="button" class="tecla7 btn btn-light" >7</button></div>
                <div id="sin_escaner_tecla8" class="tecla8"><button type="button" class="tecla8 btn btn-light" >8</button></div>
                <div id="sin_escaner_tecla9" class="tecla9"><button type="button" class="tecla9 btn btn-light" >9</button></div>
                <div id="sin_escaner_tecla0" class="tecla0"><button type="button" class="tecla0 btn btn-light" >0</button></div>
                <div id="sin_escaner_tipteclado" class="tipteclado"><button type="button" class="tipteclado btn btn-light"><i class="bi bi-keyboard"></i></button></div>
                <div id="sin_escaner_teclaDEL" class="teclaDEL"><button type="button" class="teclaDEL btn btn-light"><i class="bi bi-eraser"></i></button></div>
            </div>
    </div>            
    <div id="sin_escaner_acciones" class="acciones">
        <button  id="sin_escanear_btn_registrar" type="button" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i> REGISTRAR</button>        
    </<div>
        <input id="sin_escaner_tipo_teclado" type="hidden" value="1">
</div>
            
<?php }
}
