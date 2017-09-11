<?php
class CRUDpattern{
	var $dbproduct;
	var $dbcategory;
	var $listProduct;
	var $listCategory;
	var $filter;
	var $where;
	var $page;
	var $limit;
	var $order;
	var $cnt;
	
	function CRUDpattern(){
		//инициализация конфигурации
		if(!isset($_SESSION['CRUDpattern'])){
			$_SESSION['CRUDpattern']['filter']=array();
			$_SESSION['CRUDpattern']['page']=1;
			$_SESSION['CRUDpattern']['limit']=100;
			$_SESSION['CRUDpattern']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['CRUDpattern']['filter']=array();
			//перебираем поля формы фильтра
			foreach ($_REQUEST['filter'] as $fid=>$fval){
				//если чекбокс данного фильтра включён, то запоминаем его состояние
				if($_REQUEST['filter_check'][$fid]=='on'){
					$_SESSION['CRUDpattern']['filter'][mysql_escape_string($fid)] = mysql_escape_string($fval);
				}
			}
		}
		if(isset($_REQUEST['start'])){$_SESSION['CRUDpattern']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['CRUDpattern']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['CRUDpattern']['order'] = mysql_escape_string($_REQUEST['order']);
		}
		if(isset($_REQUEST['filter_id'])){
			$_SESSION['CRUDpattern']['filter']=array("id"=>$_REQUEST['filter_id']*1);
		}
		
		$this->filter=$_SESSION['CRUDpattern']['filter'];
		$this->start=$_SESSION['CRUDpattern']['page'];
		$this->limit=$_SESSION['CRUDpattern']['limit'];
		$this->order=$_SESSION['CRUDpattern']['order'];
		
		//создаём объекты доступа к таблицам
		$this->dbproduct=new dbproduct();
		$this->dbcategory=new dbcategory();
		
		//создать из $filter => $where
		$this->where='';
		$d='';
		foreach ($this->filter as $fid => $fval){
			$this->where.=$d."`$fid`='$fval'";
			$d=' AND ';
		}
		
		$this->cnt = $this->dbproduct->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listProduct=$this->dbproduct->load($this->where, $this->order, $start, $this->limit);
		
		//получаем лист для lookUp
		$this->listCategory=$this->dbcategory->load('','',0,0);
	}
	
	function Paint(){
		$this->shkala();
		?><a href='?view=CRUDpattern&action=addProduct'>Add</a>
<table border="1">
<tr>
	<td>id</td>
	<td>category</td>
	<td>name</td>
	<td>desc</td>
	<td>photo</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php
		foreach ($this->listProduct as $i => $onerec){
			?><tr>
	<td><?=$onerec['id']?></td>
	<td><?php echo($this->lookUp($this->listCategory, $onerec['category'], 'category'));?></td>
	<td><?=$onerec['name']?></td>
	<td><?php echo($this->longText($onerec['desc']));?></td>
	<td><?php echo($this->photo($onerec['photo']));?></td>
	<td><a href='?view=editProduct&id=<?=$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=CRUDpattern&action=delProduct&id=<?=$onerec['id']?>'>Del</a></td>
	<td><a href='?view=nextCRUDpattern&next_id=<?=$onerec['category']?>'>Next</a></td>
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
	function longText($s, $len){
		if(strlen($s)>$len){
			return substr($s,0,$len).'...';
		}else{
			return $s;
		}
	}
	function photo($photo){
		$path=photoPath($photo);
		if(file_exists($path)){
			return "<img src='$path'>";
		}else{
			return './photo/noimage.png';
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
				?><a href='?view=CRUDpattern&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>