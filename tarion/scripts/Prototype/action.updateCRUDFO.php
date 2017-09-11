<?php
function makeUpdateCRUDclassFO($crud, $tables){
	$viewName=translit(iconv('utf-8', 'cp1251', $crud['name']));
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class update".$viewName."Action{
	function Go(){
		\$id=\$_REQUEST['id']*1;
		\$db$mainTable[name]=new db$mainTable[name]();
		//новые поля
		";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			if($type=='file'){
				$s.="if(isset(\$_FILES['$fname']) && \$_FILES['$fname']['tmp_name']!=''){
			\$path=photoPath(\$id).'/$fname';
			copy(\$_FILES['$fname']['tmp_name'], \$path);
		}";
			}
		}
	}
		$s.="
		\$db$mainTable[name]->update(\$id";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			switch ($type){
				case 'int':
				case 'on_off':
					$s.=", (\$_REQUEST['$fname']*1)";
				break;
				case 'string':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'date':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'text':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'file':
					$s.=", \$id";
				break;
			}
		}else{
			if($fname!='ID'){
				$s.=", null";
			}
		}
	}
		$s.=");
	}
}
?>";
	return $s;
}
?>