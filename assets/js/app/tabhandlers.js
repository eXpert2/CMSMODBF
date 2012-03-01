
var maintabs;
var index = 0;
function addTab(b) {
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
                   contentType: 'html',
                   scripts:true,
                   loadMask: true,
                   autoLoad: true,
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



