		<?php
			$this->ExtForm->create('Loan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LoanAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Loan Type', 'value' => '');
                                        $options['items'] = array('House Loan' => 'House Loan','Additional House Loan' => 'Additional House Loan', 'Car Loan' => 'Car Loan','Emergency Loan'=>'Emergency Loan');
					$this->ExtForm->input('Type', $options);
				?>,
                                <?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Total Loan');
					$this->ExtForm->input('total', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Deduction');
					$this->ExtForm->input('Per_month', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Start Date');
					$this->ExtForm->input('start', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Number of Months');
					$this->ExtForm->input('no_months', $options);
				?>,
                                <?php 
					$options = array();
                                        $options = array('xtype'=>'textarea');
					$this->ExtForm->input('description', $options);
				?>]
		});
		
		var LoanAddWindow = new Ext.Window({
			title: '<?php __('Add Loan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LoanAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LoanAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Loan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LoanAddWindow.collapsed)
						LoanAddWindow.expand(true);
					else
						LoanAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LoanAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LoanAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentLoanData();
<?php } else { ?>
							RefreshLoanData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Warning'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					LoanAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LoanAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentLoanData();
<?php } else { ?>
							RefreshLoanData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Warning'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					LoanAddWindow.close();
				}
			}]
		});
