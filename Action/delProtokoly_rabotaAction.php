<?php
class delProtokoly_rabotaAction{
	function Go(){
		$dbprotokols=new dbprotokols();
		$dbprotokols->del($_REQUEST['id']*1);
	}
}
?>