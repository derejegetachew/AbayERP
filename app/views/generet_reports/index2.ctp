var store_parent_generetReports = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'report','name','type_ofreport','date','no'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentGeneretReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_generetReport_data = response.responseText;
			
			eval(parent_generetReport_data);
			
			GeneretReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the generetReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentGeneretReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_generetReport_data = response.responseText;
			
			eval(parent_generetReport_data);
			
			GeneretReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the generetReport edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewGeneretReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var generetReport_data = response.responseText;

			eval(generetReport_data);

			GeneretReportViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the generetReport view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentGeneretReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('GeneretReport(s) successfully deleted!'); ?>');
			RefreshParentGeneretReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the generetReport to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentGeneretReportName(value){
	var conditions = '\'GeneretReport.name LIKE\' => \'%' + value + '%\'';
	store_parent_generetReports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentGeneretReportData() {
	store_parent_generetReports.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('GeneretReports'); ?>',
	store: store_parent_generetReports,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'generetReportGrid',
	columns: [
		{header:"<?php __('report'); ?>", dataIndex: 'report', sortable: true},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Type Ofreport'); ?>", dataIndex: 'type_ofreport', sortable: true},
		{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
		{header: "<?php __('No'); ?>", dataIndex: 'no', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewGeneretReport(Ext.getCmp('generetReportGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add GeneretReport</b><br />Click here to create a new GeneretReport'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentGeneretReport();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-generetReport',
				tooltip:'<?php __('<b>Edit GeneretReport</b><br />Click here to modify the selected GeneretReport'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentGeneretReport(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-generetReport',
				tooltip:'<?php __('<b>Delete GeneretReport(s)</b><br />Click here to remove the selected GeneretReport(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove GeneretReport'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentGeneretReport(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove GeneretReport'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected GeneretReport'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentGeneretReport(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View GeneretReport'); ?>',
				id: 'view-generetReport2',
				tooltip:'<?php __('<b>View GeneretReport</b><br />Click here to see details of the selected GeneretReport'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewGeneretReport(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_generetReport_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentGeneretReportName(Ext.getCmp('parent_generetReport_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_generetReport_go_button',
				handler: function(){
					SearchByParentGeneretReportName(Ext.getCmp('parent_generetReport_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_generetReports,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-generetReport').enable();
	g.getTopToolbar().findById('delete-parent-generetReport').enable();
        g.getTopToolbar().findById('view-generetReport2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-generetReport').disable();
                g.getTopToolbar().findById('view-generetReport2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-generetReport').disable();
		g.getTopToolbar().findById('delete-parent-generetReport').enable();
                g.getTopToolbar().findById('view-generetReport2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-generetReport').enable();
		g.getTopToolbar().findById('delete-parent-generetReport').enable();
                g.getTopToolbar().findById('view-generetReport2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-generetReport').disable();
		g.getTopToolbar().findById('delete-parent-generetReport').disable();
                g.getTopToolbar().findById('view-generetReport2').disable();
	}
});



var parentGeneretReportsViewWindow = new Ext.Window({
	title: 'GeneretReport Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentGeneretReportsViewWindow.close();
		}
	}]
});

store_parent_generetReports.load({
    params: {
        start: 0,    
        limit: list_size
    }
});