<?php
$f=array(
    'success'=>true,
    'groups'=>$groups
);
$json = new Services_JSON;
echo $json->encode($f);
?>