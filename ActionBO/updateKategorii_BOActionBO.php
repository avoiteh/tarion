<?php
class updateKategorii_BOActionBO{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbcategory=new dbcategory();
		//новые поля
		
		$dbcategory->update($id, null, mysql_escape_string($_REQUEST['category']));
	}
}
?>