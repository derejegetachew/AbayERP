

var str = "<?php echo $e_id.'-'.$budget_year_id.'-'.$quarter ; ?>";


function change_status_hr(id){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'change_status_bh_hr')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			
			ChangeStatusWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}		
function agree_behavioural(id){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'agree_behavioural')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			
			ChangeStatusWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function excel_report(id){
	//location.href = "http://10.1.10.86/AbayERP/competenceCategories/ho_ind_behavioural_report_excel/"+id;
	window.open("http://10.1.10.87/AbayERP/competenceCategories/ho_ind_behavioural_report_excel/"+id , '_blank');
}

if(center_panel.find('id', 'indBehaviouralReport-tab') != "") {
	var p = center_panel.findById('indBehaviouralReport-tab');
	center_panel.setActiveTab(p);
} else{ 
	var p = center_panel.add({
	title: 'Employee behavioural report',
	id: 'indBehaviouralReport-tab',
	closable: true,
	tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Change status'); ?>',
					disabled: false,
					tooltip:'<?php __('<b>change status</b><br />click here to agree to plan and result'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					//	open_plan_history();
					
					//change_status(str);
					change_status_hr(str);
						
						}
					},
					{
					xtype: 'tbbutton',
					text: '<?php __('Excel Report'); ?>',
					disabled: false,
					tooltip:'<?php __('<b>Excel report</b><br />click here to download excel'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					//	open_plan_history();
					
					//change_status(str);
					
						excel_report(str);
					
			
						}
					},
					
					]
				}),
				html: '<div style = "height: 450px; overflow-y: auto" ><table style = "border-collapse:collapse;  width:100%; border: 1px solid grey; margin: 10px; font-size: 12px;">'+
				'<tr><td style = "border: 1px solid grey" colspan = "1">	EMPLOYEE NAME:</td><td colspan = "7" style = "border: 1px solid grey"><?php echo $full_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	ID NO:</td><td colspan = "7" style = "border: 1px solid grey"><?php echo $emp_id; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	POSITION:</td><td colspan = "7" style = "border: 1px solid grey"><?php echo $position_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	DEPARTMENT / DISTRICT:</td><td colspan = "7" style = "border: 1px solid grey"><?php echo $dept_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	APPRAISAL PERIOD:</td><td colspan = "7" style = "border: 1px solid grey"><?php echo $appraisal_period; ?></td></tr>'+
					  '<tr style = "background: #3498db; color: #fff; height: 40px;"><td style = "border: 1px solid grey; padding: 10px;">Competency</td><td style = "border: 1px solid grey; padding: 10px;">Competency Definition</td><td style = "border: 1px solid grey; padding: 10px; ">Expected Proficiency Level</td><td style = "border: 1px solid grey; padding: 10px;">Weight</td>'+
					  '<td style = "border: 1px solid grey; padding: 10px;">Actual Proficiency</td><td style = "border: 1px solid grey; padding: 10px;">Score</td><td style = "border: 1px solid grey; padding: 10px;">Rating</td><td style = "border: 1px solid grey; padding: 10px;">Remark</td></tr>'+
                      <?php 
					 for($i = 0; $i < count($behavioural_table); $i++){
						?>
                    '<tr>'+
						'<td style = "border: 1px solid grey"><?php echo $behavioural_table[$i]['competency']; ?></td><td style = "border: 1px solid grey"><?php echo $behavioural_table[$i]['competency_definition']; ?></td>'+
						'<td style = "border: 1px solid grey">'+
                        '<?php 
                        if($behavioural_table[$i]['expected_proficiency_level'] == 1)
                        {echo "beginner"; } 
                        if($behavioural_table[$i]['expected_proficiency_level'] == 2)
                        {echo "intermediate"; }
                        if($behavioural_table[$i]['expected_proficiency_level'] == 3)
                        {echo "advanced"; }
                        if($behavioural_table[$i]['expected_proficiency_level'] == 4)
                        {echo "expert"; }
                        
                        ?>'+
                    '</td>'+
                        '<td style = "border: 1px solid grey"><?php echo $behavioural_table[$i]['weight']; ?></td>'+
						'<td style = "border: 1px solid grey">'+
                        '<?php 
                        if($behavioural_table[$i]['actual_proficiency'] == 1)
                        {echo "beginner"; } 
                        if($behavioural_table[$i]['actual_proficiency'] == 2)
                        {echo "intermediate"; }
                        if($behavioural_table[$i]['actual_proficiency'] == 3)
                        {echo "advanced"; }
                        if($behavioural_table[$i]['actual_proficiency'] == 4)
                        {echo "expert"; }
                        ?>'+
                        '</td>'+
                        '<td style = "border: 1px solid grey"><?php echo $behavioural_table[$i]['score']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $behavioural_table[$i]['rating']; ?></td><td style = "border: 1px solid grey"></td>'+
						
					 '</tr>'+
					
						<?php
						
					 } 
					  ?>
					'<tr>'+
					'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
					'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey">10%</td>'+
					'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
					'<td style = "border: 1px solid grey"><?php echo $total_rating; ?></td><td style = "border: 1px solid grey"></td>'+
				    '</tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">IMMEDIATE SUPERVISOR NAME</td><td colspan = "6" style = "border: 1px solid grey"><?php echo $immediate_supervisor_name;?></td></tr>'+
					'</table></div>'

});
center_panel.setActiveTab(p);
}