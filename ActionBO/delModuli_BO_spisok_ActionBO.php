<?php
class delModuli_BO_spisok_ActionBO{
	function Go(){
		$dbmodules=new dbmodules();
		$dbmodules->del($_REQUEST['id']*1);
	}
}
?>