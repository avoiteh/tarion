<?php
class delPolzovateli_BOActionBO{
	function Go(){
		$dbuser=new dbuser();
		$dbuser->del($_REQUEST['id']*1);
	}
}
?>