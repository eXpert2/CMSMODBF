<?php /* Smarty version Smarty-3.1.7, created on 2012-08-20 18:37:13
         compiled from "db:dslist" */ ?>
<?php /*%%SmartyHeaderCode:307744f52937bd8bb67-88223963%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6be6db91d67742a6859e93261a3343cf3906cb80' => 
    array (
      0 => 'db:dslist',
      1 => 1345469830,
      2 => 'db',
    ),
  ),
  'nocache_hash' => '307744f52937bd8bb67-88223963',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f52937be47ab',
  'variables' => 
  array (
    'PageDSList' => 0,
    'ds' => 0,
    's' => 0,
    'Page' => 0,
    'param' => 0,
  ),
  'has_nocache_code' => false,
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
				<?php if ($_smarty_tpl->tpl_vars['ds']->value->ds_type=='catalog'){?>				
				<b>Список каталогов:</b><br>
				<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ds']->value->data['catalog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
				<?php echo $_smarty_tpl->tpl_vars['s']->value->left;?>
 id => <?php echo $_smarty_tpl->tpl_vars['s']->value->id;?>
; title => <a href="<?php echo $_smarty_tpl->tpl_vars['Page']->value->base_url;?>
page/<?php echo $_smarty_tpl->tpl_vars['Page']->value->name;?>
/<?php echo $_smarty_tpl->tpl_vars['s']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value->title;?>
</a>; item_count => <?php echo $_smarty_tpl->tpl_vars['s']->value->item_count;?>
<br>
				<?php } ?>
				<?php }?>			
			
				<?php if ($_smarty_tpl->tpl_vars['ds']->value->ds_type=='itemlist'&&$_smarty_tpl->tpl_vars['ds']->value->data['itemlist']){?>				
				
				<b>Список товаров каталога #<?php echo $_smarty_tpl->tpl_vars['ds']->value->data['itemlist']['catalog']->title;?>
(<?php echo $_smarty_tpl->tpl_vars['ds']->value->data['itemlist']['total'];?>
)#</b><br>
				<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ds']->value->data['itemlist']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
?>
				<b>Товар: id => <?php echo $_smarty_tpl->tpl_vars['s']->value->id;?>
; title => <?php echo $_smarty_tpl->tpl_vars['s']->value->title;?>
;</b><br>
					<?php if ($_smarty_tpl->tpl_vars['s']->value->itemparams){?>	
					<b>Параметры:</b><br>	
					<?php  $_smarty_tpl->tpl_vars['param'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['param']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['s']->value->itemparams; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['param']->key => $_smarty_tpl->tpl_vars['param']->value){
$_smarty_tpl->tpl_vars['param']->_loop = true;
?>
					<?php echo $_smarty_tpl->tpl_vars['param']->value->title;?>
 => <?php echo $_smarty_tpl->tpl_vars['param']->value->value;?>
; <br>
					<?php } ?>
					<?php }?>	
					<br>		
				<?php } ?>	
				<?php }?>				

				
						
			<?php } ?><?php }} ?>