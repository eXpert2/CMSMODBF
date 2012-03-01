<?php echo Template::message(); ?>
<?php echo isset($content) ? $content : Template::yield(); ?>