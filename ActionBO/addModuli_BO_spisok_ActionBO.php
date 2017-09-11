<?php
class addModuli_BO_spisok_ActionBO{
	function Go(){
		$dbmodules=new dbmodules();
if($_SESSION['Moduli_BO_spisok_']['filter_check']['module']=='on'){
	$module=$_SESSION['Moduli_BO_spisok_']['filter']['module'];
}else{
	$module='';
}
if($_SESSION['Moduli_BO_spisok_']['filter_check']['parent']=='on'){
	$parent=$_SESSION['Moduli_BO_spisok_']['filter']['parent'];
}else{
	$parent=0;
}
$parent=mysql_escape_string($parent);
if($_SESSION['Moduli_BO_spisok_']['filter_check']['title']=='on'){
	$title=$_SESSION['Moduli_BO_spisok_']['filter']['title'];
}else{
	$title='';
}
if($_SESSION['Moduli_BO_spisok_']['filter_check']['type']=='on'){
	$type=$_SESSION['Moduli_BO_spisok_']['filter']['type'];
}else{
	$type='';
}
$parent=$_REQUEST['parent'];
$dbmodules->add( $module,  $parent,  $title,  $type);
	}
}
?>