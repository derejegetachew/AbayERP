		<?php
			$this->ExtForm->create('Deduction');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DeductionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Name', 'value' => '');
                                        $options['items'] = array(
                                            'Agar children Aid' => 'Agar children Aid',
                                            'Social Contribution' => 'Social Contribution',
                                            'Cost Sharing'=>'Cost Sharing',
											'Penality'=>'Penality',
											'Excess Telephone'=>'Excess Telephone'
                                            );
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Measurement', 'value' => '');
                                        $options['items'] = array('Birr' => 'Birr','Percentile: Basic Salary' => 'Percentile: Basic Salary','Percentile: Gross Salary'=>'Percentile: Gross Salary');
					$this->ExtForm->input('Measurement', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $grades;
					$this->ExtForm->input('grade_id', $options);
				?>,
                               <?php 
					$options = array();
                                        if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payrolls;
					$options['value'] = $this->Session->read('Auth.User.payroll_id');
					$this->ExtForm->input('payroll_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('end_date', $options);
				?>			]
		});
		
		var DeductionAddWindow = new Ext.Window({
			title: '<?php __('Add Deduction'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DeductionAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DeductionAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Deduction.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DeductionAddWindow.collapsed)
						DeductionAddWindow.expand(true);
					else
						DeductionAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DeductionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DeductionAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentDeductionData();
<?php } else { ?>
							RefreshDeductionData();
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
					DeductionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DeductionAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDeductionData();
<?php } else { ?>
							RefreshDeductionData();
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
					DeductionAddWindow.close();
				}
			}]
		});
