<?php
class delNastroyka_BOActionBO{
	function Go(){
		$dbcross_right=new dbcross_right();
		$dbcross_right->del($_REQUEST['id']*1);
	}
}
?>