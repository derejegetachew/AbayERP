
		
<?php $imsReturnItem_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ims Return', true) . ":</th><td><b>" . $imsReturnItem['ImsReturn']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Ims Sirv Item', true) . ":</th><td><b>" . $imsReturnItem['ImsSirvItem']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Quantity', true) . ":</th><td><b>" . $imsReturnItem['ImsReturnItem']['quantity'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $imsReturnItem['ImsReturnItem']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $imsReturnItem['ImsReturnItem']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $imsReturnItem['ImsReturnItem']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var imsReturnItem_view_panel_1 = {
			html : '<?php echo $imsReturnItem_html; ?>',
			frame : true,
			height: 80
		}
		var imsReturnItem_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ImsReturnItemViewWindow = new Ext.Window({
			title: '<?php __('View ImsReturnItem'); ?>: <?php echo $imsReturnItem['ImsReturnItem']['id']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				imsReturnItem_view_panel_1,
				imsReturnItem_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ImsReturnItemViewWindow.close();
				}
			}]
		});
