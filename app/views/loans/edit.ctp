		<?php
			$this->ExtForm->create('Loan');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LoanEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $loan['Loan']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $loan['Loan']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Loan Type', 'value' => '');
                                        $options['items'] = array('House Loan' => 'House Loan','Additional House Loan' => 'Additional House Loan', 'Car Loan' => 'Car Loan','Emergency Loan'=>'Emergency Loan');
					$options['value'] = $loan['Loan']['Type'];
                                        $this->ExtForm->input('Type', $options);
				?>,
                                <?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Total Loan');
                                        $options['value'] = $loan['Loan']['total'];
					$this->ExtForm->input('total', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Deduction');
                                        $options['value'] = $loan['Loan']['Per_month'];
					$this->ExtForm->input('Per_month', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Start Date');
                                        $options['value'] = $loan['Loan']['start'];
					$this->ExtForm->input('start', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Number of Months');
                                        $options['value'] = $loan['Loan']['no_months'];
					$this->ExtForm->input('no_months', $options);
				?>,
                                <?php 
					$options = array();
                                        $options = array('xtype'=>'textarea');
                                        $options['value'] = $loan['Loan']['description'];
					$this->ExtForm->input('description', $options);
				?>			]
		});
		
		var LoanEditWindow = new Ext.Window({
			title: '<?php __('Edit Loan'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LoanEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LoanEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Loan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LoanEditWindow.collapsed)
						LoanEditWindow.expand(true);
					else
						LoanEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LoanEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LoanEditWindow.close();
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
					LoanEditWindow.close();
				}
			}]
		});