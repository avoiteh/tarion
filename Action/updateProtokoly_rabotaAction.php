<?php
class updateProtokoly_rabotaAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbprotokols=new dbprotokols();
		//новые поля
		
		$dbprotokols->update($id, ($_REQUEST['komis']*1), mysql_escape_string($_REQUEST['datakomis']), mysql_escape_string($_REQUEST['nomer']), ($_REQUEST['status']*1));
	}
}
?>