<?php /* Smarty version Smarty-3.1.7, created on 2022-04-13 23:21:30
         compiled from "/var/www/vhosts/elhadaba-rs.com/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/dashboards/DashBoardWidgetContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:170820709962575afa720418-28718910%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12ee9f77636826f2e89c854d582c7b2023602224' => 
    array (
      0 => '/var/www/vhosts/elhadaba-rs.com/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/dashboards/DashBoardWidgetContents.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '170820709962575afa720418-28718910',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DATA' => 0,
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_62575afa72596',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62575afa72596')) {function content_62575afa72596($_smarty_tpl) {?>
<?php if (count($_smarty_tpl->tpl_vars['DATA']->value)>0){?><input class="widgetData" type=hidden value='<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['DATA']->value));?>
' /><div class="widgetChartContainer" style="height:250px;width:85%"></div><?php }else{ ?><span class="noDataMsg"><?php echo vtranslate('LBL_EQ_ZERO');?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 <?php echo vtranslate('LBL_MATCHED_THIS_CRITERIA');?>
</span><?php }?><?php }} ?>