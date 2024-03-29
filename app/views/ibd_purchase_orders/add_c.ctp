		<?php
			$this->ExtForm->create('IbdPurchaseOrder');
			$this->ExtForm->defineFieldFunctions();
		?>
		var remaining=0;
		var canPost=true;
		var IbdIbcAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'IbdPurchaseOrders', 'action' => 'add_c')); ?>',
			defaultType: 'textfield',

			items: [
			  {  
				    store: new Ext.data.ArrayStore({ 
				    	id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($purchase as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
				    xtype: 'combo', 
				    id: 'PURCHASE_ORDER_NO', 
				    name: 'data[IbdPurchaseOrder][PURCHASE_ORDER_NO]', 
				    fieldLabel: 'PURCHASE ORDER NO', 
				    typeAhead: true, 
				    emptyText: 'Select One', 
				    editable: true, 
				    forceSelection: true, 
				    triggerAction: 'all', 
				    lazyRender: true, 
				    mode: 'local', 
				    valueField: 'id', 
				    displayField: 'name', 
				    allowBlank: false, 
				    anchor: '100%',
				    listeners : {
						 select: function(field,r,i){
						var permit=r.data.name;
						permit=permit.replace(/\//g,"(");
						

					Ext.Ajax.request({
                         url:'<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'get_po_importer')); ?>/'+permit,
                         success:function(data,opts){
                            var jsonData = Ext.util.JSON.decode(data.responseText);
							console.log(jsonData);
                           
                            Ext.getCmp('NAME_OF_IMPORTER').setValue(jsonData[0]['ibd_purchase_orders']['NAME_OF_IMPORTER']);
                            Ext.getCmp('currency').setValue(jsonData[0]['ibd_purchase_orders']['currency_id']);
                            Ext.getCmp('SETT_FCY').setValue(jsonData[0]['ibd_purchase_orders']['REM_FCY_AMOUNT']);
                            remaining=jsonData[0]['ibd_purchase_orders']['REM_FCY_AMOUNT'];
                            console.log(remaining);
                         },
                         failed:function(data,opts){
                          Ext.Msg.alert('Status',data);
                         }
			    		});

						}
					}
				},
                  
				 <?php 
				
					$options = array('id'=>'NAME_OF_IMPORTER');
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>
			 ,
				 <?php 
					$options = array('id'=>'currency');
					$this->ExtForm->input('currency', $options);
				?>
				,
				
				{
				xtype: 'textfield', 
				fieldLabel: 'SETT FCY', 
				id:'SETT_FCY',
				name: 'data[IbdPurchaseOrder][SETT_FCY]', 
				anchor: '100%' ,
				enableKeyEvents:true,
				listeners:{
					keyup:function(object,e){
							console.log(parseFloat(e.target.value)>parseFloat(remaining));
						if(parseFloat(e.target.value)>parseFloat(remaining)){

							canPost=false;
							
						}else{canPost=true;}
                       
					}
				}
			    }
				
				
				]
		});
		
		var IbdIbcAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Ibc'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdIbcAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdIbcAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Ibc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdIbcAddWindow.collapsed)
						IbdIbcAddWindow.expand(true);
					else
						IbdIbcAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
                    if(canPost){
					IbdIbcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdIbcAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdPurchaseOrderData();
<?php } else { ?>
							RefreshIbdPurchaseOrderData();
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
				}else{
					Ext.Msg.alert('Info','Insufficient Amount. Please Check the IBC FCY Amount')
				}

				}
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
           if(canPost){
					IbdIbcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdIbcAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdIbcData();
<?php } else { ?>
							RefreshIbdIbcData();
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
					}else{
						Ext.Msg.alert('Info','Insufficient Amount. Please Check the IBC FCY Amount')
					}
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					IbdIbcAddWindow.close();
				}
			}]
		});
