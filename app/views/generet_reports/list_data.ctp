{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($generet_reports as $generet_report){ if($st) echo ","; ?>			{
				"report":"<?php echo $generet_report['Report']['name']; ?>",
				"name":"<?php echo $generet_report['GeneretReport']['name']; ?>",
				"type_ofreport":"<?php echo $generet_report['GeneretReport']['type_ofreport']; ?>",
				"date":"<?php echo $generet_report['GeneretReport']['date']; ?>",
				"no":"<?php echo $generet_report['GeneretReport']['no']; ?>"			}
<?php $st = true; } ?>		]
}