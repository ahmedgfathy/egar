<?php /* Smarty version Smarty-3.1.7, created on 2023-03-30 11:46:44
         compiled from "/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Reports/ChartReportContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:116670569642576a40a7a67-19384765%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf51b9b60fe787bfc9141cf57281e57635b4f69a' => 
    array (
      0 => '/home/ocl95zm2k51h/public_html/crm.elhadaba-rs.com/includes/runtime/../../layouts/vlayout/modules/Reports/ChartReportContents.tpl',
      1 => 1623062736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '116670569642576a40a7a67-19384765',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CHART_TYPE' => 0,
    'DATA' => 0,
    'CLICK_THROUGH' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_642576a40ad55',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_642576a40ad55')) {function content_642576a40ad55($_smarty_tpl) {?>

<input type='hidden' name='charttype' value="<?php echo $_smarty_tpl->tpl_vars['CHART_TYPE']->value;?>
" />
<input type='hidden' name='data' value='<?php echo $_smarty_tpl->tpl_vars['DATA']->value;?>
' />
<input type='hidden' name='clickthrough' value="<?php echo $_smarty_tpl->tpl_vars['CLICK_THROUGH']->value;?>
" />

<br>
<div style="margin:0px 20px;">
	<div class='border1px' style="padding:30px 100px;">
		<div id='chartcontent' style="min-height:400px;" ></div>
		<br>
		<?php if ($_smarty_tpl->tpl_vars['CLICK_THROUGH']->value!='true'){?>
			<div class='row-fluid alert-info' style="padding:20px">
				<span class='span3 offset4'> &nbsp;</span>
				<span class='span alert-info'>
					<i class="icon-info-sign"></i>
					<?php echo vtranslate('LBL_CLICK_THROUGH_NOT_AVAILABLE',$_smarty_tpl->tpl_vars['MODULE']->value);?>

				</span>
			</div>
			<br>
		<?php }?>
	</div>
</div>
<br>
<?php }} ?>