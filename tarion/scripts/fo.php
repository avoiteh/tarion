<?php
require_once('project_init.php');
switch($json_query->mode){
	case "get":
		//�������� ������ FO
		$json_answer = Array();
		$json_answer['id']='getFO';
		$json_answer['fo']=$project['front'];
		
		/*
		//�������� �������� ��� FO
		$json_answer['fo']=array(
			1=>array("parent"=>"0","type"=>"menu","name"=>iconv("CP1251", "UTF-8","������������"),"content"=>array()),
			2=>array("parent"=>"0","type"=>"menu","name"=>iconv("CP1251", "UTF-8","���������"),"content"=>array()),
			3=>array("parent"=>"0","type"=>"menu","name"=>iconv("CP1251", "UTF-8","������"),"content"=>array()),
			4=>array("parent"=>"1","type"=>"CRUD","name"=>iconv("CP1251", "UTF-8","������ �������������"),"content"=>array()),
			5=>array("parent"=>"2","type"=>"TreeCRUD","name"=>iconv("CP1251", "UTF-8","������ ���������"),"content"=>array()),
			6=>array("parent"=>"3","type"=>"CRUD","name"=>iconv("CP1251", "UTF-8","������ �������"),"content"=>array()),
			7=>array("parent"=>"0","type"=>"menu","name"=>"Menu1","content"=>array()),
			8=>array("parent"=>"7","type"=>"menu","name"=>"Menu2","content"=>array()),
			9=>array("parent"=>"7","type"=>"menu","name"=>"Menu3","content"=>array()),
			10=>array("parent"=>"9","type"=>"menu","name"=>"Menu4","content"=>array()),
		);
		*/
		//echo("<pre>");var_dump($project['back']);echo("</pre><hr>");
	break;
	case "save":
		$project['front']=objectToArray($json_query->fo);
		file_put_contents('tarion.project', serialize($project));
		$json_answer=array();
		$json_answer['id']='saveFO';
	break;
}
echo("(".json_encode($json_answer).")");
?>