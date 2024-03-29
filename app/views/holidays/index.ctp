
var store_holidays = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','leave_type','from_date','to_date','filled_date','status','no_of_dates'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'employee', direction: "ASC"},
	groupField: 'leave_type'
});


function AddHoliday() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var holiday_data = response.responseText;
			
			eval(holiday_data);
			
			HolidayAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday add form. Error code'); ?>: ' + response.status);
		}
	});
}

function ModifyHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'modify')); ?>/'+id,
		success: function(response, opts) {
			var holiday_data = response.responseText;
			
			eval(holiday_data);
			
			HolidayEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewHoliday(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var holiday_data = response.responseText;

            eval(holiday_data);

            HolidayViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Holiday successfully deleted!'); ?>');
			RefreshHolidayData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the holiday add form. Error code'); ?>: ' + response.status);
		}
	});
}

function CancelHoliday(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'cancel')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Leave successfully canceled!'); ?>');
			RefreshHolidayData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the leave cancel form. Error code'); ?>: ' + response.status);
		}
	});
}
function SearchHoliday(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'search')); ?>',
		success: function(response, opts){
			var holiday_data = response.responseText;

			eval(holiday_data);

			holidaySearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the holiday search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByHolidayName(value){
	var conditions = '\'Holiday.name LIKE\' => \'%' + value + '%\'';
	store_holidays.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshHolidayData() {
	store_holidays.reload();

}


if(center_panel.find('id', 'holiday-tab') != "") {
	var p = center_panel.findById('holiday-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Leave'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'holiday-tab',
		xtype: 'grid',
		store: store_holidays,
		columns: [
			{header: "<?php __('Leave Type'); ?>", dataIndex: 'leave_type', sortable: true},
			{header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
			{header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
                        {header: "<?php __('No of Dates'); ?>", dataIndex: 'no_of_dates', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "" : ""]})'
        })
,
		listeners: {
			celldblclick: function(){
				//ViewHoliday(Ext.getCmp('holiday-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Request Leave'); ?>',
					tooltip:'<?php __('<b>Request Leave</b><br />Click here to create a new Leave'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
                                        id:'request-holiday',
					handler: function(btn) {
						AddHoliday();
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Modify/Delete'); ?>',
					id: 'cancel-holiday',
					tooltip:'<?php __('<b>Cancel Leave</b><br />Click here to cancel your leave'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								ModifyHoliday(sel[0].data.id);
								
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},'-','Your annual leave balance is: <?php echo $balance; ?>'
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_holidays,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
				if(r.get('status')!='Rejected' && r.get('status')!=='Resubmitted for Correction' && r.get('status')!='Resubmitted for Cancellation')
                p.getTopToolbar().findById('cancel-holiday').enable();
				

	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-holiday').disable();
			//p.getTopToolbar().findById('view-holiday').disable();
			//p.getTopToolbar().findById('delete-holiday').enable();
                        p.getTopToolbar().findById('cancel-holiday').disable();
		}
		else if(this.getSelections().length == 1){
			//p.getTopToolbar().findById('edit-holiday').enable();
			//p.getTopToolbar().findById('view-holiday').enable();
			//p.getTopToolbar().findById('delete-holiday').enable();
                        p.getTopToolbar().findById('cancel-holiday').disable();
		}
		else{
			//p.getTopToolbar().findById('edit-holiday').disable();
			//p.getTopToolbar().findById('view-holiday').disable();
			//p.getTopToolbar().findById('delete-holiday').disable();
                        p.getTopToolbar().findById('cancel-holiday').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_holidays.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
        store_holidays.on('load', function(){
        p.getTopToolbar().findById('request-holiday').enable();
		 p.getTopToolbar().findById('cancel-holiday').disable();
            store_holidays.each(function(r) {
            //if(r.get('status')=='Pending Approval' || r.get('status')=='Scheduled' || r.get('status')=='On Leave')
           // p.getTopToolbar().findById('request-holiday').disable();
   
        })
        });

	
}
