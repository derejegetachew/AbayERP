
		
<?php $cmsAssignment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Cms Case', true) . ":</th><td><b>" . $cmsAssignment['CmsCase']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Assigned By', true) . ":</th><td><b>" . $cmsAssignment['CmsAssignment']['assigned_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Assigned To', true) . ":</th><td><b>" . $cmsAssignment['CmsAssignment']['assigned_to'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $cmsAssignment['CmsAssignment']['created'] . "</b></td></tr>" . 
"</table>"; 
?>
		var cmsAssignment_view_panel_1 = {
			html : '<?php echo $cmsAssignment_html; ?>',
			frame : true,
			height: 80
		}
		var cmsAssignment_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CmsAssignmentViewWindow = new Ext.Window({
			title: '<?php __('View CmsAssignment'); ?>: <?php echo $cmsAssignment['CmsAssignment']['id']; ?>',
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
				cmsAssignment_view_panel_1,
				cmsAssignment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CmsAssignmentViewWindow.close();
				}
			}]
		});
