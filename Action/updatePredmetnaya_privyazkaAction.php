<?php
class updatePredmetnaya_privyazkaAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbppl=new dbppl();
		//новые поля
		
		$dbppl->update($id, ($_REQUEST['biblio']*1), ($_REQUEST['predmet']*1));
	}
}
?>