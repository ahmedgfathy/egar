<?php /* Smarty version Smarty-3.1.7, created on 2021-06-09 21:34:29
         compiled from "/var/www/html/hadaba/includes/runtime/../../layouts/vlayout/modules/MailManager/Mainui.tpl" */ ?>
<?php /*%%SmartyHeaderCode:205129772160c133e5a7eec4-42517714%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a14d1b46723c1b2a40992b38461c5d63d04474b' => 
    array (
      0 => '/var/www/html/hadaba/includes/runtime/../../layouts/vlayout/modules/MailManager/Mainui.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '205129772160c133e5a7eec4-42517714',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MAILBOX' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_60c133e5a83d9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_60c133e5a83d9')) {function content_60c133e5a83d9($_smarty_tpl) {?>

<input type="hidden" name="refresh_timeout" id="refresh_timeout" value="<?php echo $_smarty_tpl->tpl_vars['MAILBOX']->value->refreshTimeOut();?>
"/><?php }} ?>