<?php
class delSoderzhanie_rabotyAction{
	function Go(){
		$dbprotokol_cont=new dbprotokol_cont();
		$dbprotokol_cont->del($_REQUEST['id']*1);
	}
}
?>