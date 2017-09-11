<?php
class updateSostav_komissiiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbsostav_komis=new dbsostav_komis();
		//новые поля
		
		$dbsostav_komis->update($id, ($_REQUEST['komis']*1), ($_REQUEST['prepod']*1), ($_REQUEST['status']*1));
	}
}
?>