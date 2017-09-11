<?php
class updateGrify_izdaniyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbgrif=new dbgrif();
		//новые поля
		
		$dbgrif->update($id, mysql_escape_string($_REQUEST['grif']));
	}
}
?>