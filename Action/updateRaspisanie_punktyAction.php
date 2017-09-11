<?php
class updateRaspisanie_punktyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbraspisanie=new dbraspisanie();
		//новые поля
		
		$dbraspisanie->update($id, mysql_escape_string($_REQUEST['week']), ($_REQUEST['predmet']*1), ($_REQUEST['gruppa']*1), ($_REQUEST['prepod']*1), ($_REQUEST['den']*1), ($_REQUEST['para']*1), ($_REQUEST['kabinet']*1));
	}
}
?>