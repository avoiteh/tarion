<?php
class delBlokiAction{
	function Go(){
		$dbblok=new dbblok();
		$dbblok->del($_REQUEST['id']*1);
	}
}
?>