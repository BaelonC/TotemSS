<?php
/* Smarty version 4.3.0, created on 2023-10-16 07:07:05
  from '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/NegarAcceso.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_652d276999d513_40084101',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6e15b9fb54cabe943ea93a026c7d6b7e64770ef8' => 
    array (
      0 => '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/NegarAcceso.tpl',
      1 => 1697457981,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_652d276999d513_40084101 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="NegarAcceso_Mensaje" class="contenedor-mensaje">
    <div id="NegarAcceso_instruccion_nombre" class="titulo"><h3>El acceso ha sido denegado <?php echo $_smarty_tpl->tpl_vars['TipoDocumento']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['RutPersona']->value;?>
</h3></div>
    
    <div id="NegarAcceso_lblnombre" class="lblnombre">Nombre</div>
    <div id="NegarAcceso_nombre" class="nombre"><?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
</div>
    <div id="NegarAcceso_lblapaterno" class="lblapaterno">Apellido Paterno</div>    
    <div id="NegarAcceso_apaterno" class="apaterno"><?php echo $_smarty_tpl->tpl_vars['apellido_p']->value;?>
</div>
    <div id="NegarAcceso_lblamaterno" class="lblamaterno">Apellido Materno</div>        
    <div id="NegarAcceso_amaterno" class="amaterno"><?php echo $_smarty_tpl->tpl_vars['apellido_m']->value;?>
</div>    
    
    <div id="NegarAcceso_safenombre" class="volver">        
        <button id="NegarAcceso_btn_volver" type="button" class="btn btn-primary" ><i class="bi bi-arrow-return-left"></i>Volver</button> 
    </div>            
</div>

<?php }
}
