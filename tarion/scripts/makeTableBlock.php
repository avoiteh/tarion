<?php
function makeTableBlock($table, $parent=false){
	//модель таблицы
	$s=file_get_contents('scripts/Prototype/model.php');
	if($parent){
		//если дерево могёт быть
		$s=str_replace('/*parent*/',$parent,$s);
	}else{
		//если дерева нетути
		$p0=strpos($s,'//** tree escape block');
		$p1=strpos($s,'//** tree escape block',$p0+20);
		$s=substr($s,0,$p0).substr($s,$p1,strlen($s));
	}
	$s=str_replace('/*table*/',$table['name'],$s);
	makeDir("../Models");
	file_put_contents("../Models/$table[name]".".class.php", $s);
	
	//вьюха для таблицы
	
	//вьюха для редактирования
	//экшн для add
	//экшн для del
	//экшн для update
}
?>