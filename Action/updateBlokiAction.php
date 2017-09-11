<?php
class updateBlokiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbblok=new dbblok();
		//новые поля
		
		$dbblok->update($id, mysql_escape_string($_REQUEST['blok']), ($_REQUEST['sortindex']*1));
	}
}
?>