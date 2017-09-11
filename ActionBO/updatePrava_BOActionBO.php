<?php
class updatePrava_BOActionBO{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbright=new dbright();
		//новые поля
		
		$dbright->update($id, mysql_escape_string($_REQUEST['name']));
	}
}
?>