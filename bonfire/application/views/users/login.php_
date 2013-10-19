<script>
Ext.onReady(function() {
        var form = Ext.create('Ext.form.Panel', {
            border: false,
            fieldDefaults: {
                labelWidth: 55
            },
            url: '/login',
            defaultType: 'textfield',
            bodyPadding: 5,

            items: [{
                fieldLabel: 'Login',
                name: 'login',
                anchor:'100%'  // anchor width by percentage
            },{
                fieldLabel: 'Password',
                name: 'password',
                   inputType : 'password',
                anchor: '100%'  // anchor width by percentage
            },{
                fieldLabel: '',
                name: 'submit',
                   inputType : 'hidden',
                   value:1,
                anchor: '100%'  // anchor width by percentage
            },{
                fieldLabel: '',
                name: 'backoffice',
                   inputType : 'hidden',
                   value:1,
                anchor: '100%'  // anchor width by percentage
            }]
        });

        var win = Ext.create('Ext.window.Window', {
            title: 'Вход',
            width: 250,
            height:120,
            layout: 'fit',
            plain: true,
            items: form,
            resizable:false,
            draggable : false,
            closable:false,
            buttons: [{
                text: 'Вход',
                handler:function()
                {
                    form.getForm().submit({
                        success: function(form, action) {
                           document.location.href=action.result.redirect;
                        },
                        failure: function(form, action) {
                        switch (action.failureType) {
                            case Ext.form.action.Action.CLIENT_INVALID:
                                Ext.Msg.alert('Ошибка', 'Form fields may not be submitted with invalid values');
                                break;
                            case Ext.form.action.Action.CONNECT_FAILURE:
                                Ext.Msg.alert('Ошибка', 'Ajax communication failed');
                                break;
                            case Ext.form.action.Action.SERVER_INVALID:
                               Ext.Msg.alert('Ошибка', action.result.msg);
                       }
                    }
                    });
                }

            }]
        });

        win.show();
    });
</script>    