<?php
class delVedomost_nadb_i_vychAction{
	function Go(){
		$dbvednadbvych=new dbvednadbvych();
		$dbvednadbvych->del($_REQUEST['id']*1);
	}
}
?>