<?php
class addSpisok_komissiyAction{
	function Go(){
		$dbkomiss=new dbkomiss();
if($_SESSION['Spisok_komissiy']['filter_check']['komiss']=='on'){
	$komiss=$_SESSION['Spisok_komissiy']['filter']['komiss'];
}else{
	$komiss='';
}
if($_SESSION['Spisok_komissiy']['filter_check']['predsedat']=='on'){
	$predsedat=$_SESSION['Spisok_komissiy']['filter']['predsedat'];
}else{
	$predsedat=0;
}
if($_SESSION['Spisok_komissiy']['filter_check']['status']=='on'){
	$status=$_SESSION['Spisok_komissiy']['filter']['status'];
}else{
	$status=0;
}
$dbkomiss->add( $komiss,  $predsedat,  $status);
	}
}
?>