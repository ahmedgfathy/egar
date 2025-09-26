<?php /* Smarty version Smarty-3.1.7, created on 2023-02-22 06:39:40
         compiled from "/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/Footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:176629797663f5b8ac2cdbd8-43923034%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'efd4f0f2f21547c3068984739f23166a7d5e0c18' => 
    array (
      0 => '/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Vtiger/Footer.tpl',
      1 => 1623063831,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176629797663f5b8ac2cdbd8-43923034',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ACTIVITY_REMINDER' => 0,
    'HEADER_LINKS' => 0,
    'MAIN_PRODUCT_SUPPORT' => 0,
    'MAIN_PRODUCT_WHITELABEL' => 0,
    'FIRSTHEADERLINK' => 0,
    'FIRSTHEADERLINKCHILDRENS' => 0,
    'FEEDBACKLINKMODEL' => 0,
    'CURRENT_USER_MODEL' => 0,
    'VTIGER_VERSION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_63f5b8ac2d6df',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63f5b8ac2d6df')) {function content_63f5b8ac2d6df($_smarty_tpl) {?>
<input id='activityReminder' class='hide noprint' type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ACTIVITY_REMINDER']->value;?>
"/><?php if ($_smarty_tpl->tpl_vars['HEADER_LINKS']->value&&$_smarty_tpl->tpl_vars['MAIN_PRODUCT_SUPPORT']->value&&!$_smarty_tpl->tpl_vars['MAIN_PRODUCT_WHITELABEL']->value){?><?php $_smarty_tpl->tpl_vars["FIRSTHEADERLINK"] = new Smarty_variable($_smarty_tpl->tpl_vars['HEADER_LINKS']->value[0], null, 0);?><?php $_smarty_tpl->tpl_vars["FIRSTHEADERLINKCHILDRENS"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIRSTHEADERLINK']->value->get('childlinks'), null, 0);?><?php $_smarty_tpl->tpl_vars["FEEDBACKLINKMODEL"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIRSTHEADERLINKCHILDRENS']->value[2], null, 0);?><div id="userfeedback" class="feedback noprint"><a href="https://discussions.vtiger.com" target="_blank" xonclick="<?php echo $_smarty_tpl->tpl_vars['FEEDBACKLINKMODEL']->value->get('linkurl');?>
" class="handle"><?php echo vtranslate("LBL_FEEDBACK","Vtiger");?>
</a></div><?php }?><?php if (!$_smarty_tpl->tpl_vars['MAIN_PRODUCT_WHITELABEL']->value&&isset($_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value)){?><footer class="noprint"><div class="vtFooter"><p><!--<?php echo vtranslate('POWEREDBY');?>
 <?php echo $_smarty_tpl->tpl_vars['VTIGER_VERSION']->value;?>
--> EL Hadaba RS.&nbsp;&copy; &nbsp;<?php echo date('Y');?>
&nbsp&nbsp;<a href="#" target="_blank">El Hadaba RS  Designed and Developed By Ahmed Fathy</a><!--&nbsp;|&nbsp;<a href="#" onclick="window.open('copyright.html','copyright', 'height=115,width=575').moveTo(210,620)"><?php echo vtranslate('LBL_READ_LICENSE');?>
</a>&nbsp;|&nbsp;<a href="https://www.vtiger.com/crm/privacy-policy" target="_blank"><?php echo vtranslate('LBL_PRIVACY_POLICY');?>
</a>--></p></div></footer><?php }?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('JSResources.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></body></html>
<?php }} ?>