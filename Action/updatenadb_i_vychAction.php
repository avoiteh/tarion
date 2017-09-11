<?php
class updatenadb_i_vychAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbnadbvych=new dbnadbvych();
		//новые поля
		
		$dbnadbvych->update($id, mysql_escape_string($_REQUEST['naim']), mysql_escape_string($_REQUEST['formula']));
	}
}
?>