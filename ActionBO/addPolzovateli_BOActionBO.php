<?php
class addPolzovateli_BOActionBO{
	function Go(){
		$dbuser=new dbuser();
if($_SESSION['Polzovateli_BO']['filter_check']['login']=='on'){
	$login=$_SESSION['Polzovateli_BO']['filter']['login'];
}else{
	$login='';
}
if($_SESSION['Polzovateli_BO']['filter_check']['password']=='on'){
	$password=$_SESSION['Polzovateli_BO']['filter']['password'];
}else{
	$password='';
}
if($_SESSION['Polzovateli_BO']['filter_check']['email']=='on'){
	$email=$_SESSION['Polzovateli_BO']['filter']['email'];
}else{
	$email='';
}
if($_SESSION['Polzovateli_BO']['filter_check']['right']=='on'){
	$right=$_SESSION['Polzovateli_BO']['filter']['right'];
}else{
	$right=0;
}
$dbuser->add( $login,  $password,  $email,  $right);
	}
}
?>