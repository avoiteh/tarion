<?php
function makeTableBlock($table, $parent=false){
	//������ �������
	$s=file_get_contents('scripts/Prototype/model.php');
	if($parent){
		//���� ������ ���� ����
		$s=str_replace('/*parent*/',$parent,$s);
	}else{
		//���� ������ ������
		$p0=strpos($s,'//** tree escape block');
		$p1=strpos($s,'//** tree escape block',$p0+20);
		$s=substr($s,0,$p0).substr($s,$p1,strlen($s));
	}
	$s=str_replace('/*table*/',$table['name'],$s);
	makeDir("../Models");
	file_put_contents("../Models/$table[name]".".class.php", $s);
	
	//����� ��� �������
	
	//����� ��� ��������������
	//���� ��� add
	//���� ��� del
	//���� ��� update
}
?>