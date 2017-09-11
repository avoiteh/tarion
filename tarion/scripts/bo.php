<?php
require_once('project_init.php');
switch($json_query->mode){
	case "get":
		//получить массив БO
		$json_answer = Array();
		$json_answer['id']='getBO';
		$json_answer['bo']=$project['back'];
		
	break;
	case "save":
		$project['back']=objectToArray($json_query->bo);
		file_put_contents('tarion.project', serialize($project));
		$json_answer=array();
		$json_answer['id']='saveBO';
	break;
}
echo("(".json_encode($json_answer).")");
?>