{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; $tagresult; foreach($ims_Sirv_Items as $ims_Sirv_Item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_Sirv_Item['ImsSirvItem']['id']; ?>",
				"code":"<?php echo $ims_Sirv_Item['ImsItem']['description']; ?>",
				"description":"<?php echo $ims_Sirv_Item['ImsItem']['name']; ?>",
				"measurement":"<?php echo $ims_Sirv_Item['ImsSirvItem']['measurement']; ?>",
				"quantity":"<?php echo $ims_Sirv_Item['ImsSirvItem']['quantity']; ?>",
				"unit_price":"<?php echo $ims_Sirv_Item['ImsSirvItem']['unit_price']; ?>",
				"remark":"<?php echo $ims_Sirv_Item['ImsSirvItem']['remark']; ?>",
				"tag":"<?php $tagresult = null; foreach($ims_Sirv_Item['ImsTag'] as $tag){
					if($tagresult == null){
						$tagresult = $tag['code'];
					}
					else $tagresult = $tagresult.', '.$tag['code'];
				}			
				echo $tagresult;
				?>"			}
<?php $st = true; } ?>		]
}