<?php
class delKategorii_BOActionBO{
	function Go(){
		$dbcategory=new dbcategory();
		$dbcategory->del($_REQUEST['id']*1);
	}
}
?>