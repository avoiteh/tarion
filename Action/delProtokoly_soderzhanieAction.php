<?php
class delProtokoly_soderzhanieAction{
	function Go(){
		$dbprotokols=new dbprotokols();
		$dbprotokols->del($_REQUEST['id']*1);
	}
}
?>