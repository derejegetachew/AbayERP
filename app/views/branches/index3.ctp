//<script>
    var store_branches = new Ext.data.Store({
        reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','list_order','fc_code','bank','branch_category','tag_code','region','created','modified'        ]
        }),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'list_data2')); ?>'
	}),	
        sortInfo:{field: "name", direction: "ASC"}
    });

    function GenerateKeys(){
        Ext.MessageBox.confirm('Confirm', 'All security keys are about to be Re-Generated<br>Please confirm to continue?', function(btn){
            if(btn=='yes'){
                /* var booknewwin =new Ext.Window({
                    title: 'Please Wait...',
                    modal: true,
                    width:100,
                    height:100,
                    closable: false,
                    html: '<img src="img/large-loading.gif" style="margin:20px"/>'
                });*/
                var booknewwin=Ext.MessageBox.show({
                    msg: 'Re-Generating All Keys, please wait...',
                    progressText: 'Saving...',
                    width:300,
                    wait:true,
                    waitConfig: {interval:200}
                });
                // booknewwin.show();
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'keys', 'action' => 'generate_keys')); ?>',
                    success: function(response, opts) {
                       
                        booknewwin.hide();
                    },
                    failure: function(response, opts) {
                        Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch add form. Error code'); ?>: ' + response.status);
                    }
                });
            }
        
        });

    }
    
    function AddBranch() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var branch_data = response.responseText;
			
                eval(branch_data);
			
                BranchAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditBranch(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var branch_data = response.responseText;
			
                eval(branch_data);
			
                BranchEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewBranch(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var branch_data = response.responseText;

                eval(branch_data);

                BranchViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch view form. Error code'); ?>: ' + response.status);
            }
        });
    }
    function ViewParentUsers(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_users_data = response.responseText;

                eval(parent_users_data);

                parentUsersViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the users view form. Error code'); ?>: ' + response.status);
            }
        });
    }


    function DeleteBranch(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Branch successfully deleted!'); ?>');
                RefreshBranchData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchBranch(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'search')); ?>',
            success: function(response, opts){
                var branch_data = response.responseText;

                eval(branch_data);

                branchSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branch search form. Error Code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByBranchName(value){
	var conditions = '\'Branch.name LIKE\' => \'%' + value + '%\'';
	store_branches.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshBranchData() {
	store_branches.reload();
    }


    if(center_panel.find('id', 'branch-tab') != "") {
	var p = center_panel.findById('branch-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('Branches'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'branch-tab',
            xtype: 'grid',
            store: store_branches,
            columns: [
                {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                {header: "<?php __('Branch Code'); ?>", dataIndex: 'list_order', sortable: true},
                {header: "<?php __('Fc Code'); ?>", dataIndex: 'fc_code', sortable: true},
                {header: "<?php __('Bank'); ?>", dataIndex: 'bank', sortable: true},
				{header: "<?php __('Branch Category'); ?>", dataIndex: 'branch_category', sortable: true},
				{header: "<?php __('Tag Code'); ?>", dataIndex: 'tag_code', sortable: true},
				{header: "<?php __('Region'); ?>", dataIndex: 'region', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
            ],
		
            viewConfig: {
                forceFit:true
            },
            listeners: {
                celldblclick: function(){
                    ViewBranch(Ext.getCmp('branch-tab').getSelectionModel().getSelected().data.id);
                }
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({
			
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Edit'); ?>',
                        id: 'edit-branch',
                        tooltip:'<?php __('<b>Edit Branches</b><br />Click here to modify the selected Branch'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                EditBranch(sel.data.id);
                            };
                        }
                    },' ', '-',  '<?php __('Bank'); ?>: ', {
                        xtype : 'combo',
                        emptyText: 'All',
                        store : new Ext.data.ArrayStore({
                            fields : ['id', 'name'],
                            data : [
                                ['-1', 'All'],
    <?php
    $st = false;
    foreach ($banks as $item) {
        if ($st)
            echo ",
							";
        ?>['<?php echo $item['Bank']['id']; ?>' ,'<?php echo $item['Bank']['name']; ?>']<?php
    $st = true;
}
    ?>						]
                                }),
                                displayField : 'name',
                                valueField : 'id',
                                mode : 'local',
                                value : '-1',
                                disableKeyFilter : true,
                                triggerAction: 'all',
                                listeners : {
                                    select : function(combo, record, index){
                                        store_branches.reload({
                                            params: {
                                                start: 0,
                                                limit: list_size,
                                                bank_id : combo.getValue()
                                            }
                                        });
                                    }
                                }
                            },
                            '->', {
                                xtype: 'textfield',
                                emptyText: '<?php __('[Search By Name]'); ?>',
                                id: 'branch_search_field',
                                listeners: {
                                    specialkey: function(field, e){
                                        if (e.getKey() == e.ENTER) {
                                            SearchByBranchName(Ext.getCmp('branch_search_field').getValue());
                                        }
                                    }
                                }
                            }, {
                                xtype: 'tbbutton',
                                icon: 'img/search.png',
                                cls: 'x-btn-text-icon',
                                text: '<?php __('GO'); ?>',
                                tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                                id: 'branch_go_button',
                                handler: function(){
                                    SearchByBranchName(Ext.getCmp('branch_search_field').getValue());
                                }
                            }, '-', {
                                xtype: 'tbbutton',
                                icon: 'img/table_search.png',
                                cls: 'x-btn-text-icon',
                                text: '<?php __('Advanced Search'); ?>',
                                tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
                                handler: function(){
                                    SearchBranch();
                                }
                            }
                        ]}),
                    bbar: new Ext.PagingToolbar({
                        pageSize: list_size,
                        store: store_branches,
                        displayInfo: true,
                        displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                        beforePageText: '<?php __('Page'); ?>',
                        afterPageText: '<?php __('of {0}'); ?>',
                        emptyMsg: '<?php __('No data to display'); ?>'
                    })
                });
                p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
                    p.getTopToolbar().findById('edit-branch').enable();
                    p.getTopToolbar().findById('delete-branch').enable();
                    p.getTopToolbar().findById('view-branch').enable();
                    if(this.getSelections().length > 1){
                        p.getTopToolbar().findById('edit-branch').disable();
                        p.getTopToolbar().findById('view-branch').disable();
                    }
                });
                p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
                    if(this.getSelections().length > 1){
                        p.getTopToolbar().findById('edit-branch').disable();
                        p.getTopToolbar().findById('view-branch').disable();
                        p.getTopToolbar().findById('delete-branch').enable();
                    }
                    else if(this.getSelections().length == 1){
                        p.getTopToolbar().findById('edit-branch').enable();
                        p.getTopToolbar().findById('view-branch').enable();
                        p.getTopToolbar().findById('delete-branch').enable();
                    }
                    else{
                        p.getTopToolbar().findById('edit-branch').disable();
                        p.getTopToolbar().findById('view-branch').disable();
                        p.getTopToolbar().findById('delete-branch').disable();
                    }
                });
                center_panel.setActiveTab(p);
	
                store_branches.load({
                    params: {
                        start: 0,          
                        limit: list_size
                    }
                });
	
            }
