<?php
class delRaspisanie_punktyAction{
	function Go(){
		$dbraspisanie=new dbraspisanie();
		$dbraspisanie->del($_REQUEST['id']*1);
	}
}
?>