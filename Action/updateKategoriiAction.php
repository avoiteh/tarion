<?php
class updateKategoriiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbcategory=new dbcategory();
		//����� ����
		
		$dbcategory->update($id, ($_REQUEST['parent']*1), mysql_escape_string($_REQUEST['category']));
	}
}
?>