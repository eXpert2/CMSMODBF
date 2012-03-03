<?php /* Smarty version Smarty-3.1.7, created on 2012-03-04 02:59:28
         compiled from "db:index" */ ?>
<?php /*%%SmartyHeaderCode:116754f4932d0e209b1-70896586%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '964cbe4867079da97672aa11fb0079ec6486222e' => 
    array (
      0 => 'db:index',
      1 => 1330811950,
      2 => 'db',
    ),
  ),
  'nocache_hash' => '116754f4932d0e209b1-70896586',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f4932d0e955e',
  'variables' => 
  array (
    'Page' => 0,
    'THEME_PATH' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f4932d0e955e')) {function content_4f4932d0e955e($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
			<h2>Atatonic CSS Framework</h2>

			<p class="intro">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	
			<?php echo $_smarty_tpl->getSubTemplate ('db:dslist', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
	
			
			<br><br>
			<form method="post" action="">
				<fieldset>
					<h2>Form example</h2>

	
					<div class="notification error">The email is not correct</div>
					<div class="notification notice">That looks like a weird city to live in.</div>
	
					<div class="form-item">
						<label for="name">Name:</label>
						<input tabindex="1" id="name" type="text" name="name" />
					</div>
					
					<div class="form-item">

						<label for="street">Street name:</label>
						<input tabindex="1" id="street" type="text" name="street" />
					</div>	
					
					<div class="form-item">
						<label for="city">City:</label>
						<input tabindex="2" id="city" type="text" name="city" class="form-field-notice" value="Mars" />
					</div>
					
					<div class="form-item">

						<label for="email">Email:</label>
						<input tabindex="3" id="email" type="text" name="e-mail" class="form-field-error" value="@atatonic.net" />
					</div>
					
					<div class="form-item">
						<label for="message">Message:</label>
						<textarea tabindex="4" id="message" name="message" rows="20" cols="85" class="wymeditor"></textarea>
					</div>

					
					<button>Send form</button>
				</fieldset>
			</form>
		</div>
	</div>

	<div id="sidebar" class="at-30">
		<h1>Sidebar</h1>

		<h2><a href="/">Main Page</a></h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		
		<h2><a href="/page/about">About Page</a></h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

		<hr />
		
		<div class="list-item">

			<h2>Some other stuff</h2>
			<h3>With a sweet subtitle. Yes it is a sweet one.</h3>
			<p>
				<img src="<?php echo $_smarty_tpl->tpl_vars['THEME_PATH']->value;?>
/lib/images/example.jpg" alt="Helvetica" />
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			</p>
		</div>
		
		<div class="notification notice">

			<h5>Atatonic notice</h5>
			This is a basic notice message, without a header it might even look nicer. 
		</div>
		
		<div class="notification success">
			<h5>Success</h5>
			This is a basic success message
		</div>
		
		<div class="notification error">
			<h5>Error</h5>

			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
		</div>
	</div>
</div>

</body>
</html>
<?php }} ?>