<?php
require_once('project_init.php');
switch($json_query->mode){
	case "get":
		//получаем список таблиц
		$json_answer = Array();
		$json_answer['id']='getTables';
		$json_answer['tables']=$project['tables'];
	break;
	case "import":
		$sql="show tables";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		$tables=array();
		for ($i=0;$i<$n;$i++){
			$s=mysql_fetch_row($r);
			$tables[]=array("name"=>$s[0]);
		}
		foreach($tables as $j=>$table){
			$sql="desc `$table[name]`";
			$r=mysql_query($sql);
			$n=mysql_num_rows($r);
			for($i=0;$i<$n;$i++){
				$Field=mysql_result($r,$i,'Field');
				$Type=mysql_result($r,$i,'Type');
				$Null=mysql_result($r,$i,'Null');
				$Key=mysql_result($r,$i,'Key');
				$Default=mysql_result($r,$i,'Default');
				$Extra=mysql_result($r,$i,'Extra');
				
				$NewType='string';
				$p0=strpos($Type,'int');
				if($p0!==false){$NewType='int';}
				$p0=strpos($Type,'text');
				if($p0!==false){$NewType='text';}
				$p0=strpos($Type,'data');
				if($p0!==false){$NewType='data';}
				
				//поскольку индексное поле всегда принимаем за id
				//то существование индексного поля игнорируем!!!
				if($Key!='PRI'){
					$tables[$j]['fields'][$Field]=array("type"=>$NewType, "remark"=>'');
				}
			}
		}
		$json_answer['id']='importTables';
		$json_answer['tables']=$tables;
	break;
	case "save":
		eval("\$project['tables']=".$json_query->tables.";");
		file_put_contents('tarion.project', serialize($project));
		$json_answer['id']='saveTables';
		$json_answer['tables']=$project['tables'];
	break;
}
echo("(".json_encode($json_answer).")");
?>
