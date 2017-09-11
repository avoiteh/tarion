<?php
class delPrava_BOActionBO{
	function Go(){
		$dbright=new dbright();
		$dbright->del($_REQUEST['id']*1);
	}
}
?>