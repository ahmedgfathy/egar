<?php /* Smarty version Smarty-3.1.7, created on 2023-02-04 13:38:05
         compiled from "/home/abdo/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/EditView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:81400772163de5fbd547707-73373529%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22d45a00cbedcde8411e3ab15c99b636281fbdce' => 
    array (
      0 => '/home/abdo/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/EditView.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '81400772163de5fbd547707-73373529',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_63de5fbd54af1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63de5fbd54af1')) {function content_63de5fbd54af1($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewBlocks.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewActions.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>