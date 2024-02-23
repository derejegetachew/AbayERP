
var store_generetReports = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'report','name','type_ofreport','date','no'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'type_ofreport'
});


function AddGeneretReport() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var generetReport_data = response.responseText;
			
			eval(generetReport_data);
			
			GeneretReportAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the generetReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditGeneretReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var generetReport_data = response.responseText;
			
			eval(generetReport_data);
			
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

function DeleteGeneretReport(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('GeneretReport successfully deleted!'); ?>');
			RefreshGeneretReportData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the generetReport add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchGeneretReport(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'search')); ?>',
		success: function(response, opts){
			var generetReport_data = response.responseText;

			eval(generetReport_data);

			generetReportSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the generetReport search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByGeneretReportName(value){
	var conditions = '\'GeneretReport.name LIKE\' => \'%' + value + '%\'';
	store_generetReports.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshGeneretReportData() {
	store_generetReports.reload();
}


if(center_panel.find('id', 'generetReport-tab') != "") {
	var p = center_panel.findById('generetReport-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Generet Reports'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'generetReport-tab',
		xtype: 'grid',
		store: store_generetReports,
		columns: [
			{header: "<?php __('Report'); ?>", dataIndex: 'report', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Type Ofreport'); ?>", dataIndex: 'type_ofreport', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('No'); ?>", dataIndex: 'no', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "GeneretReports" : "GeneretReport"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewGeneretReport(Ext.getCmp('generetReport-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add GeneretReports</b><br />Click here to create a new GeneretReport'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddGeneretReport();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-generetReport',
					tooltip:'<?php __('<b>Edit GeneretReports</b><br />Click here to modify the selected GeneretReport'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditGeneretReport(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-generetReport',
					tooltip:'<?php __('<b>Delete GeneretReports(s)</b><br />Click here to remove the selected GeneretReport(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove GeneretReport'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteGeneretReport(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove GeneretReport'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected GeneretReports'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteGeneretReport(sel_ids);
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
					text: '<?php __('View GeneretReport'); ?>',
					id: 'view-generetReport',
					tooltip:'<?php __('<b>View GeneretReport</b><br />Click here to see details of the selected GeneretReport'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewGeneretReport(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Report'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($reports as $item){if($st) echo ",
							";?>['<?php echo $item['Report']['id']; ?>' ,'<?php echo $item['Report']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_generetReports.reload({
								params: {
									start: 0,
									limit: list_size,
									report_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'generetReport_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByGeneretReportName(Ext.getCmp('generetReport_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'generetReport_go_button',
					handler: function(){
						SearchByGeneretReportName(Ext.getCmp('generetReport_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchGeneretReport();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_generetReports,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-generetReport').enable();
		p.getTopToolbar().findById('delete-generetReport').enable();
		p.getTopToolbar().findById('view-generetReport').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-generetReport').disable();
			p.getTopToolbar().findById('view-generetReport').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-generetReport').disable();
			p.getTopToolbar().findById('view-generetReport').disable();
			p.getTopToolbar().findById('delete-generetReport').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-generetReport').enable();
			p.getTopToolbar().findById('view-generetReport').enable();
			p.getTopToolbar().findById('delete-generetReport').enable();
		}
		else{
			p.getTopToolbar().findById('edit-generetReport').disable();
			p.getTopToolbar().findById('view-generetReport').disable();
			p.getTopToolbar().findById('delete-generetReport').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_generetReports.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
