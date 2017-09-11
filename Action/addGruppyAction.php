<?php
class addGruppyAction{
	function Go(){
		$dbgruppa=new dbgruppa();
if($_SESSION['Gruppy']['filter_check']['gruppa']=='on'){
	$gruppa=$_SESSION['Gruppy']['filter']['gruppa'];
}else{
	$gruppa='';
}
if($_SESSION['Gruppy']['filter_check']['special']=='on'){
	$special=$_SESSION['Gruppy']['filter']['special'];
}else{
	$special=0;
}
if($_SESSION['Gruppy']['filter_check']['kurs']=='on'){
	$kurs=$_SESSION['Gruppy']['filter']['kurs'];
}else{
	$kurs=0;
}
if($_SESSION['Gruppy']['filter_check']['sozdan']=='on'){
	$sozdan=$_SESSION['Gruppy']['filter']['sozdan'];
}else{
	$sozdan=0;
}
if($_SESSION['Gruppy']['filter_check']['status']=='on'){
	$status=$_SESSION['Gruppy']['filter']['status'];
}else{
	$status=0;
}
$dbgruppa->add( $gruppa,  $special,  $kurs,  $sozdan,  $status);
	}
}
?>