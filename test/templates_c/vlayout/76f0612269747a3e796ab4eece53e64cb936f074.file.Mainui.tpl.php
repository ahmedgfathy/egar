<?php /* Smarty version Smarty-3.1.7, created on 2023-03-14 14:28:36
         compiled from "/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/MailManager/Mainui.tpl" */ ?>
<?php /*%%SmartyHeaderCode:84035246364108494363fd9-78355205%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76f0612269747a3e796ab4eece53e64cb936f074' => 
    array (
      0 => '/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/MailManager/Mainui.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '84035246364108494363fd9-78355205',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MAILBOX' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_641084943698b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_641084943698b')) {function content_641084943698b($_smarty_tpl) {?>

<input type="hidden" name="refresh_timeout" id="refresh_timeout" value="<?php echo $_smarty_tpl->tpl_vars['MAILBOX']->value->refreshTimeOut();?>
"/><?php }} ?>