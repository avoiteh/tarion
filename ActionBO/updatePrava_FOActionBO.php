<?php
class updatePrava_FOActionBO{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbfront_right=new dbfront_right();
		//новые поля
		
		$dbfront_right->update($id, mysql_escape_string($_REQUEST['name']));
	}
}
?>