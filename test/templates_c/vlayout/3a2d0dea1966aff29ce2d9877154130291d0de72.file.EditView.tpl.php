<?php /* Smarty version Smarty-3.1.7, created on 2022-03-26 13:23:35
         compiled from "/var/www/vhosts/elhadaba-rs.com/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/EditView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:319031297623f13d7db9a16-42148307%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a2d0dea1966aff29ce2d9877154130291d0de72' => 
    array (
      0 => '/var/www/vhosts/elhadaba-rs.com/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/EditView.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '319031297623f13d7db9a16-42148307',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_623f13d7dbe9a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_623f13d7dbe9a')) {function content_623f13d7dbe9a($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewBlocks.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewActions.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>