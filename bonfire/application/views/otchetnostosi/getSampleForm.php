<script type="text/javascript">
//alert('3');
Ext.create('Ext.data.Store',{
    storeId:'axisAllAnalyticStore_<?php echo $sample_id;?>',
        fields: [ 'id', 'title','type'],
        autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getAxisAllList/<?php echo $sample_id;?>/0/',
            reader: {
                type: 'json',
                root: 'axises',
                successProperty: 'success'
            }
        }
    
    }
);

Ext.create('Ext.data.Store',{
    storeId:'axisColAnalyticStore_<?php echo $sample_id;?>',
        fields: [ 'id', 'title','type'],
        autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getAxisAllList/<?php echo $sample_id;?>/1/',
            reader: {
                type: 'json',
                root: 'axises',
                successProperty: 'success'
            }
        }
    
    }
);
Ext.create('Ext.data.Store',{
    storeId:'axisRowAnalyticStore_<?php echo $sample_id;?>',
        fields: [ 'id', 'title','type'],
        autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getAxisAllList/<?php echo $sample_id;?>/2/',
            reader: {
                type: 'json',
                root: 'axises',
                successProperty: 'success'
            }
        }
    
    }
);

//************************************


Ext.create('Ext.data.Store', {
    storeId:'typeAnalyticStore',
    fields:['title'],
    data:{'items':[
        { "title":'olap'},
        { "title":'sql'},
    ]},
    proxy: {
        type: 'memory',
        reader: {
            type: 'json',
            root: 'items'
        }
    }
});

Ext.create('Ext.data.Store', {
    storeId:'statusAnalyticStore',
    fields:['id', 'title'],
    data:{'items':[
        { 'id':'active','title':'Активный'},
        { 'id':'inactive','title':'Неактивный'},
        { 'id':'deleted','title':'Удалённый'},
    ]},
    proxy: {
        type: 'memory',
        reader: {
            type: 'json',
            root: 'items'
        }
    }
});

        //##################
Ext.create('Ext.data.Store',{
    storeId:'groupAnalyticStore',
        fields: [ 'id', 'title'],
        autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getGroupList/',
            reader: {
                type: 'json',
                root: 'groups',
                successProperty: 'success'
            }
        }
    }
);
        
