<script>
var osipassportform = Ext.create('Ext.form.Panel', {
        url:'/getositree/passportosi/saveosiformdata',
        id:'osipassportform<?=$osiID?>',
        frame:true,
        title: 'Паспорт ОСИ',
        bodyStyle:'padding:5px 5px 0',
        width: 500,
        fieldDefaults: {
            msgTarget: 'side',
            labelWidth: 150
        },
        defaultType: 'textfield',
        defaults: {
            anchor: '100%'
        },

        items: [
        {
            xtype: 'hiddenfield',
            name: 'action',
            value:'saveosipassport'
        }
        <?
        foreach($osiformfields as $fld)
        {
        $fieldname = $fld->fieldname;
        $fieldvalue = $osivalue->$fieldname;

        ?>
        ,{
            fieldLabel: '<?=$fld->fieldtitle?>',
            name: '<?=$fld->fieldname?>',
            <?
            if($fld->fieldname=='id')
            {
            	echo "readOnly:true,\n";
            } else {
            ?>
            xtype:'<?=$fld->fldformtype?>',
            <? } ?>
            value:'<?=$fieldvalue?>'
        }
        <?
        }
        ?>

        ],

        buttons: [{
            text: 'Сохранить',
            handler:function(){
              Ext.getCmp('osipassportform<?=$osiID?>').getForm().submit({
              	success:function(f,a){
                  Ext.Msg.alert('Сохранено',a.result.msg);
              	},
              	failure:function(f,a){
                  Ext.Msg.alert('Ошибка',a.result.msg);
              	}
              });
            }
        },{
            text: 'Сбросить'
        }]
    });


    Ext.getCmp('contentpanel').add(osipassportform);

</script>