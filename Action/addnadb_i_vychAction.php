<?php
class addnadb_i_vychAction{
	function Go(){
		$dbnadbvych=new dbnadbvych();
if($_SESSION['nadb_i_vych']['filter_check']['naim']=='on'){
	$naim=$_SESSION['nadb_i_vych']['filter']['naim'];
}else{
	$naim='';
}
if($_SESSION['nadb_i_vych']['filter_check']['formula']=='on'){
	$formula=$_SESSION['nadb_i_vych']['filter']['formula'];
}else{
	$formula='';
}
$dbnadbvych->add( $naim,  $formula);
	}
}
?>