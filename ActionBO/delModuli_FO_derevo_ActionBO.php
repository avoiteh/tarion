<?php
class delModuli_FO_derevo_ActionBO{
	function Go(){
		$dbfront_modules=new dbfront_modules();
		$dbfront_modules->del($_REQUEST['id']*1);
	}
}
?>