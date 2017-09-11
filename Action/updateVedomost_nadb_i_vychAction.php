<?php
class updateVedomost_nadb_i_vychAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbvednadbvych=new dbvednadbvych();
		//новые поля
		
		$dbvednadbvych->update($id, ($_REQUEST['prepod']*1), ($_REQUEST['tip']*1), mysql_escape_string($_REQUEST['god']));
	}
}
?>