<?php
class Nastroyka_BOViewBO{
	var $dbcross_right;
	var $listcross_right;
var $dbmodules;
var $listmodules;
var $dbright;
var $listright;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Nastroyka_BOViewBO(){
		//инициализация конфигурации
		if(!isset($_SESSION['Nastroyka_BO'])){
			$_SESSION['Nastroyka_BO']['filter']=array();
			$_SESSION['Nastroyka_BO']['filter_check']=array();
			$_SESSION['Nastroyka_BO']['page']=1;
			$_SESSION['Nastroyka_BO']['limit']=100;
			$_SESSION['Nastroyka_BO']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Nastroyka_BO']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			$datafields=array();
$_SESSION['Nastroyka_BO']['filter']['id'] = mysql_escape_string($_REQUEST['filter']['id']);//*
$_SESSION['Nastroyka_BO']['filter_check']['id'] = $_REQUEST['filter_check']['id'] == 'on';
$_SESSION['Nastroyka_BO']['datafields']['module']='int';
$_SESSION['Nastroyka_BO']['filter']['module'] = mysql_escape_string($_REQUEST['filter']['module']);
$_SESSION['Nastroyka_BO']['filter_check']['module'] = $_REQUEST['filter_check']['module'] == 'on';
$_SESSION['Nastroyka_BO']['datafields']['right']='int';
$_SESSION['Nastroyka_BO']['filter']['right'] = mysql_escape_string($_REQUEST['filter']['right']);
$_SESSION['Nastroyka_BO']['filter_check']['right'] = $_REQUEST['filter_check']['right'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Nastroyka_BO']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Nastroyka_BO']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Nastroyka_BO']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Nastroyka_BO']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Nastroyka_BO']['filter'];
		$this->filter_check=$_SESSION['Nastroyka_BO']['filter_check'];
		$this->start=$_SESSION['Nastroyka_BO']['page'];
		$this->limit=$_SESSION['Nastroyka_BO']['limit'];
		$this->order=$_SESSION['Nastroyka_BO']['order'];
		//создаём объекты доступа к таблицам
		$this->dbcross_right=new dbcross_right();
$this->dbmodules = new dbmodules();
//получаем лист для lookUp
		$this->listmodules=$this->dbmodules->load('','',0,0);$this->dbright = new dbright();
//получаем лист для lookUp
		$this->listright=$this->dbright->load('','',0,0);
		
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Nastroyka_BO']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Nastroyka_BO']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Nastroyka_BO']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbcross_right->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listcross_right=$this->dbcross_right->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>

<form action='?view=Nastroyka_BOViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[id]' <?php if($this->filter_check['id']){ echo(" checked");}?> value='on'>id:<br><input type=text name='filter[id]' value='<?php echo($this->filter['id']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[module]' <?php if($this->filter_check['module']){ echo(" checked");}?> value='on'>module:<br><?php echo($this->lookUpList($this->listmodules, $this->filter['module'], 'module', 'filter[module]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[right]' <?php if($this->filter_check['right']){ echo(" checked");}?> value='on'>right:<br><?php echo($this->lookUpList($this->listright, $this->filter['right'], 'name', 'filter[right]'));?></td></tr></table>
</form>

<table border="1">
<form method="POST" action="?view=Nastroyka_BOViewBO&action=updateNastroyka_BOActionBO">
	<tr>
		<td rowspan="2">Модули</td><td colspan="<?php echo count($this->listright);?>" align="center">Права</td>
	</tr>
	<tr>
		<?php
		foreach ($this->listright as $rec){
			?><td><?=$rec['name']?></td><?php
		}
		?>
	</tr>
	<?php
	foreach ($this->listmodules as $module){
		?>
	<tr>
		<td><?=$module['title']?>(<?=$module['type']?>)</td>
		<?php
		foreach ($this->listright as $rec){
			?><td><input type="checkbox" name="cross_<?=$module['module']?>_<?=$rec['name']?>" value='on'<?php
			if($this->getCross($module['id'], $rec['id'])){?> checked<?php }
			?>><?php
		}
		?>
	</tr>
		<?php
	}
	?>
	<tr>
		<td colspan="<?php echo(count($this->listright)+1);?>"><input type="submit" value=" Сохранить "></td>
	</tr>
</form>
</table>
<?php
	}
	function getCross($module,$right){
		$res=false;
		foreach ($this->listcross_right as $one){
			if($one['module']==$module && $one['right']==$right){
				$res=true;
				break;
			}
		}
		return $res;
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
				?><a href='?view=Nastroyka_BOViewBO&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>