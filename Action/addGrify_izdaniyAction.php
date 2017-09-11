<?php
class addGrify_izdaniyAction{
	function Go(){
		$dbgrif=new dbgrif();
if($_SESSION['Grify_izdaniy']['filter_check']['grif']=='on'){
	$grif=$_SESSION['Grify_izdaniy']['filter']['grif'];
}else{
	$grif='';
}
$dbgrif->add( $grif);
	}
}
?>