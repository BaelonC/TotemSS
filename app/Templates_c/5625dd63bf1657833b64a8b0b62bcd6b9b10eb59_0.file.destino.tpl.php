<?php
/* Smarty version 4.3.0, created on 2022-12-26 06:37:17
  from '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/destino.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63a9957d655b18_65279514',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5625dd63bf1657833b64a8b0b62bcd6b9b10eb59' => 
    array (
      0 => '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/destino.tpl',
      1 => 1672056759,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63a9957d655b18_65279514 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="destinos" class="contenedor-destinos">    
    <div id="establecimiento" class="nombre_establecimiento"><?php echo $_smarty_tpl->tpl_vars['Establecimiento']->value;?>
</div>
    <div id="rut_visita" class="Rut"><?php echo $_smarty_tpl->tpl_vars['RutPersona']->value;?>
</div>
    <div id="nombre_visita" class="persona"><?php echo $_smarty_tpl->tpl_vars['NombrePersona']->value;?>
</div>    
    <div id="tabs" class="Destinos">
      <ul>
         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Destinos']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?> 
             <li><a href="#tabs-<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
">Piso <?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</a></li>
         <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>  
      </ul>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Destinos']->value, 'Destino', false, 'key', 'outer', array (
));
$_smarty_tpl->tpl_vars['Destino']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['Destino']->value) {
$_smarty_tpl->tpl_vars['Destino']->do_else = false;
?>  

          <div id="tabs-<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
">      
                <div class="widget">               
                   <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Destino']->value, 'DatosSala', false, 'key2', 'inner', array (
));
$_smarty_tpl->tpl_vars['DatosSala']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key2']->value => $_smarty_tpl->tpl_vars['DatosSala']->value) {
$_smarty_tpl->tpl_vars['DatosSala']->do_else = false;
?>
                       <input type="button" id="P_<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
_<?php echo $_smarty_tpl->tpl_vars['DatosSala']->value['id_sala'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['DatosSala']->value['sala'];?>
" onclick="registrar_entrada('<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['DatosSala']->value['id_sala'];?>
')" >  
                   <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>  
                </div>    
          </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>  
    </div>
</div><?php }
}
