<?php
class addTovary_BOActionBO{
	function Go(){
		$dbproduct=new dbproduct();
if($_SESSION['Tovary_BO']['filter_check']['category']=='on'){
	$category=$_SESSION['Tovary_BO']['filter']['category'];
}else{
	$category=0;
}
if($_SESSION['Tovary_BO']['filter_check']['name']=='on'){
	$name=$_SESSION['Tovary_BO']['filter']['name'];
}else{
	$name='';
}
if($_SESSION['Tovary_BO']['filter_check']['desc']=='on'){
	$desc=$_SESSION['Tovary_BO']['filter']['desc'];
}else{
	$desc='';
}
if($_SESSION['Tovary_BO']['filter_check']['photo']=='on'){
	$photo=$_SESSION['Tovary_BO']['filter']['photo'];
}else{
	$photo=0;
}
$dbproduct->add( $category,  $name,  $desc,  $photo);
	}
}
?>