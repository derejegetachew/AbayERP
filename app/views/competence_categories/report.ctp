<?php
			$this->ExtForm->create('CompetenceCategory');
			$this->ExtForm->defineFieldFunctions();
		?>

var store_employee_names = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'full_name','position'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'search_emp2')); ?>'
	}),	
        sortInfo:{field: 'full_name', direction: "ASC"}
    });
      store_employee_names.load({
            params: {
                start: 0
            }
        });

var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});
function my_technical_report(emp, budget_year, quarter){
	myMask.show();
	var data = emp+'-'+budget_year+'-'+quarter;
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'ho_ind_objectives_report')); ?>/'+data,
		success: function(response, opts) {
			var competenceCategories_data = response.responseText;
			
			eval(competenceCategories_data);
			AllReportWindow.close();

			myMask.hide();	
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategories edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function my_tracking_report(emp, budget_year, quarter){
	myMask.show();
	var data = emp+'-'+budget_year+'-'+quarter;
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'ho_ind_tracking_report')); ?>/'+data,
		success: function(response, opts) {
			var competenceCategories_data = response.responseText;
			
			eval(competenceCategories_data);
			AllReportWindow.close();

			myMask.hide();	
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategories edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function my_behavioural_report(emp, budget_year, quarter){
	myMask.show();
	var data = emp+'-'+budget_year+'-'+quarter;
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'ho_ind_behavioural_report')); ?>/'+data,
		success: function(response, opts) {
			var competenceCategories_data = response.responseText;
			
			eval(competenceCategories_data);
			AllReportWindow.close();
			myMask.hide();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategories edit form. Error code'); ?>: ' + response.status);
		}
	});
}

		var AllReportForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'report')); ?>',
			defaultType: 'textfield',

			items: [

               
				{
                        xtype: 'combo',
                        
                        emptyText: 'All',
                        id: 'emp_combo',
						name: 'emp_combo',
						hiddenName:'data[CompetenceCategory][emp]',
                        store : store_employee_names,
                        displayField : 'full_name',
                        valueField : 'id',
                        fieldLabel: 'Full Name',
                        mode: 'local',
                        disableKeyFilter : true,
                        emptyText: '',
                        editable: true,
                        triggerAction: 'all',
                        hideTrigger:true,
						anchor: '100%',
                                    },
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'report_store2',
						id: 2,
						fields: ['id','name'],
						
						data: [						
						<?php  foreach($budget_years as $key => $val){
                         ?>
                         [<?php echo $key; ?>, '<?php echo $val; ?>'],
                         <?php
                        } ?>						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[CompetenceCategory][budget_year_id]',
					id: 'budget_year_combo',
					name: 'budget_year_combo',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Type',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Budget Year',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'report_store3',
						id: 1,
						fields: ['id','name'],
						
						data: [						
						[1 , 'I'],[2, 'II'],[3, 'III'],[4, 'IV']						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[CompetenceCategory][quarter]',
					id: 'quarter_combo',
					name: 'quarter_combo',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Type',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Quarter',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				
                {
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'report_store4',
						id: 0,
						fields: ['id','name'],
						
						data: [						
						['technical','Technical'],['tracking', 'Tracking'],['behavioural','Behavioural'],						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[CompetenceCategory][report_type]',
					id: 'type_combo',
					name: 'type_combo',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Type',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Report Type',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
							
                ]
		});
		
		var AllReportWindow = new Ext.Window({
			title: '<?php __('Individual Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AllReportForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					AllReportForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Competence Category.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(AllReportWindow.collapsed)
                        AllReportWindow.expand(true);
					else
                        AllReportWindow.collapse(true);
				}
			}],
			buttons: [  
				 {
				text: '<?php __('Display Report'); ?>',
				handler: function(btn){
					
				if(Ext.getCmp('emp_combo').getValue() != '' &&
				Ext.getCmp('budget_year_combo').getValue() != '' &&
				Ext.getCmp('quarter_combo').getValue() != ''  &&
				Ext.getCmp('type_combo').getValue() != ''
				){
					if(Ext.getCmp('type_combo').getValue() == 'technical'){
						my_technical_report(Ext.getCmp('emp_combo').getValue(),Ext.getCmp('budget_year_combo').getValue(),
						Ext.getCmp('quarter_combo').getValue());
					}
					else if(Ext.getCmp('type_combo').getValue() == 'tracking'){
						my_tracking_report(Ext.getCmp('emp_combo').getValue(),Ext.getCmp('budget_year_combo').getValue(),
						Ext.getCmp('quarter_combo').getValue());
					}
					else {
						my_behavioural_report(Ext.getCmp('emp_combo').getValue(),Ext.getCmp('budget_year_combo').getValue(),
						Ext.getCmp('quarter_combo').getValue());
					}
				}
				else {
					alert("Please fill all fields");
				}
               
			   
                }
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					AllReportWindow.close();
				}
			}]
		});
