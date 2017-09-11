<?php
class addBibliotechnye_kategoriiAction{
	function Go(){
		$dblibcat=new dblibcat();
if($_SESSION['Bibliotechnye_kategorii']['filter_check']['libcat']=='on'){
	$libcat=$_SESSION['Bibliotechnye_kategorii']['filter']['libcat'];
}else{
	$libcat='';
}
$dblibcat->add( $libcat);
	}
}
?>