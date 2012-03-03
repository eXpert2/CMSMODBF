<?php /* Smarty version Smarty-3.1.7, created on 2012-03-04 02:56:11
         compiled from "db:dslist" */ ?>
<?php /*%%SmartyHeaderCode:307744f52937bd8bb67-88223963%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6be6db91d67742a6859e93261a3343cf3906cb80' => 
    array (
      0 => 'db:dslist',
      1 => 1330811553,
      2 => 'db',
    ),
  ),
  'nocache_hash' => '307744f52937bd8bb67-88223963',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PageDSList' => 0,
    'ds' => 0,
    's' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f52937be47ab',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f52937be47ab')) {function content_4f52937be47ab($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['ds'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ds']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PageDSList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ds']->key => $_smarty_tpl->tpl_vars['ds']->value){
$_smarty_tpl->tpl_vars['ds']->_loop = true;
?>			
				<b>Прикрепленный источник: $<?php echo $_smarty_tpl->tpl_vars['ds']->value->name;?>
</b><br>
				<?php if ($_smarty_tpl->tpl_vars['ds']->value->ds_type=='recordlist'){?>				
				<b>Список из таблицы:</b><br>
					<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ds']->value->data['records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
					id => <?php echo $_smarty_tpl->tpl_vars['s']->value->id;?>
; title => <?php echo $_smarty_tpl->tpl_vars['s']->value->title;?>
<br>
					<?php } ?>	
				<br>	
				Страницы: <?php echo $_smarty_tpl->tpl_vars['ds']->value->data['pages'];?>
	
				<br>	
				<br>	
				<?php }?>	
				<?php if ($_smarty_tpl->tpl_vars['ds']->value->ds_type=='record'){?>				
				<b>Запись из таблицы:</b><br>
					id => <?php echo $_smarty_tpl->tpl_vars['ds']->value->data->id;?>
; title => <?php echo $_smarty_tpl->tpl_vars['ds']->value->data->title;?>
<br>
				<?php }?>		
				<?php if ($_smarty_tpl->tpl_vars['ds']->value->ds_type=='form'){?>				
				<b>Форма из таблицы:</b><br>
					Форма => <br><?php echo $_smarty_tpl->tpl_vars['ds']->value->data['form'];?>
<br>
				<?php }?>	
				<?php if ($_smarty_tpl->tpl_vars['ds']->value->ds_type=='field'){?>				
				<b>Произвольное поле:</b><br>
					Значение => <?php echo $_smarty_tpl->tpl_vars['ds']->value->data['value'];?>
<br>
				<?php }?>			
			<?php } ?><?php }} ?>