<?php
class delGrify_izdaniyAction{
	function Go(){
		$dbgrif=new dbgrif();
		$dbgrif->del($_REQUEST['id']*1);
	}
}
?>