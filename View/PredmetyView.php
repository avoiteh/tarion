<?php
class PredmetyView{
	var $dbpredmet;
	var $listpredmet;
var $dbblok;
var $listblok;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function PredmetyView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Predmety'])){
			$_SESSION['Predmety']['filter']=array();
			$_SESSION['Predmety']['filter_check']=array();
			$_SESSION['Predmety']['page']=1;
			$_SESSION['Predmety']['limit']=100;
			$_SESSION['Predmety']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Predmety']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Predmety']['datafields']=array();
$_SESSION['Predmety']['datafields']['blok']='int';
$_SESSION['Predmety']['filter']['blok'] = mysql_escape_string($_REQUEST['filter']['blok']);
$_SESSION['Predmety']['filter_check']['blok'] = $_REQUEST['filter_check']['blok'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Predmety']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Predmety']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Predmety']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Predmety']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Predmety']['filter'];
		$this->filter_check=$_SESSION['Predmety']['filter_check'];
		$this->start=$_SESSION['Predmety']['page'];
		$this->limit=$_SESSION['Predmety']['limit'];
		$this->order=$_SESSION['Predmety']['order'];
		//создаём объекты доступа к таблицам
		$this->dbpredmet=new dbpredmet();
$this->dbblok = new dbblok();
//получаем лист для lookUp
		$this->listblok=$this->dbblok->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Predmety']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Predmety']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Predmety']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbpredmet->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listpredmet=$this->dbpredmet->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=PredmetyView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[blok]' <?php if($this->filter_check['blok']){ echo(" checked");}?> value='on'>blok:<br><?php echo($this->lookUpList($this->listblok, $this->filter['blok'], 'blok', 'filter[blok]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=PredmetyView&action=addPredmetyAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>ID</td>
<td>blok</td>
<td>predmet</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listpredmet as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['id']);?></td>
	<td><?php echo($this->lookUp($this->listblok, $onerec['blok'], 'blok'));?></td>
	<td><?php echo($onerec['predmet']);?></td>
	<td><a href='?view=PredmetyEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=PredmetyView&action=delPredmetyAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=PredmetyView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>