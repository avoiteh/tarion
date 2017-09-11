<?php
class KategoriiView{
	var $dbcategory;
	var $listcategory;
var $filter;
	var $filter_check;
	var $parent;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function KategoriiView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Kategorii'])){
			$_SESSION['Kategorii']['filter']=array();
			$_SESSION['Kategorii']['filter_check']=array();
			$_SESSION['Kategorii']['page']=1;
			$_SESSION['Kategorii']['limit']=100;
			$_SESSION['Kategorii']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Kategorii']['filter']=array();
			//собираем поля формы фильтра

		}
		if(isset($_REQUEST['start'])){$_SESSION['Kategorii']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Kategorii']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Kategorii']['order'] = mysql_escape_string($_REQUEST['order']);
		}
		if(isset($_REQUEST['filter_id'])){
			$_SESSION['Kategorii']['filter']=array("id"=>$_REQUEST['filter_id']*1);
		}
		
		$this->filter=$_SESSION['Kategorii']['filter'];
		$this->filter_check=$_SESSION['Kategorii']['filter_check'];
		$this->start=$_SESSION['Kategorii']['page'];
		$this->limit=$_SESSION['Kategorii']['limit'];
		$this->order=$_SESSION['Kategorii']['order'];
		//создаём объекты доступа к таблицам
		$this->dbcategory=new dbcategory();

		if(isset($_REQUEST['parent'])){
			$this->parent=$_REQUEST['parent']*1;
			$_SESSION['Kategorii']['parent']=$this->parent;
		}else{
			if(isset($_SESSION['Kategorii']['parent'])){
				$this->parent=$_SESSION['Kategorii']['parent'];
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
					$this->where.=$d."`$fid`='$fval'";
				}
			}
		}
		$this->cnt = $this->dbcategory->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listcategory=$this->dbcategory->load($this->where, $this->order, $start, $this->limit);
		//есть потомок
$this->childView='Tovary';

	}
	
	function Paint(){
		echo($this->parentLine().'<br>');
		$this->shkala();
		?><br>
<a href='?view=KategoriiView&action=addKategoriiAction<?php if($this->parent!=0){
		echo "&parent=$this->parent"; } ?>'>Add</a><br>
Filter:
<form action='?view=KategoriiView' method=post>
<table border=1><tr></tr></table>
<input type='submit' value='Фильтр'>
<form>
<table border="1">
<tr>
<td>ID</td>
<td>parent</td>
<td>category</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<?php
		foreach ($this->listcategory as $i => $onerec){
			?><tr>
	<td><?php echo($onerec['id']);?></td>
	<td><?php echo($onerec['parent']);?></td>
	<td><?php echo($onerec['category']);?></td>
	<td><a href='?view=KategoriiView&parent=<?=$onerec['id']?>'>Node</a></td>
	<td><a href='?view=KategoriiEdit&id=<?=$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=KategoriiView&action=delKategoriiAction&id=<?=$onerec['id']?>'>Del</a></td>
	
<td><a href='?view=TovaryView&filter_check[category]=on&filter[category]=<?=$onerec['id']?>'>Next</a></td>
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
			$rec=$this->dbcategory->get($parent);
			$parent=$rec['parent'];
			$s='<a href="?view=KategoriiView&parent='.$rec['id'].'">'.$rec['category'].'</a>'.$d.$s;
			$d=' / ';
		}
		$s='<a href="?view=KategoriiView&parent=0">All</a>'.$d.$s;
		return $s;
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
				?><a href='?view=KategoriiView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>