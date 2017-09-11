<?php
function makeDelCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class del".$viewName."ActionBO{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
		\$db$mainTable[name]->del(\$_REQUEST['id']*1);
	}
}
?>";
	return $s;
}
?>