<?php
class delMetod_razrabotkiAction{
	function Go(){
		$dbreg_book=new dbreg_book();
		$dbreg_book->del($_REQUEST['id']*1);
	}
}
?>