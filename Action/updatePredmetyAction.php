<?php
class updatePredmetyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbpredmet=new dbpredmet();
		//новые поля
		
		$dbpredmet->update($id, ($_REQUEST['blok']*1), mysql_escape_string($_REQUEST['predmet']));
	}
}
?>