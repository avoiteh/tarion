<?php
class updateTovaryAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbproduct=new dbproduct();
		//новые поля
		if(isset($_FILES['photo']) && $_FILES['photo']['tmp_name']!=''){
			$path=photoPath($id).'/photo';
			copy($_FILES['photo']['tmp_name'], $path);
		}
		$dbproduct->update($id, ($_REQUEST['category']*1), mysql_escape_string($_REQUEST['name']), mysql_escape_string($_REQUEST['desc']), $id);
	}
}
?>