<?php
class delKategoriiAction{
	function Go(){
		$dbcategory=new dbcategory();
		$dbcategory->del($_REQUEST['id']*1);
	}
}
?>