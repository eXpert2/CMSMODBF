<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

function smarty_function_assets($params, $template)
{
  switch($params['place'])
  {
  	case"header":
  	$assets = "
<script src=\"".base_url()."assets/js/head.min.js\"></script>
<script src=\"".base_url()."assets/js/jquery-1.5.min.js\"></script>
<script>
head.feature(\"placeholder\", function() {
	var inputElem = document.createElement('input');
	return new Boolean('placeholder' in inputElem);
});
</script>";
 $assets .= Assets::css();
  	break;
  	case"footer":
	$assets = "
<script>
	head.js(".Assets::external_js(null, true).");
</script>";
    $assets .= Assets::module_js();
    $assets .= Assets::inline_js();
  	break;
  }

  echo $assets;
}


?>