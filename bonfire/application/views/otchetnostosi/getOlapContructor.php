<script type="text/javascript">

/*var Analytics = function () {
    var 
    }

  return {
     setButDisabledAnalytic : setButDisabledAnalytic
  };
}();*/
/* function setButDisabledAnalytic(leftCol,rightCol,leftRow,rightRow){
        //if(Ext.get('leftButColAnalytic'))
        {
            Ext.getCmp('leftButColAnalytic').setDisabled(leftCol);
            Ext.getCmp('leftButRowAnalytic').setDisabled(leftRow);
            Ext.getCmp('rightButColAnalytic').setDisabled(rightCol);
            Ext.getCmp('rightButRowAnalytic').setDisabled(rightRow); 
            
           }
        }       	
    //alert('<?php echo $sample_id;?>');
    //alert(Ext.getCmp('formSample').getForm().getRecord().data.id);

function changeAxisAnalityc(axis_id,type_id){
         var sample_id=Ext.getCmp('formSample').getForm().getRecord().data.id;
         var store_url='/otchetnostosi/getAxisAllList/'+sample_id+'/';
         alert(sample_id);
        Ext.Ajax.request({
            url:'/otchetnostosi/updAxisAllList/'+sample_id+'/',
            method:'post',
            params:{
                id:axis_id,
                type:type_id
            },
            success: function(responseObject)
        	{
            	Ext.data.StoreManager.lookup('axisAllAnalyticStore').load({url:store_url+'0/'});
                Ext.data.StoreManager.lookup('axisColAnalyticStore').load({url:store_url+'1/'});
                Ext.data.StoreManager.lookup('axisRowAnalyticStore').load({url:store_url+'2/'});
                setButDisabledAnalytic(true,true,true,true);
        	},
        	failure: function() 
        	{
        		Ext.MessageBox.alert('Ошибка','Возникла ошибка!');
        	}
        });  
        //alert('1');  

}
*/

var sample_id=<?php echo $sample_id;?>;
/*var axisAllAnalyticStore=new Ext.create('Ext.data.Store',{
    storeId:'axisAllAnalyticStore_<?php echo $sample_id;?>',
        fields: [ 'id', 'title','type'],
        //autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getAxisAllList/'+sample_id+'/0/',
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
        //autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getAxisAllList/'+sample_id+'/1/',
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
        //autoLoad: true,
    
        proxy: {
            type: 'ajax',
            url: '/otchetnostosi/getAxisAllList/'+sample_id+'/2/',
            reader: {
                type: 'json',
                root: 'axises',
                successProperty: 'success'
            }
        }
    
    }
);

*/
//store1.loadData(store2.reader.jsonData);

