<?php /* Smarty version Smarty-3.1.7, created on 2023-02-09 13:16:50
         compiled from "/home/abdo/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Calendar/SideBarWidgets.tpl" */ ?>
<?php /*%%SmartyHeaderCode:179121128663e4f2424634b0-02781140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5055f114d0939f53a0db6e15f804ac133fd68fa' => 
    array (
      0 => '/home/abdo/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Calendar/SideBarWidgets.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '179121128663e4f2424634b0-02781140',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUICK_LINKS' => 0,
    'MODULE' => 0,
    'SIDEBARWIDGET' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_63e4f24247d5c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63e4f24247d5c')) {function content_63e4f24247d5c($_smarty_tpl) {?>
<div class="quickWidgetContainer accordion"><?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable(1, null, 0);?><?php  $_smarty_tpl->tpl_vars['SIDEBARWIDGET'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['SIDEBARWIDGET']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['QUICK_LINKS']->value['SIDEBARWIDGET']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['SIDEBARWIDGET']->key => $_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value){
$_smarty_tpl->tpl_vars['SIDEBARWIDGET']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['SIDEBARWIDGET']->key;
?><div class="quickWidget"><div class="accordion-heading accordion-toggle quickWidgetHeader" data-target="#<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_sideBar_<?php echo Vtiger_Util_Helper::replaceSpaceWithUnderScores($_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getLabel());?>
"data-toggle="collapse" data-parent="#quickWidgets" data-label="<?php echo $_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getLabel();?>
"data-widget-url="<?php echo $_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getUrl();?>
" ><span class="pull-left"><img class="imageElement" data-rightimage="<?php echo vimage_path('rightArrowWhite.png');?>
" data-downimage="<?php echo vimage_path('downArrowWhite.png');?>
" src="<?php echo vimage_path('rightArrowWhite.png');?>
" /></span><?php if ($_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getLabel()=='LBL_ADDED_CALENDARS'||$_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getLabel()=='LBL_ACTIVITY_TYPES'){?><span class="pull-right"><i class="icon-plus addCalendarView" title="<?php echo vtranslate('LBL_ADD_CALENDAR_VIEW',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></i></span><?php }?><h5 class="title widgetTextOverflowEllipsis" title="<?php echo vtranslate($_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h5><div class="loadingImg hide pull-right"><div class="loadingWidgetMsg"><strong><?php echo vtranslate('LBL_LOADING_WIDGET',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></div></div><div class="clearfix"></div></div><div class="widgetContainer accordion-body collapse" id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_sideBar_<?php echo Vtiger_Util_Helper::replaceSpaceWithUnderScores($_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getLabel());?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['SIDEBARWIDGET']->value->getUrl();?>
"></div></div><?php } ?></div><?php }} ?>