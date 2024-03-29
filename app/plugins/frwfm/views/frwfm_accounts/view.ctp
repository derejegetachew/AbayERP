
		
<?php $frwfmAccount_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Frwfm Application', true) . ":</th><td><b>" . $frwfmAccount['FrwfmApplication']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Acc No', true) . ":</th><td><b>" . $frwfmAccount['FrwfmAccount']['acc_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $frwfmAccount['FrwfmAccount']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $frwfmAccount['FrwfmAccount']['branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount', true) . ":</th><td><b>" . $frwfmAccount['FrwfmAccount']['amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency', true) . ":</th><td><b>" . $frwfmAccount['FrwfmAccount']['currency'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $frwfmAccount['FrwfmAccount']['type'] . "</b></td></tr>" . 
"</table>"; 
?>
		var frwfmAccount_view_panel_1 = {
			html : '<?php echo $frwfmAccount_html; ?>',
			frame : true,
			height: 80
		}
		var frwfmAccount_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var FrwfmAccountViewWindow = new Ext.Window({
			title: '<?php __('View FrwfmAccount'); ?>: <?php echo $frwfmAccount['FrwfmAccount']['name']; ?>',
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
				frwfmAccount_view_panel_1,
				frwfmAccount_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FrwfmAccountViewWindow.close();
				}
			}]
		});
