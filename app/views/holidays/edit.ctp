		<?php
			$this->ExtForm->create('Holiday');
			$this->ExtForm->defineFieldFunctions();
		?>
		var HolidayEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $holiday['Holiday']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $holiday['Holiday']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $leave_types;
					$options['value'] = $holiday['Holiday']['leave_type_id'];
					$this->ExtForm->input('leave_type_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $holiday['Holiday']['from_date'];
					$this->ExtForm->input('from_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $holiday['Holiday']['to_date'];
					$this->ExtForm->input('to_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $holiday['Holiday']['filled_date'];
					$this->ExtForm->input('filled_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $holiday['Holiday']['status'];
					$this->ExtForm->input('status', $options);
				?>			]
		});
		
		var HolidayEditWindow = new Ext.Window({
			title: '<?php __('Edit Holiday'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: HolidayEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					HolidayEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Holiday.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(HolidayEditWindow.collapsed)
						HolidayEditWindow.expand(true);
					else
						HolidayEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					HolidayEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HolidayEditWindow.close();
					<?php if(isset($parent_id)){ ?>
							RefreshParentHolidayData();
					<?php } else { ?>
							RefreshHolidayData();
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
					HolidayEditWindow.close();
				}
			}]
		});
