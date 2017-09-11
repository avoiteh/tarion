<?php
class addBlokiAction{
	function Go(){
		$dbblok=new dbblok();
if($_SESSION['Bloki']['filter_check']['blok']=='on'){
	$blok=$_SESSION['Bloki']['filter']['blok'];
}else{
	$blok='';
}
if($_SESSION['Bloki']['filter_check']['sortindex']=='on'){
	$sortindex=$_SESSION['Bloki']['filter']['sortindex'];
}else{
	$sortindex=0;
}
$dbblok->add( $blok,  $sortindex);
	}
}
?>