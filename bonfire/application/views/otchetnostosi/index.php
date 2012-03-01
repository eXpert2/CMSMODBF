<?php
$f1=array(
    'xtype'=>'panel',
    'items'=> array(
        array(
            'xtype'=>'toolbar',
            'items'=>array(
                    array(
                        'xtype'=>'button',
                        'text'=>'Добавить'
                    ),
                    array(
                        'xtype'=>'button',
                        'text'=>'Редактировать'
                    ),
                    array(
                        'xtype'=>'button',
                        'text'=>'Удалить'
                    )
                )
            ),
        array(
            'xtype'=>'panel',
            'height'=>'300',
            'items'=>array(
                    array(
                        'xtype'=>'treepanel',
                        'id'=>'packages_tree',
                        'title'=>'Дерево',
                        'text'=>'Добавить',
                        'region'=>'west',
                        'width'=> 200,
                        'height'=> 700,
                        'rootVisible'=>false,
                        //'itemclick'=>'%listen1%'          
                        //,//( Ext.view.View this, Ext.data.Model record, HTMLElement item, Number index, Ext.EventObject e, Object eOpts )
                        'root'=>array(
                            'text'=>'Корень',
                            'expanded'=>true,
                            'children'=>array(
                                array('text'=>'Первый','leaf'=> true),
                                array('text'=>'Второй','leaf'=> true)
                                )
                            )
                        
                    )

                )
            )            
    )
);

$listen1='function(){alert(\'click el\');}';

$f2= json_encode($f1);
//$f2=str_replace('"%listen1%"',$listen1,$f2);
echo $f2;
exit;
?>