<?php
class updateRazd_prep_planaAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbppr=new dbppr();
		//����� ����
		
		$dbppr->update($id, mysql_escape_string($_REQUEST['razdel']));
	}
}
?>