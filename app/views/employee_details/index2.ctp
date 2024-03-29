var store_parent_employeeDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','grade','status','step','position','branch','start_date','end_date','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'list_data', $parent_id)); ?>'	}),
                sortInfo:{field: 'start_date', direction: "ASC"}
});


function AddParentEmployeeDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_employeeDetail_data = response.responseText;
			
			eval(parent_employeeDetail_data);
			
			EmployeeDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeeDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentEmployeeDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_employeeDetail_data = response.responseText;
			
			eval(parent_employeeDetail_data);
			
			EmployeeDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeeDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewEmployeeDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var employeeDetail_data = response.responseText;

			eval(employeeDetail_data);

			EmployeeDetailViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employeeDetail view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentEmployeeDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Employment history successfully deleted!'); ?>');
			RefreshParentEmployeeDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employment history to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentEmployeeDetailName(value){
	var conditions = '\'EmployeeDetail.name LIKE\' => \'%' + value + '%\'';
	store_parent_employeeDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentEmployeeDetailData() {
	store_parent_employeeDetails.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __(''); ?>',
	store: store_parent_employeeDetails,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'employeeDetailGrid',
	columns: [
		{header:"<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
		{header:"<?php __('Step'); ?>", dataIndex: 'step', sortable: true},
		{header:"<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
                {header:"<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
                {header:"<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
		{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
                {header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true}],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Promote/Demote'); ?>',
				tooltip:'<?php __('<b>Promote/Demote Employee</b>'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentEmployeeDetail();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-employeeDetail',
				tooltip:'<?php __('<b>Edit EmployeeDetail</b><br />Click here to modify the selected EmployeeDetail'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentEmployeeDetail(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-employeeDetail',
				tooltip:'<?php __('<b>Delete EmployeeDetail(s)</b><br />Click here to remove the selected EmployeeDetail(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Employment History'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentEmployeeDetail(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Employment history'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentEmployeeDetail(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_employeeDetails,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-employeeDetail').enable();
	g.getTopToolbar().findById('delete-parent-employeeDetail').enable();
       // g.getTopToolbar().findById('view-employeeDetail2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-employeeDetail').disable();
           //     g.getTopToolbar().findById('view-employeeDetail2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-employeeDetail').disable();
		g.getTopToolbar().findById('delete-parent-employeeDetail').enable();
             //   g.getTopToolbar().findById('view-employeeDetail2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-employeeDetail').enable();
		g.getTopToolbar().findById('delete-parent-employeeDetail').enable();
              //  g.getTopToolbar().findById('view-employeeDetail2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-employeeDetail').disable();
		g.getTopToolbar().findById('delete-parent-employeeDetail').disable();
              //  g.getTopToolbar().findById('view-employeeDetail2').disable();
	}
});



var parentEmployeeDetailsViewWindow = new Ext.Window({
	title: 'Employment History',
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
			parentEmployeeDetailsViewWindow.close();
		}
	}]
});

store_parent_employeeDetails.load({
    params: {
        start: 0,    
        limit: list_size
    }
});