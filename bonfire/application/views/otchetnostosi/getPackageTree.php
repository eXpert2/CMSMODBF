
<?php

$tree=array(
    'success'=> true,
    'packages'=>array(
        'root'=>array(
                'text'=>'Корень',
                'expanded'=>true,
                'children'=>array(
                    array('text'=>'Первый','leaf'=> true),
                    array('text'=>'Второй','leaf'=> true)
                    )
        )
    )
);
$tree2=array(

        'root'=>array(
                'text'=>'Корень',
                'expanded'=>true,
                'children'=>array(
                    array('text'=>'Первый','leaf'=> true),
                    array('text'=>'Второй','leaf'=> true)
                    )
        )
);

echo json_encode($tree);

?>