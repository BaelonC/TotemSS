<?php
/* Smarty version 4.3.0, created on 2023-03-01 09:10:14
  from '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/Errores.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff6ad6bdf755_55606074',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b900ff9c692dd91aa6089c49146cd44936f3829e' => 
    array (
      0 => '/home/fernando.garcia/workspace/apl/php/PruebasConcepto/totem/app/Views/Auth/Errores.tpl',
      1 => 1672260127,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ff6ad6bdf755_55606074 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $_smarty_tpl->tpl_vars['mensaje_titulo']->value;?>
</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo $_smarty_tpl->tpl_vars['mensaje']->value;?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Entendido</button>        
      </div>
    </div>
  </div>
</div>

<?php }
}
