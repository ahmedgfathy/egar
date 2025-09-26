<?php /* Smarty version Smarty-3.1.7, created on 2024-10-05 11:11:42
         compiled from "/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Import/Import_Basic_Buttons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:155465981267011eee4a0052-86043311%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '824aa7a7d93f1c65f6d8047d8ae76df7291b5a6a' => 
    array (
      0 => '/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Import/Import_Basic_Buttons.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155465981267011eee4a0052-86043311',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'FOR_MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_67011eee4a7d6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_67011eee4a7d6')) {function content_67011eee4a7d6($_smarty_tpl) {?>

<button type="submit" name="next"  class="btn btn-success"
		onclick="return ImportJs.uploadAndParse();"><strong><?php echo vtranslate('LBL_NEXT_BUTTON_LABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>
&nbsp;&nbsp;
<a name="cancel" class="cursorPointer cancelLink" value="<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" onclick="location.href='index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=List'">
		<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>

</a><?php }} ?>