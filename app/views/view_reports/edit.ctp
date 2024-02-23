		<?php
			$this->ExtForm->create('ViewReport');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ViewReportEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'viewReports', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $view_report['ViewReport']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $view_report['ViewReport']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $view_report['ViewReport']['lname'];
					$this->ExtForm->input('lname', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $view_report['ViewReport']['sex'];
					$this->ExtForm->input('sex', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $view_report['ViewReport']['phone'];
					$this->ExtForm->input('phone', $options);
				?>			]
		});
		
		var ViewReportEditWindow = new Ext.Window({
			title: '<?php __('Edit View Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ViewReportEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ViewReportEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing View Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ViewReportEditWindow.collapsed)
						ViewReportEditWindow.expand(true);
					else
						ViewReportEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ViewReportEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ViewReportEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentViewReportData();
<?php } else { ?>
							RefreshViewReportData();
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
					ViewReportEditWindow.close();
				}
			}]
		});
