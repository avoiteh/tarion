<?php
class delNastroyka_FOActionBO{
	function Go(){
		$dbfront_cross_right=new dbfront_cross_right();
		$dbfront_cross_right->del($_REQUEST['id']*1);
	}
}
?>