<?php
class updateKabinetyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbkabinet=new dbkabinet();
		//����� ����
		
		$dbkabinet->update($id, mysql_escape_string($_REQUEST['kabinet']));
	}
}
?>