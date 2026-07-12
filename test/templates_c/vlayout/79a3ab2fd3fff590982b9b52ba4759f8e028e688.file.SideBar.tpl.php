<?php /* Smarty version Smarty-3.1.7, created on 2026-07-12 14:08:16
         compiled from "/mnt/c/Users/ahmed/Downloads/egar/egar/includes/runtime/../../layouts/vlayout/modules/Vtiger/SideBar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16700594616a539fd03c3ab6-81440405%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79a3ab2fd3fff590982b9b52ba4759f8e028e688' => 
    array (
      0 => '/mnt/c/Users/ahmed/Downloads/egar/egar/includes/runtime/../../layouts/vlayout/modules/Vtiger/SideBar.tpl',
      1 => 1783862618,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16700594616a539fd03c3ab6-81440405',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6a539fd04921c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6a539fd04921c')) {function content_6a539fd04921c($_smarty_tpl) {?>
<div class="sideBarContents"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SideBarLinks.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="clearfix"></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SideBarWidgets.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }} ?>