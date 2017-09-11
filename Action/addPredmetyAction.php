<?php
class addPredmetyAction{
	function Go(){
		$dbpredmet=new dbpredmet();
if($_SESSION['Predmety']['filter_check']['blok']=='on'){
	$blok=$_SESSION['Predmety']['filter']['blok'];
}else{
	$blok=0;
}
if($_SESSION['Predmety']['filter_check']['predmet']=='on'){
	$predmet=$_SESSION['Predmety']['filter']['predmet'];
}else{
	$predmet='';
}
$dbpredmet->add( $blok,  $predmet);
	}
}
?>