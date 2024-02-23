
var store_job_applications = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','job','letter','date'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'applications', 'action' => 'list_data', $job['Job']['id'])); ?>'	})
});
		
<?php $job_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $job['Job']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Start Date', true) . ":</th><td><b>" . $job['Job']['start_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Expire Date', true) . ":</th><td><b>" . $job['Job']['end_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Grade', true) . ":</th><td><b>" . $job['Job']['grade'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Location', true) . ":</th><td><b>" . $job['Job']['location'] . "</b></td></tr>" . 
       		"<tr><th align=right>" . __('Requirements', true) . ":</th><td><b>" . $job['Job']['description'] . "</b></td></tr>" . 
"</table>"; 
?>
		var job_view_panel_1 = {
			html : '<?php echo $job_html; ?>',
			frame : true,
			height: 500
		}
		var job_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true}
		});

		var JobViewWindow = new Ext.Window({
			title: '<?php __('View Vacancy'); ?>: <?php echo $job['Job']['name']; ?>',
			width: 700,
			height:545,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				job_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					JobViewWindow.close();
				}
			}]
		});