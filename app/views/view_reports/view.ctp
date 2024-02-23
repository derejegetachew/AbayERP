
		
<?php $viewReport_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $viewReport['ViewReport']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Lname', true) . ":</th><td><b>" . $viewReport['ViewReport']['lname'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Sex', true) . ":</th><td><b>" . $viewReport['ViewReport']['sex'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Phone', true) . ":</th><td><b>" . $viewReport['ViewReport']['phone'] . "</b></td></tr>" . 
"</table>"; 
?>
		var viewReport_view_panel_1 = {
			html : '<?php echo $viewReport_html; ?>',
			frame : true,
			height: 80
		}
		var viewReport_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var ViewReportViewWindow = new Ext.Window({
			title: '<?php __('View ViewReport'); ?>: <?php echo $viewReport['ViewReport']['name']; ?>',
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
				viewReport_view_panel_1,
				viewReport_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ViewReportViewWindow.close();
				}
			}]
		});
