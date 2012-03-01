<script>
var osipanelconteyner = Ext.create('Ext.panel.Panel', {
		xtype:'panel',
		height:'100%',
        id:'main-panel',
        layout: {
                   type: 'hbox'
               	},
        items:[{
        	title:'Меню выбора',
        	id:'sidebar',
        	xtype:'panel',
            height:Ext.getCmp('viewport').getHeight()-80,
            width:200,
            frame:true
        },{
        	title:'Действия',
        	id:'contentpanel',
        	xtype:'panel',
        	height:Ext.getCmp('viewport').getHeight()-80,
        	width:Ext.getCmp('viewport').getWidth()-204,
            frame:true

        }]
    });
Ext.getCmp('maintabs').getActiveTab().add(osipanelconteyner);

var ositreestore = Ext.create('Ext.data.TreeStore', {
        proxy: {
            type: 'ajax',
            url: '/getositree/passportosi/index'
        },
        sorters: [{
            property: 'pos',
            direction: 'ASC'
        }],
        root: {
            text: 'Паспорта ОСИ',
            id: 'osisrc',
            expanded: true
        },
        fields: [
		{name:'id'},
		{name:'osiID'},
		{name:'text'},
		{name:'pos'}
		]
    });

    // create the Tree
    var ositree = Ext.create('Ext.tree.Panel', {
        id:'sidebartree',
        store: ositreestore,
        hideHeaders: false,
        rootVisible: true,
        height:Ext.getCmp('sidebar').getHeight()-35,
        collapsible: false
    });

    Ext.getCmp('sidebar').add(ositree);

    Ext.getCmp('viewport').on('resize',function(){
    // auto resizing viewport child elements height
    	if(Ext.getCmp('sidebar'))
		{
		Ext.getCmp('sidebar').setHeight(Ext.getCmp('viewport').getHeight()-80);
    	Ext.getCmp('contentpanel').setHeight(Ext.getCmp('viewport').getHeight()-80);
    	Ext.getCmp('contentpanel').setWidth(Ext.getCmp('viewport').getWidth()-204);
    	Ext.getCmp('sidebartree').setHeight(Ext.getCmp('sidebar').getHeight()-35);
    	}
    });

    Ext.getCmp('sidebartree').on('itemclick',function(a,b,c,d,e,o){
    // auto resizing viewport child elements height
    	//alert(b.data.osiID+'clicked!');
    	loadFormData(b.data.osiID);
    });


	function loadFormData(osiID)
	{
		var r = new Ext.Component({
		    xtype:'panel',
		    layout:'anchor',
		    id:'tempcontent',
		    loadMask:true,
		    loader: {
		        url: '/getositree/passportosi/getosiformdata',
		        renderer:'html',
		        loadMask:true,
		        scripts: true,
		        params: {
		             osiID: osiID
		        }
		    }
		});
		r.loader.load()
		Ext.getCmp('contentpanel').removeAll();
		Ext.getCmp('contentpanel').add(r);
        //var data = Ext.JSON.decode(response.responseText);

	}

    function doRenderOsiForm(data)
    {
    	alert(data);
    }

</script>

