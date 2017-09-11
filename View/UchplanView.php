<?php
class UchplanView{
	var $dbuch_plan;
	var $listuch_plan;
var $dbfront_user;
var $listfront_user;
var $dbspecial;
var $listspecial;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function UchplanView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Uchplan'])){
			$_SESSION['Uchplan']['filter']=array();
			$_SESSION['Uchplan']['filter_check']=array();
			$_SESSION['Uchplan']['page']=1;
			$_SESSION['Uchplan']['limit']=100;
			$_SESSION['Uchplan']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Uchplan']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Uchplan']['datafields']=array();
$_SESSION['Uchplan']['datafields']['prepod']='int';
$_SESSION['Uchplan']['filter']['prepod'] = mysql_escape_string($_REQUEST['filter']['prepod']);
$_SESSION['Uchplan']['filter_check']['prepod'] = $_REQUEST['filter_check']['prepod'] == 'on';
$_SESSION['Uchplan']['datafields']['god']='string';
$_SESSION['Uchplan']['filter']['god'] = mysql_escape_string($_REQUEST['filter']['god']);
$_SESSION['Uchplan']['filter_check']['god'] = $_REQUEST['filter_check']['god'] == 'on';
$_SESSION['Uchplan']['datafields']['special']='int';
$_SESSION['Uchplan']['filter']['special'] = mysql_escape_string($_REQUEST['filter']['special']);
$_SESSION['Uchplan']['filter_check']['special'] = $_REQUEST['filter_check']['special'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Uchplan']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Uchplan']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Uchplan']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Uchplan']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Uchplan']['filter'];
		$this->filter_check=$_SESSION['Uchplan']['filter_check'];
		$this->start=$_SESSION['Uchplan']['page'];
		$this->limit=$_SESSION['Uchplan']['limit'];
		$this->order=$_SESSION['Uchplan']['order'];
		//создаём объекты доступа к таблицам
		$this->dbuch_plan=new dbuch_plan();
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbspecial = new dbspecial();
//получаем лист для lookUp
		$this->listspecial=$this->dbspecial->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Uchplan']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Uchplan']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Uchplan']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbuch_plan->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listuch_plan=$this->dbuch_plan->load($this->where, $this->order, $start, $this->limit);
		//есть потомок
$this->childView='Uchplan_soderzhanie';

	}
	
	function Paint(){
		?>
<form action='?view=UchplanView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[prepod]' <?php if($this->filter_check['prepod']){ echo(" checked");}?> value='on'>prepod:<br><?php echo($this->lookUpList($this->listfront_user, $this->filter['prepod'], 'email', 'filter[prepod]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[god]' <?php if($this->filter_check['god']){ echo(" checked");}?> value='on'>god:<br><input class=filter type=text name='filter[god]' value='<?php echo($this->filter['god']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[special]' <?php if($this->filter_check['special']){ echo(" checked");}?> value='on'>special:<br><?php echo($this->lookUpList($this->listspecial, $this->filter['special'], 'special', 'filter[special]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=UchplanView&action=addUchplanAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>prepod</td>
<td>god</td>
<td>naim</td>
<td>special</td>
<td>sem1</td>
<td>sem2</td>
<td>sem3</td>
<td>sem4</td>
<td>sem5</td>
<td>sem6</td>
<td>sem7</td>
<td>sem8</td>
<td></td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listuch_plan as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($this->lookUp($this->listfront_user, $onerec['prepod'], 'email'));?></td>
	<td><?php echo($onerec['god']);?></td>
	<td><?php echo($onerec['naim']);?></td>
	<td><?php echo($this->lookUp($this->listspecial, $onerec['special'], 'special'));?></td>
	<td><?php echo($onerec['sem1']);?></td>
	<td><?php echo($onerec['sem2']);?></td>
	<td><?php echo($onerec['sem3']);?></td>
	<td><?php echo($onerec['sem4']);?></td>
	<td><?php echo($onerec['sem5']);?></td>
	<td><?php echo($onerec['sem6']);?></td>
	<td><?php echo($onerec['sem7']);?></td>
	<td><?php echo($onerec['sem8']);?></td>
	<td><a href='?view=UchplanEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=UchplanView&action=delUchplanAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
<td><a href='?view=Uchplan_soderzhanieView&filter_check[plann]=on&filter[plann]=<?=$onerec['id']?>'>Next</a></td>
</tr><?php
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
		}
?>
</table>
Страница: <?php
		$this->shkala();
	}
	function lookUp(&$list, $id, $field_name){
		$res=false;
		$fna=explode(":",$field_name);
		foreach ($list as $rec){
			if($rec['id']==$id){
				$res='';
				foreach ($fna as $ofn){
					$res.=$rec[$ofn].' ';
				}
			}
		}
		return $res;
	}
	function lookUpList(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
		<option value=0> --- </option>
";
		$fna=explode(':',$field_name);
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value='".$rec['id']."'";
				if($rec['id']==$id){
					$s.=" selected";
				}
				$s.=">";
				foreach ($fna as $ofn){
					$s.=$rec[$ofn].' ';
				}
				$s.="</option>
";
			}
		}
		$s.="</select>
";
		return $s;
	}
	function longText($s, $len=50){
		if(strlen($s)>$len){
			return substr($s,0,$len).'...';
		}else{
			return $s;
		}
	}
	function photo($photo, $name){
		$path=photoPath($photo).'/'.$name;
		if(file_exists($path)){
			return "<img src='$path'>";
		}else{
			return "<img src='./photo/noimage.png'>";
		}
	}
	function shkala(){
		$cnt=round($this->cnt / $this->limit + 0.5);
		for($i=0;$i<$cnt;$i++){
			if($i>0){
				?> | <?php
			}
			if($i+1==$this->page){
				echo ($i+1);
			}else{
				?><a href='?view=UchplanView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>