<?php
class delSpetsialnostiAction{
	function Go(){
		$dbtop_spec=new dbtop_spec();
		$dbtop_spec->del($_REQUEST['id']*1);
	}
}
?>