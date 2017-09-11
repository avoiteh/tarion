<?php
class addTipy_izdaniyAction{
	function Go(){
		$dbbook_type=new dbbook_type();
if($_SESSION['Tipy_izdaniy']['filter_check']['booktype']=='on'){
	$booktype=$_SESSION['Tipy_izdaniy']['filter']['booktype'];
}else{
	$booktype='';
}
$dbbook_type->add( $booktype);
	}
}
?>