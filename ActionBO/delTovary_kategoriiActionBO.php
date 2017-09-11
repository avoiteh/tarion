<?php
class delTovary_kategoriiActionBO{
	function Go(){
		$dbproduct=new dbproduct();
		$dbproduct->del($_REQUEST['id']*1);
	}
}
?>