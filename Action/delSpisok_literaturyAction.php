<?php
class delSpisok_literaturyAction{
	function Go(){
		$dbbiblio=new dbbiblio();
		$dbbiblio->del($_REQUEST['id']*1);
	}
}
?>