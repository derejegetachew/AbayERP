<?php //print_r($people);?>
{
	success:true,
	rows: [
<?php $st = false; foreach($people as $person){if(!empty($person['User']) && !empty($person['User']['Person']) && !empty($person['EmployeeDetail'][0]) && !empty($person['EmployeeDetail'][0]['Position'])){ if($st) echo ","; $pre = ""; $post = ''; ?>	
        {
            "id":"<?php echo $person['Employee']['id']; ?>",
            "full_name":"<?php echo $pre . $person['User']['Person']['first_name'].' '.$person['User']['Person']['middle_name'].' '.$person['User']['Person']['last_name'] . $post; ?>",			
            "position":"<?Php echo $person['EmployeeDetail'][0]['Position']['name']; ?>",
            "user_id":"<?Php echo $person['Employee']['user_id']; ?>"
        }
<?php $st = true; } } ?>		
        ]
}