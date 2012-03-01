<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo config_item('site.title'); ?></title>
	<?php echo Assets::css(); ?>
    <script src="/assets/js/extjs407/ext-all.js" type="text/javascript" ></script>
</head>
<body>
			<?php echo Template::message(); ?>
			<?php echo isset($content) ? $content : Template::yield(); ?>


        <div id="dev" style="display:none;">
        <?php if (ENVIRONMENT == 'development') :?>
			<p style="float: right; margin-right: 80px;">Page rendered in {elapsed_time} seconds, using {memory_usage}.</p>
		<?php endif; ?>
        </div>

	    <div id="debug" style="display:none;"></div>

</body>
</html>