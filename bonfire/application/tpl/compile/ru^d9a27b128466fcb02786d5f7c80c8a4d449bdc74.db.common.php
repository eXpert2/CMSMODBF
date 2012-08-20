<?php /* Smarty version Smarty-3.1.7, created on 2012-08-20 22:51:04
         compiled from "db:common" */ ?>
<?php /*%%SmartyHeaderCode:50204f49f281423b06-79244401%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9a27b128466fcb02786d5f7c80c8a4d449bdc74' => 
    array (
      0 => 'db:common',
      1 => 1345485063,
      2 => 'db',
    ),
  ),
  'nocache_hash' => '50204f49f281423b06-79244401',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f49f2814822e',
  'variables' => 
  array (
    'Page' => 0,
    'THEME_PATH' => 0,
    'data' => 0,
    'website' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f49f2814822e')) {function content_4f49f2814822e($_smarty_tpl) {?><?php if (!is_callable('smarty_function_assets')) include 'Y:\\home\\uz\\bonfire\\bonfire\\application\\third_party\\smarty\\plugins\\function.assets.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title><?php echo $_smarty_tpl->tpl_vars['Page']->value->title;?>
</title>

	<meta name="keywords" content="css, grid, atatonic, zotonic, tim benniks, tbdesigns, typography" />
	<meta name="description" content="This is the project page for the CSS Framework Atatonic. Atatonic is meant to make your web&mdash;life easier and is created to provide a stable grid and solid typography." />
	<meta name="author" content="Tim Benniks" />
	
	<link href="<?php echo $_smarty_tpl->tpl_vars['THEME_PATH']->value;?>
/lib/css/zp-base.css" type="text/css" media="all" rel="stylesheet" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['THEME_PATH']->value;?>
/lib/css/zp-type.css" type="text/css" media="all" rel="stylesheet" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['THEME_PATH']->value;?>
/lib/css/zp-forms.css" type="text/css" media="all" rel="stylesheet" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['THEME_PATH']->value;?>
/lib/css/zp-print.css" type="text/css" media="print" rel="stylesheet" />
	
	<!--[if IE]>
	<link href="<?php echo $_smarty_tpl->tpl_vars['THEME_PATH']->value;?>
/lib/css/zp-ie.css" type="text/css" media="screen" rel="stylesheet" />
	<![endif]-->
	<?php echo smarty_function_assets(array('place'=>'header'),$_smarty_tpl);?>
	

	<style type="text/css">
		body {
			background: #fff url(<?php echo $_smarty_tpl->tpl_vars['THEME_PATH']->value;?>
/lib/images/gridbg.gif);
		}
		
		#sidebar {
			font-size: 11px;
		}
		
		p.intro { 
			font-style: bold;
		} 
		
		.content .padding {
			padding: 0 100px 0 0;
		}
		
		.item .padding {
			padding: 0 12px 0 0;
		}
		
		.list-item h2 {
			margin: 0;
			line-height: 36px;
		}
		
		blockquote p {
			margin: 0;
		}

		fieldset {
			padding: 0 9px 9px
		}
		
		.at-wrapper {
			margin: 18px auto 0;
		}
		
	</style>
</head>

<body>

<div class="skip">
	<a href="#content" title="Go directly to page content">Go to page content</a>
</div>

<div class="at-wrapper">
	<div class="at-70 content">
		<div class="padding">
			<h1><?php echo $_smarty_tpl->tpl_vars['Page']->value->title;?>
 </h1>
			
			<?php if ($_smarty_tpl->tpl_vars['data']->value){?>	
			<h2>// <?php echo $_smarty_tpl->tpl_vars['data']->value->title;?>
</h2>
			<?php echo $_smarty_tpl->tpl_vars['data']->value->text;?>

			<?php if ($_smarty_tpl->tpl_vars['website']->value){?>	Веб сайт компании: <?php echo $_smarty_tpl->tpl_vars['website']->value['value'];?>
 <br><?php }?>
			<?php }?>	
	
			<?php echo $_smarty_tpl->getSubTemplate ('db:dslist', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

			
		</div>
	</div>

	<div id="sidebar" class="at-30">
		<?php echo $_smarty_tpl->getSubTemplate ('db:menu', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
		
	</div>
</div>
<?php echo smarty_function_assets(array('place'=>'footer'),$_smarty_tpl);?>
	

</body>
</html><?php }} ?>