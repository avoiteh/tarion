<?php
class updateSpisok_literaturyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbbiblio=new dbbiblio();
		//новые поля
		
		$dbbiblio->update($id, ($_REQUEST['booktype']*1), mysql_escape_string($_REQUEST['author']), mysql_escape_string($_REQUEST['title']), mysql_escape_string($_REQUEST['dataizd']), mysql_escape_string($_REQUEST['izdatel']), ($_REQUEST['grif']*1), ($_REQUEST['kolvo']*1), ($_REQUEST['libcat']*1));
	}
}
?>