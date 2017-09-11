<?php
class addPredmetnaya_privyazkaAction{
	function Go(){
		$dbppl=new dbppl();
if($_SESSION['Predmetnaya_privyazka']['filter_check']['biblio']=='on'){
	$biblio=$_SESSION['Predmetnaya_privyazka']['filter']['biblio'];
}else{
	$biblio=0;
}
if($_SESSION['Predmetnaya_privyazka']['filter_check']['predmet']=='on'){
	$predmet=$_SESSION['Predmetnaya_privyazka']['filter']['predmet'];
}else{
	$predmet=0;
}
$dbppl->add( $biblio,  $predmet);
	}
}
?>