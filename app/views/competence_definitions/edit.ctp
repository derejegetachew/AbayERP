		<?php
			$this->ExtForm->create('CompetenceDefinition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CompetenceDefinitionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'competenceDefinitions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $competence_definition['CompetenceDefinition']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $competences;
					$options['value'] = $competence_definition['CompetenceDefinition']['competence_id'];
					$this->ExtForm->input('competence_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $competence_levels;
					$options['value'] = $competence_definition['CompetenceDefinition']['competence_level_id'];
					$this->ExtForm->input('competence_level_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $competence_definition['CompetenceDefinition']['definition'];
					$this->ExtForm->input('definition', $options);
				?>			]
		});
		
		var CompetenceDefinitionEditWindow = new Ext.Window({
			title: '<?php __('Edit Competence Definition'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompetenceDefinitionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompetenceDefinitionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Competence Definition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompetenceDefinitionEditWindow.collapsed)
						CompetenceDefinitionEditWindow.expand(true);
					else
						CompetenceDefinitionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CompetenceDefinitionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompetenceDefinitionEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompetenceDefinitionData();
<?php } else { ?>
							RefreshCompetenceDefinitionData();
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
					CompetenceDefinitionEditWindow.close();
				}
			}]
		});
