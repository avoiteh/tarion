<?php
class updateSpisok_komissiyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbkomiss=new dbkomiss();
		//новые поля
		
		$dbkomiss->update($id, mysql_escape_string($_REQUEST['komiss']), ($_REQUEST['predsedat']*1), ($_REQUEST['status']*1));
	}
}
?>