
var store_jobs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','start_date','end_date','grade','location','remark'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'list_data3')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});

function MyJob() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'index4')); ?>',
		success: function(response, opts) {
			var job_data = response.responseText;
			
			eval(job_data);
			
			parentJobsMyWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function AddJob() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var job_data = response.responseText;
			
			eval(job_data);
			
			JobAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job add form. Error code'); ?>: ' + response.status);
		}
	});
}
function AddParentApplication(id) {
  var a='<?php echo $disable; ?>';
  
  if(a=='true'){
  Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var parent_application_data = response.responseText;
			
			eval(parent_application_data);
			
			ApplicationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the application add form. Error code'); ?>: ' + response.status);
		}
	});
  }else{
		Ext.Msg.alert('<?php __('Info'); ?>', '<?php __('Sorry You have not fulfilled the one year minimum work experience at Abay Bank S.C to apply for jobs.')?>');
 }
 
}
function EditJob(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var job_data = response.responseText;
			
			eval(job_data);
			
			JobEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewJob(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var job_data = response.responseText;

            eval(job_data);

            JobViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentApplications(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_applications_data = response.responseText;

            eval(parent_applications_data);

            parentApplicationsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteJob(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Job successfully deleted!'); ?>');
			RefreshJobData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the job add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchJob(){
  
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var job_data = response.responseText;

			eval(job_data);

			jobSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the job search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByJobName(value){
	var conditions = '\'Job.name LIKE\' => \'%' + value + '%\'';
	store_jobs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshJobData() {
	store_jobs.reload();
}


if(center_panel.find('id', 'job-tab') != "") {
	var p = center_panel.findById('job-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Jobs'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'job-tab',
		xtype: 'grid',
		store: store_jobs,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true,},
			{header: "<?php __('Requirements'); ?>", dataIndex: 'description'},
			{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
			{header: "<?php __('Location'); ?>", dataIndex: 'location', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Last Application Date'); ?>", dataIndex: 'end_date', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Jobs" : "Job"]})'
        })
,
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
                tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Apply'); ?>',
					tooltip:'<?php echo $message; ?>',
          id: 'edit-job',
          disabled: true,
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',  
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							AddParentApplication(sel.data.id);
						};
					}
				}, ' ','-',' ','-',
				{
					xtype: 'tbbutton',
					text: '<?php __('VIEW YOUR HISTORY'); ?>',
					id: 'my-job',
					tooltip:'<?php __('<b>View History</b>'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {						
							MyJob();					
					}
				}
                                ]
                                }),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_jobs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
  var a='<?php echo $disable; ?>';
  //if(a=='true'){
   p.getTopToolbar().findById('edit-job').enable();
  //}
		
		//p.getTopToolbar().findById('delete-job').enable();
		//p.getTopToolbar().findById('view-job').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-job').disable();
			//p.getTopToolbar().findById('view-job').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1 ){
			p.getTopToolbar().findById('edit-job').disable();
			//p.getTopToolbar().findById('view-job').disable();
			//p.getTopToolbar().findById('delete-job').enable();
		}
		else if(this.getSelections().length == 1 && $disable){
			p.getTopToolbar().findById('edit-job').enable();
			//p.getTopToolbar().findById('view-job').enable();
			//p.getTopToolbar().findById('delete-job').enable();
		}
		else{
			p.getTopToolbar().findById('edit-job').disable();
			//p.getTopToolbar().findById('view-job').disable();
			//p.getTopToolbar().findById('delete-job').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_jobs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
