		<?php
			$this->ExtForm->create('GeneretReport');
			$this->ExtForm->defineFieldFunctions();
		?>
		var GeneretReportEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'generetReports', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $reports;
					$options['value'] = $generet_report['GeneretReport']['report_id'];
					$this->ExtForm->input('report_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $generet_report['GeneretReport']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $generet_report['GeneretReport']['type_ofreport'];
					$this->ExtForm->input('type_ofreport', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $generet_report['GeneretReport']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $generet_report['GeneretReport']['no'];
					$this->ExtForm->input('no', $options);
				?>			]
		});
		
		var GeneretReportEditWindow = new Ext.Window({
			title: '<?php __('Edit Generet Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: GeneretReportEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					GeneretReportEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Generet Report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(GeneretReportEditWindow.collapsed)
						GeneretReportEditWindow.expand(true);
					else
						GeneretReportEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					GeneretReportEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							GeneretReportEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentGeneretReportData();
<?php } else { ?>
							RefreshGeneretReportData();
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
					GeneretReportEditWindow.close();
				}
			}]
		});
