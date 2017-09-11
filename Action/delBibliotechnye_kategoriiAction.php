<?php
class delBibliotechnye_kategoriiAction{
	function Go(){
		$dblibcat=new dblibcat();
		$dblibcat->del($_REQUEST['id']*1);
	}
}
?>