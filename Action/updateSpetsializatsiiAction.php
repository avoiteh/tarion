<?php
class updateSpetsializatsiiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbspecial=new dbspecial();
		//����� ����
		
		$dbspecial->update($id, mysql_escape_string($_REQUEST['special']), ($_REQUEST['topspec']*1));
	}
}
?>