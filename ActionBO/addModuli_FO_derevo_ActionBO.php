<?php
class addModuli_FO_derevo_ActionBO{
	function Go(){
		$dbfront_modules=new dbfront_modules();
if($_SESSION['Moduli_FO_derevo_']['filter_check']['module']=='on'){
	$module=$_SESSION['Moduli_FO_derevo_']['filter']['module'];
}else{
	$module='';
}
if($_SESSION['Moduli_FO_derevo_']['filter_check']['parent']=='on'){
	$parent=$_SESSION['Moduli_FO_derevo_']['filter']['parent'];
}else{
	$parent=0;
}
$parent=mysql_escape_string($parent);
if($_SESSION['Moduli_FO_derevo_']['filter_check']['title']=='on'){
	$title=$_SESSION['Moduli_FO_derevo_']['filter']['title'];
}else{
	$title='';
}
if($_SESSION['Moduli_FO_derevo_']['filter_check']['type']=='on'){
	$type=$_SESSION['Moduli_FO_derevo_']['filter']['type'];
}else{
	$type='';
}
$parent=$_REQUEST['parent'];
$dbfront_modules->add( $module,  $parent,  $title,  $type);
	}
}
?>