var tabHeight=500;
Ext.create('Ext.tab.Panel', {
    width: '100%',
    id: 'olapContructorAnalytic_<?php echo $sample_id;?>',
    setButDisabledAnalytic:function (leftCol,rightCol,leftRow,rightRow){
        if(Ext.get('leftButColAnalytic_<?php echo $sample_id;?>')){
            Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').setDisabled(leftCol);
            Ext.getCmp('leftButRowAnalytic_<?php echo $sample_id;?>').setDisabled(leftRow);
            Ext.getCmp('rightButColAnalytic_<?php echo $sample_id;?>').setDisabled(rightCol);
            Ext.getCmp('rightButRowAnalytic_<?php echo $sample_id;?>').setDisabled(rightRow); 
            
           }
        },       	
    
    changeAxisAnalityc:function (axis_id,type_id){
         var sample_id=Ext.getCmp('formSample_<?php echo $sample_id;?>').getForm().getRecord().data.id;
         var store_url='/otchetnostosi/getAxisAllList/'+sample_id+'/';
         //alert(sample_id);
        Ext.Ajax.request({
            url:'/otchetnostosi/updAxisAllList/'+sample_id+'/',
            method:'post',
            params:{
                id:axis_id,
                type:type_id
            },
            success: function(responseObject)
        	{
            	//Ext.data.StoreManager.lookup('axisAllAnalyticStore').load({url:store_url+'0/'});
                //Ext.data.StoreManager.lookup('axisColAnalyticStore').load({url:store_url+'1/'});
                //Ext.data.StoreManager.lookup('axisRowAnalyticStore').load({url:store_url+'2/'});
                Ext.getCmp('axisAllAnalyticGrid_<?php echo $sample_id;?>').getStore().load({url:store_url+'0/'});
                Ext.getCmp('axisColAnalyticGrid_<?php echo $sample_id;?>').getStore().load({url:store_url+'1/'});
                Ext.getCmp('axisRowAnalyticGrid_<?php echo $sample_id;?>').getStore().load({url:store_url+'2/'});
                //Ext.getCmp('axisAllAnalyticGrid').reconfigure();
                //this.setButDisabledAnalytic(true,true,true,true);
                //if(Ext.get('leftButColAnalytic')){
                    //Ext.getCmp('leftButColAnalytic').setDisabled(true);
                    //Ext.getCmp('leftButRowAnalytic').setDisabled(true);
                    //Ext.getCmp('rightButColAnalytic').setDisabled(true);
                    //Ext.getCmp('rightButRowAnalytic').setDisabled(true); 
                    
                //   }
        	},
        	failure: function() 
        	{
        		Ext.MessageBox.alert('Ошибка','Возникла ошибка!');
        	}
        });  
        //alert('1');  

    },
    height: tabHeight,
    //renderTo: Ext.getCmp('analitycConstTab'),
    items: [
        {
            title:'Конструктор olap',
            items:[
 {
    xtype:'panel',
    id: 'analytic_const_<?php echo $sample_id;?>',
    width: '100%',
    padding:2,
    height:tabHeight,
    layout: {
        type: 'hbox',
        align: 'left'
        },

    items:[
        {
            xtype:'panel',
            width:'100%',
            padding:2,
            id: 'analytic_const_top_<?php echo $sample_id;?>',

            height:tabHeight,
            layout: {
                type: 'hbox',
                align: 'left'
                },

            items:[
                {
                    xtype:'grid',
                    store: 'axisAllAnalyticStore_<?php echo $sample_id;?>',
                    id:'axisAllAnalyticGrid_<?php echo $sample_id;?>',
                    width:200,
                    height:tabHeight,
                    padding:2,
                    title:'Все измерения',
                        columns: [
                            { header: 'ИД',  dataIndex: 'id',hidden:true },
                            { header: 'Измерения', dataIndex: 'title', flex: 1 }
                        ],
                    listeners:{
                    itemclick:function(){
                       
                        Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                        Ext.getCmp('leftButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                        Ext.getCmp('rightButColAnalytic_<?php echo $sample_id;?>').setDisabled(false);
                        Ext.getCmp('rightButRowAnalytic_<?php echo $sample_id;?>').setDisabled(false); 
 
                        //Ext.getCmp('olapContructorAnalytic').setButDisabledAnalytic(false,true,false,true);
                    }
                    }
                },
                {
                    xtype:'panel',
                    id: 'analytic_const_cr_<?php echo $sample_id;?>',
                    auroWidth:true,
                    padding:2,
                    height:tabHeight,
                    layout: {
                        type: 'vbox',
                        align: 'top'
                        },
                    items:[
                        {
                            xtype:'panel',
                            id: 'analytic_const_col_<?php echo $sample_id;?>',
                            width:284,
                            height:200,
                            padding:2,
                            layout: {
                                type: 'hbox',
                                align: 'left'
                            },
                            items:[
                                {
                                    xtype:'toolbar',
                                    width:30,
                                    height:200,
                                    layout: {
                                        type: 'vbox',
                                        align: 'stretch'
                                    },
                                    items:[
                                        {
                                            //text: '>',
                                            icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-right.gif',
                                            width:30,
                                            height:30,
                                            id:'rightButColAnalytic_<?php echo $sample_id;?>',
                                            disabled:true,
                                            handler:function(){
                                            var rec=Ext.getCmp('axisAllAnalyticGrid_<?php echo $sample_id;?>').getSelectionModel().getSelection()[0].data.id;
                                            Ext.getCmp('olapContructorAnalytic_<?php echo $sample_id;?>').changeAxisAnalityc(rec,1);
                                            }    
                                        },
                                        {
                                            //text: '<',
                                            icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-left.gif',    
                                            width:30,
                                            height:30,
                                            id:'leftButColAnalytic_<?php echo $sample_id;?>',
                                            disabled:true,
                                            handler:function(){
                                                
                                               
                                            var rec=Ext.getCmp('axisColAnalyticGrid_<?php echo $sample_id;?>').getSelectionModel().getSelection()[0].data.id;
                                            Ext.getCmp('olapContructorAnalytic_<?php echo $sample_id;?>').changeAxisAnalityc(rec,0);

                                            
                                            }        
                                        }
                                        ]

                                },
                                {
                                    xtype:'grid',
                                    id:'axisColAnalyticGrid_<?php echo $sample_id;?>',
                                    store: 'axisColAnalyticStore_<?php echo $sample_id;?>',
                                    width:'100%',
                                    height:200,
                                    title:'Измерения для колонок',
                                        columns: [
                                            { header: 'ИД',  dataIndex: 'id',hidden:true },
                                            { header: 'Измерения', dataIndex: 'title', flex: 1 }
                                        ],
                                    listeners:{
                                    itemclick:function(){
                                        alert(Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').isVisible());
                                        Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').setDisabled(false);
                                        Ext.getCmp('leftButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                        Ext.getCmp('rightButColAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                        Ext.getCmp('rightButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true); 

                                        //Ext.getCmp('olapContructorAnalytic').setButDisabledAnalytic(true,false,true,true);
                                    }
                                    } 
                                   }                            

                                ]
                        },
                        {
                            xtype:'panel',
                            id: 'analytic_const_row_<?php echo $sample_id;?>',
                            width:284,
                            height:200,
                            padding:2,
                            layout: {
                                type: 'hbox',
                                align: 'left'
                            },
                            items:[
                                {
                                    xtype:'toolbar',
                                    width:30,
                                    height:200,
                                    layout: {
                                        type: 'vbox',
                                        align: 'stretch'
                                    },
                                    items:[
                                        {
                                            //text: '>',
                                            icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-right.gif',
                                            width:30,
                                            height:30,
                                            id:'leftButRowAnalytic_<?php echo $sample_id;?>',
                                            disabled:true,
                                            handler:function(){
                                                
                                                var rec=Ext.getCmp('axisAllAnalyticGrid_<?php echo $sample_id;?>').getSelectionModel().getSelection()[0].data.id;
                                                Ext.getCmp('olapContructorAnalytic_<?php echo $sample_id;?>').changeAxisAnalityc(rec,2);

                                            }        
                                        },
                                        {
                                            //text: '<',
                                            icon: '/assets/js/extjs407/resources/themes/images/default/grid/dd-insert-arrow-left.gif',    
                                            width:30,
                                            height:30,
                                            id:'rightButRowAnalytic_<?php echo $sample_id;?>',
                                            disabled:true,
                                            handler:function(){
                                                var rec=Ext.getCmp('axisRowAnalyticGrid_<?php echo $sample_id;?>').getSelectionModel().getSelection()[0].data.id;                    
                                                Ext.getCmp('olapContructorAnalytic_<?php echo $sample_id;?>').changeAxisAnalityc(rec,0);

                                            }        
                                        }
                                        ]

                                },
                                {
                                    xtype:'grid',
                                    store: 'axisRowAnalyticStore_<?php echo $sample_id;?>',
                                    id:'axisRowAnalyticGrid_<?php echo $sample_id;?>',
                                    width:'100%',
                                    height:200,
                                    title:'Измерения для рядов',
                                        columns: [
                                            { header: 'ИД',  dataIndex: 'id',hidden:true },
                                            { header: 'Тип',  dataIndex: 'type',hidden:true },
                                            { header: 'Измерения', dataIndex: 'title', flex: 1 }
                                        ],
                                    listeners:{
                                    itemclick:function(){
                                        //alert('dddd')
                                        Ext.getCmp('leftButColAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                        Ext.getCmp('leftButRowAnalytic_<?php echo $sample_id;?>').enable(true).doAutoRender();
                                        Ext.getCmp('rightButColAnalytic_<?php echo $sample_id;?>').setDisabled(true);
                                        Ext.getCmp('rightButRowAnalytic_<?php echo $sample_id;?>').setDisabled(true); 
                                        //Ext.getCmp('olapContructorAnalytic').setButDisabledAnalytic(true,true,true,false);
                                    }
                                    } 
                                        
                                }                            

                                ]
                        }
                        ]
                    
                }
                
                ]
        }
        ]
}

]
        },
        {
            title:'Ручной режим',
            items:[
                {
                    xtype:'panel',
                    id: 'analytic_manual_<?php echo $sample_id;?>',
                    width: '100%',
                    padding:2,
                    height:tabHeight,
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
                                    checked   : true
                                },
                                {
                                    xtype:'fieldset',
                                    title: 'Запрос MDX',
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
                                            disabled:true,
                                            width:'100%',
                                            height:100
                                        }
                                    
                                    ]
                                }
                            ]

                }
                ]
        },
    ]});

//if(Ext.get('olapContructorAnalytic_<?php echo $sample_id;?>')){
    //Ext.getCmp('olapContructorAnalytic').changeAxisAnalityc(0,0);
//}
//changeAxisAnalityc(0,0);

</script>
