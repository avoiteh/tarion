<?php
function makeAddCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class add".$viewName."ActionBO{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
";
	
		//если есть какие-то фильтры, то надо указывать данные из этих фильтров
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.="if(\$_SESSION['$viewName']['filter_check']['$field_name']=='on'){
	\$$field_name=\$_SESSION['$viewName']['filter']['$field_name'];
}else{
	\$$field_name=";
			if($field['type']=='string' || $field['type']=='text'){
				$s.="''";
			}else{
				$s.='0';
			}
			$s.=";
}
";
			if($crud['type']=='TreeCRUD'){
				if($field_name==$crud['content']['parent_key']){
					$s.="\$$field_name=mysql_escape_string(\$$field_name);
";
				}
			}
		}
		
		if($crud['type']=='TreeCRUD'){
		$s.="\$".$crud['content']['parent_key']."=\$_REQUEST['".$crud['content']['parent_key']."'];
";
	}

		$s.="\$db$mainTable[name]->add(";
		$d='';
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.=$d." \$$field_name";
			/*
			if($crud['type']=='TreeCRUD'){
				if($field['type']=='string' || $field['type']=='text'){
					if($field_name==$crud['content']['parent_key']){
						$s.="mysql_escape_string(\$$field_name)";
					}else{
						$s.="''";
					}
				}else{
					if($field_name==$crud['content']['parent_key']){
						$s.="\$$field_name*1";
					}else{
						$s.="0";
					}
				}
			}else{
				if($field['type']=='string' || $field['type']=='text'){
					$s.="''";
					
					
					
				}else{
					$s.="0";
				}
			}
			*/
			$d=', ';
		}
		$s.=");
	}
}
?>";
	return $s;
}
?>