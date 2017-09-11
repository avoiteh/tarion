<?php
class updateSoderzhanie_rabotyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbprotokol_cont=new dbprotokol_cont();
		//новые поля
		
		$dbprotokol_cont->update($id, ($_REQUEST['preprab']*1), ($_REQUEST['protokol']*1));
	}
}
?>