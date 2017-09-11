<?php
class delSpetsializatsiiAction{
	function Go(){
		$dbspecial=new dbspecial();
		$dbspecial->del($_REQUEST['id']*1);
	}
}
?>