
var store_viewReports = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','lname','sex','phone'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'view_reports', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'name'
});


function AddViewReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'viewReports', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var viewReport_data = response.responseText;
			
			eval(viewReport_data);
			
			ViewReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the viewReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditViewReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'viewReports', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var viewReport_data = response.responseText;
			
			eval(viewReport_data);
			
			ViewReportEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the viewReport edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewViewReport(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'viewReports', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var viewReport_data = response.responseText;

            eval(viewReport_data);

            ViewReportViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the viewReport view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteViewReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'viewReports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ViewReport successfully deleted!'); ?>');
			RefreshViewReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the viewReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchViewReport(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'viewReports', 'action' => 'search')); ?>',
		success: function(response, opts){
			var viewReport_data = response.responseText;

			eval(viewReport_data);

			viewReportSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the viewReport search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByViewReportName(value){
	var conditions = '\'ViewReport.name LIKE\' => \'%' + value + '%\'';
	store_viewReports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshViewReportData() {
	store_viewReports.reload();
}


if(center_panel.find('id', 'viewReport-tab') != "") {
	var p = center_panel.findById('viewReport-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('View Reports'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'viewReport-tab',
		xtype: 'grid',
		store: store_viewReports,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Lname'); ?>", dataIndex: 'lname', sortable: true},
			{header: "<?php __('Sex'); ?>", dataIndex: 'sex', sortable: true},
			{header: "<?php __('Phone'); ?>", dataIndex: 'phone', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ViewReports" : "ViewReport"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewViewReport(Ext.getCmp('viewReport-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ViewReports</b><br />Click here to create a new ViewReport'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddViewReport();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-viewReport',
					tooltip:'<?php __('<b>Edit ViewReports</b><br />Click here to modify the selected ViewReport'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditViewReport(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-viewReport',
					tooltip:'<?php __('<b>Delete ViewReports(s)</b><br />Click here to remove the selected ViewReport(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ViewReport'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteViewReport(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ViewReport'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ViewReports'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteViewReport(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View ViewReport'); ?>',
					id: 'view-viewReport',
					tooltip:'<?php __('<b>View ViewReport</b><br />Click here to see details of the selected ViewReport'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewViewReport(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'viewReport_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByViewReportName(Ext.getCmp('viewReport_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'viewReport_go_button',
					handler: function(){
						SearchByViewReportName(Ext.getCmp('viewReport_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchViewReport();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_viewReports,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-viewReport').enable();
		p.getTopToolbar().findById('delete-viewReport').enable();
		p.getTopToolbar().findById('view-viewReport').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-viewReport').disable();
			p.getTopToolbar().findById('view-viewReport').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-viewReport').disable();
			p.getTopToolbar().findById('view-viewReport').disable();
			p.getTopToolbar().findById('delete-viewReport').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-viewReport').enable();
			p.getTopToolbar().findById('view-viewReport').enable();
			p.getTopToolbar().findById('delete-viewReport').enable();
		}
		else{
			p.getTopToolbar().findById('edit-viewReport').disable();
			p.getTopToolbar().findById('view-viewReport').disable();
			p.getTopToolbar().findById('delete-viewReport').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_viewReports.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
