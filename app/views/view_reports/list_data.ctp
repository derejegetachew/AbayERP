{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($view_reports as $view_report){ if($st) echo ","; ?>			{
				"id":"<?php echo $view_report['ViewReport']['id']; ?>",
				"name":"<?php echo $view_report['ViewReport']['name']; ?>",
				"lname":"<?php echo $view_report['ViewReport']['lname']; ?>",
				"sex":"<?php echo $view_report['ViewReport']['sex']; ?>",
				"phone":"<?php echo $view_report['ViewReport']['phone']; ?>"			}
<?php $st = true; } ?>		]
}