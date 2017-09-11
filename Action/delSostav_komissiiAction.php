<?php
class delSostav_komissiiAction{
	function Go(){
		$dbsostav_komis=new dbsostav_komis();
		$dbsostav_komis->del($_REQUEST['id']*1);
	}
}
?>