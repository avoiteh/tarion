<?php
class updateTipy_izdaniyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbbook_type=new dbbook_type();
		//новые поля
		
		$dbbook_type->update($id, mysql_escape_string($_REQUEST['booktype']));
	}
}
?>