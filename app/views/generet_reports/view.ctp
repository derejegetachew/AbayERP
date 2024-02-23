
		
<?php $generetReport_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Report', true) . ":</th><td><b>" . $generetReport['Report']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $generetReport['GeneretReport']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type Ofreport', true) . ":</th><td><b>" . $generetReport['GeneretReport']['type_ofreport'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $generetReport['GeneretReport']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('No', true) . ":</th><td><b>" . $generetReport['GeneretReport']['no'] . "</b></td></tr>" . 
"</table>"; 
?>
		var generetReport_view_panel_1 = {
			html : '<?php echo $generetReport_html; ?>',
			frame : true,
			height: 80
		}
		var generetReport_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var GeneretReportViewWindow = new Ext.Window({
			title: '<?php __('View GeneretReport'); ?>: <?php echo $generetReport['GeneretReport']['name']; ?>',
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
				generetReport_view_panel_1,
				generetReport_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					GeneretReportViewWindow.close();
				}
			}]
		});
