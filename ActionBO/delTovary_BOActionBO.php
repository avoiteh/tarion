<?php
class delTovary_BOActionBO{
	function Go(){
		$dbproduct=new dbproduct();
		$dbproduct->del($_REQUEST['id']*1);
	}
}
?>