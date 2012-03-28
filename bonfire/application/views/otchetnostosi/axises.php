<?php
$f=array(
    'success'=>true,
    'axises'=>$axises
);
$json = new Services_JSON;
echo $json->encode($f);
?>