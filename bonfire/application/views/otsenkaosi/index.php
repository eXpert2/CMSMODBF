<script>
var terpanel = Ext.create('Ext.Panel', {
        id:'main-panel',
        baseCls:'x-plain',
        style:'padding:5px;',
        layout: {
            type: 'table',
            columns: 16
        },
        // applied to child components
        defaults: {frame:false, width:60, height: 25},
        items:[
        {
            html:'Заголовок таблицы',
            colspan:16,
            width:960
        }
        <? for($i=1;$i<=100;$i++){ ?>
        ,{
            html:'ячейка<?=$i?>',
        }
        <? } ?>

        ]
    });

    Ext.getCmp('maintabs').getActiveTab().add(terpanel);

</script>

