<?php
class updateUchashchiesyaAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbuchenik=new dbuchenik();
		//новые поля
		
		$dbuchenik->update($id, mysql_escape_string($_REQUEST['family']), mysql_escape_string($_REQUEST['name']), mysql_escape_string($_REQUEST['otch']), ($_REQUEST['gruppa']*1), ($_REQUEST['kurszach']*1), mysql_escape_string($_REQUEST['datarozhd']), mysql_escape_string($_REQUEST['mesto']), mysql_escape_string($_REQUEST['adres']), mysql_escape_string($_REQUEST['nation']), mysql_escape_string($_REQUEST['zachprikaz']), mysql_escape_string($_REQUEST['zachdata']), mysql_escape_string($_REQUEST['obrazovanie']), mysql_escape_string($_REQUEST['perevod2prikaz']), mysql_escape_string($_REQUEST['perevod2data']), mysql_escape_string($_REQUEST['perevod3prikaz']), mysql_escape_string($_REQUEST['perevod3data']), mysql_escape_string($_REQUEST['perevod4prikaz']), mysql_escape_string($_REQUEST['perevod4data']), mysql_escape_string($_REQUEST['perevod5prikaz']), mysql_escape_string($_REQUEST['perevod5data']), mysql_escape_string($_REQUEST['vypuskprikaz']), mysql_escape_string($_REQUEST['vypuskdata']), mysql_escape_string($_REQUEST['father']), mysql_escape_string($_REQUEST['mother']), mysql_escape_string($_REQUEST['parents']), ($_REQUEST['status']*1), mysql_escape_string($_REQUEST['phone']));
	}
}
?>