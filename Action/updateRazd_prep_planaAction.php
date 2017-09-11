<?php
class updateRazd_prep_planaAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbppr=new dbppr();
		//новые поля
		
		$dbppr->update($id, mysql_escape_string($_REQUEST['razdel']));
	}
}
?>