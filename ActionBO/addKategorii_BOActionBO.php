<?php
class addKategorii_BOActionBO{
	function Go(){
		$dbcategory=new dbcategory();
if($_SESSION['Kategorii_BO']['filter_check']['parent']=='on'){
	$parent=$_SESSION['Kategorii_BO']['filter']['parent'];
}else{
	$parent=0;
}
$parent=mysql_escape_string($parent);
if($_SESSION['Kategorii_BO']['filter_check']['category']=='on'){
	$category=$_SESSION['Kategorii_BO']['filter']['category'];
}else{
	$category='';
}
$parent=$_REQUEST['parent'];
$dbcategory->add( $parent,  $category);
	}
}
?>