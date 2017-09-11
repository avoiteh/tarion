<?php
class Moduli_BO_spisok_ViewBO{
	var $dbmodules;
	var $listmodules;
var $filter;
	var $filter_check;
	var $parent;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Moduli_BO_spisok_ViewBO(){
		//инициализация конфигурации
		if(!isset($_SESSION['Moduli_BO_spisok_'])){
			$_SESSION['Moduli_BO_spisok_']['filter']=array();
			$_SESSION['Moduli_BO_spisok_']['filter_check']=array();
			$_SESSION['Moduli_BO_spisok_']['page']=1;
			$_SESSION['Moduli_BO_spisok_']['limit']=100;
			$_SESSION['Moduli_BO_spisok_']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Moduli_BO_spisok_']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Moduli_BO_spisok_']['datafields']=array();
$_SESSION['Moduli_BO_spisok_']['filter']['id'] = mysql_escape_string($_REQUEST['filter']['id']);//*
$_SESSION['Moduli_BO_spisok_']['filter_check']['id'] = $_REQUEST['filter_check']['id'] == 'on';
$_SESSION['Moduli_BO_spisok_']['datafields']['module']='string';
$_SESSION['Moduli_BO_spisok_']['filter']['module'] = mysql_escape_string($_REQUEST['filter']['module']);
$_SESSION['Moduli_BO_spisok_']['filter_check']['module'] = $_REQUEST['filter_check']['module'] == 'on';
$_SESSION['Moduli_BO_spisok_']['datafields']['title']='string';
$_SESSION['Moduli_BO_spisok_']['filter']['title'] = mysql_escape_string($_REQUEST['filter']['title']);
$_SESSION['Moduli_BO_spisok_']['filter_check']['title'] = $_REQUEST['filter_check']['title'] == 'on';
$_SESSION['Moduli_BO_spisok_']['datafields']['type']='string';
$_SESSION['Moduli_BO_spisok_']['filter']['type'] = mysql_escape_string($_REQUEST['filter']['type']);
$_SESSION['Moduli_BO_spisok_']['filter_check']['type'] = $_REQUEST['filter_check']['type'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Moduli_BO_spisok_']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Moduli_BO_spisok_']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Moduli_BO_spisok_']['order'] = mysql_escape_string($_REQUEST['order']);
		}
		if(isset($_REQUEST['filter_id'])){
			$_SESSION['Moduli_BO_spisok_']['filter']=array("id"=>$_REQUEST['filter_id']*1);
		}
		
		$this->filter=$_SESSION['Moduli_BO_spisok_']['filter'];
		$this->filter_check=$_SESSION['Moduli_BO_spisok_']['filter_check'];
		$this->start=$_SESSION['Moduli_BO_spisok_']['page'];
		$this->limit=$_SESSION['Moduli_BO_spisok_']['limit'];
		$this->order=$_SESSION['Moduli_BO_spisok_']['order'];
		//создаём объекты доступа к таблицам
		$this->dbmodules=new dbmodules();

		if(isset($_REQUEST['parent'])){
			$this->parent=$_REQUEST['parent']*1;
			$_SESSION['Moduli_BO_spisok_']['parent']=$this->parent;
		}else{
			if(isset($_SESSION['Moduli_BO_spisok_']['parent'])){
				$this->parent=$_SESSION['Moduli_BO_spisok_']['parent'];
			}else{
				$this->parent=0;
			}
		}
		//создать из $filter => $where
		$this->where=" `parent`='$this->parent'";
		$d=' AND';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Moduli_BO_spisok_']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Moduli_BO_spisok_']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Moduli_BO_spisok_']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbmodules->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listmodules=$this->dbmodules->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		echo($this->parentLine().'<br>');
		?>

<form action='?view=Moduli_BO_spisok_ViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=1><tr>
<td><input type='checkbox' name='filter_check[id]' <?php if($this->filter_check['id']){ echo(" checked");}?> value='on'>id:<br><input type=text name='filter[id]' value='<?php echo($this->filter['id']);?>'></td>
<td><input type='checkbox' name='filter_check[module]' <?php if($this->filter_check['module']){ echo(" checked");}?> value='on'>module:<br><input type=text name='filter[module]' value='<?php echo($this->filter['module']);?>'></td>
<td><input type='checkbox' name='filter_check[title]' <?php if($this->filter_check['title']){ echo(" checked");}?> value='on'>title:<br><input type=text name='filter[title]' value='<?php echo($this->filter['title']);?>'></td>
<td><input type='checkbox' name='filter_check[type]' <?php if($this->filter_check['type']){ echo(" checked");}?> value='on'>type:<br><input type=text name='filter[type]' value='<?php echo($this->filter['type']);?>'></td></tr></table>
</form>
<br>
<a href='?view=Moduli_BO_spisok_ViewBO&action=addModuli_BO_spisok_ActionBO<?php if($this->parent!=0){
		echo "&parent=$this->parent"; } ?>'>Add</a><br>
Страница:  <?php $this->shkala(); ?>
<table border="1">
<tr>
<td>ID</td>
<td>module</td>
<td>parent</td>
<td>title</td>
<td>type</td>
<td></td>
<td></td>
<td></td>
</tr>
<?php
		foreach ($this->listmodules as $i => $onerec){
			?><tr>
	<td><?php echo($onerec['id']);?></td>
	<td><?php echo($onerec['module']);?></td>
	<td><?php echo($onerec['parent']);?></td>
	<td><?php echo($onerec['title']);?></td>
	<td><?php echo($onerec['type']);?></td>
	<td><a href='?view=Moduli_BO_spisok_ViewBO&parent=<?=$onerec['id']?>'>Node</a></td>
	<td><a href='?view=Moduli_BO_spisok_EditBO&id=<?=$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=Moduli_BO_spisok_ViewBO&action=delModuli_BO_spisok_ActionBO&id=<?=$onerec['id']?>'>Del</a></td>
	
</tr><?php
		}
?>
</table>
		<?php
		$this->shkala();
	}
	function parentLine(){
		$s='';
		$parent=$this->parent;
		$d='';
		while($parent!=0){
			$rec=$this->dbmodules->get($parent);
			$parent=$rec['parent'];
			$s='<a href="?view=Moduli_BO_spisok_ViewBO&parent='.$rec['id'].'">'.$rec['title'].'</a>'.$d.$s;
			$d=' / ';
		}
		$s='<a href="?view=Moduli_BO_spisok_ViewBO&parent=0">All</a>'.$d.$s;
		return $s;
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
				?><a href='?view=Moduli_BO_spisok_ViewBO&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>