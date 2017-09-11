<?php
function makeDelCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class del".$viewName."Action{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
		\$db$mainTable[name]->del(\$_REQUEST['id']*1);
	}
}
?>";
	return $s;
}
?>