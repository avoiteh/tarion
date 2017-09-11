<?php
class updatePolzovateli_BOActionBO{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbuser=new dbuser();
		//новые поля
		
		$dbuser->update($id, mysql_escape_string($_REQUEST['login']), mysql_escape_string($_REQUEST['password']), mysql_escape_string($_REQUEST['email']), ($_REQUEST['right']*1));
	}
}
?>