<?php
class updatePednagruzkaAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbped_nagr=new dbped_nagr();
		//новые поля
		
		$dbped_nagr->update($id, mysql_escape_string($_REQUEST['god']), ($_REQUEST['prepod']*1), ($_REQUEST['predmet']*1), ($_REQUEST['gruppa']*1), ($_REQUEST['theory']*1), ($_REQUEST['praktik']*1), ($_REQUEST['kurs']*1), ($_REQUEST['kurstest']*1), ($_REQUEST['examine']*1), ($_REQUEST['allhour']*1), ($_REQUEST['sem1chas']*1), ($_REQUEST['sem1ned']*1), ($_REQUEST['sem2chas']*1), ($_REQUEST['sem2ned']*1), ($_REQUEST['sem1vych']*1), ($_REQUEST['sem2vych']*1), ($_REQUEST['prikaz']*1), mysql_escape_string($_REQUEST['remark']));
	}
}
?>