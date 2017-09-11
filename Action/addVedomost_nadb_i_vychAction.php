<?php
class addVedomost_nadb_i_vychAction{
	function Go(){
		$dbvednadbvych=new dbvednadbvych();
if($_SESSION['Vedomost_nadb_i_vych']['filter_check']['prepod']=='on'){
	$prepod=$_SESSION['Vedomost_nadb_i_vych']['filter']['prepod'];
}else{
	$prepod=0;
}
if($_SESSION['Vedomost_nadb_i_vych']['filter_check']['tip']=='on'){
	$tip=$_SESSION['Vedomost_nadb_i_vych']['filter']['tip'];
}else{
	$tip=0;
}
if($_SESSION['Vedomost_nadb_i_vych']['filter_check']['god']=='on'){
	$god=$_SESSION['Vedomost_nadb_i_vych']['filter']['god'];
}else{
	$god='';
}
$dbvednadbvych->add( $prepod,  $tip,  $god);
	}
}
?>