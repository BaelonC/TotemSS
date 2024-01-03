<?php
/* Smarty version 4.3.0, created on 2023-01-20 08:16:15
  from '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/sin_scaner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63caa22fb2f451_67536588',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b4c25a2ecae613fa4c992509afa4b3f22d93cce9' => 
    array (
      0 => '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/sin_scaner.tpl',
      1 => 1674224168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63caa22fb2f451_67536588 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="medio_alternativo" class="contenedor-docto-alternativo">
    <div id="paises" class="pais">
        <select id="lstpaises" class="form-select" >
            <option selected>País de Origen</option>
           <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['paises']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?> 
             <option id="paises_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->getCodigo();?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->getDESCRIPCION();?>
</option>
           <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>              
        </select>
    </div>
    <div id="tipo_documento" class="tipos">
        <select id="TipDocto" class="form-select" >
            <option selected>T. docto. identificación</option>
           <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tipDctoIdentificacion']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?> 
             <option id="paises_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->getCodigo();?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->getDESCRIPCION();?>
</option>
           <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>              
        </select>        
    </div>
    <div id="val_tipo_documento" class="valtipo">        
        <input id="valor_documento" type="text" value=""">
    </div>
    <div id="teclado" class="teclado">
            <div id="teclado_numerico" class="contenedor-teclado">
                <div id="tecla1" class="tecla1"><button type="button" class="tecla1 btn btn-light" onclick="addchar('1');">1</button></div>
                <div id="tecla2" class="tecla2"><button type="button" class="tecla2 btn btn-light" onclick="addchar('2');">2</button></div>
                <div id="tecla3" class="tecla3"><button type="button" class="tecla3 btn btn-light" onclick="addchar('3');">3</button></div>
                <div id="tecla4" class="tecla4"><button type="button" class="tecla4 btn btn-light" onclick="addchar('4');">4</button></div>
                <div id="tecla5" class="tecla5"><button type="button" class="tecla5 btn btn-light" onclick="addchar('5');">5</button></div>
                <div id="tecla6" class="tecla6"><button type="button" class="tecla6 btn btn-light" onclick="addchar('6');">6</button></div>
                <div id="tecla7" class="tecla7"><button type="button" class="tecla7 btn btn-light" onclick="addchar('7');">7</button></div>
                <div id="tecla8" class="tecla8"><button type="button" class="tecla8 btn btn-light" onclick="addchar('8');">8</button></div>
                <div id="tecla9" class="tecla9"><button type="button" class="tecl9 btn btn-light" onclick="addchar('9');">9</button></div>
                <div id="tecla0" class="tecla0"><button type="button" class="tecla0 btn btn-light" onclick="addchar('0');">0</button></div>
                <div id="tipteclado" class="tipteclado"><button type="button" class="tipteclado btn btn-light" onclick="ChangeTeclado();"><i class="bi bi-keyboard"></i></button></div>
                <div id="teclaDEL" class="teclaDEL"><button type="button" class="teclaDEL btn btn-light" onclick="delchar();"><i class="bi bi-eraser"></i></button></div>
            </div>
    </div>            
    <div id="acciones" class="acciones">
        <button type="button" class="btn btn-primary" onclick="registroManual('<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
');"><i class="bi bi-arrow-return-left"></i> REGISTRAR</button>        
    </<div>
</div>
            
<?php }
}
