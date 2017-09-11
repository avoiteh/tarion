<?php
class addSostav_komissiiAction{
	function Go(){
		$dbsostav_komis=new dbsostav_komis();
if($_SESSION['Sostav_komissii']['filter_check']['komis']=='on'){
	$komis=$_SESSION['Sostav_komissii']['filter']['komis'];
}else{
	$komis=0;
}
if($_SESSION['Sostav_komissii']['filter_check']['prepod']=='on'){
	$prepod=$_SESSION['Sostav_komissii']['filter']['prepod'];
}else{
	$prepod=0;
}
if($_SESSION['Sostav_komissii']['filter_check']['status']=='on'){
	$status=$_SESSION['Sostav_komissii']['filter']['status'];
}else{
	$status=0;
}
$dbsostav_komis->add( $komis,  $prepod,  $status);
	}
}
?>