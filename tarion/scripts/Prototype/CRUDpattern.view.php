<?php
function makeViewCRUDclass($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."ViewBO{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."ViewBO(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			\$datafields=array();
";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
//		if(isset(\$_REQUEST['filter_id'])){
//			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
//		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		
		//создать из \$filter => \$where
		\$this->where='';
		\$d='';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		?>
";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."ViewBO'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."ViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>";
		$col='eeeeee';
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td valign=top bgcolor='#$col' nowrap>";
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href=\"?view=$viewName"."ViewBO&action=add$viewName"."ActionBO\"'><br>
Страница: <?php \$this->shkala();?>
<table border=\"1\">
<tr bgcolor='#cccccc'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		\$col='eeeeee';
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr bgcolor='#<?=\$col?>'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."EditBO&id=<?=\$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=$viewName"."ViewBO&action=del$viewName"."ActionBO&id=<?=\$onerec['id']?>'><img src='images/b_drop.png'></a></td>";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."ViewBO&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
			if(\$col=='eeeeee'){\$col='dddddd';}else{\$col='eeeeee';}
		}
?>
</table>
Страница: <?php
		\$this->shkala();
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."ViewBO&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?>