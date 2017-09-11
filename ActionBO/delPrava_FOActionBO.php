<?php
class delPrava_FOActionBO{
	function Go(){
		$dbfront_right=new dbfront_right();
		$dbfront_right->del($_REQUEST['id']*1);
	}
}
?>