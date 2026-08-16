<?php /* Smarty version Smarty-3.1.7, created on 2026-07-29 12:55:46
         compiled from "/var/www/html/egar/includes/runtime/../../layouts/vlayout/modules/Users/ChangePassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13166326676a69f852ad34e2-65408891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed2add99ae24f7f5ae70cb6a86f7b3c3ed418c92' => 
    array (
      0 => '/var/www/html/egar/includes/runtime/../../layouts/vlayout/modules/Users/ChangePassword.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13166326676a69f852ad34e2-65408891',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'USERID' => 0,
    'CURRENT_USER_MODEL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6a69f852b25c2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6a69f852b25c2')) {function content_6a69f852b25c2($_smarty_tpl) {?>
<div id="massEditContainer" class='modelContainer'><div class="modal-header contentsBackground"><button data-dismiss="modal" class="close" title="<?php echo vtranslate('LBL_CLOSE');?>
">&times;</button><h3 id="massEditHeader"><?php echo vtranslate('LBL_CHANGE_PASSWORD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h3></div><form class="form-horizontal" id="changePassword" name="changePassword" method="post" action="index.php"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="userid" value="<?php echo $_smarty_tpl->tpl_vars['USERID']->value;?>
" /><div name='massEditContent'><div class="modal-body"><div class="control-group"><?php if (!$_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value->isAdminUser()){?><label class="control-label"><?php echo vtranslate('LBL_OLD_PASSWORD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><div class="controls"><input type="password" name="old_password" data-validation-engine="validate[required]"/></div><?php }?></div><div class="control-group"><label class="control-label"><?php echo vtranslate('LBL_NEW_PASSWORD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><div class="controls"><input type="password" name="new_password" data-validation-engine="validate[required]"/></div></div><div class="control-group"><label class="control-label"><?php echo vtranslate('LBL_CONFIRM_PASSWORD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><div class="controls"><input type="password" name="confirm_password" data-validation-engine="validate[required]"/></div></div></div></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form></div>
<?php }} ?>