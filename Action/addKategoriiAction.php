<?php
class addKategoriiAction{
	function Go(){
		$dbcategory=new dbcategory();
if($_SESSION['Kategorii']['filter_check']['parent']=='on'){
	$parent=$_SESSION['Kategorii']['filter']['parent'];
}else{
	$parent=0;
}
$parent=mysql_escape_string($parent);
if($_SESSION['Kategorii']['filter_check']['category']=='on'){
	$category=$_SESSION['Kategorii']['filter']['category'];
}else{
	$category='';
}
$parent=$_REQUEST['parent'];
$dbcategory->add( $parent,  $category);
	}
}
?>