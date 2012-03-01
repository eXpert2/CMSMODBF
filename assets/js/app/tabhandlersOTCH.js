
var maintabs;
var index = 0;
function addTabOTCH(b) {
		if(Ext.get('tab_'+b.id))
		{
			Ext.getCmp('tab_'+b.id).show();
		} else {
        ++index;
        maintabs = Ext.getCmp('maintabs');
        maintabs.add({
        	title:b.text,
    		id:'tab_'+b.id,
    		closable: true,
               loader: {
                   url: '/'+b.id,
                   contentType: 'component',
                   autoLoad: true,
                   success:function(obj,response,params) {
/*
    this - The ElementLoader instance.
    response - The response object.
    options - Ajax options.

*/ 
                   
                        Ext.MessageBox.alert('newComponent',response.responseText);
                       //var newComponent = eval('{"xtype":"form","bodyStyle":{"padding":"10px"},"items":[{"xtype":"textfield","fieldLabel":"Name","id":"name"}]}'); // see discussion below
                       var newComponent = eval('(' + response.responseText+')'); // see discussion below
                        obj.getTarget(0).add(newComponent); // add the component to the TabPanel
                        //obj.getTarget(0).add(f1); // add the component to the TabPanel
                        //obj.setActiveTab(newComponent);


 Ext.get('packages_tree').on('click', function(node, event){
    //if(node.leaf)
    {
        Ext.MessageBox.alert('newComponent',node.text);
    }
});

                   },
                   failure:function(t,r,o){
	                   	/*
	                   	Ext.Msg.show({
	                   		title:'Ошибка',
	                   		msg:r.responseText,
	                   		buttons: Ext.Msg.OK,
	                   	});
	                   	*/
	                   	Ext.getCmp('tab_'+b.id).update(r.responseText);
                   }
               }
        }).show();
        }
    } //addtab


