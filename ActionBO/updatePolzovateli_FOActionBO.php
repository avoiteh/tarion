<?php
class updatePolzovateli_FOActionBO{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbfront_user=new dbfront_user();
		//новые поля
		
		$dbfront_user->update($id, mysql_escape_string($_REQUEST['email']), mysql_escape_string($_REQUEST['password']), ($_REQUEST['right']*1));
	}
}
?>