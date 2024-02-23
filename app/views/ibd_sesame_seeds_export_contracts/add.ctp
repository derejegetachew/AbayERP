		<?php
			$this->ExtForm->create('IbdSesameSeedsExportContract');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdSesameSeedsExportContractAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'add')); ?>',
		

			items: [
			{
			layout:'column',
            items:[
            {

			         columnWidth:.5,
						layout: 'form',
						items: [
				<?php 
					$options = array();
					$this->ExtForm->input('exporter_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('contract_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('contract_registry_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value']=$contract_no;
					$this->ExtForm->input('contract_registration_no', $options);
				?>,
				{
				    id:'quantity_mt',
					xtype:'textfield',
					fieldLabel:'Quantity Mt',
					anchor:'100%',
					name :'data[IbdSesameSeedsExportContract][quantity_mt]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('price_mt').getValue();
							 var result=value*other;
                             Ext.getCmp('total_price').setValue(result);
						}
					}
			     },
			     {
				    id:'price_mt',
					xtype:'textfield',
					fieldLabel:'Price',
					anchor:'100%',
					name :'data[IbdSesameSeedsExportContract][price_mt]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('quantity_mt').getValue();
							 var result=value*other;
                             Ext.getCmp('total_price').setValue(result);
						}
					}
			     }
				,
						<?php 
					$options = array('id'=>'total_price');
					$this->ExtForm->input('total_price', $options);
				?>,
			
				]},
				{

			         columnWidth:.5,
						layout: 'form',
						items: [
					<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Currency','valueField'=>'name');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currency_types;
					$this->ExtForm->input('type_of_currency', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','valueField'=>'name','fieldLabel'=>'Payment Method');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payment_terms;
					$this->ExtForm->input('payment_method', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('commodity_type', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('shipment_date', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Delivery Term');
					$list=array('FOB'=>'FOB');
					$options['items']=$list;
					$this->ExtForm->input('delivery_term', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('sales_contract_reference', $options);
				?>			
				]}
				]}

				]
		});
		
		var IbdSesameSeedsExportContractAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Sesame Seeds Export Contract'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdSesameSeedsExportContractAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdSesameSeedsExportContractAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Sesame Seeds Export Contract.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdSesameSeedsExportContractAddWindow.collapsed)
						IbdSesameSeedsExportContractAddWindow.expand(true);
					else
						IbdSesameSeedsExportContractAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdSesameSeedsExportContractAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdSesameSeedsExportContractAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdSesameSeedsExportContractData();
<?php } else { ?>
							RefreshIbdSesameSeedsExportContractData();
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
					IbdSesameSeedsExportContractAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdSesameSeedsExportContractAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdSesameSeedsExportContractData();
<?php } else { ?>
							RefreshIbdSesameSeedsExportContractData();
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
					IbdSesameSeedsExportContractAddWindow.close();
				}
			}]
		});