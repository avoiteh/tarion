<?php
class updateBibliotechnye_kategoriiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dblibcat=new dblibcat();
		//новые поля
		
		$dblibcat->update($id, mysql_escape_string($_REQUEST['libcat']));
	}
}
?>