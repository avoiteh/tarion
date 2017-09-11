<?php
class updatePlan_prep__soderzhanieAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbprepod_cont=new dbprepod_cont();
		//новые поля
		
		$dbprepod_cont->update($id, ($_REQUEST['plann']*1), ($_REQUEST['tip']*1), mysql_escape_string($_REQUEST['opis']), mysql_escape_string($_REQUEST['srok']));
	}
}
?>