<?php
class SpetsializatsiiView{
	var $dbspecial;
	var $listspecial;
var $dbtop_spec;
var $listtop_spec;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function SpetsializatsiiView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Spetsializatsii'])){
			$_SESSION['Spetsializatsii']['filter']=array();
			$_SESSION['Spetsializatsii']['filter_check']=array();
			$_SESSION['Spetsializatsii']['page']=1;
			$_SESSION['Spetsializatsii']['limit']=100;
			$_SESSION['Spetsializatsii']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Spetsializatsii']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Spetsializatsii']['datafields']=array();
$_SESSION['Spetsializatsii']['datafields']['topspec']='int';
$_SESSION['Spetsializatsii']['filter']['topspec'] = mysql_escape_string($_REQUEST['filter']['topspec']);
$_SESSION['Spetsializatsii']['filter_check']['topspec'] = $_REQUEST['filter_check']['topspec'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Spetsializatsii']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Spetsializatsii']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Spetsializatsii']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Spetsializatsii']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Spetsializatsii']['filter'];
		$this->filter_check=$_SESSION['Spetsializatsii']['filter_check'];
		$this->start=$_SESSION['Spetsializatsii']['page'];
		$this->limit=$_SESSION['Spetsializatsii']['limit'];
		$this->order=$_SESSION['Spetsializatsii']['order'];
		//создаём объекты доступа к таблицам
		$this->dbspecial=new dbspecial();
$this->dbtop_spec = new dbtop_spec();
//получаем лист для lookUp
		$this->listtop_spec=$this->dbtop_spec->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Spetsializatsii']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Spetsializatsii']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Spetsializatsii']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbspecial->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listspecial=$this->dbspecial->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=SpetsializatsiiView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[topspec]' <?php if($this->filter_check['topspec']){ echo(" checked");}?> value='on'>topspec:<br><?php echo($this->lookUpList($this->listtop_spec, $this->filter['topspec'], 'topspec', 'filter[topspec]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=SpetsializatsiiView&action=addSpetsializatsiiAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>special</td>
<td>topspec</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listspecial as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['special']);?></td>
	<td><?php echo($this->lookUp($this->listtop_spec, $onerec['topspec'], 'topspec'));?></td>
	<td><a href='?view=SpetsializatsiiEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=SpetsializatsiiView&action=delSpetsializatsiiAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=SpetsializatsiiView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>