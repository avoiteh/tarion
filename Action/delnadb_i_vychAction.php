<?php
class delnadb_i_vychAction{
	function Go(){
		$dbnadbvych=new dbnadbvych();
		$dbnadbvych->del($_REQUEST['id']*1);
	}
}
?>