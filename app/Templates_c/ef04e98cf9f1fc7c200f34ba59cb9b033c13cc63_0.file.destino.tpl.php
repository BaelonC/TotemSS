<?php
/* Smarty version 4.3.0, created on 2023-03-21 08:00:25
  from '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/destino.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6419aa696cadf7_74040789',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ef04e98cf9f1fc7c200f34ba59cb9b033c13cc63' => 
    array (
      0 => '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/destino.tpl',
      1 => 1679403595,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6419aa696cadf7_74040789 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="destino_destinos" class="contenedor-destinos">    
    <div id="destino_nacionalidad" class="nacionalidad"><?php echo $_smarty_tpl->tpl_vars['nacionalidad']->value;?>
</div>
    <div id="destino_codigo_pais" class="codigo_pais"><?php echo $_smarty_tpl->tpl_vars['codigo_pais']->value;?>
</div>                
    <div id="destino_lbl_establecimiento" class="lbl_NEstablecimiento">Establecimiento</div>
    <div id="destino_establecimiento" class="nombre_establecimiento"><?php echo $_smarty_tpl->tpl_vars['Establecimiento']->value;?>
</div>
    <div id="destino_lbl_rut" class="lbl_rut"><?php echo $_smarty_tpl->tpl_vars['TipoDocumento']->value;?>
</div>
    <div id="destino_rut_visita" class="Rut"><?php echo $_smarty_tpl->tpl_vars['RutPersona']->value;?>
</div>
    <div id="destino_lbl_nombre_visita" class="lbl_persona">Nombre</div>
    <div id="destino_nombre_visita" class="nombre"><?php echo $_smarty_tpl->tpl_vars['NombrePersona']->value;?>
</div>        
    <div id="destino_apellido_p" class="apellido_p"><?php echo $_smarty_tpl->tpl_vars['apellido_p']->value;?>
</div>
    <div id="destino_apellido_m" class="apellido_m"><?php echo $_smarty_tpl->tpl_vars['apellido_m']->value;?>
</div>
    <div id="destino_tabs" class="Destinos">
      <ul>
         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Destinos']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?> 
             <li><a href="#destino_tabs-<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
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

          <div id="destino_tabs-<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
">      
                <div id="destino_widget-<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
" class="widget">               
                   <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Destino']->value, 'DatosSala', false, 'key2', 'inner', array (
));
$_smarty_tpl->tpl_vars['DatosSala']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key2']->value => $_smarty_tpl->tpl_vars['DatosSala']->value) {
$_smarty_tpl->tpl_vars['DatosSala']->do_else = false;
?>
                       <input type="button" id="destino_P_<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
_<?php echo $_smarty_tpl->tpl_vars['DatosSala']->value['id_sala'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['DatosSala']->value['sala'];?>
">  
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
