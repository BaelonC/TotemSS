<?php
/* Smarty version 4.3.0, created on 2023-01-18 08:36:22
  from '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/completarDatosPersona.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63c803e6cb6f00_74301085',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '237f34095293bfe77b8cfefc74d5b47c64441150' => 
    array (
      0 => '/home/juan.urrutia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/completarDatosPersona.tpl',
      1 => 1674052570,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63c803e6cb6f00_74301085 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="completaPersona" class="contenedor-completaPersona">
    <div id="instruccion_nombre" class="titulo"><h3>Ingrese los datos personales asociado al rut <?php echo $_smarty_tpl->tpl_vars['RutPersona']->value;?>
</h3></div>
    <div id="lblnombre" class="lblnombre">Nombre</div>
    <div id="nombre" class="nombre"><input id="nom_persona" type="text" values="" class="nombre"></div>
    <div id="lblapaterno" class="lblapaterno">Apellido Materno</div>    
    <div id="apaterno" class="apaterno"><input id="nom_apaterno" type="text" values=""></div>
    <div id="lblamaterno" class="lblamaterno">Apellido Materno</div>        
    <div id="amaterno" class="amaterno"><input id="nom_amaterno" type="text" values=""></div>    
    <div id="safenombre" class="safenombre">        
        <button id="btn_safenombre" type="button" class="btn btn-primary" onclick="updatePersona('<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
');"><i class="bi bi-arrow-return-left"></i>Registrar</button> 
    </div>        
</div>
<?php }
}
