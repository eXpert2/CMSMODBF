<?php
$f=array(
    'success'=>true,
    'cubes'=>$cubes
);
$json = new Services_JSON;
echo $json->encode($f);
?>