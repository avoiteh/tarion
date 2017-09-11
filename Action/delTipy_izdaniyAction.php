<?php
class delTipy_izdaniyAction{
	function Go(){
		$dbbook_type=new dbbook_type();
		$dbbook_type->del($_REQUEST['id']*1);
	}
}
?>