<?php
class addSotrudnikiAction{
	function Go(){
		$dbfront_user=new dbfront_user();
if($_SESSION['Sotrudniki']['filter_check']['email']=='on'){
	$email=$_SESSION['Sotrudniki']['filter']['email'];
}else{
	$email='';
}
if($_SESSION['Sotrudniki']['filter_check']['password']=='on'){
	$password=$_SESSION['Sotrudniki']['filter']['password'];
}else{
	$password='';
}
if($_SESSION['Sotrudniki']['filter_check']['right']=='on'){
	$right=$_SESSION['Sotrudniki']['filter']['right'];
}else{
	$right=0;
}
if($_SESSION['Sotrudniki']['filter_check']['login']=='on'){
	$login=$_SESSION['Sotrudniki']['filter']['login'];
}else{
	$login='';
}
if($_SESSION['Sotrudniki']['filter_check']['family']=='on'){
	$family=$_SESSION['Sotrudniki']['filter']['family'];
}else{
	$family='';
}
if($_SESSION['Sotrudniki']['filter_check']['name']=='on'){
	$name=$_SESSION['Sotrudniki']['filter']['name'];
}else{
	$name='';
}
if($_SESSION['Sotrudniki']['filter_check']['otch']=='on'){
	$otch=$_SESSION['Sotrudniki']['filter']['otch'];
}else{
	$otch='';
}
if($_SESSION['Sotrudniki']['filter_check']['dataworkstart']=='on'){
	$dataworkstart=$_SESSION['Sotrudniki']['filter']['dataworkstart'];
}else{
	$dataworkstart=0;
}
if($_SESSION['Sotrudniki']['filter_check']['razryd']=='on'){
	$razryd=$_SESSION['Sotrudniki']['filter']['razryd'];
}else{
	$razryd=0;
}
if($_SESSION['Sotrudniki']['filter_check']['category']=='on'){
	$category=$_SESSION['Sotrudniki']['filter']['category'];
}else{
	$category=0;
}
if($_SESSION['Sotrudniki']['filter_check']['kabinet']=='on'){
	$kabinet=$_SESSION['Sotrudniki']['filter']['kabinet'];
}else{
	$kabinet=0;
}
$dbfront_user->add( $email,  $password,  $right,  $login,  $family,  $name,  $otch,  $dataworkstart,  $razryd,  $category,  $kabinet);
	}
}
?>