<?php
class Predmetnaya_privyazkaView{
	var $dbppl;
	var $listppl;
var $dbbiblio;
var $listbiblio;
var $dbpredmet;
var $listpredmet;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Predmetnaya_privyazkaView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Predmetnaya_privyazka'])){
			$_SESSION['Predmetnaya_privyazka']['filter']=array();
			$_SESSION['Predmetnaya_privyazka']['filter_check']=array();
			$_SESSION['Predmetnaya_privyazka']['page']=1;
			$_SESSION['Predmetnaya_privyazka']['limit']=100;
			$_SESSION['Predmetnaya_privyazka']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Predmetnaya_privyazka']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Predmetnaya_privyazka']['datafields']=array();
$_SESSION['Predmetnaya_privyazka']['datafields']['biblio']='int';
$_SESSION['Predmetnaya_privyazka']['filter']['biblio'] = mysql_escape_string($_REQUEST['filter']['biblio']);
$_SESSION['Predmetnaya_privyazka']['filter_check']['biblio'] = $_REQUEST['filter_check']['biblio'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Predmetnaya_privyazka']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Predmetnaya_privyazka']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Predmetnaya_privyazka']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Predmetnaya_privyazka']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Predmetnaya_privyazka']['filter'];
		$this->filter_check=$_SESSION['Predmetnaya_privyazka']['filter_check'];
		$this->start=$_SESSION['Predmetnaya_privyazka']['page'];
		$this->limit=$_SESSION['Predmetnaya_privyazka']['limit'];
		$this->order=$_SESSION['Predmetnaya_privyazka']['order'];
		//создаём объекты доступа к таблицам
		$this->dbppl=new dbppl();
$this->dbbiblio = new dbbiblio();
//получаем лист для lookUp
		$this->listbiblio=$this->dbbiblio->load('','',0,0);$this->dbpredmet = new dbpredmet();
//получаем лист для lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Predmetnaya_privyazka']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Predmetnaya_privyazka']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Predmetnaya_privyazka']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbppl->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listppl=$this->dbppl->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?><a href='?view=Spisok_literaturyView'>&lt;&lt;&lt;&lt; Назад</br>
<form action='?view=Predmetnaya_privyazkaView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[biblio]' <?php if($this->filter_check['biblio']){ echo(" checked");}?> value='on'>biblio:<br><?php echo($this->lookUpList($this->listbiblio, $this->filter['biblio'], 'title', 'filter[biblio]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Predmetnaya_privyazkaView&action=addPredmetnaya_privyazkaAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>biblio</td>
<td>predmet</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listppl as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($this->lookUp($this->listbiblio, $onerec['biblio'], 'title'));?></td>
	<td><?php echo($this->lookUp($this->listpredmet, $onerec['predmet'], 'predmet'));?></td>
	<td><a href='?view=Predmetnaya_privyazkaEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Predmetnaya_privyazkaView&action=delPredmetnaya_privyazkaAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Predmetnaya_privyazkaView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>