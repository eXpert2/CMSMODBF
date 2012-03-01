Ext.onReady(function(){

var mainmenubtns = [{
						    text: 'Паспорт ОСИ',
						    xtype: 'splitbutton',
						    id:'passportosi',
						    iconCls: 'passportosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        addTab(this);
						    },
						     menu: new Ext.menu.Menu({
						        items: [
						            {text: 'Оценка доступности ОСИ',  id:'otsenkaosi', handler: function(){ addTab(this); }},
						            {text: 'Отчётность',  id:'otchetnostosi', handler: function(){ addTabOTCH(this); }},
						        ]
						    })

						},
						{
						    text: 'Администрирование',
						    iconCls: 'passportosi',
						    id:'adminosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        addTab(this);
						    }
						} ,
						{
						    text: 'Пользователи',
						    iconCls: 'passportosi',
						    id:'usersosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        addTab(this);
						    }
						} ,
						{
						    text: 'Обращения граждан',
						    iconCls: 'passportosi',
						    id:'feedbackosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        addTab(this);
						    }
						},
						{
						    text: 'Справочники',
						    iconCls: 'passportosi',
						    id:'dicosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        addTab(this);
						    }
						} ,
						{
						    text: 'Взаимодействия',
						    xtype: 'splitbutton',
						    iconCls: 'passportosi',
						    id:'connectionsosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        addTab(this);
						    },
						     menu: new Ext.menu.Menu({
						        items: [
						            {text: 'Мониторинг', id:'monitorosi', handler: function(){ addTab(this); }},
						            {text: 'Информационный портал', id:'infoportalosi', handler: function(){ addTab(this); }},
						        ]
						    })
						} ,
						{
						    text: 'Загр./Выгр.',
						    iconCls: 'passportosi',
						    id:'exportosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        addTab(this);
						    }
						},
						{
						    text: 'Выход',
						    iconCls: 'passportosi',
						    id:'logoutosi',
            				iconAlign: 'right',
            				scale:'large',
						    handler: function() {
						        document.location.href='/logout';
						    }
						}];

var viewport = Ext.create('Ext.container.Viewport', {
    layout: 'border',
    id:'viewport',
    items: [
    		{
    		region:'north',
      		baseCls:'x-plain',
            height: 50,
   			layout: {
                     type: 'hbox',
                     padding:'5',
                     align:'stretch',
                     pack:'center',
                 	},
             defaults:{xtype:'button',margins:'0 5 0 0'},
             items: mainmenubtns
      		},
            {
	        region: 'center',
	        id:'maintabs',
	        xtype: 'tabpanel', // TabPanel itself has no title
	        activeTab: 0,      // First tab active by default
	        enableTabScroll: true,
	        defaults: {
	            autoScroll:true,
	            bodyPadding: 0
	        },
	        items: [{
	            title: 'Главная',
	            loader: {
                    url: '/welcome',
                    contentType: 'html',
                    autoLoad: true,
                    params: '',
                    loadMask: true
                }
	        }
	        ]
    }]
});

});// Ext.Ready

