<?php
class delSpisok_komissiyAction{
	function Go(){
		$dbkomiss=new dbkomiss();
		$dbkomiss->del($_REQUEST['id']*1);
	}
}
?>