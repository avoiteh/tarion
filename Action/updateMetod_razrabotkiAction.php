<?php
class updateMetod_razrabotkiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbreg_book=new dbreg_book();
		//новые поля
		
		$dbreg_book->update($id, mysql_escape_string($_REQUEST['datareg']), mysql_escape_string($_REQUEST['nomer']), mysql_escape_string($_REQUEST['naim']), ($_REQUEST['prepod']*1), ($_REQUEST['komprot']*1), ($_REQUEST['komis']*1), ($_REQUEST['status']*1));
	}
}
?>