Ext.create('Ext.data.Store',{
    storeId:'cubeAnalyticStore',
        fields: [ 'id', 'title'],
        autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getCubeList/',
            reader: {
                type: 'json',
                root: 'cubes',
                successProperty: 'success'
            }
        }
    }
);
        
        Ext.define('SampleFormData_<?php echo $sample_id;?>', {
            extend: 'Ext.data.Model',
            fields: ['id', 'sysname','type', 'title','description','group_id','cube_id'],
            proxy: {
                type: 'ajax',
                url: '/otchetnostosi/SampleData/<?php echo $sample_id;?>/',
                reader: {
                    type: 'json',
                    root: 'sample'
                }
            }
        });

        var sampleForm=new Ext.create('Ext.form.Panel',{
            title: 'Форма управления выборкой',
            width:'100%',
            height:700,
            id:'formSample_<?php echo $sample_id;?>',
            bodyPadding: 3,
            url: '/otchetnostosi/addSample',
            items:[
                {
                    xtype:'tabpanel',
                    //id:'tabPanelFormAnalytic',
                    defaults:{
                        width:300,
                        allowBlank: false,
                        enableKeyEvents: true
                    },
                    items:[
                        {
                            title:'Общие сведения',
                            padding:5,
                            items:[
                                {
                                    xtype: 'hiddenfield',
                                    name: 'id',
                                    id:'id'
                                },
                                {
                                    xtype:'textfield',
                                    fieldLabel:'Системное имя',
                                    name:'sysname',
                                    id:'sysname'
                                },
                                {
                                    xtype:'textfield',
                                    fieldLabel:'Название',
                                    name:'title',
                                    id:'title'
                                },
                               {
                                    xtype:'combo',
                                    width:400,
                                    fieldLabel:'Группа',
                                    displayField:'title',
                                    valueField:'id',
                                    store: Ext.data.StoreManager.lookup('groupAnalyticStore'),
                                    queryMode:'local',
                                    name:'group_id',
                                    id:'group_id'
                                },
                               {
                                    xtype:'combo',
                                    width:400,
                                    fieldLabel:'Тип выборки',
                                    displayField:'title',
                                    valueField:'title',
                                    store: Ext.data.StoreManager.lookup('typeAnalyticStore'),
                                    queryMode:'local',
                                    name:'type',
                                    id:'type'
                                },
                               {
                                    xtype:'combo',
                                    width:400,
                                    fieldLabel:'Куб',
                                    displayField:'title',
                                    valueField:'id',
                                    store: Ext.data.StoreManager.lookup('cubeAnalyticStore'),
                                    queryMode:'local',
                                    name:'cube_id',
                                    id:'cube_id'
                                },
                               {
                                    xtype:'combo',
                                    width:400,
                                    fieldLabel:'Статус',
                                    displayField:'title',
                                    valueField:'id',
                                    store: Ext.data.StoreManager.lookup('statusAnalyticStore'),
                                    queryMode:'local',
                                    name:'status',
                                    id:'status'
                                },
                                {
                                    xtype:'fieldset',
                                    layout:'fit',
                                    title:'Краткое описание',
                                    padding:3,
                                    width:'100%',
                                    items:[
                                        {
                                        xtype:'textarea',
                                        name: 'description',
                                        id: 'description',
                                        height:50,
                                        width:'100%',
                                        
                                        /*listeners:{
                                                keyup: checkForm
                                        }*/

                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            title:'Конструктор',
                            id:'analitycConstTab_<?php echo $sample_id;?>',
                            <?php if($sample_id==0):?>
                            disabled:true,
                            <?php endif;?>
                            width:'100%',
                            items:[
                                {
                                    xtype:'tabpanel',
                                    width: '100%',
                                    listeners:{
                                        render:function(obj,opts){
                                            var parHeight=Ext.getCmp('formSample_<?php echo $sample_id;?>').getHeight();
                                            obj.setHeight(parHeight-90);
                                        }
                                    },
                                    items:[
                                        {
                                            title:'Дизайнер',
                                            bodyPadding: 10,
                                            layout: {
                                                type: 'hbox',
                                                align: 'left'
                                                },
                                            items:[
                                                {
                                                    xtype:'grid',
                                                    store: 'axisAllAnalyticStore_<?php echo $sample_id;?>',
                                                    id:'formSample_<?php echo $sample_id;?>_axisAll',
                                                    width:200,
                                                    height:500,
                                                    padding:2,
                                                    title:'Все измерения',
                                                        columns: [
                                                            { header: 'ИД',  dataIndex: 'id',hidden:true },
                                                            { header: 'Измерения', dataIndex: 'title', flex: 1 }
                                                        ],
                                                    listeners:{
                                                        render:function(obj,opts){
                                                            var parHeight=Ext.getCmp('formSample_<?php echo $sample_id;?>').getHeight();
                                                            obj.setHeight(parHeight-140);
                                                        },
                                                    itemclick:function(){
                                                       //alert('123');
                                                                 
                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_leftButCol').setDisabled(true);
                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_rightButCol').setDisabled(false);
                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_leftButRow').setDisabled(true);
                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_rightButRow').setDisabled(false);
                                                    }
                                                    }
                                                },
                                                //#####
                                                {
                                                    xtype:'panel',
                                                    //title:'Измерения для выборки',
                                                    id:'formSample_<?php echo $sample_id;?>_panel',
                                                    padding:2,
                                                    width:300,
                                                    layout: {
                                                        type: 'vbox',
                                                        align: 'center'
                                                        },
                                                    listeners:{
                                                        render:function(obj,opts){
                                                            var parHeight=Ext.getCmp('formSample_<?php echo $sample_id;?>').getHeight();
                                                            obj.setHeight(parHeight-140);
                                                            //var parWidth=Ext.getCmp('formSample_<?php echo $sample_id;?>').getWidth();
                                                            //obj.setWidth(300);
                                                        }
                                                    },
                                                    items:[
                                                    //***
                                                        {
                                                            xtype:'panel',
                                                            width:'100%',
                                                            padding:2,
                                                            layout: {
                                                                type: 'hbox',
                                                                align: 'left'
                                                                },
                                                            listeners:{
                                                                render:function(obj,opts){
                                                                    var parHeight=Ext.getCmp('formSample_<?php echo $sample_id;?>_panel').getHeight();
                                                                    obj.setHeight(parHeight/2-10);

                                                                }
                                                            },
                                                            items:[
                                                                {
                                                                    xtype:'toolbar',
                                                                    width:32,
                                                                    padding:2,
                                                                    layout: {
                                                                        type: 'vbox',
                                                                        align: 'center'
                                                                        },
                                                                    listeners:{
                                                                        render:function(obj,opts){
                                                                            var parHeight=Ext.getCmp('formSample_<?php echo $sample_id;?>_panel').getHeight();
                                                                            obj.setHeight(parHeight/2-16);
                                                                            //var parWidth=Ext.getCmp('formSample_<?php echo $sample_id;?>_panelCol').getWidth();
                                                                            //obj.setWidth(parWidth-6);
                                                                        }
                                                                    },
                                                                    items:[
                                                                    
                                                                    {
                                                                        //text: '>',
                                                                        icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-right.gif',
                                                                        width:30,
                                                                        height:30,
                                                                        id:'formSample_<?php echo $sample_id;?>_rightButCol',
                                                                        disabled:true,
                                                                        handler:function(){
                                                                        var rec=Ext.getCmp('formSample_<?php echo $sample_id;?>_axisAll').getSelectionModel().getSelection()[0].data.id;
                                                                        changeAxisAnalityc_<?php echo $sample_id;?>(rec,1);
                                                                        }    
                                                                    },
                                                                    {
                                                                        //text: '<',
                                                                        icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-left.gif',    
                                                                        width:30,
                                                                        height:30,
                                                                        id:'formSample_<?php echo $sample_id;?>_leftButCol',
                                                                        disabled:true,
                                                                        handler:function(){
                                                                            var rec=Ext.getCmp('formSample_<?php echo $sample_id;?>_axisCol').getSelectionModel().getSelection()[0].data.id;
                                                                            changeAxisAnalityc_<?php echo $sample_id;?>(rec,0);
                            
                                                                        
                                                                        }        

                                                                    }
                                                                    ]
                                                                },
                                                                {
                                                                    xtype:'grid',
                                                                    id:'formSample_<?php echo $sample_id;?>_axisCol',
                                                                    store: 'axisColAnalyticStore_<?php echo $sample_id;?>',
                                                                    width:'100%',
                                                                    height:200,
                                                                    title:'Измерения для рядов',
                                                                        columns: [
                                                                            { header: 'ИД',  dataIndex: 'id',hidden:true },
                                                                            { header: 'Измерения', dataIndex: 'title', flex: 1 }
                                                                        ],
                                                                    listeners:{
                                                                    itemclick:function(){
                                                                        //alert(Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').isVisible());
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_leftButCol').setDisabled(false);
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_rightButCol').setDisabled(true);
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_leftButRow').setDisabled(true);
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_rightButRow').setDisabled(true);
                                                                        
                                                                        /*Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').setDisabled(false);
                                                                        Ext.getCmp('leftButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                                                        Ext.getCmp('rightButColAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                                                        Ext.getCmp('rightButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true); */
                                
                                                                        //Ext.getCmp('olapContructorAnalytic').setButDisabledAnalytic(true,false,true,true);
                                                                    }
                                                                    } 
                                                                   }
                                                                ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            width:'100%',
                                                            padding:2,
                                                            layout: {
                                                                type: 'hbox',
                                                                align: 'left'
                                                                },
                                                            listeners:{
                                                                render:function(obj,opts){
                                                                    var parHeight=Ext.getCmp('formSample_<?php echo $sample_id;?>_panel').getHeight();
                                                                    obj.setHeight(parHeight/2-10);

                                                                }
                                                            },
                                                            items:[
                                                                {
                                                                    xtype:'toolbar',
                                                                    width:32,
                                                                    padding:2,
                                                                    layout: {
                                                                        type: 'vbox',
                                                                        align: 'center'
                                                                        },
                                                                    listeners:{
                                                                        render:function(obj,opts){
                                                                            var parHeight=Ext.getCmp('formSample_<?php echo $sample_id;?>_panel').getHeight();
                                                                            obj.setHeight(parHeight/2-16);
                                                                            //var parWidth=Ext.getCmp('formSample_<?php echo $sample_id;?>_panelCol').getWidth();
                                                                            //obj.setWidth(parWidth-6);
                                                                        }
                                                                    },
                                                                    items:[
                                                                    
                                                                    {
                                                                        //text: '>',
                                                                        icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-right.gif',
                                                                        width:30,
                                                                        height:30,
                                                                        id:'formSample_<?php echo $sample_id;?>_rightButRow',
                                                                        disabled:true,
                                                                        handler:function(){
                                                                        var rec=Ext.getCmp('formSample_<?php echo $sample_id;?>_axisAll').getSelectionModel().getSelection()[0].data.id;
                                                                        changeAxisAnalityc_<?php echo $sample_id;?>(rec,2);
                                                                        }    
                                                                    },
                                                                    {
                                                                        //text: '<',
                                                                        icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-left.gif',    
                                                                        width:30,
                                                                        height:30,
                                                                        id:'formSample_<?php echo $sample_id;?>_leftButRow',
                                                                        disabled:true,
                                                                        handler:function(){
                                                                            var rec=Ext.getCmp('formSample_<?php echo $sample_id;?>_axisRow').getSelectionModel().getSelection()[0].data.id;
                                                                            changeAxisAnalityc_<?php echo $sample_id;?>(rec,0);
                            
                                                                        
                                                                        }        

                                                                    }
                                                                    ]
                                                                },
                                                                {
                                                                    xtype:'grid',
                                                                    id:'formSample_<?php echo $sample_id;?>_axisRow',
                                                                    store: 'axisRowAnalyticStore_<?php echo $sample_id;?>',
                                                                    width:'100%',
                                                                    height:200,
                                                                    title:'Измерения для колонок',
                                                                        columns: [
                                                                            { header: 'ИД',  dataIndex: 'id',hidden:true },
                                                                            { header: 'Измерения', dataIndex: 'title', flex: 1 }
                                                                        ],
                                                                    listeners:{
                                                                    itemclick:function(){
                                                                        //alert(Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').isVisible());
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_leftButCol').setDisabled(true);
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_rightButCol').setDisabled(true);
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_leftButRow').setDisabled(false);
                                                                        Ext.getCmp('formSample_<?php echo $sample_id;?>_rightButRow').setDisabled(true);
                                                                        
                                                                        /*Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').setDisabled(false);
                                                                        Ext.getCmp('leftButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                                                        Ext.getCmp('rightButColAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                                                        Ext.getCmp('rightButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true); */
                                
                                                                        //Ext.getCmp('olapContructorAnalytic').setButDisabledAnalytic(true,false,true,true);
                                                                    }
                                                                    } 
                                                                   }
                                                                ]
                                                        },                                                        
                                                    ]
                                                },
                                                //####
                                            ]
                                        },
                                        {
                                            title:'Ручной режим',
                                            layout: {
                                                type: 'vbox',
                                                align: 'left'
                                                },                                            
                                                items:[
                                                        {
                                                            xtype:'checkboxfield',
                                                            boxLabel  : 'Режим конструктора',
                                                            name      : 'autodesign',
                                                            inputValue: '1',
                                                            checked   : true,
                                                            listeners:{
                                                                change:function( Field, newValue,oldValue,eOpts ){
                                                                    //alert(newValue);
                                                                    Ext.getCmp('formSample_<?php echo $sample_id;?>_manual_query').setDisabled(newValue);
                                                                    
                                                                }
                                                            }
                                                        },
                                                        {
                                                            xtype:'fieldset',
                                                            id:'formSample_<?php echo $sample_id;?>_manual_query',
                                                            title: 'Запрос MDX',
                                                            disabled:true,
                                                            width:'100%',
                                                            height:125,
                                                            layout: {
                                                                type: 'vbox',
                                                                align: 'stretch'
                                                                },
                                                            
                                                            items:[
                                                                {
                                                                    xtype     : 'textareafield',
                                                                    name      : 'query',
                                                                    width:'100%',
                                                                    height:100
                                                                }
                                                            
                                                            ]
                                                        }
                                            ]
                                        }
                                    ]
                                    
                                }
                                ],
                            listeners:{
                                /*beforeactivate:function( obj,eOpts ){
                                    //Ext.MessageBox.alert('11','222');
                                    var const_type=Ext.getCmp('formSample_<?php echo $sample_id;?>').getForm().getRecord().data.type;
                                      //alert('='+const_type);
                                        
                                    if(Ext.get(const_type+'ContructorAnalytic_<?php echo $sample_id;?>')){
                                        if(Ext.get('olapContructorAnalytic_<?php echo $sample_id;?>')){
                                            Ext.getCmp('olapContructorAnalytic_<?php echo $sample_id;?>').changeAxisAnalityc(0,0);
                                        }                                        
                                        //changeAxisAnalityc(Ext.getCmp('formSample').getForm().getRecord().data.id,0,0);    
                                    }else{
                                        
                                        obj.add({
                                    		id:const_type+'2ContructorAnalytic',
                                    		//closable: true,
                                               loader: {
                                                   url: '/otchetnostosi/getContructor/'+Ext.getCmp('formSample_<?php echo $sample_id;?>').getForm().getRecord().data.id+'/'+const_type+'/',
                                                   contentType: 'html',
                                                   scripts:true,
                                                   //loadMask: true,
                                                   autoLoad: true,
                                                   success:function(){
                                                    obj.add( Ext.getCmp('olapContructorAnalytic_<?php echo $sample_id;?>'));
                                                   },
                                                   failure:function(t,r,o){
                               	                   	    obj.update(r.responseText);
                                                   }
                                               }
                                        });
                                        
                                        
                                    }
                                }*/
                            }
                        },
                        {
                            title:'Распределение прав',
                            html:'Распределение прав'
                        }
                        ]
                }
            ],
             buttons: [
             {
                text: 'Сохранить',
                formBind: true, //only enabled once the form is valid
                disabled: true,
                handler: function() {
                var form = this.up('form').getForm();
                            if (form.isValid()) {
                                form.submit({
                                    success: function(form, action) {
                                    Ext.Msg.alert('Успешно', action.result.msg);
                                    Ext.getCmp('formSample_<?php echo $sample_id;?>').close();
                                    Ext.getCmp('tab_sform_<?php echo $sample_id;?>').close();
                                    },
                                    failure: function(form, action) {
                                        Ext.Msg.alert('Облом', action.result.msg);
                                    }
                                });
                            }
                    }
            },
              {
                text: 'Очистить',
                handler: function() {
                    this.up('form').getForm().reset();
                }
            },
              {
                text: 'Отменить',
                handler: function() {
                    Ext.getCmp('formSample_<?php echo $sample_id;?>').close();
                    Ext.getCmp('tab_sform_<?php echo $sample_id;?>').close();

                     
                }
            },
            ]
            
        }
        );

        Ext.ModelMgr.getModel('SampleFormData_<?php echo $sample_id;?>').load(<?php echo $sample_id;?>,{
        url:'/otchetnostosi/getSampleData/<?php echo $sample_id;?>/', 
         
        success: function(sample) {
            Ext.getCmp('formSample_<?php echo $sample_id;?>').loadRecord(sample); 
        }
    }); 
       //##################  
Ext.getCmp('tab_sform_<?php echo $sample_id;?>').add(sampleForm);


function changeAxisAnalityc_<?php echo $sample_id;?>(axis_id,type_id){
         var store_url='/otchetnostosi/getAxisAllList/<?php echo $sample_id;?>/';
        Ext.Ajax.request({
            url:'/otchetnostosi/updAxisAllList/<?php echo $sample_id;?>/',
            method:'post',
            params:{
                id:axis_id,
                type:type_id
            },
            success: function(responseObject)
        	{
            	Ext.data.StoreManager.lookup('axisAllAnalyticStore_<?php echo $sample_id;?>').load({url:store_url+'0/'});
                Ext.data.StoreManager.lookup('axisColAnalyticStore_<?php echo $sample_id;?>').load({url:store_url+'1/'});
                Ext.data.StoreManager.lookup('axisRowAnalyticStore_<?php echo $sample_id;?>').load({url:store_url+'2/'});
                //setButDisabledAnalytic(true,true,true,true);
        	},
        	failure: function() 
        	{
        		Ext.MessageBox.alert('Ошибка','Возникла ошибка!');
        	}
        });  
        //alert('1');  

}
</script>