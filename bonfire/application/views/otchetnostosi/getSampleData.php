<?php
$f=array(
    'success'=>true,
    'sample'=>$sample
);
$json = new Services_JSON;
echo $json->encode($f);
?>