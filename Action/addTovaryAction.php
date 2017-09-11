<?php
class addTovaryAction{
	function Go(){
		$dbproduct=new dbproduct();
if($_SESSION['Tovary']['filter_check']['category']=='on'){
	$category=$_SESSION['Tovary']['filter']['category'];
}else{
	$category=0;
}
if($_SESSION['Tovary']['filter_check']['name']=='on'){
	$name=$_SESSION['Tovary']['filter']['name'];
}else{
	$name='';
}
if($_SESSION['Tovary']['filter_check']['desc']=='on'){
	$desc=$_SESSION['Tovary']['filter']['desc'];
}else{
	$desc='';
}
if($_SESSION['Tovary']['filter_check']['photo']=='on'){
	$photo=$_SESSION['Tovary']['filter']['photo'];
}else{
	$photo=0;
}
$dbproduct->add( $category,  $name,  $desc,  $photo);
	}
}
?>