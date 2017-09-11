<?php
class TovaryView{
	var $dbproduct;
	var $listproduct;
var $dbcategory;
var $listcategory;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function TovaryView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Tovary'])){
			$_SESSION['Tovary']['filter']=array();
			$_SESSION['Tovary']['filter_check']=array();
			$_SESSION['Tovary']['page']=1;
			$_SESSION['Tovary']['limit']=100;
			$_SESSION['Tovary']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Tovary']['filter']=array();
			//собираем поля формы фильтра
$_SESSION['Tovary']['filter']['category'] = mysql_escape_string($_REQUEST['filter']['category']);
$_SESSION['Tovary']['filter_check']['category'] = $_REQUEST['filter_check']['category'] == 'on';
$_SESSION['Tovary']['filter']['name'] = mysql_escape_string($_REQUEST['filter']['name']);
$_SESSION['Tovary']['filter_check']['name'] = $_REQUEST['filter_check']['name'] == 'on';
$_SESSION['Tovary']['filter']['desc'] = mysql_escape_string($_REQUEST['filter']['desc']);
$_SESSION['Tovary']['filter_check']['desc'] = $_REQUEST['filter_check']['desc'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Tovary']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Tovary']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Tovary']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Tovary']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Tovary']['filter'];
		$this->filter_check=$_SESSION['Tovary']['filter_check'];
		$this->start=$_SESSION['Tovary']['page'];
		$this->limit=$_SESSION['Tovary']['limit'];
		$this->order=$_SESSION['Tovary']['order'];
		//создаём объекты доступа к таблицам
		$this->dbproduct=new dbproduct();
$this->dbcategory = new dbcategory();
//получаем лист для lookUp
		$this->listcategory=$this->dbcategory->load('','',0,0);
		
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					$this->where.=$d."`$fid`='$fval'";
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbproduct->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listproduct=$this->dbproduct->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		$this->shkala();
		?><br>
<a href='?view=TovaryView&action=addTovaryAction'>Add</a><br>
Filter:
<form action='?view=TovaryView' method=post>
<table border=1><tr>
<td><input type='checkbox' name='filter_check[category]' <?php if($this->filter_check['category']){ echo(" checked");}?> value='on'>category: <?php echo($this->lookUpList($this->listcategory, $this->filter['category'], 'category', 'filter[category]'));?></td>
<td><input type='checkbox' name='filter_check[name]' <?php if($this->filter_check['name']){ echo(" checked");}?> value='on'>name: <input type=text name='filter[name]' value='<?php echo($this->filter['name']);?>'></td>
<td><input type='checkbox' name='filter_check[desc]' <?php if($this->filter_check['desc']){ echo(" checked");}?> value='on'>desc: <input type=text name='filter[desc]' value='<?php echo($this->filter['desc']);?>'></td></tr></table>
<input type='submit' value='Фильтр'>
<form>
<table border="1">
<tr>
<td>ID</td>
<td>category</td>
<td>name</td>
<td>desc</td>
<td>photo</td>
<td></td>
<td></td>
</tr>
<?php
		foreach ($this->listproduct as $i => $onerec){
			?><tr>
	<td><?php echo($onerec['id']);?></td>
	<td><?php echo($this->lookUp($this->listcategory, $onerec['category'], 'category'));?></td>
	<td><?php echo($onerec['name']);?></td>
	<td><?php echo($this->longText($onerec['desc']));?></td>
	<td><?php echo($this->photo($onerec['id'], 'photo'));?></td>
	<td><a href='?view=TovaryEdit&id=<?=$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=TovaryView&action=delTovaryAction&id=<?=$onerec['id']?>'>Del</a></td>
</tr><?php
		}
?>
</table>
		<?php
		$this->shkala();
	}
	function lookUp(&$list, $id, $field_name){
		$res=false;
		foreach ($list as $rec){
			if($rec['id']==$id){
				$res=$rec[$field_name];
			}
		}
		return $res;
	}
	function lookUpList(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
		<option value=0> --- </option>
";
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value=''";
				if($rec['id']==$id){
					$s.=" selected";
				}
				$s.=">$rec[$field_name]</option>
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
				?><a href='?view=TovaryView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>