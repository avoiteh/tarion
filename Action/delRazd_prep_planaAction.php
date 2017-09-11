<?php
class delRazd_prep_planaAction{
	function Go(){
		$dbppr=new dbppr();
		$dbppr->del($_REQUEST['id']*1);
	}
}
?>