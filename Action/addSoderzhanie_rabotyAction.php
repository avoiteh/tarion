<?php
class addSoderzhanie_rabotyAction{
	function Go(){
		$dbprotokol_cont=new dbprotokol_cont();
if($_SESSION['Soderzhanie_raboty']['filter_check']['preprab']=='on'){
	$preprab=$_SESSION['Soderzhanie_raboty']['filter']['preprab'];
}else{
	$preprab=0;
}
if($_SESSION['Soderzhanie_raboty']['filter_check']['protokol']=='on'){
	$protokol=$_SESSION['Soderzhanie_raboty']['filter']['protokol'];
}else{
	$protokol=0;
}
$dbprotokol_cont->add( $preprab,  $protokol);
	}
}
?>