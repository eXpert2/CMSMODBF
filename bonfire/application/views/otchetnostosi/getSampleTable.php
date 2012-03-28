<?php
$f=array(
    'success'=>true,
    'samples'=>$samples
);
$json = new Services_JSON;
echo $json->encode($f);
?>